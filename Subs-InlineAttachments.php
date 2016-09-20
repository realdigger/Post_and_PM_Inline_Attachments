<?php
/**********************************************************************************
* Subs-InlineAttachments.php - Subs of Inline Attachment mod
*********************************************************************************
* This program is distributed in the hope that it is and will be useful, but
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY
* or FITNESS FOR A PARTICULAR PURPOSE .
**********************************************************************************/
if (!defined('SMF'))
	die('Hacking attempt...');

//================================================================================
// BBCode hook function & supporting subfunction for ILA mod
//================================================================================
function ILA_tags()
{
	return array('attach', 'attachment', 'attachmini', 'attachthumb', 'attachurl');
}

function ILA_BBCode(&$codes)
{
	foreach (ILA_tags() as $tag)
	{
		// BBCode Usage: [attach=id,width,height]content ignored[/attach]
		$codes[] = array(
			'tag' => $tag,
			'type' => 'unparsed_commas_content',
			'test' => '(\d+|\d+,\d+|\d+,\d+,\d+|\d+,msg\d+|\d+,\d+,msg\d+|\d+,\d+,\d+,msg\d+)\]',
			'content' => '$1',
			'validate' => 'ILA_Start_v1x',
			'disabled_content' => '',
		);

		// BBCode Usage: [attach id=n width=x height=y float=mode margin=m scale=yes]content ignored[/attach]
		$codes[] = array(
			'tag' => $tag,
			'type' => 'unparsed_content',
			'parameters' => array(
				'id' => array('match' => '(\d+)', 'validate' => 'ILA_Param_ID'),
				'width' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Width'),
				'height' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Height'),
				'float' => array('optional' => true, 'match' => '(left|right|center)', 'validate' => 'ILA_Param_Float'),
				'margin' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Margin'),
				'scale' => array('optional' => true, 'match' => '(true|false|yes|no)', 'validate' => 'ILA_Param_Scale'),
				'msg' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Msg'),
			),
			'content' => '$1',
			'validate' => 'ILA_Start_v20',
			'disabled_content' => '',
		);
	}
}

//================================================================================
// Subfunction that deals with preparing for running the ILA mod:
//================================================================================
function ILA_Load_Stuff()
{
	global $context, $modSettings;

	// Load the language strings for this mod:
	loadLanguage('InlineAttachments');

	// Set some things up for performance benefits:
	$context['ila']['pm_attach'] = false;
	$context['ila_params'] = array();
	if (!isset($context['ila']['attachments']))
		$context['ila']['attachments'] = array();
	if (!isset($context['ila']['pm_view_attachments']))
		$context['ila']['pm_view_attachments'] = allowedTo('pm_view_attachments');
}

//================================================================================
// Sub-function gets attachment data so that inline attachments can be processed
//================================================================================
function ILA_Setup($msg_id, &$message)
{
	global $context, $topic;
	
	// Load language strings and stuff (duh)
	ILA_Load_Stuff();

	// We can't load attachments if we don't know the message id number....
	if (($id = $context['ila']['msg'] = (int) $msg_id) != 0)
		ILA_Post_Attachments($id);
	elseif (($id = $context['ila']['msg'] = (int) str_replace('pre', '', $msg_id)) != 0)
		ILA_Post_Attachments($id);
	elseif (function_exists('loadPMAttachmentContext'))
	{
		if (($id = $context['ila']['msg'] = (int) str_replace('pm', '', $msg_id)) != 0)
			ILA_PM_Attachments($id);
		elseif (($id = $context['ila']['msg'] = (int) str_replace('pm_pre', '', $msg_id)) != 0)
			ILA_PM_Attachments($id);
	}

	// If there isn't a message to setup for, just return to the caller:
	if (empty($message))
		return;

	// Convert "[attach=n]" to "[attach=n][/attach]" and remove the stuff between the brackets:
	foreach (ILA_tags() as $tag)
	{
		$pattern = '#\[' . $tag . '(=| )(.+?)\]([^\[]*)\[/' . $tag . '\]#i' . ($context['utf8'] ? 'u' : '');
		$message = preg_replace($pattern, '[' . $tag . '$1$2][/' . $tag .']', $message);
		$pattern = '#\[' . $tag . '(=| )(.+?)\]#i' . ($context['utf8'] ? 'u' : '');
		$message = preg_replace($pattern, '[' . $tag . '$1$2][/' . $tag .']', $message);
		$message = str_replace('[/' . $tag .'][/' . $tag .']', '[/' . $tag . ']', $message);
	}

	// Replace attachments inside code brackets cause we don't know what post/PM it belongs to...
	$pattern = '#\[code(.+?)\](.+?)\[/code\]#i' . ($context['utf8'] ? 'u' : '');
	if (preg_match_all($pattern, $message, $codes, PREG_PATTERN_ORDER))
	{
		$codes = array_unique($codes[0]);
		foreach ($codes as $code)
			$message = str_replace($code, ILA_Invalid_Tags($code), $message);
	}

	// Process the inline attachments in the quotes, then pass the result back:
	ILA_Process_Quotes($message);
}

//================================================================================
// Sub-function dealing with gathering post attachments for ILA_Setup
//================================================================================
function ILA_Post_Attachments($msg_id, $override = false)
{
	global $context, $modSettings, $smcFunc, $attachments, $sourcedir, $topic;

	// Only pull if topic ID --IS-- specified, or action is --NOT-- specified:
	$msg_id = (int) $msg_id;
	if (isset($_REQUEST['topic']) || isset($_REQUEST['action']) || SMF == 'SSI' || $override)
	{
		// Set the topic variable to whatever topic is being pulled from:
		$request = $smcFunc['db_query']('', '
			SELECT id_topic FROM {db_prefix}messages WHERE id_msg = {int:msg}',
			array('msg' => (int) $msg_id)
		);
		$row = $smcFunc['db_fetch_assoc']($request);
		$smcFunc['db_free_result']($request);
		$topic = $row['id_topic'];

		// Check to make sure that we can view attachments for the topic:
		if (!isset($context['ila']['view_attachments'][$topic]))
			$context['ila']['view_attachments'][$topic] = allowedTo('view_attachments');
	}

	// Fetch attachments for use in "parse_bbc" function...
	unset($attachments[$msg_id]);
	if (!empty($modSettings['attachmentEnable']) && !empty($context['ila']['view_attachments'][$topic]))
	{
		$request = $smcFunc['db_query']('', '
			SELECT
				a.id_attach, a.id_folder, a.id_msg, a.filename, a.file_hash, IFNULL(a.size, 0) AS filesize, a.downloads, a.approved,
				a.width, a.height' . (empty($modSettings['attachmentShowImages']) || empty($modSettings['attachmentThumbnails']) ? '' : ',
				IFNULL(thumb.id_attach, 0) AS id_thumb, thumb.width AS thumb_width, thumb.height AS thumb_height') . '
			FROM {db_prefix}attachments AS a' . (empty($modSettings['attachmentShowImages']) || empty($modSettings['attachmentThumbnails']) ? '' : '
				LEFT JOIN {db_prefix}attachments AS thumb ON (thumb.id_attach = a.id_thumb)') . '
			WHERE a.id_msg = {int:message_id}
				AND a.attachment_type = {int:attachment_type}',
			array(
				'message_id' => (int) $msg_id,
				'attachment_type' => 0,
				'is_approved' => 1,
			)
		);
		$temp = array();
		while ($row = $smcFunc['db_fetch_assoc']($request))
		{
			if (!$row['approved'] && $modSettings['postmod_active'])
				continue;

			$temp[$row['id_attach']] = $row;
			if (!isset($attachments[$row['id_msg']]))
				$attachments[$row['id_msg']] = array();
		}
		$smcFunc['db_free_result']($request);

		// This is better than sorting it with the query...
		ksort($temp);
		foreach ($temp as $row)
			$attachments[$row['id_msg']][] = $row;
	}

	// Load the attachment context even if there are no attachments:
	require_once($sourcedir . '/Display.php');
	$context['ila']['attachments'][$msg_id] = loadAttachmentContext($msg_id);
}

//================================================================================
// Sub-function dealing with gathering PM attachments for ILA_Setup
//================================================================================
function ILA_PM_Attachments($msg_id)
{
	global $context, $modSettings, $smcFunc, $attachments, $sourcedir, $user_info;

	// Fetch attachments for use in "parse_bbc" function...
	$msg_id = (int) $msg_id;
	unset($attachments[$msg_id]);
	if (!empty($modSettings['pmAttachmentEnable']) && !empty($context['ila']['pm_view_attachments']))
	{
		$request = $smcFunc['db_query']('', '
			SELECT
				pa.id_attach, pa.id_folder, pa.id_pm, pa.pm_report, pa.filename, pa.file_hash, IFNULL(pa.size, 0) AS filesize, pa.downloads,
				pa.width, pa.height' . (empty($modSettings['pmAttachmentShowImages']) || empty($modSettings['pmAttachmentThumbnails']) ? '' : ',
				IFNULL(thumb.id_attach, 0) AS id_thumb, thumb.width AS thumb_width, thumb.height AS thumb_height') . '
			FROM {db_prefix}pm_attachments AS pa' . (empty($modSettings['pmAttachmentShowImages']) || empty($modSettings['pmAttachmentThumbnails']) ? '' : '
				LEFT JOIN {db_prefix}pm_attachments AS thumb ON (thumb.id_attach = pa.id_thumb)') . '
				LEFT JOIN {db_prefix}personal_messages AS pm ON (pm.id_pm = pa.id_pm)
				LEFT JOIN {db_prefix}pm_recipients AS pmr ON (pmr.id_pm = pa.id_pm AND pmr.id_member = {int:current_user})
			WHERE pa.attachment_type = {int:attachment_type}
				AND pa.id_pm = {int:msg_id}
				AND (pm.id_member_from = {int:current_user} OR pmr.id_member = {int:current_user})',
			array(
				'msg_id' => $msg_id,
				'attachment_type' => 0,
				'current_user' => $user_info['id'],
			)
		);
		$temp = array();
		while ($row = $smcFunc['db_fetch_assoc']($request))
		{
			$temp[$row['id_attach']] = $row;

			if (!isset($attachments[$row['id_pm']]))
				$attachments[$row['id_pm']] = array();
		}
		$smcFunc['db_free_result']($request);

		// This is better than sorting it with the query...
		ksort($temp);
		foreach ($temp as $row)
			$attachments[$row['id_pm']][] = $row;
	}

	// Load the attachment context even if there are no attachments:
	require_once($sourcedir . '/PersonalMessage.php');
	$context['ila']['attachments'][$msg_id] = loadPMAttachmentContext($msg_id);
	$context['ila']['pm_attach'] = true;
}

//================================================================================
// Functions that are called to alter ILA tags that have been quoted:
//================================================================================
function ILA_Process_Quotes(&$message)
{
	global $context;

	$pattern = '#\[quote(.+?)\](.+?)\[/quote\]#i' . ($context['utf8'] ? 'u' : '');
	if (preg_match_all($pattern, $message, $quotes, PREG_PATTERN_ORDER))
	{
		$quotes = array_unique($quotes[0]);
		foreach ($quotes as $quote)
			$message = str_replace($quote, ILA_Add_MsgID($quote), $message);
	}
}

function ILA_Add_MsgID($message)
{
	global $context;
	
	// Start searching for the SMF 2.0.x-style message ID in the quote bracket:
	$pattern = '#\[quote(.+?)\#msg(\d+)(.+?)\]#i' . ($context['utf8'] ? 'u' : '');
	if (!preg_match_all($pattern, $message, $info, PREG_PATTERN_ORDER))
	{
		// Look for SMF 2.1-style message ID in the quote bracket:
		$pattern = '#\[quote(.+?)msg=(\d+)(.+?)\]#i' . ($context['utf8'] ? 'u' : '');
		if (!preg_match_all($pattern, $message, $info, PREG_PATTERN_ORDER))
			return ILA_Invalid_Tags($message, true);
	}
	foreach (ILA_tags() as $tag)
	{
		// Process the "Version 1.0" bbcode forms here:
		$pattern = '#\[' . $tag . '=(.+?)\]#i' . ($context['utf8'] ? 'u' : '');
		$message = preg_replace($pattern, '[' . $tag . '=$1,msg' . $info[2][0] . ']', $message);
		$pattern = '#msg(\d+),msg(\d+)#i' . ($context['utf8'] ? 'u' : '');
		$message = preg_replace($pattern, 'msg$1', $message);

		// Process the "Version 2.0" bbcode forms here:
		$pattern = '#\[' . $tag . ' (.+?)\]#i' . ($context['utf8'] ? 'u' : '');
		$message = preg_replace($pattern, '[' . $tag . ' $1 msg=' . $info[2][0] . ']', $message);
		$pattern = '#msg=(\d+) msg=(\d+)#i' . ($context['utf8'] ? 'u' : '');
		$message = preg_replace($pattern, 'msg=$1', $message);
	}
	return $message;
}

//================================================================================
// Function called to replace invalid attachment tags in the message
//================================================================================
function ILA_Invalid_Tags($message, $exclude_msgid = false)
{
	global $txt, $context, $modSettings, $topic;

	// Load language strings and stuff (duh)
	ILA_Load_Stuff();

	// Show attachment text string or error text string in topic history
	$replacement = ((empty($modSettings['attachmentEnable']) || empty($context['ila']['view_attachments'][$topic])) ? $txt['ila_nopermission'] : $txt['ila_attachment']);
	foreach (ILA_tags() as $tag)
	{
		// Force each inline attachment tag into our mutant "Version 3.0" form :p
		$pattern = '#\[' . $tag . '(=| )(.+?)\]([^\[]*)\[/' . $tag . '\]#i' . ($context['utf8'] ? 'u' : '');
		$message = preg_replace($pattern, '[' . $tag . '$1$2]', $message);

		// If "$exclude_msgid" is false, clear all invalid inline attachments from the message:
		$pattern = '#\[' . $tag . '(=| )(.+?)\]#i' . ($context['utf8'] ? 'u' : '');
		if (empty($exclude_msgid))
			$message = preg_replace($pattern, $replacement, $message);
			
		// Otherwise, clear invalid inline attachments that don't have a message ID linked to it:
		elseif (preg_match_all($pattern, $message, $attachcode, PREG_PATTERN_ORDER))
		{
			$attachcode = array_unique($attachcode[0]);
			asort($attachcode);
			foreach ($attachcode as $txt)
			{
				if (!preg_match('# msg=(/d+)#i', $txt) && !preg_match('#,msg(/d+)#i', $txt))
					$message = str_replace($txt, $replacement, $message);
			}
		}		
	}
	return $message;
}

//================================================================================
// Function to fix the tags after an attachment has been removed:
//================================================================================
function ILA_Fix_Tags(&$message, &$query)
{
	global $context, $attachments, $modSettings;

	// Load language strings and stuff (duh)
	ILA_Load_Stuff();

	// Convert all inline attachment tags to "Version 3.0" form:
	foreach (ILA_tags() as $tag)
	{
		// Force each inline attachment tag into our mutant "Version 3.0" form :p
		$pattern = '#\[' . $tag . '(=| )(.+?)\]([^\[]*)\[/' . $tag . '\]#i' . ($context['utf8'] ? 'u' : '');
		$message = preg_replace($pattern, '[' . $tag . '$1$2]', $message);

		// Start processing missing attachments:
		$pattern = '#\[' . $tag . '(=| )(.+?)\]#i' . ($context['utf8'] ? 'u' : '');
		if (preg_match_all($pattern, $message, $attachtags, PREG_PATTERN_ORDER))
		{
			// Figure out where the attachments will be once the requested ones are deleted:
			$msg_id = $query['id_msg'];
			if (!isset($attachment[$msg_id]))
				ILA_Setup($msg_id, $msg_id);
			$i = $modSettings['ila_one_based_numbering'];
			$attach = array();
			foreach ($attachments[$msg_id] as $b)
			{
				if (in_array($b['id_attach'], $query['not_id_attach']))
					$attach[$b['id_attach']] = $i++;
			}
			foreach ($query['not_id_attach'] as $b)
			{
				if (!isset($attachments[$msg_id][$b]) && !isset($attach[$b]))
					$attach[$b] = $i++;
			}				

			// Find the unique attachment bbcodes and sort them so we don't change the same bbcode multiple times:
			$attachtags = array_unique($attachtags[0]);
			asort($attachtags);

			// Adjust or remove the attachment bbcodes so that the ones remaining still work:
			foreach ($attachtags as $txt)
			{
				if (preg_match('# id=(\d+)#i', $txt, $attach_num))
				{
					if (!preg_match('# msg=(/d+)#i', $txt))
					{
						$look_for = $attach_num[1] - $modSettings['ila_one_based_numbering'];
						if (!empty($attachments[$msg_id][$look_for]['id_attach']))
						{
							$id_attach = $attachments[$msg_id][$look_for]['id_attach'];
							if (!isset($attach[$id_attach]))
								$message = str_replace($txt, '', $message);
							else
							{
								$pattern = '#\[' . $tag . '(.+?)' . $attach_num[0] . '(.+?)\]#i' . ($context['utf8'] ? 'u' : '');
								$message = preg_replace($pattern, '[' . $tag . '$1 id=' . $attach[$id_attach] . '$2]', $message);
							}
						}
						else
							$message = str_replace($txt, '', $message);
					}
				}
				elseif (preg_match('(\d+)', $txt, $attach_num))
				{
					if (!preg_match('#,msg(/d+)#i', $txt))
					{
						$look_for = $attach_num[0] - $modSettings['ila_one_based_numbering'];
						if (!empty($attachments[$msg_id][$look_for]['id_attach']))
						{
							$id_attach = $attachments[$msg_id][$look_for]['id_attach'];
							if (!isset($attach[$id_attach]))
								$message = str_replace($txt, '', $message);
							else
								$message = str_replace($txt, '[' . $tag . '=' . $attach[$id_attach] . substr($txt, strlen($tag) + strlen($attach[$id_attach]) + 2), $message);
						}
						else
							$message = str_replace($txt, '', $message);
					}
				}
				else
					$message = str_replace($txt, '', $message);
			}
		}
	}
}

//================================================================================
// BBCode parameter validation functions
//================================================================================
function ILA_Param_Scale($answer)
{
	global $context;
	$context['ila_params']['scale'] = ($answer == false || $answer == 'no');
}

function ILA_Param_ID($id)
{
	global $context;
	$context['ila_params']['id'] = (int) $id;
}

function ILA_Param_Width($width)
{
	global $context;
	$context['ila_params']['width'] = max(0, (int) $width);
}

function ILA_Param_Height($height)
{
	global $context;
	$context['ila_params']['height'] = max(0, (int) $height);
}

function ILA_Param_Float($where)
{
	global $context;
	$context['ila_params']['float'] = ($where == 'left' ? 'left' : ($where == 'right' ? 'right' : 'center'));
}

function ILA_Param_Margin($margin)
{
	global $context;
	$context['ila_params']['margin'] = max(0, (int) $margin);
}

function ILA_Param_Msg($msg)
{
	global $context, $modSettings;
	
	if (empty($modSettings['ila_allow_quoted_images']))
		return;
	$context['ila_params']['msg'] = $msg = (int) $msg;
	if (empty($msg))
		return;
	elseif (!isset($context['ila']['attachments'][$msg]) && empty($context['ila']['pm_attach']))
		ILA_Post_Attachments($msg, true);
	elseif (!isset($context['ila']['attachments'][$msg]) && !empty($context['ila']['pm_attach']))
		ILA_PM_Attachments($msg);
}

//================================================================================
// Validation & link building function for the Inline Attachment mod
//================================================================================
function ILA_Start_v1x(&$tag, &$data, $disabled)
{
	global $context, $txt;

	if (!isset($data[1]))
		$data = $txt['ila_invalid'];
	else
	{
		$context['ila_params'] = array(
			'id' => (int) $data[1],
			'width' => isset($data[2]) ? (int) $data[2] : 0,
			'height' => isset($data[3]) ? (int) $data[3] : 0,
		);
		if (substr($data[ count($data) - 1 ], 0, 3) == 'msg')
			ILA_Param_Msg( substr($data[ count($data) - 1 ], 3) );
		$data[0] = ILA_Build_Link($tag, $context['ila_params']['id']);
	}
}

function ILA_Start_v20(&$tag, &$data, $disabled)
{
	global $context, $txt;

	if (!isset($context['ila_params']['id']))
		$data = $txt['ila_invalid'];
	else
		$data = ILA_Build_Link($tag, $context['ila_params']['id']);
	unset($context['ila_params']);
}

function ILA_Build_Link(&$tag, &$id)
{
	global $context, $modSettings, $txt, $settings, $topic, $sourcedir;

	// If the "one-based numbering" option is set, subtract 1 from the attachment ID to make it compatible:
	$id = $id - $modSettings['ila_one_based_numbering'];

	// Are attachments enabled and can we see them?  If not, return no permission message:
	if (empty($context['ila']['pm_attach']) && (empty($modSettings['attachmentEnable']) || empty($context['ila']['view_attachments'][$topic])))
		return $txt['ila_nopermission'];
	if (!empty($context['ila']['pm_attach']) && (empty($modSettings['pmAttachmentEnable']) || empty($context['ila']['pm_view_attachments'])))
		return $txt['ila_nopermission'];

	// Does the specified attachment exist in the message?  If not, return attachment invalid message:
	$allowed = (isset($modSettings['ila_allow_quoted_images']) && !empty($modSettings['ila_allow_quoted_images']));
	$msg = (isset($context['ila_params']['msg']) ? ($allowed ? $context['ila_params']['msg'] : -1) : $context['ila']['msg']);
	if (!isset($context['ila']['attachments'][$msg]))
		return $txt['ila_invalid'];
	if (!isset($context['ila']['attachments'][$msg][$id]))
		return $txt['ila_invalid'];
	if (empty($context['ila']['attachments'][$msg][$id]['is_approved']))
		return $txt['ila_unapproved'];

	// Mark attachment as "don't show" if admin has checked that option:
	$attachment = &$context['ila']['attachments'][$msg][$id];
	if (!empty($modSettings['ila_duplicate']))
		$context['dontshowattachment'][$msg][$attachment['id']] = true;

	// Return empty string if a non-image attachment was requested:
	if (!$attachment['is_image'] && $tag['tag'] != 'attachmini')
		return '<div class="smalltext"><a href="' . $attachment['href'] . '"><img src="' . $settings['images_url'] . '/icons/clip.gif" align="middle" alt="*" border="0" />&nbsp;' . $attachment['name'] . '</a> ('. $attachment['size']. ($attachment['is_image'] ? '. ' . $attachment['real_width'] . 'x' . $attachment['real_height'] . ' - ' . $txt['attach_viewed'] : ' - ' . $txt['attach_downloaded']) . ' ' . $attachment['downloads'] . ' ' . $txt['attach_times'] . '.)</div>';
	elseif (!$attachment['is_image'])
		return '';

	// If neither width nor height is set, use the global max image size settings:
	$max_width = &$context['ila_params']['width'];
	$max_height = &$context['ila_params']['height'];
	if (empty($max_width) && empty($max_height))
	{
		$max_width = $modSettings['max_image_width'];
		$max_height = $modSettings['max_image_height'];
	}

	// Figure out which parameters we are going to use:
	$use_thumbnail = ($tag['tag'] == 'attachthumb');
	if (isset($modSettings['ila_attach_same_as_attachment']) && empty($modSettings['ila_attach_same_as_attachment']))
		$use_thumbnail = $use_thumbnail || ($tag['tag'] == 'attach');
	$thumb = ($use_thumbnail && !empty($attachment['thumbnail']['has_thumb']) ? $attachment['thumbnail']['href'] : $attachment['href']);
	$image = ($tag['tag'] == 'attachthumb' ? $thumb : $attachment['href']);
	$src_width = $real_width = ($use_thumbnail ? $attachment['thumb_width'] : $attachment['real_width']);
	$src_height = $real_height = ($use_thumbnail ? $attachment['thumb_height'] : $attachment['real_height']);

	// Did the user request no scaling activities?
	$shrunk = false;
	if (!empty($context['ila_params']['scale']))
	{
		$src_width = $max_width;
		$src_height = $max_height;
	}
	// Scale the image if desired dimensions are specified by user OR maximum image size is set by admin:
	elseif ((!empty($max_width) || !empty($max_height)))
	{
		if (!empty($max_width) && $src_width > $max_width)
		{
			$src_height = floor($src_height * $max_width / $src_width);
			$src_width = $max_width;
			$shrunk = true;
		}
		if (!empty($max_height) && $src_height > $max_height)
		{
			$src_width = floor($src_width * $max_height / $src_height);
			$src_height = $max_height;
			$shrunk = true;
		}
	}

	// Process the remaining bbcode parameters:
	$width = (!empty($src_width) ? ' width="' . $src_width .'"' : '');
	$height = (!empty($src_height) ? ' height="' . $src_height .'"' : '');
	$divfloat = (isset($context['ila_params']['float']) ? ' style="float:' . $context['ila_params']['float'] . (isset($context['ila_params']['margin']) ? '; margin:' . $context['ila_params']['margin'] . 'px' : '') . '"' : '');
	$float = ((!empty($modSettings['ila_download_count']) && $tag['tag'] != 'attachmini') ? '' : $divfloat);
	$margin = (!isset($context['ila_params']['float']) && isset($context['ila_params']['margin']) ? ' style="margin:' . $context['ila_params']['margin'] . 'px"' : '');

	// Build the replacement string for the caller:
	if ($shrunk && $modSettings['ila_highslide'] && $tag['tag'] != 'attachurl')
	{
		// HS4SMF Installed?
		if (!empty($modSettings['hs4smf_enabled']) && function_exists('hs4smf_get_slidegroup'))
		{
			$settings['hs4smf_img_count'] = (isset($settings['hs4smf_img_count'])) ? $settings['hs4smf_img_count'] + 1 : 1;
			$slidegroup = hs4smf_get_slidegroup($id);
			if (!isset($settings['hs4smf_slideshow']) && $settings['hs4smf_img_count'] > 1)
				$settings['hs4smf_slideshow'] = 1;
			$html = '<a href="' . $image . ';image" id="link_' . $id . '" class="highslide" onclick="return hs.expand(this, ' . $slidegroup . ')"><img src="' . $thumb . '" ' . $width . $height . ' alt="' . $attachment['name'] . '"' . $float . $margin . ' id="thumb_' . $id . '" /></a>';
		}
		// Highslide Image Viewer Installed?
		elseif (function_exists('highslide_images'))
			$html = '<a href="' . $image . ';image" id="link_' . $id . '" class="highslide" rel="highslide"><img src="' . $thumb . '" ' . $width . $height . ' alt="' . $attachment['name'] . '"' . $float . $margin . ' id="thumb_' . $id . '" /></a>' . (isset($context['subject']) ? '<span class="highslide-heading">' . $context['subject'] . '</span>' : '');
		// jQLightbox Installed?
		elseif (!empty($modSettings['enable_jqlightbox_mod']) && strpos($context['html_headers'], 'jquery.prettyPhoto.css'))
			$html = '<a href="' . $image . ';image" id="link_' . $id . '" rel="lightbox[gallery]"><img src="' . $thumb . '" ' . $width . $height . ' alt="' . $attachment['name'] . '"' . $float . $margin . ' id="thumb_' . $id . '" /></a>';
		// Simple Mode
		else
			$html = '<img src="' . $thumb . ';image" alt=""' . $width . $height . ' alt="' . $attachment['name'] . '"' . $float . $margin . ' class="bbc_img resized" />';
	}
	else
		$html = '<img src="' . $thumb . ';image" alt=""' . $width . $height . ' alt="' . $attachment['name'] . '"' . $float . $margin . ' class="bbc_img resized" />';

	// If the option to show EXIF is checked, let's show the EXIF information (if available):
	if (!empty($modSettings['ila_display_exif']) && isset($attachment['exif']))
		$html .= '<span class="smalltext">' . preg_replace('/\s+/', " ", $attachment['exif']) . '</span><br />' . (!empty($modSettings['ila_download_count']) && $tag['tag'] != 'attachmini' ? '' : '<br />');

	// Add the download count to the image tag if requested:
	if (!empty($modSettings['ila_download_count']) && $tag['tag'] != 'attachmini')
		$html = '<div' . $divfloat . '>' . $html . '<br/><span class="smalltext"><a href="' . $image . '"><img src="' . $settings['images_url'] . '/icons/clip.gif" align="middle" alt="*" border="0" />&nbsp;' . $attachment['name'] . '</a> ('. $attachment['size']. ($attachment['is_image'] ? '. ' . $src_width . 'x' . $src_height . ' - ' . $txt['attach_viewed'] : ' - ' . $txt['attach_downloaded']) . ' ' . $attachment['downloads'] . ' ' . $txt['attach_times'] . '.)</span></div>';

	// Clear the parameter set for the next usage and return string to caller:
	unset($context['ila_params']);
	return $html;
}

//================================================================================
// Hook functions to add new subsection to the Modifications Setting page:
//================================================================================
function ILA_Admin_Menu_Hook(&$area)
{
	global $txt;
	ILA_Load_Stuff();
	$area['config']['areas']['modsettings']['subsections']['ila'] = array($txt['ila_admin_settings']);
}

function ILA_Admin_Settings_Hook(&$sub)
{
	$sub['ila'] = 'ILA_Admin_Settings';
}

function ILA_Admin_Settings($return_config = false)
{
	global $context, $modSettings, $txt, $scripturl, $sourcedir;
	isAllowedTo('admin_forum');

	// Get latest version of the mod and display whether current mod is up-to-date:
	if (($file = cache_get_data('ila_mod_version', 86400)) == null)
	{
		$file = file_get_contents('http://www.xptsp.com/tools/mod_version.php?url=Post_and_PM_Inline_Attachments');
		cache_put_data('ila_mod_version', $file, 86400);
	}
	if (preg_match('#Post_and_PM_Inline_Attachments_v(.+?)\.zip#i', $file, $version))
	{
		if (isset($modSettings['ila_version']) && $version[1] > $modSettings['ila_version'])
			$context['settings_message'] = '<strong>' . sprintf($txt['ila_no_update'], $version[1]) . '</strong>';
		else
			$context['settings_message'] = '<strong>' . $txt['ila_no_update'] . '</strong>';
	}

	// Assemble the options available in this mod:
	$config_vars = array(
		array('check', 'ila_duplicate'),
		array('check', 'ila_download_count'),
		array('check', 'ila_turn_nosniff_off'),
		array('check', 'ila_one_based_numbering'),
		array('check', 'ila_attach_same_as_attachment'),
		array('check', 'ila_allow_quoted_images'),
	);
	if (function_exists('hs4smf') || function_exists('highslide_images') || (!empty($modSettings['enable_jqlightbox_mod']) && strpos($context['html_headers'], 'jquery.prettyPhoto.css')))
		$config_vars[] = array('check', 'ila_highslide');
	if (file_exists($sourcedir . '/exif.php'))
		$config_vars[] = array('check', 'ila_display_exif');
		
	if ($return_config)
		return $config_vars;
	$context['post_url'] = $scripturl . '?action=admin;area=modsettings;sa=ila;save';
	$context['settings_title'] = $txt['ila_title'];

	// Saving?
	if (isset($_GET['save']))
	{
		checkSession();
		saveDBSettings($config_vars);
		redirectexit('action=admin;area=modsettings;sa=ila');
	}
	prepareDBSettingContext($config_vars);
}

?>
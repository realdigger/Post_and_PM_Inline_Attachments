<?php
/**********************************************************************************
* Subs-InlineAttachments.php - Subs of Inline Attachment mod
***********************************************************************************
* This mod is licensed under the 2-clause BSD License, which can be found here:
*	http://opensource.org/licenses/BSD-2-Clause
***********************************************************************************
* This program is distributed in the hope that it is and will be useful, but	  *
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY	  *
* or FITNESS FOR A PARTICULAR PURPOSE.											  *
**********************************************************************************/
if (!defined('SMF'))
	die('Hacking attempt...');

//================================================================================
// BBCode hook functions & supporting subfunction for ILA mod
//================================================================================
function ILA_Button(&$buttons)
{
	global $context, $settings;

	return;
	// Load everything we are going to need for the editor:
	loadTemplate('InlineAttachments');
	$context['template_layers'][] = 'ILA_popup';
	$context['html_headers'] .= '
	<link rel="stylesheet" type="text/css" href="' . $settings['theme_url'] . '/css/ILA.css" />';

	// Now add the button to the editor!
	$buttons[0][] = array(
		'image' => 'attachment',
		'code' => 'attachment',
		'description' => $txt['ila_insert_button'],
	);
}

function ILA_Load_Theme()
{
	global $context, $modSettings;

	// Set max width and height for inline attachments via CSS:
	$width = !empty($modSettings['ila_max_width']) ? $modSettings['ila_max_width'] . 'px' : '100%';
	$height = !empty($modSettings['ila_max_height']) ? $modSettings['ila_max_height'] . 'px' : 'auto';
	$context['html_headers'] .= '
	<style>.ila_attach {width: auto; height: auto; max-width: ' . $width . '; max-height: ' . $height . ';}</style>';
}

function ILA_tags()
{
	return array('attach', 'attachment', 'attachmini', 'attachthumb', 'attachurl');
}

function ILA_parameters(&$params1, &$params2)
{
	global $sourcedir;

	$params1 = array(
		'id' => array('match' => '(\d+)', 'validate' => 'ILA_Param_ID'),
		'width' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Width'),
		'height' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Height'),
		'float' => array('optional' => true, 'match' => '(left|right|center)', 'validate' => 'ILA_Param_Float'),
		'margin' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Margin'),
		'margin-left' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Margin_Left'),
		'margin-right' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Margin_Right'),
		'margin-top' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Margin_Top'),
		'margin-bottom' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Margin_Bottom'),
	);
	$params2 = array_merge($params1, array(
		'border-style' => array('match' => '(none|dotted|dashed|solid|double|groove|ridge|inset|outset)', 'validate' => 'ILA_Param_Border_Style'),
		'border-width' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Border_Width'),
		'border-color' => array('optional' => true, 'match' => '(#[\da-fA-F]{3}|#[\da-fA-F]{6}|[A-Za-z]{1,20}|rgb\(\d{1,3}, ?\d{1,3}, ?\d{1,3}\))', 'validate' => 'ILA_Param_Border_Color'),
	));
	$more = array(
		'scale' => array('optional' => true, 'match' => '(true|false|yes|no|invert)', 'validate' => 'ILA_Param_Scale'),
		'msg' => array('optional' => true, 'match' => '(new|\d+)', 'validate' => 'ILA_Param_Msg'),
	);
	$params1 = array_merge($params1, $more);
	$params2 = array_merge($params2, $more);
}

function ILA_BBCode(&$codes)
{
	ILA_parameters($params1, $params2);
	foreach (ILA_tags() as $tag)
	{
		// BBCode Usage: [attach=id,width,height]content ignored[/attach]
		$codes[] = array(
			'tag' => $tag,
			'type' => 'unparsed_commas_content',
			'test' => '(\d+|\d+,\d+|\d+,\d+,\d+|\d+,msg\d+|\d+,\d+,msg\d+|\d+,\d+,\d+,msg\d+)\]',
			'content' => '',
			'validate' => 'ILA_Start_v1x',
			'disabled_content' => '',
		);

		// BBCode Usage: [attach {params}]content ignored[/attach]
		$codes[] = array(
			'tag' => $tag,
			'type' => 'unparsed_content',
			'parameters' => $params2,
			'content' => '',
			'validate' => 'ILA_Start_v20',
			'disabled_content' => '',
		);
		$codes[] = array(
			'tag' => $tag,
			'type' => 'unparsed_content',
			'parameters' => $params1,
			'content' => '',
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
	global $context;

	// Load the language strings for this mod:
	loadLanguage('InlineAttachments');

	// Set some things up for performance benefits:
	$context['ila']['pm_attach'] = false;
	$context['ila_params'] = array();
	if (!isset($context['ila']['attachments']))
		$context['ila']['attachments'] = array();
	if (!isset($context['ila']['view_attachments']))
		$context['ila']['view_attachments'] = array();
	if (!isset($context['ila']['pm_view_attachments']))
		$context['ila']['pm_view_attachments'] = allowedTo('pm_view_attachments');
}

//================================================================================
// Sub-function gets attachment data so that inline attachments can be processed
//================================================================================
function ILA_Setup($msg_id, &$message)
{
	global $context, $modSettings;

	// Load language strings and stuff (duh)
	ILA_Load_Stuff();

	// We can't load attachments if we don't know the message id number....
	if (!empty($msg_id))
	{
		if (($id = (int) $msg_id) != 0)
			ILA_Post_Attachments($context['ila']['msg'] = $id);
		elseif (($id = (int) str_replace('pre', '', $msg_id)) != 0)
			ILA_Post_Attachments($context['ila']['msg'] = $id);
		elseif (function_exists('loadPMAttachmentContext'))
		{
			if (($id = (int) str_replace('pm', '', $msg_id)) != 0)
				ILA_PM_Attachments($context['ila']['msg'] = $id);
			elseif (($id = (int) str_replace('pm_pre', '', $msg_id)) != 0)
				ILA_PM_Attachments($context['ila']['msg'] = $id);
		}
	}
	if (empty($id))
		$id = ($msg_id == '' && isset($context['ila']['msg']) ? $context['ila']['msg'] : $msg_id);
	$context['ila_msg'] = $id;

	// Make damn sure that the "dont_show" element is defined for this message:
	if (!isset($context['ila']['dont_show'][$id]))
		$context['ila']['dont_show'][$id] = array();

	// If there isn't a message to setup for, just return to the caller:
	if (empty($message))
		return;

	// Convert v3.0+ tags into usable tags for the parser:
	$attach_id = empty($modSettings['ila_one_based_numbering']) ? 0 : 1;
	foreach (ILA_tags() as $tag)
	{
		// Convert "[attach=n]" to "[attach=n][/attach]" and remove the stuff between the brackets:
		$pattern = '#\[' . $tag . '(=| )(.+?)\]([^\[]*)\[/' . $tag . '\]#i' . ($context['utf8'] ? 'u' : '');
		$message = preg_replace($pattern, '[' . $tag . '$1$2][/' . $tag .']', $message);
		$pattern = '#\[' . $tag . '(=| )(.+?)\]#i' . ($context['utf8'] ? 'u' : '');
		$message = preg_replace($pattern, '[' . $tag . '$1$2][/' . $tag .']', $message);
		$message = str_replace('[/' . $tag .'][/' . $tag .']', '[/' . $tag . ']', $message);

		// Kludgey workaround for messages with autonumbering closed tags, courtsey of "dcmouser" @ SMF:
		$len = strlen( $findstr = '[' . $tag . ']' );
		do
		{
			$pos = strpos($message, $findstr);
			if ($pos !== false)
			{
				$message = substr_replace($message, '[' . $tag . '=' . $attach_id . '][/' . $tag . ']', $pos, $len);
				$attach_id++;
			}
		} while ($pos !== false);
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
	ILA_Fix_Param_Order($message);
	ILA_Process_Quotes($message);
}

//================================================================================
// Sub-function dealing with gathering post attachments for ILA_Setup
//================================================================================
function ILA_Post_Attachments($msg_id, $override = false)
{
	global $context, $modSettings, $smcFunc, $attachments, $sourcedir, $topic, $board, $user_info;

	// Only pull if topic ID --IS-- specified, or action is --NOT-- specified:
	$msg_id = (int) $msg_id;
	if (empty($msg_id))
		return;
	if (isset($_REQUEST['topic']) || isset($_REQUEST['action']) || SMF == 'SSI' || $override)
	{
		// Set the topic variable to whatever topic is being pulled from:
		$request = $smcFunc['db_query']('', '
			SELECT id_topic, id_member, id_board
			FROM {db_prefix}messages
			WHERE id_msg = {int:msg}',
			array(
				'msg' => (int) $msg_id,
			)
		);
		$row = $smcFunc['db_fetch_assoc']($request);
		$smcFunc['db_free_result']($request);
		$topic = $row['id_topic'];
		$context['ila']['id_member'][$msg_id] = $row['id_member'];
		if (empty($board))
			$board = $row['id_board'];
	}

	// Check to make sure that we can view attachments for the topic:
	if (!empty($topic) && !isset($context['ila']['view_attachments'][$topic]))
	{
		$permission_view_attachments = allowedTo('view_attachments');
		if (!$permission_view_attachments && isset($board) && intval($board))
		{
			if (isset($context['ila']['cachedboardpermissioncheck'][$board]))
				$permission_view_attachments = $context['ila']['cachedboardpermissioncheck'][$board];
			else
				$context['ila']['cachedboardpermissioncheck'][$board] = $permission_view_attachments = allowedTo('view_attachments', $board);
		}
		$context['ila']['view_attachments'][$topic] = $permission_view_attachments;
	}

	// Fetch attachments for use in "parse_bbc" function...
	unset($attachments[$msg_id]);
	if (!empty($modSettings['attachmentEnable']) && !empty($context['ila']['view_attachments'][$topic]))
	{
		$request = $smcFunc['db_query']('', '
			SELECT
				a.id_attach, a.id_folder, a.id_msg, a.filename, a.file_hash, IFNULL(a.size, 0) AS filesize,
				a.downloads, a.approved, a.width, a.height, IFNULL(thumb.id_attach, 0) AS id_thumb,
				thumb.width AS thumb_width, thumb.height AS thumb_height
			FROM {db_prefix}attachments AS a
				LEFT JOIN {db_prefix}attachments AS thumb ON (thumb.id_attach = a.id_thumb)
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
			if (!$row['approved'] && !empty($modSettings['postmod_active']) && !allowedTo('approve_posts') && $context['ila']['id_member'][$msg_id] != $user_info['id'])
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
	$context['ila']['attachments'][$msg_id] = loadAttachmentContext($msg_id, true);
}

//================================================================================
// Sub-function dealing with gathering PM attachments for ILA_Setup
//================================================================================
function ILA_PM_Attachments($msg_id)
{
	global $context, $modSettings, $smcFunc, $attachments, $sourcedir, $user_info;

	// Fetch attachments for use in "parse_bbc" function...
	$msg_id = (int) $msg_id;
	if (empty($msg_id))
		return;
	unset($attachments[$msg_id]);
	if (!empty($modSettings['pmAttachmentEnable']) && !empty($context['ila']['pm_view_attachments']))
	{
		$request = $smcFunc['db_query']('', '
			SELECT
				pa.id_attach, pa.id_folder, pa.id_pm, pa.pm_report, pa.filename, pa.file_hash,
				IFNULL(pa.size, 0) AS filesize, pa.downloads, pa.width, pa.height,
				IFNULL(thumb.id_attach, 0) AS id_thumb, thumb.width AS thumb_width, thumb.height AS thumb_height
			FROM {db_prefix}pm_attachments AS pa
				LEFT JOIN {db_prefix}pm_attachments AS thumb ON (thumb.id_attach = pa.id_thumb)
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
function ILA_Process_Quotes(&$message, $msg_id = 0)
{
	global $context, $modSettings;

	$pattern = '#\[quote(.+?)\](.+?)\[/quote\]#i' . ($context['utf8'] ? 'u' : '');
	if (preg_match_all($pattern, $message, $quotes, PREG_PATTERN_ORDER))
	{
		$quotes = array_unique($quotes[0]);
		foreach ($quotes as $quote)
			$message = str_replace($quote, ILA_Add_MsgID($quote), $message);
	}
	if (!empty($msg_id))
		$message = ILA_Add_MsgID($message, $msg_id);
}

function ILA_Add_MsgID($message, $msg = 0)
{
	global $context;

	// Start searching for the SMF 2.0.x-style message ID in the quote bracket:
	if (empty($msg))
	{
		$pattern = '#\[quote(.+?)\#msg(\d+) (.+?)\]#i' . ($context['utf8'] ? 'u' : '');
		if (!preg_match_all($pattern, $message, $info, PREG_PATTERN_ORDER))
		{
			// Look for SMF 2.1-style message ID in the quote bracket:
			$pattern = '#\[quote(.+?)msg=(\d+) (.+?)\]#i' . ($context['utf8'] ? 'u' : '');
			if (!preg_match_all($pattern, $message, $info, PREG_PATTERN_ORDER))
				return ILA_Invalid_Tags($message, $msg, true);
		}
		$msg = $info[2][0];
	}
	foreach (ILA_tags() as $tag)
	{
		// Process the "Version 1.0" bbcode forms here:
		$pattern = '#\[' . $tag . '=(.+?)\]#i' . ($context['utf8'] ? 'u' : '');
		$message = preg_replace($pattern, '[' . $tag . '=$1,msg' . $msg . ']', $message);
		$pattern = '#msg(\d+),msg(\d+)#i' . ($context['utf8'] ? 'u' : '');
		$message = preg_replace($pattern, 'msg$1', $message);

		// Process the "Version 2.0" bbcode forms here:
		$pattern = '#\[' . $tag . ' (.+?)\]#i' . ($context['utf8'] ? 'u' : '');
		$message = preg_replace($pattern, '[' . $tag . ' $1 msg=' . $msg . ']', $message);
		$pattern = '#msg=(new|\d+) msg=(\d+)#i' . ($context['utf8'] ? 'u' : '');
		$message = preg_replace($pattern, 'msg=$1', $message);
	}
	return $message;
}

//================================================================================
// Function called to replace invalid attachment tags in the message
//================================================================================
function ILA_Invalid_Tags($message, $msg_id = 0, $exclude_msgid = false)
{
	global $txt, $context, $modSettings, $topic;

	// Load language strings and stuff (duh)
	ILA_Load_Stuff();

	// Show attachment text string or error text string in topic history
	$replacement = (empty($modSettings['attachmentEnable']) || empty($context['ila']['view_attachments'][$topic]) ? $txt['ila_nopermission'] : $txt['ila_attachment']);
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
			foreach ($attachcode as $code)
			{
				if (preg_match('# msg=(\d+)#i', $code, $msg_param))
				{
					if ($msg_param[1] == $msg_id)
						$message = str_replace($code, $replacement, $message);
				}
				elseif (preg_match('#,msg(\d+)#i', $code, $msg_param))
				{
					if ($msg_param[1] == $msg_id)
						$message = str_replace($code, $replacement, $message);
				}
				else
					$message = str_replace($code, $replacement, $message);
			}
		}
	}
	return $message;
}

//================================================================================
// Function to fix the tags after an attachment has been removed:
//================================================================================
function ILA_Reorganize_Tags(&$message, &$query)
{
	global $context, $attachments, $modSettings;

	// Figure out where the attachments will be once the requested ones are deleted:
	$msg_id = $query['id_msg'];
	if (!isset($attachment[$msg_id]))
		ILA_Setup($msg_id, $msg_id);
	$i = intval(!empty($modSettings['ila_one_based_numbering']));
	$attach = array();
	foreach ($attachments[$msg_id] as $attachment)
	{
		if (in_array($attachment['id_attach'], $query['not_id_attach']))
		{
			$attach[$attachment['id_attach']] = $i;
			$i += 1;
		}
	}

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
			// Find the unique attachment bbcodes and sort them so we don't change the same bbcode multiple times:
			$attachtags = array_unique($attachtags[0]);
			asort($attachtags);

			// Adjust or remove the attachment bbcodes so that the ones remaining still work:
			foreach ($attachtags as $txt)
			{
				if (preg_match('# id=(\d+)#i', $txt, $attach_num))
				{
					preg_match('# msg=(\d+)#i', $txt, $msg_num);
					if (isset($msg_num[1]) && $msg_num[1] == $msg_id)
					{
						$look_for = $attach_num[1] - intval(!empty($modSettings['ila_one_based_numbering']));
						if (!empty($attachments[$msg_id][$look_for]['id_attach']))
						{
							$id_attach = $attachments[$msg_id][$look_for]['id_attach'];
							if (!isset($attach[$id_attach]))
								$message = str_replace($txt, '', $message);
							else
							{
								$pattern = '#\[' . $tag . $attach_num[0] . '(.+?)\]#i' . ($context['utf8'] ? 'u' : '');
								$message = preg_replace($pattern, '[' . $tag . ' id=' . ((int) $attach[$id_attach]) . '$1]', $message);
							}
						}
						else
							$message = str_replace($txt, '', $message);
					}
				}
				elseif (preg_match('(\d+)', $txt, $attach_num))
				{
					if (!preg_match('#,msg(\d+)#i', $txt))
					{
						$look_for = $attach_num[0] - intval(!empty($modSettings['ila_one_based_numbering']));
						if (!empty($attachments[$msg_id][$look_for]['id_attach']))
						{
							$id_attach = $attachments[$msg_id][$look_for]['id_attach'];
							if (!isset($attach[$id_attach]))
								$message = str_replace($txt, '', $message);
							else
								$message = str_replace($txt, '[' . $tag . '=' . ((int) $attach[$id_attach]) . substr($txt, strlen($tag) + strlen($attach[$id_attach]) + 2), $message);
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
// Function to fix the ORDER of the parameters in v2 tags:
//================================================================================
function ILA_Fix_Param_Order(&$message)
{
	global $context;

	ILA_parameters($dummy, $parameters);
	foreach (ILA_tags() as $tag)
	{
		$pattern = '#\[' . $tag . ' (.+?)\]#i' . ($context['utf8'] ? 'u' : '');
		preg_match_all($pattern, $message, $matches);
		$matches = array_unique($matches[0]);
		asort($matches);
		foreach ($matches as $match)
		{
			$params = explode(' ', $match);
			unset($params[0]);
			$order = array();
			$replace_str = $old = $order[''] = '';
			foreach ($params as $param)
			{
				if (strpos($param, '=') === false)
					$order[$old] .= ' ' . $param;
				else
					$order[$old = substr($param, 0, strpos($param, '='))] = substr($param, strpos($param, '=') + 1);
			}
			$out = '[' . $tag;
			foreach ($parameters as $key => $ignore)
				$out .= (isset($order[$key]) ? ' ' . $key . '=' . $order[$key] : '');
			$message = str_replace($match, $out, $message);
		}
	}
}

//================================================================================
// BBCode parameter validation functions
//================================================================================
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
	$context['ila_params']['float'] = (!empty($where) ? ($where == 'left' ? 'left' : ($where == 'right' ? 'right' : 'center')) : false);
}

function ILA_Param_Margin($margin)
{
	global $context;
	$context['ila_params']['margin'] = max(0, (int) $margin);
}

function ILA_Param_Margin_Left($margin)
{
	global $context;
	$context['ila_params']['margin-left'] = max(0, (int) $margin);
}

function ILA_Param_Margin_Right($margin)
{
	global $context;
	$context['ila_params']['margin-right'] = max(0, (int) $margin);
}

function ILA_Param_Margin_Top($margin)
{
	global $context;
	$context['ila_params']['margin-top'] = max(0, (int) $margin);
}

function ILA_Param_Margin_Bottom($margin)
{
	global $context;
	$context['ila_params']['margin-bottom'] = max(0, (int) $margin);
}

function ILA_Param_Border_Style($style)
{
	global $context;
	$context['ila_params']['border-style'] = $style;
}

function ILA_Param_Border_Width($width)
{
	global $context;
	$context['ila_params']['border-width'] = max(0, (int) $width);
}

function ILA_Param_Border_Color($color)
{
	global $context;
	$context['ila_params']['border-color'] = $color;
}

function ILA_Param_Scale($answer)
{
	global $context, $modSettings;
	if ($answer == 'invert')
		$context['ila_params']['scale'] = empty($modSettings['ila_enable_responsive']);
	else
		$context['ila_params']['scale'] = (!$answer || $answer == 'false' || $answer == 'no');
}

function ILA_Param_Msg($msg)
{
	global $context, $modSettings, $sourcedir;

	$context['ila_params']['msg'] = ($msg == 'new' ? 'new' : (int) $msg);
	$msg = (int) $msg;
	if (empty($modSettings['ila_allow_quoted_images']) || empty($msg) || file_exists($sourcedir . '/Subs-Tapatalk.php'))
		return;
	elseif (!isset($context['ila']['attachments'][$msg]) && empty($context['ila']['pm_attach']))
		ILA_Post_Attachments($msg, true);
	elseif (!isset($context['ila']['attachments'][$msg]) && !empty($context['ila']['pm_attach']))
		ILA_PM_Attachments($msg);
}

//================================================================================
// Validation functions for the Inline Attachment mod
//================================================================================
function ILA_Start_v1x(&$tag, &$data, &$disabled)
{
	global $context, $txt;

	if (!isset($data[1]))
		$tag['content'] = $txt['ila_invalid'];
	else
	{
		$context['ila_params'] = array(
			'id' => (int) $data[1],
			'width' => isset($data[2]) ? (int) $data[2] : 0,
			'height' => isset($data[3]) ? (int) $data[3] : 0,
		);
		if (substr($data[ count($data) - 1 ], 0, 3) == 'msg')
			ILA_Param_Msg( substr($data[ count($data) - 1 ], 3) );
		$tag['content'] = ILA_Build_HTML($tag, $context['ila_params']['id']);
	}
	unset($context['ila_params']);
}

function ILA_Start_v20(&$tag, &$data, &$disabled)
{
	global $context, $txt;

	if (!isset($context['ila_params']['id']))
		$tag['content'] = $txt['ila_invalid'];
	else
		$tag['content'] = ILA_Build_HTML($tag, $context['ila_params']['id']);
	unset($context['ila_params']);
}

//================================================================================
// Link building functions for the Inline Attachment mod
//================================================================================
function ILA_Build_HTML(&$tag, &$id)
{
	global $context, $modSettings, $settings, $txt, $topic, $sourcedir, $user_info, $smcFunc, $forum_version;

	// If the "one-based numbering" option is set, subtract 1 from the attachment ID to make it compatible:
	$id = $id - intval(!empty($modSettings['ila_one_based_numbering']));

	// Make sure that we can access other messages:
	$allowed = (isset($modSettings['ila_allow_quoted_images']) && !empty($modSettings['ila_allow_quoted_images']) && !file_exists($sourcedir . '/Subs-Tapatalk.php'));
	if (isset($context['ila_params']['msg']))
		$msg = ($allowed || (isset($context['ila']['msg']) && $context['ila_params']['msg'] == $context['ila']['msg']) ? $context['ila_params']['msg'] : -1);
	else
		$msg = (isset($context['ila']['msg']) ? $context['ila']['msg'] : -1);

	// Are attachments enabled and can we see them?	 If not, return no permission message:
	if (!isset($context['ila']['attachments'][$msg][$id]))
		return $txt['ila_invalid'];
	$attachment = &$context['ila']['attachments'][$msg][$id];
	if (empty($context['ila']['pm_attach']) && (empty($modSettings['attachmentEnable']) || empty($context['ila']['view_attachments'][$topic])))
		return $txt['ila_nopermission'];
	if (!empty($context['ila']['pm_attach']) && (empty($modSettings['pmAttachmentEnable']) || empty($context['ila']['pm_view_attachments'])))
		return $txt['ila_nopermission'];

	// This part is done after board permission check because we don't want to give user false hope.
	// If we are previewing the post, return "attachment not uploaded yet" message:
	if (!isset($context['ila']['attachments'][$msg]) && (isset($_REQUEST['action']) ? $_REQUEST['action'] : '') == 'post2')
		return $txt['ila_not_uploaded'];
	
	// Does the specified attachment exist in the message?  If not, return attachment invalid message:
	if ($msg == 'new')
		return $txt['ila_attachment'];
	if (!isset($context['ila']['attachments'][$msg]) || !isset($context['ila']['attachments'][$msg][$id]))
		return $txt['ila_invalid'];

	// Return message that message is unapproved ONLY IF not admin, moderator, or post author:
	if (empty($attachment['is_approved']) && (!empty($context['ila']['id_member'][$msg]) && $user_info['id'] != $context['ila']['id_member'][$msg] && !$user_info['is_admin'] && !$user_info['is_mod']))
		return $txt['ila_unapproved'];

	// IMPORTANT: Set the download counter variable correctly!
	$download_count = ($tag['tag'] == 'attachurl' ? 4 : ($tag['tag'] == 'attachmini' ? 0 : 
		(isset($modSettings['ila_download_count']) ? $modSettings['ila_download_count'] : 0)));

	// Start assembling the transparency CSS style:
	$style = min(100, max(0, (isset($modSettings['ila_transparent']) ? $modSettings['ila_transparent'] : 40)));
	if (empty($attachment['is_approved']) && empty($style))
		return $txt['ila_unapproved'];
	$style = (empty($attachment['is_approved']) ? 'opacity: ' . ($style / 100) . '; filter: alpha(opacity=' . $style . ');' : '');

	//===========================================================================================
	// Is this an image?  If so, assemble the HTML necessary to show it:
	//===========================================================================================
	if (!empty($attachment['is_image']))
	{
		// Set the specified width and height in the CSS style:
		$width = !empty($context['ila_params']['width']) ? $context['ila_params']['width'] : 0;
		$height = !empty($context['ila_params']['height']) ? $context['ila_params']['height'] : 0;
		$style .= !empty($width) ? ' width: ' . $width . 'px;' : '';
		$style .= !empty($height) ? ' height: ' . $height . 'px;' : '';

		// Call the appropriate function to get the HTML we need:
		$has_thumb = !empty($attachment['thumbnail']['has_thumb']);
		$function = 'ILA_tag_' . (!empty($modSettings['ila_attach_same_as_attachment']) && $tag['tag'] == 'attach' ? 'attachment' : $tag['tag']);
		$html = $function($attachment, $dimensions, $has_thumb, !empty($style) ? 'style="' . $style . '"' : '');

		// If the option to show EXIF is checked, let's show the EXIF information (if available):
		if ($tag['tag'] != 'attachurl' && !empty($modSettings['ila_display_exif']) && isset($attachment['exif']))
			$html .= '<span class="smalltext">' . preg_replace('/\s+/', " ", $attachment['exif']) . '</span><br />' . (!empty($modSettings['ila_download_count']) && $tag['tag'] != 'attachmini' ? '' : '<br />');
	}
	//===========================================================================================
	// If this is not an image, see if we can still display the attachment:
	//===========================================================================================
	else
	{
		$url = &$attachment['href'];
		$ext = strtolower(pathinfo($attachment['name'], PATHINFO_EXTENSION));

		// If we are allowed to embed attached SVG files, then do so:
		if (!empty($modSettings['ila_embed_svg_files']) && $ext == 'svg')
		{
			$width = (!empty($context['ila_params']['width']) ? $context['ila_params']['width'] : 0);
			$height = (!empty($context['ila_params']['height']) ? $context['ila_params']['height'] : 0);
			$html = '<img src="' .$url . '"' . (empty($width) ? '' : ' width="' . $width . '"') . (empty($height) ? '' : ' height="' . $height . '"') . ' alt="' . $attachment['name'] . '" class="bbc_img" />';
		}
		// If we are allowed to embed attached TXT files, then do so:
		elseif (!empty($modSettings['ila_embed_txt_files']) && $ext == 'txt')
		{
			require_once($sourcedir . '/Subs-Package.php');
			$html = parse_bbc(fetch_web_data($url));
		}
		// If we are allowed to embed attached PDF files, then do so:
		elseif (!empty($modSettings['ila_embed_pdf_files']) && $ext == 'pdf')
		{
			$width = (isset($context['ila_params']['width']) ? $context['ila_params']['width'] : 500);
			$height = (isset($context['ila_params']['height']) ? $context['ila_params']['height'] : 600);
			$turl = preg_replace('#index.php\?action=dlattach;topic=(\d+)\.(\d+);attach=(\d+)#i', 'attachment_$1.$2_$3.pdf', $url);
			$html = '<iframe src="http://docs.google.com/gview?url=' . $turl .'&embedded=true" width="' . $width . '" height="' . $height .'" frameborder="0"></iframe>';
		}
		// If we are allowed to embed videos, then do so for supported formats:
		elseif (!empty($modSettings['ila_embed_video_files']))
		{
			$width = (!empty($context['ila_params']['width']) ? $context['ila_params']['width'] :
				(!empty($modSettings['ila_video_default_width']) ? $modSettings['ila_video_default_width'] : 640));
			$height = (!empty($context['ila_params']['height']) ? $context['ila_params']['height'] :
				(!empty($modSettings['ila_video_default_height']) ? $modSettings['ila_video_default_height'] : 400));
			$dim = ' width="' . $width . '" height="' . $height . '"';
			$download_count = isset($modSettings['ila_video_show_download_link']) ? $modSettings['ila_video_show_download_link'] : 0;

			if ($ext == 'avi')
				$html = '<object classid="clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616"' . $dim . ' codebase="http://go.divx.com/plugin/DivXBrowserPlugin.cab">' .
						'<param name="mode" value="full" />' .
						'<param name="autoPlay" value="false" />' .
						'<param name="src" value="' . $url . '" />' .
						'<embed type="video/divx" src="' . $url . '" mode="full"' . $dim . ' autoPlay="false" pluginspage="http://go.divx.com/plugin/download/"></embed>' .
					'</object>';
			elseif ($ext == 'wmv')
				$html = '<object classid="clsid:22D6F312-B0F6-11D0-94AB-0080C74C7E95"' . $dim . ' standby="Loading Windows Media Player components..." type="application/x-oleobject" id="MediaPlayer">' .
						'<param name="FileName" value="' . $url . '">' .
						'<param name="autostart" value="false">' .
						'<param name="ShowControls" value="true">' .
						'<param name="ShowStatusBar" value="false">' .
						'<param name="ShowDisplay" value="false">' .
						'<embed type="application/x-mplayer2" src="' . $url . '" name="MediaPlayer"' . $dim . ' ShowControls="1" ShowStatusBar="0" ShowDisplay="0" autostart="0"></embed>' .
					'</object>';
			elseif ($ext == 'mp4' || $ext == 'ogv' || $ext == 'webm')
			{
				// Search for other video attachments with similar names:
				$file = array();
				$filename = pathinfo($attachment['name'], PATHINFO_FILENAME);
				foreach (array('mp4', 'ogv', 'webm', 'jpg', 'png') as $ext)
				{
					foreach ($context['ila']['attachments'][$msg] as $attachment)
						if ($attachment['name'] == $filename . '.' . $ext)
							$file[$ext] = $attachment;
				}

				// Build the video HTML to show the user:
				$img = (!empty($file['png']) ? $file['png']['href'] : (!empty($file['jpg']) ? $file['jpg']['href'] : ''));
				$html5 = !empty($modSettings['ila_video_html5']);
				$html = ($html5 ? '<video controls="controls" width="'. $width . '" height="' . $height . '">' .
					(!empty($file['mp4']['href']) ? '<source src="' . $file['mp4']['href'] . '" type="video/mp4" />' : '') .
					(!empty($file['ogv']['href']) ? '<source src="' . $file['ogv']['href'] . '" type="video/ogv" />' : '') .
					(!empty($file['webm']['href']) ? '<source src="' . $file['webm']['href'] . '" type="video/webm" />' : '') : '') .
					($html5 || !empty($file['mp4']['href']) || !empty($file['webm']['href']) ?
					'<object type="application/x-shockwave-flash" data="http://player.longtailvideo.com/player.swf" width="' . $width . '" height="' . $height .'">' .
						'<param name="movie" value="http://player.longtailvideo.com/player.swf" />' .
						'<param name="allowFullScreen" value="true" />' .
						'<param name="wmode" value="transparent" />' .
						'<param name="flashVars" value="controlbar=over&amp;' . (!empty($img) ? 'image=' . urlencode($img) . '&amp;' : '') . 'file=' . (!empty($file['mp4']['href']) ? urlencode($file['mp4']['href']) : urlencode($file['webm']['href'])) . '" />' .
						(!empty($img) ? '<img src="' . $img . '" width="' . $width . '" height="' . $height .'" title="' . $txt['ila_no_video'] . '" />' : $txt['ila_no_video']) .
					'</object>' : '') . ($html5 ? '</video>' : '');
			}
		}
	}

	//===========================================================================================
	// Add the download count to the image tag if requested:
	if (empty($html) || $download_count)
	{
		// Prepare certain elements so that the HTML building code looks at least a little nicer:
		$downloaded = (!isset($txt['attach_times']) ? sprintf($txt['attach_downloaded'], $attachment['downloads']) : $txt['attach_downloaded'] . ' ' . $attachment['downloads'] . ' ' . $txt['attach_times']);
		$viewed = (!isset($txt['attach_times']) ? sprintf($txt['attach_viewed'], $attachment['downloads']) : $txt['attach_viewed'] . ' ' . $attachment['downloads'] . ' ' . $txt['attach_times']);
		
		// Let's build the HTML code for the download count now....
		$html = (!empty($html) ? $html . '<br/>' : '') . 
			'<span class="smalltext">' .
				'<a href="' . $attachment['href'] . '"><img src="' . $settings['images_url'] . '/icons/clip.' . (!isset($txt['attach_times']) ? 'png' : 'gif') . '" align="middle" alt="*" border="0" /> ' . $attachment['name'] . '</a>' . 
				($download_count ? ($download_count >= 5 ? '<br/>' : ' ') . '(' . $attachment['size'] . ($attachment['is_image'] && !empty($dimensions['width']) ? ' . ' . $dimensions['width'] . 'x' . $dimensions['height'] . ($download_count == 6 ? ')<br/>(' : ' - ') . $viewed : ' - ' . $downloaded) . ')' : '').
			'</span>';
	}

	// Do we have something to float or put a margin around?
	if (!empty($html))
	{
		// Process all the margin parameters:
		$style = false;
		if (isset($context['ila_params']['margin']))
			$style .= ' margin: ' . $context['ila_params']['margin'] . 'px;';
		if (isset($context['ila_params']['margin-left']))
			$style .= ' margin-left: ' . $context['ila_params']['margin-left'] . 'px;';
		if (isset($context['ila_params']['margin-right']))
			$style .= ' margin-right: ' . $context['ila_params']['margin-right'] . 'px;';
		if (isset($context['ila_params']['margin-top']))
			$style .= ' margin-top: ' . $context['ila_params']['margin-top'] . 'px;';
		if (isset($context['ila_params']['margin-bottom']))
			$style .= ' margin-bottom: ' . $context['ila_params']['margin-bottom'] . 'px;';
		if (isset($context['ila_params']['border-style']))
			$style .= ' border-style: ' . $context['ila_params']['border-style'] . ';';
		if (isset($context['ila_params']['border-width']))
			$style .= ' border-width: ' . $context['ila_params']['border-width'] . 'px;';
		if (isset($context['ila_params']['border-color']))
			$style .= ' border-color: ' . $context['ila_params']['border-color'] . ';';

		// Add the margin and float params to the rest of the HTML:
		if (isset($context['ila_params']['float']) && $context['ila_params']['float'] == 'center')
			$html = '<div style="margin-left: auto; margin-right: auto; display: block;">' . $html . '</div>';
		elseif (isset($context['ila_params']['float']))
			$html = '<div style="float: ' . $context['ila_params']['float'] . ';' . (!empty($style) ? $style : '') . '">' . $html . '</div>';
		elseif (!empty($style))
		{
			if ((!empty($modSettings['ila_download_count']) && $tag['tag'] != 'attachmini') || $tag['tag'] == 'attachurl')
				$html = '<div style="' . (!empty($style) ? $style : '') . '">' . $html . '</div>';
			else
				$html = str_replace('<img src="', '<img style="' . $style . '" src="', $html);
		}
	}

	// Mark ONLY approved attachments as "don't show" if admin has checked that option:
	if (!empty($modSettings['ila_duplicate']) && !empty($attachment['is_approved']))
		$context['ila']['dont_show'][$msg][$attachment['id']] = true;

	// Return to our lord and saviour, our caller! :p
	return $html;
}

//================================================================================
// Helper functions that return HTML on how to display each attachment inline:
//================================================================================
function ILA_subfunction($id, $full, $thumb, $name, $style = '', $has_thumb = false, $expand = true)
{
	global $sourcedir, $settings, $modSettings, $context;

	// Yup, you read right: Increase attachment ID by one million! 99.99+% chance
	// of no conflict while showing attachments as thumbnails below post!
	$id += 1000000;
	
	// Are we asked not to scale the image in ANY WAY?
	$class = !empty($modSettings['ila_enable_responsive']) && empty($context['ila_params']['scale']) ? 'ila_attach' : '';

	// Is the image expandable using known highslide/lightbox viewers?
	if ($expand && !empty($modSettings['ila_highslide']))
	{
		// Load any other necessary files: (NOTE: Provided as courtesy to dcmouser)
		if (!empty($modSettings['dc_mod_enable_highslideviewer']))
			require_once($sourcedir . '/DcSubsHighslideImageViewer.php');

		// HS4SMF Installed?
		if (!empty($modSettings['hs4smf_enabled']) && function_exists('hs4smf_get_slidegroup'))
		{
			$msgid = (int) $msg;
			hs4smf_track_slidegroup($msgid); // is this needed?
			$slidegroup = hs4smf_get_slidegroup($msgid);
			if (!isset($settings['hs4smf_slideshow']) && $settings['hs4smf_img_count'] > 1)
				$settings['hs4smf_slideshow'] = 1;
			return '<a href="' . $full . ';image" id="link_' . $id . '" class="highslide' . (!empty($class) ? ' ' . $class : '') . '" onclick="return hs.expand(this, ' . $slidegroup . ')"><img src="' . $thumb . '" alt="' . $name . '"' . ' id="thumb_' . $id . '"' . $style  .' /></a>';
		}
		// Highslide Image Viewer Installed?
		elseif (function_exists('highslide_images'))
			return '<a href="' . $full . ';image" id="link_' . $id . '" class="highslide' . (!empty($class) ? ' ' . $class : '') . '" rel="highslide"><img src="' . $thumb . '" alt="' . $name . '"' . ' id="thumb_' . $id . '"' . $style . ' /></a>' . (isset($context['subject']) ? '<span class="highslide-heading">' . $context['subject'] . '</span>' : '');
		// jQLightbox Installed?
		elseif (!empty($modSettings['enable_jqlightbox_mod']) && strpos($context['html_headers'], 'jquery.prettyPhoto.css'))
			return '<a href="' . $full . ';image" id="link_' . $id . '" rel="lightbox[gallery]"><img src="' . $thumb . '"  alt="' . $name . '"' . ' id="thumb_' . $id . '"' . (!empty($class) ? ' ' . $class : '') . $style  .' /></a>';
	}

	// Okay, can't show via known highslide/lightbox viewers.  Show it via SMF methods:
	if ($has_thumb)
		return '<a href="' . $full . '" id="link_' . $id . '" onclick="return expandThumb(' . $id . ');"><img src="' . $thumb . '" alt="" id="thumb_' . $id . '"' . (!empty($class) ? ' class="' . $class . '"' : '') . ' /></a>';
	else
		return '<img src="' . $full . ';image" ' . ' alt="' . $name . '"' . ' class="bbc_img resized' . (!empty($class) ? ' ' . $class : '') . '"' . $style .' />';
}

// Attachment => Show full expanded picture
function ILA_tag_attachment(&$info, &$dim, $has_thumb, $style)
{
	$dim = array('width' => $info['width'], 'height' => $info['height']);
	return ILA_subfunction($info['id'], $info['href'], $info['href'], $info['name'], $style);
}

// Attach => Show thumbnail, expandable to full picture
function ILA_tag_attach(&$info, &$dim, $has_thumb, $style)
{
	$dim = array('width' => $info['width'], 'height' => $info['height']);
	$image = ($expand = !empty($info['thumbnail']['has_thumb'])) ? $info['thumbnail']['href'] : $info['href'];
	return ILA_subfunction($info['id'], $info['href'], $image, $info['name'], $style, $has_thumb, $expand);
}

// AttachThumb => Show thumbnail ONLY, not expandable
function ILA_tag_attachthumb(&$info, &$dim, $has_thumb, $style)
{
	$data = &$info;
	if (!empty($info['thumbnail']['has_thumb']))
		$dim = array('width' => $info['thumb_width'], 'height' => $info['thumb_height'], 'img' => $info['thumbnail']['href']);
	else
		$dim = array('width' => $info['width'], 'height' => $info['height'], 'img' => $info['href']);
	return ILA_subfunction($info['id'], $dim['href'], $dim['href'], $info['name'], $style, $has_thumb);
}

// AttachMini => Show thumbnail, expandable to full picture; exclude attachment info below
function ILA_tag_attachmini(&$info, &$dim, $has_thumb, $style)
{
	$image = ($expand = !empty($info['thumbnail']['has_thumb'])) ? $info['thumbnail']['href'] : $info['href'];
	$dim = array('width' => $info['width'], 'height' => $info['height']);
	return ILA_subfunction($info['id'], $info['href'], $image, $info['name'], $style, $has_thumb, $expand);
}

// AttachURL => Shows attachment size, image dimensions, and download count; no picture
function ILA_tag_attachurl(&$attachment, &$dim, $has_thumb, $style)
{
	return false;
}

//================================================================================
// Helper function to return the correct MIME type for certain types of files:
//================================================================================
function ILA_Mime_Type($ext, &$mime_type)
{
	$mime = array(
		'svg' => 'image/svg+xml',
		'pdf' => 'application/pdf',
		'ogv' => 'video/ogg',
		'mp4' => 'video/mp4',
		'webm' => 'video/webm',
		'avi' => 'video/x-msvideo',
		'wmv' => 'video/x-ms-wmv',
	);
	$mime_type = (isset($mime[$ext]) ? $mime[$ext] : '');
	return !empty($mime_type);
}

?>
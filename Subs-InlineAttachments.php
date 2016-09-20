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
// BBCode bbcode button hook function for the Inline Attachment mod
//================================================================================
function ILA_BBC_Buttons(&$buttons)
{
	global $txt;

	$buttons[count($buttons) - 1][] = array(
		'image' => 'attachment',
		'code' => 'attachment',
		'description' => $txt['ila_insert'],
		'before' => '[attachment=]',
		'after' => '[/attachment]',
	);
}

//================================================================================
// BBCode hook function for the Inline Attachment mod
//================================================================================
function ILA_BBCode(&$codes)
{
	// BBCode Usage: [attach=id,width,height]content ignored[/attach]
	$codes[] = array(
		'tag' => 'attach',
		'type' => 'unparsed_commas_content',
		'test' => '(\d+|\d+,\d+|\d+,\d+,\d+)\]',
		'content' => '$1',
		'validate' => 'ILA_Validate_v1x',
		'disabled_content' => '',
	);

	// BBCode Usage: [attach id=n width=x height=y float=mode]content ignored[/attach]
	$codes[] = array(
		'tag' => 'attach',
		'type' => 'unparsed_content',
		'parameters' => array(
			'id' => array('match' => '(\d+)', 'validate' => 'ILA_Param_ID'),
			'width' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Width'),
			'height' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Height'),
			'float' => array('optional' => true, 'match' => '(left|right|center)', 'validate' => 'ILA_Param_Float'),
			'margin' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Margin'),
			'scale' => array('optional' => true, 'match' => '(true|false|yes|no)', 'validate' => 'ILA_Param_Scale'),
		),
		'content' => '$1',
		'validate' => 'ILA_Validate_v20',
		'disabled_content' => '',
	);

	// BBCode Usage: [attachment=id,width,height]content ignored[/attachment]
	$codes[] = array(
		'tag' => 'attachment',
		'type' => 'unparsed_commas_content',
		'test' => '(\d+|\d+,\d+|\d+,\d+,\d+)\]',
		'content' => '$1',
		'validate' => 'ILA_Validate_v1x',
		'disabled_content' => '',
	);

	// BBCode Usage: [attachment id=n width=x height=y float=mode]content ignored[/attachment]
	$codes[] = array(
		'tag' => 'attachment',
		'type' => 'unparsed_content',
		'parameters' => array(
			'id' => array('match' => '(\d+)', 'validate' => 'ILA_Param_ID'),
			'width' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Width'),
			'height' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Height'),
			'float' => array('optional' => true, 'match' => '(left|right|center)', 'validate' => 'ILA_Param_Float'),
			'margin' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Margin'),
			'scale' => array('optional' => true, 'match' => '(true|false|yes|no)', 'validate' => 'ILA_Param_Scale'),
		),
		'content' => '$1',
		'validate' => 'ILA_Validate_v20',
		'disabled_content' => '',
	);

	// BBCode Usage: [attachmini=id,width,height]content ignored[/attachmini]
	$codes[] = array(
		'tag' => 'attachmini',
		'type' => 'unparsed_commas_content',
		'test' => '(\d+|\d+,\d+|\d+,\d+,\d+)\]',
		'content' => '$1',
		'validate' => 'ILA_Validate_v1x',
		'disabled_content' => '',
	);

	// BBCode Usage: [attachmini id=n width=x height=y float=mode]content ignored[/attachmini]
	$codes[] = array(
		'tag' => 'attachmini',
		'type' => 'unparsed_content',
		'parameters' => array(
			'id' => array('match' => '(\d+)', 'validate' => 'ILA_Param_ID'),
			'width' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Width'),
			'height' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Height'),
			'float' => array('optional' => true, 'match' => '(left|right|center)', 'validate' => 'ILA_Param_Float'),
			'margin' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Margin'),
			'scale' => array('optional' => true, 'match' => '(true|false|yes|no)', 'validate' => 'ILA_Param_Scale'),
		),
		'content' => '$1',
		'validate' => 'ILA_Validate_v20',
		'disabled_content' => '',
	);

	// BBCode Usage: [attachthumb=id,width,height]content ignored[/attachthumb]
	$codes[] = array(
		'tag' => 'attachthumb',
		'type' => 'unparsed_commas_content',
		'test' => '(\d+|\d+,\d+|\d+,\d+,\d+)\]',
		'content' => '$1',
		'validate' => 'ILA_Validate_v1x',
		'disabled_content' => '',
	);

	// BBCode Usage: [attachthumb id=n width=x height=y float=mode]content ignored[/attachthumb]
	$codes[] = array(
		'tag' => 'attachthumb',
		'type' => 'unparsed_content',
		'parameters' => array(
			'id' => array('match' => '(\d+)', 'validate' => 'ILA_Param_ID'),
			'width' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Width'),
			'height' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Height'),
			'float' => array('optional' => true, 'match' => '(left|right|center)', 'validate' => 'ILA_Param_Float'),
			'margin' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Margin'),
			'scale' => array('optional' => true, 'match' => '(true|false|yes|no)', 'validate' => 'ILA_Param_Scale'),
		),
		'content' => '$1',
		'validate' => 'ILA_Validate_v20',
		'disabled_content' => '',
	);

	// BBCode Usage: [attachurl=id,width,height]content ignored[/attachurl]
	$codes[] = array(
		'tag' => 'attachurl',
		'type' => 'unparsed_commas_content',
		'test' => '(\d+|\d+,\d+|\d+,\d+,\d+)\]',
		'content' => '$1',
		'validate' => 'ILA_Validate_v1x',
		'disabled_content' => '',
	);

	// BBCode Usage: [attachurl id=n width=x height=y float=mode]content ignored[/attachurl]
	$codes[] = array(
		'tag' => 'attachurl',
		'type' => 'unparsed_content',
		'parameters' => array(
			'id' => array('match' => '(\d+)', 'validate' => 'ILA_Param_ID'),
			'width' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Width'),
			'height' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Height'),
			'float' => array('optional' => true, 'match' => '(left|right|center)', 'validate' => 'ILA_Param_Float'),
			'margin' => array('optional' => true, 'match' => '(\d+)', 'validate' => 'ILA_Param_Margin'),
			'scale' => array('optional' => true, 'match' => '(true|false|yes|no)', 'validate' => 'ILA_Param_Scale'),
		),
		'content' => '$1',
		'validate' => 'ILA_Validate_v20',
		'disabled_content' => '',
	);
}

//================================================================================
// BBCode Validation functions
//================================================================================
function ILA_Validate_v1x(&$tag, &$data, $disabled)
{
	global $context, $txt;

	if (!isset($data[1]))
		$data = $txt['ila_invalid'];
	else
	{
		$context["ila_params"] = array(
			'width' => isset($data[2]) ? $data[2] : 0, 
			'height' => isset($data[3]) ? $data[3] : 0,
		);
		$data[0] = ILA_Validate($tag, $data[1], $data[0]);
	}
}

function ILA_Validate_v20(&$tag, &$data, $disabled)
{
	global $context, $txt;

	if (!isset($context["ila_params"]["id"]))
		$data = $txt['ila_invalid'];
	else
		$data = ILA_Validate($tag, $context["ila_params"]["id"], $data);
	unset($context["ila_params"]);
}

function ILA_Param_Scale($answer)
{
	global $context;
	$context['ila_params']['scale'] = ($answer == false || $answer == 'no');
}

function ILA_Param_ID($id)
{
	global $context;
	$context["ila_params"]['id'] = (int) max(0, $id);
}

function ILA_Param_Width($width)
{
	global $context;
	$context["ila_params"]['width'] = (int) max(0, $width);
}

function ILA_Param_Height($height)
{
	global $context;
	$context["ila_params"]['height'] = (int) max(0, $height);
}

function ILA_Param_Float($where)
{
	global $context;
	$context["ila_params"]['float'] = $where;
}

function ILA_Param_Margin($margin)
{
	global $context;
	$context["ila_params"]['margin'] = (int) max(0, $margin);
}

//================================================================================
// Hook function to add options to the Modifications Setting page
//================================================================================
function ILA_Mod_Settings(&$vars)
{
	$vars[] = array('title', 'ila_title');
	if (function_exists('hs4smf'))
		$vars[] = array('check', 'ila_highslide');
	$vars[] = array('check', 'ila_duplicate');
	$vars[] = array('check', 'ila_download_count');
	$vars[] = array('check', 'ila_turn_nosniff_off');
}

//================================================================================
// Sub-function gets attachment data so that inline attachments can be processed
//================================================================================
function ILA_Setup($msg_id, $message)
{
	global $context, $board;

	// Set some things up for performance benefits:
	$context['ila_pm_attach'] = false;
	$context['ila_attachments'] = array();
	if (!isset($context['ila_view_attachments']))
		$context['ila_view_attachments'] = allowedTo('view_attachments');
	if (!isset($context['ila_pm_view_attachments']))
		$context['ila_pm_view_attachments'] = allowedTo('pm_view_attachments');
		
	// We can't load attachments if we don't know the message id number....
	if (($context['ila_message'] = (int) $msg_id) != 0)
		ILA_Post_Attachments($msg_id);
	elseif (($context['ila_message'] = (int) str_replace('pre', '', $msg_id)) != 0)
		ILA_Post_Attachments($context['ila_message']);
	elseif (function_exists('loadPMAttachmentContext'))
	{
		if (($context['ila_message'] = (int) str_replace('pm', '', $msg_id)) != 0)
			ILA_PM_Attachments($context['ila_message']);
		elseif (($context['ila_message'] = (int) str_replace('pm_pre', '', $msg_id)) != 0)
			ILA_PM_Attachments($context['ila_message']);
	}

	// Replace attachments inside quotes and codes cause we don't know what post/PM it belongs to...
	if (!empty($message))
	{
		if (preg_match_all('#\[(code|quote)(.+?)\]([^\[]*)\[/(code|quote)\]#im'. ($context['utf8'] ? 'u' : ''), $message, $quotecode, PREG_PATTERN_ORDER))
		{
			$quotecode = array_unique($quotecode[0]);
			foreach ($quotecode as $a => $b)
				$message = str_replace($b, ILA_Remove_Tags($b), $message);
		}
	}
	return $message;
}

//================================================================================
// Sub-function dealing with gathering post attachments for ILA_Setup
//================================================================================
function ILA_Post_Attachments($msg_id)
{
	global $modSettings, $smcFunc, $attachments, $context, $sourcedir;

	// Fetch attachments for use in "parse_bbc" function...
	unset($attachments[$msg_id]);
	if (!empty($modSettings['attachmentEnable']) && $context['ila_view_attachments'])
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
	$context['ila_attachments'] = loadAttachmentContext($msg_id);
}

//================================================================================
// Sub-function dealing with gathering PM attachments for ILA_Setup
//================================================================================
function ILA_PM_Attachments($msg_id)
{
	global $modSettings, $smcFunc, $attachments, $context, $sourcedir, $user_info;

	// Fetch attachments for use in "parse_bbc" function...
	unset($attachments[$msg_id]);
	if (!empty($modSettings['pmAttachmentEnable']) && $context['ila_pm_view_attachments'])
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
	$context['ila_attachments'] = loadPMAttachmentContext($msg_id);
	$context['ila_pm_attach'] = true;
}

//================================================================================
// Function called to replace attachment tags from the message
//================================================================================
function ILA_Remove_Tags($message)
{
	global $txt, $modSettings, $context;

	// Show attachment text string or error text string in topic history
	$pattern = '#\[attachment=(.+?)\]([^\[]*)\[/attachment\]#i' . ($context['utf8'] ? 'u' : '') ;
	if (empty($modSettings['attachmentEnable']) || !$context['ila_view_attachments'])
		$message = preg_replace($pattern, $txt['ila_nopermission'], $message);
	else
		$message = preg_replace($pattern, $txt['ila_attachment'], $message);
	return $message;
}

//================================================================================
// Function to remove an attachment from the message body
//================================================================================
function ILA_Remove_Attachment($message, $query)
{
	global $context, $attachments;

	$pattern = '#\[attachment=(.+?)\]([^\[]*)\[/attachment\]#i' . ($context['utf8'] ? 'u' : '');
	if(preg_match_all($pattern, $message, $attachcode, PREG_PATTERN_ORDER))
	{
		// Figure out where the attachments will be once the requested ones are deleted:
		$msg_id = $query['id_msg'];
		ILA_Setup($msg_id, '');
		$i = 0;
		$attach = array();
		foreach ($attachments[$msg_id] as $a => $b)
		{
			if (in_array($b['id_attach'], $query['not_id_attach']))
				$attach[$b['id_attach']] = $i++;
		}
		
		// Find the unique attachment bbcodes and sort them so we don't change the same bbcode multiple times:
		$attachcode = array_unique($attachcode[0]);
		asort($attachcode);

		// Adjust or remove the attachment bbcodes so that the ones remaining still work:
		foreach ($attachcode as $txt)
		{
			if (preg_match('(\d+)', $txt, $attach_num))
			{
				if (!empty($attachments[$msg_id][(int) $attach_num[0]]['id_attach']))
				{
					$id_attach = $attachments[$msg_id][(int) $attach_num[0]]['id_attach'];
					if (!isset($attach[$id_attach]))
						$message = str_replace($txt, '', $message);
					else
						$message = str_replace($txt, '[attachment=' . $attach[$id_attach] . substr($txt, strpos($txt, $attach_num[0]) + strlen($attach_num[0])), $message);
				}
				else
					$message = str_replace($txt, '', $message);
			}
		}
	}
	return $message;
}

//================================================================================
// Validation & link building function for the Inline Attachment mod
//================================================================================
function ILA_Validate(&$tag, $id, $content)
{
	global $modSettings, $context, $txt, $settings;

	// Are attachments enabled and can we see them?  If not, return no permission message:
	if (!$context['ila_pm_attach'] && (empty($modSettings['attachmentEnable']) || !$context['ila_view_attachments']))
		return $txt['ila_nopermission'];
	if ($context['ila_pm_attach'] && (empty($modSettings['pmAttachmentEnable']) || !$context['ila_pm_view_attachments']))
		return $txt['ila_nopermission'];

	// Does the specified attachment exist?  If not, return attachment invalid message:
	if (!isset($context['ila_attachments'][$id]))
		return $txt['ila_invalid'];

	// Mark attachment as "don't show" if admin has checked that option:
	$attachment = &$context['ila_attachments'][$id];
	if (!empty($modSettings['ila_duplicate']))
		$context['dontshowattachment'][$attachment['id']] = true;

	// Return empty string if a non-image attachment was requested:
	if (!$attachment['is_image'] && $tag['tag'] != 'attachmini')
		return '<div class="smalltext"><a href="' . $attachment['href'] . '"><img src="' . $settings['images_url'] . '/icons/clip.gif" align="middle" alt="*" border="0" />&nbsp;' . $attachment['name'] . '</a> ('. $attachment['size']. ($attachment['is_image'] ? '. ' . $attachment['real_width'] . 'x' . $attachment['real_height'] . ' - ' . $txt['attach_viewed'] : ' - ' . $txt['attach_downloaded']) . ' ' . $attachment['downloads'] . ' ' . $txt['attach_times'] . '.)</div>';
	elseif (!$attachment['is_image'])
		return '';

	// If neither width nor height is set, use the global max image size settings:
	$max_width = &$context["ila_params"]['width'];
	$max_height = &$context["ila_params"]['height'];
	if (empty($max_width) && empty($max_height))
	{
		$max_width = $modSettings['max_image_width'];
		$max_height = $modSettings['max_image_height'];
	}

	// Figure out which parameters we are going to use:
	$use_thumbnail = ($tag['tag'] == 'attachthumb') || ($tag['tag'] == 'attach' && !empty($attachment['thumbnail']['has_thumb']));
	$src_width = $real_width = ($use_thumbnail ? $attachment['thumb_width'] : $attachment['real_width']);
	$src_height = $real_height = ($use_thumbnail ? $attachment['thumb_height'] : $attachment['real_height']);
	$thumb = ($use_thumbnail && !empty($attachment['thumbnail']['has_thumb']) ? $attachment['thumbnail']['href'] : $attachment['href']);
	$image = ($tag['tag'] == 'attachthumb' ? $thumb : $attachment['href']);

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
	$float = (isset($context["ila_params"]['float']) ? ' style="float:' . $context["ila_params"]['float'] . (isset($context["ila_params"]['margin']) ? '; margin:' . $context["ila_params"]['margin'] . 'px' : '') . '"' : '');
	$margin = (!isset($context["ila_params"]['float']) && isset($context["ila_params"]['margin']) ? ' style="margin:' . $context["ila_params"]['margin'] . 'px"' : '');

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

	// Add the download count to the image tag if requested:
	if (!empty($modSettings['ila_download_count']) && $tag['tag'] != 'attachmini')
		$html .= '<div class="smalltext"><a href="' . $image . '"><img src="' . $settings['images_url'] . '/icons/clip.gif" align="middle" alt="*" border="0" />&nbsp;' . $attachment['name'] . '</a> ('. $attachment['size']. ($attachment['is_image'] ? '. ' . $src_width . 'x' . $src_height . ' - ' . $txt['attach_viewed'] : ' - ' . $txt['attach_downloaded']) . ' ' . $attachment['downloads'] . ' ' . $txt['attach_times'] . '.)</div>';

	// Clear the parameter set for the next usage and return string to caller:
	unset($context["ila_params"]);
	return $html;
}

?>
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
// Hook function to add options to the Modifications Setting page
//================================================================================
function ILA_Mod_Settings(&$vars)
{
	$vars[] = array('title', 'ila_title');
	if (function_exists('hs4smf'))
		$vars[] = array('check', 'ila_highslide');
	$vars[] = array('check', 'ila_duplicate');
	$vars[] = array('check', 'ila_download_count');
}

//================================================================================
// BBCode hook function for the Inline Attachment mod
//================================================================================
function ILA_BBCode(&$codes)
{
	// Usage: [attachment=n][/attachment]
	// Purpose: Shows full-size (or scaled-down) image of the attachment
	$codes[] = array(
		'tag' => 'attachment',
		'type' => 'unparsed_commas_content',
		'test' => '(\d+|\d+,\d+|\d+,\d+,\d+)\]',
		'content' => '$1',
		'validate' => create_function('&$tag, &$data, $disabled', '
			if (!isset($disabled[\'attachment\']))
				$data[0] = ILA_Validate($data);
			elseif (!empty($data[0]))
				$data[0] = \'[ \' . $data[0] . \' ]\';'
		),
		'block_level' => true,
		'content' => '$1',
		'disabled_content' => '$1',
	);
}

//================================================================================
// Sub-function gets attachment data so that inline attachments can be processed
//================================================================================
function ILA_Setup($msg_id, $message)
{
	global $context;

	// We can't load attachments if we don't know the message id number....
	$context['ila_pm_attach'] = false;
	$context['ila_attachments'] = array();
	if (($context['ila_message'] = (int) $msg_id) != 0)
		ILA_Post_Attachments($msg_id);
	elseif (($context['ila_message'] = (int) str_replace('pm', '', $msg_id)) != 0 && function_exists('loadPMAttachmentContext'))
		ILA_PM_Attachments($context['ila_message']);

	// Replace attachments inside quotes and codes cause we don't know what post/PM it belongs to...
	if (!empty($message))
	{
		if(preg_match_all('#\[(code|quote)(.+?)\]([^\[]*)\[/(code|quote)\]#im'. ($context['utf8'] ? 'u' : ''), $message, $quotecode, PREG_PATTERN_ORDER))
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
	if (!empty($modSettings['attachmentEnable']) && allowedTo('view_attachments'))
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
	if (!empty($modSettings['pmAttachmentEnable']) && allowedTo('pm_view_attachments'))
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
// Validation function for the Inline Attachment mod
//================================================================================
function ILA_Validate($data)
{
	global $modSettings, $context, $txt, $settings;

	// Are attachments enabled and can we see them?  If not, return no permission message:
	if (!$context['ila_pm_attach'] && (empty($modSettings['attachmentEnable']) || !allowedTo('view_attachments')))
		return $txt['ila_nopermission'];
	if ($context['ila_pm_attach'] && (empty($modSettings['pmAttachmentEnable']) || !allowedTo('pm_view_attachments')))
		return $txt['ila_nopermission'];

	// Does the specified attachment exist?  If not, return attachment invalid message:
	$attach = &$context['ila_attachments'];
	if (!isset($attach[$data[1]]))
		return $txt['ila_invalid'];

	// Mark attachment as "don't show" if admin has checked that option:
	$attachment = $attach[$data[1]];
	if (!empty($modSettings['ila_duplicate']))
		$context['dontshowattachment'][$attachment['id']] = true;

	// Return empty string if a non-image attachment was requested:
	if (!$attachment['is_image'])
		return '<div class="smalltext"><a href="' . $attachment['href'] . '"><img src="' . $settings['images_url'] . '/icons/clip.gif" align="middle" alt="*" border="0" />&nbsp;' . $attachment['name'] . '</a> ('. $attachment['size']. ($attachment['is_image'] ? '. ' . $attachment['real_width'] . 'x' . $attachment['real_height'] . ' - ' . $txt['attach_viewed'] : ' - ' . $txt['attach_downloaded']) . ' ' . $attachment['downloads'] . ' ' . $txt['attach_times'] . '.)</div>';

	// Scale the image if it is too large:
	$data[2] = isset($data[2]) ? $data[2] : $modSettings['max_image_width'];
	$data[3] = isset($data[3]) ? $data[3] : $modSettings['max_image_height'];
	if (!empty($data[2]) && $attachment['real_width'] > $data[2])
	{
		$attachment['real_height'] = (int) (($data[2] * $attachment['real_height']) / $attachment['real_width']);
		$attachment['real_width'] = $data[2];
	}
	if (!empty($data[3]) && $attachment['real_height'] > $data[3])
	{
		$attachment['real_width'] = (int) (($data[3] * $attachment['real_width']) / $attachment['real_height']);
		$attachment['real_height'] = $data[3];
	}

	// Build the replacement string for the caller:
	$html = (!empty($data[2]) ? ' width="' . $attachment['real_width'] . '"' : '');
	$html .=  (!empty($data[3]) ? ' height="'. $attachment['real_height'] .'"' : '');
	$html = '<img src="' . $attachment['href'] . ';image" alt=""' . $html . ' class="bbc_img resized" />';
	if (!empty($modSettings['ila_highslide']) && function_exists('hs4smf'))
		$html = '<a href="' . $attachment['href'] . ';image" id="link_' . $attachment['id'] . '" class="highslide" onclick="return hs.expand(this, { slideshowGroup: \'' . $context['ila_message'] . '\' })">' . str_replace('bbc_img resized', 'bbc_img', $html) . '</a>';
	if (!empty($modSettings['ila_download_count']))
		$html .= '<br/><div class="smalltext"><a href="' . $attachment['href'] . '"><img src="' . $settings['images_url'] . '/icons/clip.gif" align="middle" alt="*" border="0" />&nbsp;' . $attachment['name'] . '</a> ('. $attachment['size']. ($attachment['is_image'] ? '. ' . $attachment['real_width'] . 'x' . $attachment['real_height'] . ' - ' . $txt['attach_viewed'] : ' - ' . $txt['attach_downloaded']) . ' ' . $attachment['downloads'] . ' ' . $txt['attach_times'] . '.)</div>';

	// Return replacement string to the caller:
	return $html;
}

//================================================================================
// Function called to replace attachment tags from the message
//================================================================================
function ILA_Remove_Tags($message)
{
	global $txt, $modSettings, $context;

	// Show attachment text string or error text string in topic history
	$pattern = '#\[attachment=(.+?)\]([^\[]*)\[/attachment\]#i' . ($context['utf8'] ? 'u' : '') ;
	if (empty($modSettings['attachmentEnable']) || !allowedTo('view_attachments'))
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

?>
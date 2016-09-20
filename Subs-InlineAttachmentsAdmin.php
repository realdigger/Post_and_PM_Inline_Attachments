<?php
/**********************************************************************************
* Subs-InlineAttachmentsAdmin.php - Subs of Inline Attachment mod
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
// Hook functions to add new subsection to the Modifications Setting page:
//================================================================================
function ILA_Admin_Menu_Hook(&$area)
{
	global $txt;
	loadLanguage('InlineAttachmentsAdmin');
	$area['layout']['areas']['manageattachments']['subsections']['ila'] = array($txt['ila_admin_settings']);
}

function ILA_Admin_Settings_Hook(&$sub)
{
	$sub['ila'] = 'ILA_Admin_Settings';
}

function ILA_Admin_Settings($return_config = false)
{
	global $context, $modSettings, $txt, $scripturl, $sourcedir, $forum_version;
	isAllowedTo('admin_forum');

	// Load required stuff in order to make this work right:
	require_once($sourcedir . '/ManagePermissions.php');
	require_once($sourcedir . '/ManageServer.php');

	// Get latest version of the mod and display whether current mod is up-to-date:
	if (($file = cache_get_data('ila_mod_version', 86400)) == null)
	{
		$file = file_get_contents('http://www.xptsp.com/tools/mod_version.php?url=Post_and_PM_Inline_Attachments');
		cache_put_data('ila_mod_version', $file, 86400);
	}
	if (preg_match('#Post_and_PM_Inline_Attachments_v(.+?)\.zip#i', $file, $version))
	{
		if (isset($modSettings['ila_version']) && $version[1] > $modSettings['ila_version'])
			$context['settings_body'] = '<strong>' . sprintf($txt['ila_no_update'], $version[1]) . '</strong>';
		else
			$context['settings_body'] = '<strong>' . $txt['ila_no_update'] . '</strong>';
	}

	// Assemble the options available in this mod:
	if (!isset($modSettings['ila_insert_tag']))
		$modSettings['ila_insert_tag'] = 'attachment';
	if ($tapatalk = file_exists($sourcedir . '/Subs-Tapatalk.php'))
		$modSettings['ila_allow_quoted_images'] = 0;
	$tags = array();
	foreach (ILA_tags() as $tag)
		$tags[$tag] = $tag;
	$config_vars = array(
		array('select', 'ila_insert_tag', $tags),
		array('check', 'ila_attach_same_as_attachment'),
		'',
		array('check', 'ila_highslide', ((function_exists('hs4smf') || function_exists('highslide_images') || (!empty($modSettings['enable_jqlightbox_mod']) && strpos($context['html_headers'], 'jquery.prettyPhoto.css'))) ? 99 : 'disabled') => true),
		array('check', 'ila_one_based_numbering'),
		array('check', 'ila_allow_quoted_images', ($tapatalk ? 'disabled' : 99) => true),
		array('check', 'ila_duplicate'),
		array('select', 'ila_download_count', array($txt['ila_download_count_n'], $txt['ila_download_count_f'], $txt['ila_download_count_fs'], $txt['ila_download_count_fsd'], $txt['ila_download_count_fsdc'], $txt['ila_download_count_fsdc2'], $txt['ila_download_count_fsdc3'])),
		array('int', 'ila_transparent', 'javascript' => 'onchange="validateOpacity();"'),
		'',
		array('check', 'ila_embed_video_files', 'javascript' => 'onchange="toggleVideo();"'),
		array('check', 'ila_video_options_start', 'type' => 'callback'), 	// <== Begin hidden video options section
		array('int', 'ila_video_default_width', 'javascript' => 'onchange="validateWidth();"'),
		array('int', 'ila_video_default_height', 'javascript' => 'onchange="validateHeight();"'),
		array('check', 'ila_video_show_download_link'),
		array('check', 'ila_video_html5'),
		array('check', 'ila_video_options_end', 'type' => 'callback'),		// <== Finish hidden video options section
		'',
		array('check', 'ila_embed_svg_files'),
		array('check', 'ila_embed_txt_files'),
		array('check', 'ila_embed_pdf_files'),
		'',
		array('check', 'ila_turn_nosniff_off', (substr($forum_version, 0, 7) == 'SMF 2.0' ? 99 : 'disabled') => true),
		array('check', 'ila_display_exif', (file_exists($sourcedir . '/exif.php') ? 99 : 'disabled') => true),
	);
	if ($return_config)
		return $config_vars;

	// Set up for showing settings to the user:
	$context['sub_template'] = 'show_settings';
	$context['settings_title'] = $txt['ila_title'];
	$context['post_url'] = $scripturl . '?action=admin;area=manageattachments;sa=ila;save';

	// We want javascript for our video options.
	$context['settings_insert_below'] = '
		<script type="text/javascript"><!-- // --><![CDATA[
			function toggleVideo()
			{
				var checked = document.getElementById("ila_embed_video_files").checked;
				document.getElementById("ila_video_options").style.display = (checked ? "" : "none");
			}
			function validateOpacity()
			{
				value = document.getElementById("ila_transparent").value;
				document.getElementById("ila_transparent").value = Math.max(0, Math.min(100, value));
			}
			function validateWidth()
			{
				value = document.getElementById("ila_video_default_width").value;
				document.getElementById("ila_video_default_width").value = Math.max(0, value);
			}
			function validateHeight()
			{
				value = document.getElementById("ila_video_default_height").value;
				document.getElementById("ila_video_default_height").value = Math.max(0, value);
			}
			toggleVideo();
		// ]]></script>';

	// Set certain fields to default values if they aren't already set:
	$modSettings['ila_transparent'] = (isset($modSettings['ila_transparent']) ? $modSettings['ila_transparent'] : 40);
	$modSettings['ila_video_default_width'] = (isset($modSettings['ila_video_default_width']) ? $modSettings['ila_video_default_width'] : 640);
	$modSettings['ila_video_default_height'] = (isset($modSettings['ila_video_default_height']) ? $modSettings['ila_video_default_height'] : 400);

	// Saving?
	if (isset($_GET['save']))
	{
		checkSession();
		$_POST['ila_opacity'] = min(100, max(0, (isset($_POST['ila_opacity']) ? $_POST['ila_opacity'] : 40)));
		$old = (isset($modSettings['ila_one_based_numbering']) ? $modSettings['ila_one_based_numbering'] : 0);
		saveDBSettings($config_vars);
		$redirect = -1;
		if (!empty($old) && empty($_POST['ila_one_based_numbering']))
			$redirect = ILA_Admin_Adjust(false);
		elseif (empty($old) && !empty($_POST['ila_one_based_numbering']))
			$redirect = ILA_Admin_Adjust(true);
		if ($redirect)
			redirectexit('action=admin;area=manageattachments;sa=ila;done');
	}
	// Haven't completed the renumbering thing yet?
	elseif (isset($_GET['ascend']) || isset($_GET['descend']))
	{
		checkSession();
		if (ILA_Admin_Adjust( isset($_GET['ascend']) ))
			redirectexit('action=admin;area=manageattachments;sa=ila;done');
	}
	prepareDBSettingContext($config_vars);
}

//================================================================================
// Template callback functions needed for hiding video options:
//================================================================================
function template_callback_ila_video_options_start()
{
	echo '<div id="ila_video_options">';
}

function template_callback_ila_video_options_end()
{
	echo '</div>';
}

//================================================================================
// Helper function to deal with adjusting all ILA bbcodes when options change:
//================================================================================
function ILA_Admin_Adjust($ascending = true)
{
	global $smcFunc, $context;
	isAllowedTo('admin_forum');

	// Set some variables before we start:
	$start_time = time();
	$change_by = ($ascending ? 1 : -1);
	$start = (isset($_POST['start']) ? (int) $_POST['start'] : 0);
	$count = (isset($_POST['count']) ? (int) $_POST['count'] : 0);
	$last_step = (isset($_POST['step']) ? (int) $_POST['step'] : 0);
	$step = 0;
	$tags = ILA_tags();

	// There are two cycles to this operation: posts & PMs....
	foreach (array(array('messages', 'id_msg'), array('personal_messages', 'id_pm')) as $cycle)
	{
		// Process only the posts that has at least one ILA tag within it:
		foreach ($tags as $tag)
		{
			// Skip tags we've already covered.	 Unset tag parameter once we get there....
			$step++;
			if ($step < $last_step)
				continue;

			// Get the number of posts that have an ILA tag within it:
			$request = $smcFunc['db_query']('', '
				SELECT COUNT(*) AS count
				FROM {db_prefix}' . $cycle[0] . '
				WHERE body LIKE "%' . $tag . '=%"
					OR body LIKE "%' . $tag . ' id=%"',
				array(
				)
			);
			$row = $smcFunc['db_fetch_assoc']($request);
			$smcFunc['db_free_result']($request);
			$max = $row['count'];

			// Start processing messages with the ILA tag in it:
			do 
			{
				$request = $smcFunc['db_query']('', '
					SELECT ' . $cycle[1] . ', body
					FROM {db_prefix}' . $cycle[0] . '
					WHERE body LIKE "%' . $tag . '=%"
						OR body LIKE "%' . $tag . ' id=%"
					LIMIT {int:start}, 100',
					array(
						'start' => $start,
					)
				);
				while ($row = $smcFunc['db_fetch_assoc']($request))
				{
					// Does this message have the bbcode are looking for?
					$count++;
					$pattern = '#\[(' . $tag . '(=| id=))(\d+)(|(,| )(.+?))\]#i' . ($context['utf8'] ? 'u' : '');
					if (!preg_match_all($pattern, $row['body'], $attachtags, PREG_PATTERN_ORDER))
						continue;

					// If ascending, sort in reverse order.	 If descending, sort in normal order.
					// We do this to keep from overwriting the wrong attachment ID during this operation!
					$attachtags = array_unique($attachtags[0]);
					if ($ascending)
						arsort($attachtags);
					else
						asort($attachtags);

					// Change the attachment ID number that the bbcode is using:
					$begin = $end = '';
					foreach ($attachtags as $txt)
					{
						if (preg_match('#\[' . $tag . '(=| id=)(\d+)(|(,| )(.+?))\]#i', $txt, $params))
						{
							$begin .= 'REPLACE(';
							$end = ', "[' . $tag . $params[1] . $params[2] . '", "[' . $tag . $params[1] . ($params[2] + $change_by) . '")' . $end;
						}
					}

					// Modify the message in the database so that it is correct:
					$smcFunc['db_query']('', '
						UPDATE {db_prefix}' . $cycle[0] . '
						SET body = ' . $begin . 'body' . $end . '
						WHERE ' . $cycle[1] . ' = {int:id}',
						array(
							'id' => $row[$cycle[1]],
						)
					);

					// If more than 5 seconds have passed, tell the user "not done yet"....
					if (time() - $start_time > 5)
					{
						$smcFunc['db_free_result']($request);
						$context['sub_template'] = 'not_done';
						$context['substep_enabled'] = true;
						$context['substep_continue_percent'] = floor(($count / $max) * 100);
						$context['continue_percent'] = floor( ( (($step - 1) / (count($tags) * 2)) + ($context['substep_continue_percent'] * (1 / count($tags) * 2)) ) * 100);
						$context['continue_get_data'] = 'action=admin;area=manageattachments;sa=ila;' . ($ascending ? 'ascend' : 'descend');
						$context['continue_post_data'] = '<input type="hidden" name="' . $context['session_var'] . '" value="' . $context['session_id'] . '" />
					<input type="hidden" name="step" value="' . $step .'" />
					<input type="hidden" name="count" value="' . $count . '" />
					<input type="hidden" name="start" value="' . $start . '" />';
						$context['continue_countdown'] = 5;
						return false;
					}
				}
				$smcFunc['db_free_result']($request);
			} while ($count < $max);

			// Yay! We're done with this one!  Reset the starting point to 0 and go to next tag:
			$count = $start = 0;
		}
	}
	return true;
}

?>
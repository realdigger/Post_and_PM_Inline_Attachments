<?php
/**********************************************************************************
* add_remove_hooks.php                                                            *
***********************************************************************************
* This mod is licensed under the 2-clause BSD License, which can be found here:
*	http://opensource.org/licenses/BSD-2-Clause
***********************************************************************************
* This program is distributed in the hope that it is and will be useful, but	  *
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY	  *
* or FITNESS FOR A PARTICULAR PURPOSE.											  *
***********************************************************************************
* This file is a simplified database installer. It does what it is suppoed to.    *
**********************************************************************************/
global $modSettings;

// If we have found SSI.php and we are outside of SMF, then we are running standalone.
if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
	require_once(dirname(__FILE__) . '/SSI.php');
elseif (!defined('SMF')) // If we are outside SMF and can't find SSI.php, then throw an error
	die('<b>Error:</b> Cannot install - please verify you put this file in the same place as SMF\'s SSI.php.');
db_extend('packages');
	
// Define the hooks
$hook_functions = array(
// BBCode stuff:
	'integrate_pre_include' => '$sourcedir/Subs-InlineAttachments.php',
	'integrate_bbc_codes' => 'ILA_BBCode',
	'integrate_load_theme' => 'ILA_Load_Theme',
// Admin stuff:
	'integrate_admin_include' => '$sourcedir/Subs-InlineAttachmentsAdmin.php',
	'integrate_admin_areas' => 'ILA_Admin_Menu_Hook',
// SMF 2.1+ stuff (emulated for SMF 2.0.x):
	'integrate_manage_attachments' => 'ILA_Admin_Settings_Hook',
);

// Adding or removing them?
$insert = "\n# POST AND PM INLINE ATTACHMENTS BEGINS\nRewriteEngine on\nRewriteRule attachment_(\\d+)\.(\\d+)_(\\d+)\.pdf index.php?action=dlattach;topic=$1.$2;attach=$3\n# POST AND PM INLINE ATTACHMENTS ENDS\n";
if (!empty($context['uninstalling']))
{
	$call = 'remove_integration_function';

	// Update the .htaccess file to remove our edits!
	$oldHtaccess = file_get_contents($boarddir . '/.htaccess');
	$oldHtaccess = str_replace($insert, '', $oldHtaccess);
	if ($handle = fopen($boarddir . '/.htaccess', 'w'))
	{
		fwrite($handle, $oldHtaccess);
		fclose($handle);
		@chmod($boarddir . '/.htaccess', 0755);
	}
}
else
{
	$call = 'add_integration_function';

	// Set all mod settings that aren't already set:
	$new = array(
		'ila_insert_tag' => 'attachment',
		'ila_attach_same_as_attachment' => 0,
		'ila_highslide' => 1,
		'ila_one_based_numbering' => 0,
		'ila_allow_quoted_images' => 1,
		'ila_duplicate' => 1,
		'ila_download_count' => 0,
		'ila_transparent' => 40,
		'ila_embed_video_files' => 0,
		'ila_video_default_width' => 640,
		'ila_video_default_height' => 400,
		'ila_video_show_download_link' => 0,
		'ila_video_html5' => 1,
		'ila_embed_svg_files' => 0,
		'ila_embed_txt_files' => 0,
		'ila_embed_pdf_files' => 0,
		'ila_turn_nosniff_off' => 0,
		'ila_insert_format' => 2,
		'ila_display_exif' => 0,
	);
	foreach ($new as $key => $ignore)
		if (isset($modSettings[$key]))
			unset($new[$key]);

	// Capture mod version number during the run of this script:
	$contents = file( dirname(__FILE__) . '/package-info.xml' );
	if (preg_match('#\<version\>(.+?)\</version\>#i', implode('', $contents), $version))
		$new['ila_version'] = $version[0];
	updateSettings( $new );

	// Update the .htaccess file so that we can send external sites a good short URL:
	$oldHtaccess = @file_get_contents($boarddir . '/.htaccess');
	$oldHtaccess = str_replace($insert, '', $oldHtaccess) . $insert;
	if ($handle = fopen($boarddir . '/.htaccess', 'w'))
	{
		fwrite($handle, $oldHtaccess);
		fclose($handle);
		@chmod($boarddir . '/.htaccess', 0755);
	}
}

// Do the deed
foreach ($hook_functions as $hook => $function)
	$call($hook, $function);

if (SMF == 'SSI')
   echo 'Congratulations! You have successfully installed this mod!';

?>
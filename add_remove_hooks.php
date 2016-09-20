<?php
/**********************************************************************************
* add_remove_hooks.php                                                            *
***********************************************************************************
* This program is distributed in the hope that it is and will be useful, but      *
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY    *
* or FITNESS FOR A PARTICULAR PURPOSE.                                            *
*                                                                                 *
* This file is a simplified database installer. It does what it is suppoed to.    *
**********************************************************************************/

// If we have found SSI.php and we are outside of SMF, then we are running standalone.
if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
	require_once(dirname(__FILE__) . '/SSI.php');
elseif (!defined('SMF')) // If we are outside SMF and can't find SSI.php, then throw an error
	die('<b>Error:</b> Cannot install - please verify you put this file in the same place as SMF\'s SSI.php.');
db_extend('packages');
	
// Define the hooks
$hook_functions = array(
	'integrate_pre_include' => '$sourcedir/Subs-InlineAttachments.php',
	'integrate_bbc_codes' => 'ILA_BBCode',
	'integrate_admin_areas' => 'ILA_Admin_Menu_Hook',
	'integrate_manage_attachments' => 'ILA_Admin_Settings_Hook',
);

// Adding or removing them?
if (!empty($context['uninstalling']))
	$call = 'remove_integration_function';
else
{
	$call = 'add_integration_function';
	
	// Add some new settings if they haven't been set yet:
	$new = array(
		'ila_highslide' => 1,
		'ila_duplicate' => 1,
		'ila_download_count' => 0,
		'ila_turn_nosniff_off' => 0,
		'ila_one_based_numbering' => 0,
		'ila_attach_same_as_attachment' => 0,
		'ila_allow_quoted_images' => 1,
		'ila_display_exif' => 0,
		'ila_dont_process_quotes' => 0,
		'ila_allow_playing_videos' => 0,
		'ila_insert_tag' => 'attachment',
	);

	// Capture mod version number during the run of this script:
	$contents = file( dirname(__FILE__) . '/package-info.xml' );
	if (preg_match('#\<version\>(.+?)\</version\>#i', implode('', $contents), $version))
		$new['ila_version'] = $version[0];
	updateSettings( $new );
}

// Do the deed
foreach ($hook_functions as $hook => $function)
	$call($hook, $function);

if (SMF == 'SSI')
   echo 'Congratulations! You have successfully installed this mod!';

?>
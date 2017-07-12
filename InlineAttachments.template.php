<?php
/**********************************************************************************
* InlineAttachments.template.php - Template of Inline Attachment mod
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
// Template functions necessary to perform the popup:
//================================================================================
function template_ILA_popup_above()
{
	global $txt, $scripturl, $settings;
	
	echo '
	<div id="ila_popup" class="ila_overlay">
		<div class="ila_popup">
			<div class="cat_bar">
				<h3 class="catbg">
					<span class="ie6_header floatleft">', $txt['ila_popup_title'], '</span>
				</h3>
			</div>
			<a class="ila_close" href="#" onclick="history.go(-1); return false;">&times;</a>
			<div class="ila_content">', $parsed['body'], '</div>
		</div>
	</div>';
}

function template_ILA_popup_below()
{
}

function template_ILA_popup_trigger()
{
	global $boardurl, $txt;
	echo ' <a class="button" href="#ila_popup"><img src="', $boardurl, '/Themes/default/images/helptopics.gif" class="icon" alt="', $txt['ila_popup_title'], '"></a>';
}

?>
<?php
/**********************************************************************************
* InlineAttachments.english.php - English language file
***********************************************************************************
* This mod is licensed under the 2-clause BSD License, which can be found here:
*	http://opensource.org/licenses/BSD-2-Clause
***********************************************************************************
* This program is distributed in the hope that it is and will be useful, but      *
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY    *
* or FITNESS FOR A PARTICULAR PURPOSE.                                            *
**********************************************************************************/
if (!defined('SMF')) 
	die('Hacking attempt...');

$txt['ila_insert'] = 'Insert Attachment %d';
$txt['ila_attachment'] = ' [ Attachment ] ';
$txt['ila_attachment_preview'] = '[ Attachment Placeholder ]';
$txt['ila_nopermission'] = ' [ You are not allowed to view attachments ] ';
$txt['ila_invalid'] = ' [ Invalid Attachment ] ';
$txt['ila_unapproved'] = ' [ Attachment has not been approved yet ] ';
$txt['ila_not_uploaded'] = ' [ Attachment has not been uploaded yet ] ';
$txt['ila_pdf1'] = 'It appears you don\'t have Adobe Reader or PDF support in this web browser.';
$txt['ila_pdf2'] = 'Click here to download the PDF.';
$txt['ila_no_video'] = 'No video playback capabilities, please download the video below.';

$txt['ila_popup_title'] = 'Inline Attachment parameters';
$txt['ila_popup_body'] = '[table]
[tr][td]id[/td][td]{attachment id}[/td][td]ID number of the attachment to show inline (NOT attachment number!)[/td][/tr]
[tr][td]width[/td][td]{width}[/td][td]Desired width of image to show.  Valid: positive integers.[/td][/tr]
[tr][td]height[/td][td]{height}[/td][td]Desired height of image to show.  Valid: positive integers.[/td][/tr]
[tr][td]float[/td][td]{float}[/td][td]Floats image to relation to everything else.  Valid: left, right, center[/td][/tr]
[tr][td]margin[/td][td]{pixels}[/td][td]Margin around inline attachment.  Valid: positive integers[/td][/tr]
[tr][td]margin-left[/td][td]{pixels}[/td][td]Left margin around inline attachment.  Valid: positive integers[/td][/tr]
[tr][td]margin-right[/td][td]{pixels}[/td][td]Right margin around inline attachment.  Valid: positive integers[/td][/tr]
[tr][td]margin-top[/td][td]{pixels}[/td][td]Top margin around inline attachment.  Valid: positive integers[/td][/tr]
[tr][td]margin-bottom[/td][td]{pixels}[/td][td]Bottom margin around inline attachment.  Valid: positive integers[/td][/tr]
[tr][td]border-style[/td][td]{style}[/td][td]Border style.  Valid: none, dotted, dashed, solid, double, groove, ridge, inset, outset[/td][/tr]
[tr][td]border-width[/td][td]{pixels}[/td][td]Border width around inline attachment.  Valid: positive integers[/td][/tr]
[tr][td]border-color[/td][td]{color}[/td][td]Border color.  Valid formats: plain text, #xxx, #xxxxxx, rbg(d,d,d)[/td][/tr]
[tr][td]scale[/td][td]{answer}[/td][td]Override scaling of image.  Valid: true, false, yes, no[/td][/tr]
[tr][td]msg[/td][td]{msg ID}[/td][td]Message ID number.  Valid: positive integers.[/td][/tr]
[/table]';

?>
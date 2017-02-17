<?php
/**********************************************************************************
* InlineAttachments.spanish_latin-utf8.php - Latin Spanish language file
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

$txt['ila_insert'] = 'Insertar archivo adjunto %d';
$txt['ila_attachment'] = ' [ Archivo adjunto ] ';
$txt['ila_nopermission'] = ' [ No tienes permiso para ver el/los archivo(s) adjunto(s) ] ';
$txt['ila_invalid'] = ' [ Archivo adjunto Inválido ] ';
$txt['ila_unapproved'] = ' [ Archivo adjunto que todavía no ha sido aprobado ] ';
$txt['ila_not_uploaded'] = ' [ Archivo adjunto que aún no se ha subido ] ';
$txt['ila_pdf1'] = 'Parece que no tiene Adobe Reader o compatibilidad con PDF en este navegador web :( !!!.';
$txt['ila_pdf2'] = 'Haga clic aquí para descargar el PDF.';
$txt['ila_no_video'] = 'No hay capacidades de reproducción de vídeo, por favor descarga el vídeo a continuación.';

$txt['ila_help_msg'] = '
id=<strong>{attachment id}</strong> => ID number of the attachment to show inline (NOT attachment number!)
width=<strong>{width}</strong> => Desired width of image to show.  Valid: positive integers.
height=<strong>{height}</strong> => Desired height of image to show.  Valid: positive integers.
float=<strong>{float}</strong> => Floats image to relation to everything else.  Valid: left, right, center
margin=<strong>{pixels}</strong> => Margin around inline attachment.  Valid: positive integers
margin-left=<strong>{pixels}</strong> => Left margin around inline attachment.  Valid: positive integers
margin-right=<strong>{pixels}</strong> => Right margin around inline attachment.  Valid: positive integers
margin-top=<strong>{pixels}</strong> => Top margin around inline attachment.  Valid: positive integers
margin-bottom=<strong>{pixels}</strong> => Bottom margin around inline attachment.  Valid: positive integers
border-style=<strong>{style}</strong> => Border style.  Valid: none, dotted, dashed, solid, double, groove, ridge, inset, outset
border-width=<strong>{pixels}</strong> => Border width around inline attachment.  Valid: positive integers
border-color=<strong>{color}</strong> => Border color.  Valid formats: plain text, #xxx, #xxxxxx, rbg(d,d,d)
scale=<strong>{answer}</strong> => Override scaling of image.  Valid: true, false, yes, no
msg=<strong>{msg ID}</strong> => Message ID number.  Valid: positive integers.
';

?>
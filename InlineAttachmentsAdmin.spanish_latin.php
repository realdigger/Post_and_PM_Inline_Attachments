<?php
/**********************************************************************************
* InlineAttachmentsAdmin.spanish_latin.php - Latin Spanish language file
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

global $helptxt;

// Regular language strings:
$txt['ila_admin_settings'] = 'Insertar archivo adjunto';
$txt['ila_new_version'] = 'Correos y adjuntos PM en l&iacute;nea tiene una versi&oacute;n %s disponible para su descarga!';
$txt['ila_no_update'] = 'Su instalaci&oacute;n de correos y PM adjuntos en l&iacute;nea se encuentra actualizado a la fecha!';
$txt['ila_completed_singular'] = '1 mensaje con etiquetas de datos adjuntos en l&iacute;nea se han actualizado!';
$txt['ila_completed_plural'] = '%d mensajes con datos adjuntos en l&iacute;nea, las etiquetas se han actualizado!';

$txt['ila_title'] = 'Correos y adjuntos PM en l&iacute;nea';
$txt['ila_insert_tag'] = 'Tag a utilizar al insertar archivos adjuntos en l&iacute;nea:';
$txt['ila_highslide'] = '¿Habilitar efectos deslizantes para datos adjuntos en l&iacute;nea? ';
$txt['ila_one_based_numbering'] = 'En caso de que la primera uni&oacute;n debe ser numerada &quot;1&quot;?';
//$txt['ila_one_based_numbering_ask'] = 'Do you want to adjust all inline attachment IDs so that they still work the same as before?  Press \"OK\" to do this upon saving.';
//$txt['ila_enable_responsive'] = 'Enable responsive CSS for inline attachments?';
$txt['ila_allow_quoted_images'] = '¿Permitir el citado imágenes de fijaci&oacute;n de otro(s) tema(s) y/o mensaje(s)?';
$txt['ila_duplicate'] = '¿Eliminar imagen del adjunto puesto despu&eacute;s de su uso en un(os) tema(s) y/o mensaje(s)?';
$txt['ila_download_count'] = 'El enlace de descarga y ajuste del contador:';
$txt['ila_download_count_n'] = 'Deshabilitar';
$txt['ila_download_count_f'] = 'S&oacute;lo el nombre del archivo';
$txt['ila_download_count_fs'] = 'Nombre del archivo y el tama&ntilde;o';
$txt['ila_download_count_fsd'] = 'Nombre de archivo, tama&ntilde;o y dimensiones';
$txt['ila_download_count_fsdc'] = 'Nombre de archivo, tama&ntilde;o, dimensiones y descripci&oacute;n';
$txt['ila_download_count_fsdc2'] = 'Nombre de archivo, tama&ntilde;o, dimensiones y descripci&oacute;n (2 l&iacute;neas)';
$txt['ila_download_count_fsdc3'] = 'Nombre de archivo, tama&ntilde;o, dimensiones y descripci&oacute;n (3 l&iacute;neas)';
$txt['ila_transparent'] = 'Las imágenes no aprobadas que se muestran transparentes: (%)<div class="smalltext">NOTA: Usar <strong>0</strong> para desactivar mostrar imágenes no aprobados</div>';
//$txt['ila_popup_help'] = 'Include link for ILA popup window parameters?';

$txt['ila_embed_video_files'] = '¿Incrustar formatos de v&iacute;deo compatibles en el tema/mensaje?';
$txt['ila_video_default_width'] = 'Ancho predeterminado de v&iacute;deo cuando no se especifica el ancho:';
$txt['ila_video_default_height'] = 'Altura por defecto de v&iacute;deo cuando no se especifica la altura:';
$txt['ila_video_show_download_link'] = '¿Mostrar enlace de descarga de v&iacute;deos?';
$txt['ila_video_html5'] = 'Compruebe para utilizar etiquetas de v&iacute;deo HTML5 para mostrar v&iacute;deo:';

$txt['ila_embed_svg_files'] = '¿Insertar archivos SVG dentro del tema/mensaje?';
$txt['ila_embed_txt_files'] = '¿Incrustar archivos de texto como parte del mensaje?';
$txt['ila_embed_pdf_files'] = '¿Incrustar archivos PDF en el tema/mensaje?';

$txt['ila_attach_same_as_attachment'] = '&quot;adjuntar&quot; bbcode igual que &quot;adjunto archivo&quot;?';
$txt['ila_turn_nosniff_off'] = '¿Vueltas &quot;nosniff&quot; para opci&oacute;n de apagado para IE8+?';
$txt['ila_display_exif'] = '¿Ver la informaci&oacute;n EXIF debajo de la imagen?';

//$txt['ila_max_width'] = 'Restrict images to maximum width of:<div class="smalltext">NOTE: <strong>0</strong> = disabled</div>';
//$txt['ila_max_height'] = 'Restrict images to maximum height of:<div class="smalltext">NOTE: <strong>0</strong> = disabled</div>';
//$txt['ila_insert_format'] = 'Format to insert new attachment tags:';

// Help language strings:
$helptxt['ila_insert_tag'] = 'Esta opci&oacute;n le permite elegir qu&eacute; etiqueta tendra el adjuntos en l&iacute;nea para su uso con el&quot;Insertar Archivo Adjunto&quot; v&iacute;nculo despu&eacute;s de cada archivo adjunto cargado.<br /><br />
	Las opciones son:
	<blockquote class="bbc_standard_quote">
		<strong>Archivo Adjunto</strong> - Mostrar archivo adjunto de imagen de tama&ntilde;o completo,<br />
		<strong>Adjuntar</strong> - Muestra los datos adjuntos como una miniatura, ampliable a tama&ntilde;o completo.<br />
		<strong>Adjuntar Hoja</strong> - Muestra miniaturas no expansibles de los datos adjuntos.<br />
		<strong>Adjuntar Archivo Mini</strong> - Muestra los datos adjuntos como una miniatura, ampliable a tama&ntilde;o completo. Conteo de la descarga y el nombre se omite por debajo (independientemente de la configuraci&oacute;n de la ILA).
		<strong>Adjuntar URL</strong> => Muestra el archivo adjunto como usted utilizara una [b]url[/b] etiqueta en lugar de otra etiqueta.
	</blockquote>
	La etiqueta de datos adjuntos en l&iacute;nea por defecto es <strong>Archivo Adjunto</strong>.';
$helptxt['ila_attach_same_as_attachment'] = 'Cuando est&aacute; activada, esta opci&oacute;n cambia el <strong>Archivo Adjunto</strong> para que la etiqueta muestre los datos adjuntos como una miniatura, ampliable a tama&ntilde;o completo, al igual que el <strong>Adjuntar</strong> hace la etiqueta.<br /><br />La configuraci&oacute;n por defecto es (<strong>sin restricci&oacute;n</strong>) que es para mostrar los datos adjuntos como tama&ntilde;o completo.';
$helptxt['ila_highslide'] = 'Cuando est&aacute; activada, esta opci&oacute;n utiliza uno de los mods compatibles para visualizar la imagen utilizando <a href="http://www.highslide.com/">High slide</a> efectos.<br /><br />Los siguientes mods son compatibles:
	<blockquote class="bbc_standard_quote">
		<strong><a href="https://github.com/Spuds/SMF-HS4SMF">HS4SMF v0.8.1</a></strong> (required to be installed prior to ILA!)<br />
		<strong><a href="http://custom.simplemachines.org/mods/index.php?mod=1450">Highslide Image Viewer</a></strong><br />
		<strong><a href="http://custom.simplemachines.org/mods/index.php?mod=1605">JQLightBox</a></strong>
	</blockquote>';
$helptxt['ila_one_based_numbering'] = 'Cuando se activa, esta opci&oacute;n cambia todos los archivos adjuntos en l&iacute;nea de manera que se numera el primer archivo adjunto <strong>1</strong> (uno), en comparaci&oacute;n con el valor por defecto <strong>0</strong> (Cero).<br /><br />Tenga en cuenta que cambiar esta opci&oacute;n har&aacute; que el mod para alterar todas las etiquetas adjuntos en l&iacute;nea a trav&eacute;s de su foro para que esta opci&oacute;n se mostrar&aacute; correctamente con el ajuste cambiado.';
$helptxt['ila_allow_quoted_images'] = 'Cuando est&aacute; marcada y sin <a href="https://tapatalk.com/download_SimpleMachines.php">Tapatalk</a> SMF plugin, se puede citar im&aacute;genes y tienen el adjuntos en l&iacute;nea se muestran correctamente. De lo contrario, el adjuntos en l&iacute;nea se sustituye con una cadena de texto de marcador de posici&oacute;n que indica el que la uni&oacute;n en l&iacute;nea estaba en el tema citado.<br /><br />Con el <a href="https://tapatalk.com/download_SimpleMachines.php">Tapatalk</a> SMF plugin instalado,esta opci&oacute;n no est&aacute; disponible para su uso, ya que rompe la aplicaci&oacute;n Tapatalk por alguna raz&oacute;n. Las futuras versiones de este mod pueden resolver este problema.';
$helptxt['ila_duplicate'] = 'Cuando se activa, esta opci&oacute;n elimina la fijaci&oacute;n de la lista de fijaci&oacute;n despu&eacute;s del mensaje.<br /><br />El valor predeterminado es <strong>comprobado</strong>.';
$helptxt['ila_download_count'] = 'Esta opci&oacute;n controla lo que se muestra debajo de la l&iacute;nea del archivo adjunto.  Las siguientes opciones est&aacute;n presentes:
	<blockquote class="bbc_standard_quote">
		<strong>Desactivado</strong> - Sin texto que se muestra debajo.<br />
		<strong>S&oacute;lo el nombre de archivo</strong><br />
		<strong>Nombre del archivo y el tama&ntilde;o</strong><br />
		<strong>Nombre de archivo, tama&ntilde;o y dimensiones</strong><br />
		<strong>Nombre de archivo, tama&ntilde;o, dimensiones y descripci&oacute;n</strong><br />
		<strong>Nombre de archivo, tama&ntilde;o, dimensiones y descripci&oacute;n (2 l&iacute;neas)</strong><br />
		<strong>Nombre de archivo, tama&ntilde;o, dimensiones y descripci&oacute;n (3 l&iacute;neas)</strong><br />
	</blockquote><br />
	Con el <strong>Nombre de archivo, tama&ntilde;o, dimensiones y descripci&oacute;n</strong> opci&oacute;n, todo es pantalla en una l&iacute;nea, como esto:
	<blockquote class="bbc_standard_quote">
		<img src="Themes/default/images/icons/clip.gif" alt="*" align="middle" border="0"></img>Desert.jpg (826.11 kB . 1024x768 - visto 5 veces) ::)
	</blockquote><br />
	Con la opci&oacute;n de 2 l&iacute;neas, enlace de descarga est&aacute; en la primera l&iacute;nea; Tama&ntilde;o, dimensiones y número de descargas se encuentran en la segunda l&iacute;nea. Ejemplo:
	<blockquote class="bbc_standard_quote">
		<img src="Themes/default/images/icons/clip.gif" alt="*" align="middle" border="0"></img>Desert.jpg<br />
		(826.11 kB . 1024x768 - visto 3 veces) ::)
	</blockquote><br />
	Con la opci&oacute;n de 3 l&iacute;neas, enlace de descarga est&aacute; en la primera l&iacute;nea; El tama&ntilde;o y las dimensiones son en la segunda l&iacute;nea; Conteo de la descarga est&aacute; en la tercera l&iacute;nea.
	<blockquote class="bbc_standard_quote">
		<img src="Themes/default/images/icons/clip.gif" alt="*" align="middle" border="0"></img>Desert.jpg<br />
		(826.11 kB . 1024x768)<br />
		(Visto 2 veces)<br />
	</blockquote>';
$helptxt['ila_transparent'] = 'Esta opci&oacute;n permite cambiar la transparencia de las im&aacute;genes son aprobados, como porcentaje de <strong>0</strong> a <strong>100</strong>. Al establecer este valor <strong>0</strong> desactivado esta opci&oacute;n. Los miembros que no pueden ver las im&aacute;genes no autorizadas no se ven afectados por esta opci&oacute;n. <br /> <br /> El valor por defecto es <strong>40</strong>,como en <strong>40%</strong>.';
$helptxt['ila_embed_video_files'] = 'Cuando se activa, esta opci&oacute;n le permite incluir los siguientes archivos de v&iacute;deo en un puesto:
	<blockquote class="bbc_standard_quote">
		<strong>AVI</strong> - played using <strong><a href="http://www.divx.com">DivX</a></strong>\'s player.  Assumes the DivX codec is installed on the OS being browsed.<br />
		<strong>WMV</strong> - played using Windows Media Player.<br />
		<strong>MP4</strong> - played using HTML5 tags (when &quot;Video HTML5&quot; is checked), with fallback HTML provided by <a href="http://www.jwplayer.com">JWPlayer</a>\'s Flash player.<br />
		<strong>WebM</strong> - played using HTML5 tags (when &quot;Video HTML5&quot; is checked), with fallback HTML provided by <a href="http://www.jwplayer.com">JWPlayer</a>\'s Flash player.<br />
		<strong>OGV</strong> - played using HTML5 tags (when &quot;Video HTML5&quot; is checked), with no fallback HTML provided.<br />
	</blockquote>';
$helptxt['ila_video_default_width'] = 'Esta opci&oacute;n especifica el ancho de la pantalla por defecto de los datos adjuntos de v&iacute;deo en l&iacute;nea. Puede ser anulado por el uso de la <strong>anchura</strong> par&aacute;metros en el uso de la etiqueta adjuntos en l&iacute;nea, tales como:<code class="bbc_code">[Archivo Adjunto id=x width=640]</code><br/>El valor por defecto es <strong>640</strong>.';
$helptxt['ila_video_default_height'] = 'Esta opci&oacute;n especifica la altura de la pantalla por defecto de los datos adjuntos de v&iacute;deo en l&iacute;nea. Puede ser anulado por el uso de la <strong>altura</strong> par&aacute;metros en el uso de la etiqueta adjuntos en l&iacute;nea, tales como:<code class="bbc_code">[Archivo Adjunto id=x height=640]</code><br/>El valor por defecto es <strong>400</strong>.';
$helptxt['ila_video_show_download_link'] = 'Cuando se activa, esta opci&oacute;n proporciona un enlace de descarga para el usuario, de manera que si el v&iacute;deo no se reproduce en la p&aacute;gina web, el usuario puede descargar el video para poder reproducir de forma local.';
$helptxt['ila_video_html5'] = 'Cuando est&aacute; activada, esta opci&oacute;n env&iacute;a las etiquetas HTML5 con el fin de intentar reproducir <strong>MP4</strong>, <strong>ogv</strong>, y <strong>WebM</strong> como formatos de archivo. Independientemente de este ajuste, se proporciona el uso de c&oacute;digo HTML de repliegue <a href="http://www.jwplayer.com">JWPlayer</a>\'s Flash player.<br /><br /><strong>RESTRICCIONES:</strong> Con el fin de reproducir archivos de v&iacute;deo con &eacute;xito utilizando HTML5 sin necesidad de utilizar el c&oacute;digo HTML de reserva, se requiere que el p&oacute;ster para cargar archivos de v&iacute;deo en todos los <strong> </ strong> 3 formatos. Si todos los formatos no se proporcionan y las etiquetas HTML de v&iacute;deo no se pueden reproducir el formato para el navegador, el c&oacute;digo HTML de retorno ser&aacute; utilizado para intentar reproducir el archivo de v&iacute;deo. Tenga en cuenta que el archivo de v&iacute;deo no puede residir en un <strong>localhost</strong>, <strong>127.0.0.1</strong>, o red interna (<strong>192.168.x.x</strong>) direcci&oacute;n IP.';
$helptxt['ila_embed_svg_files'] = 'Cuando se activa, esta opci&oacute;n le permite incrustar im&aacute;genes SVG (Scalable Vector Graphics) en su puesto, como un regular <strong>JPG</strong>, <strong>GIF</strong>, o <strong>PNG</strong> adjuntos en l&iacute;nea. De lo contrario, adjuntos en SVG no se pueden mostrar con normalidad.<br /><br />El valor predeterminado es <strong>sin restricci&oacute;n</strong>.';
$helptxt['ila_embed_txt_files'] = 'When checked, this option allows you to embed the contents of a TXT file into the post.<br /><br />Default is <strong>unchecked</strong>.';
$helptxt['ila_embed_pdf_files'] = 'When checked, this option allows you to embed an attached PDF file into the post using the Google Docs service.  Note that Google Docs cannot pull the attachment from <strong>localhost</strong> and <strong>127.0.0.1</strong> addresses, nor unresolvable IP addresses (most notably network IPs behind a router, for example: <strong>192.168.1.1</strong>).<br /><br />Default is <strong>unchecked</strong>.';
$helptxt['ila_turn_nosniff_off'] = 'Al activar esta opci&oacute;n puede ayudar a resolver cuestiones en las que el tipo MIME de un archivo adjunto no coincide con el tipo real de los datos adjuntos y los usuarios est&aacute;n utilizando IE8+.<br /><br />
	<strong>What the &quot;nosniff&quot; option does in IE 8+:</strong>
	<blockquote class="bbc_standard_quote">
		<strong>MIME-cambios de manipulaci&oacute;n</strong>. Los siguientes cambios se realizan en los Explorer 8 Multipurpose Internet Mail Extensions (MIME) de Internet algoritmos de detecci&oacute;n de tipo:<br /><br />
		<strong>Restringir detecci&oacute;n del tipo de MIME</strong>. Internet Explorer 8 impide la detecci&oacute;n, de los datos de sniffing, de los archivos de imagen con /*tipos de contenido MIME en HTML o script. Si un archivo contiene la escritura y el servidor declara que se trata de un archivo de imagen, Internet Explorer 8 no se ejecuta la secuencia de comandos incrustada.<br /><br />
		<strong>Evitar detecci&oacute;n del tipo de MIME</strong>. Las aplicaciones web ahora pueden impedir la detecci&oacute;n tipo MIME. El env&iacute;o de los nuevos X-Content-Type-Opciones: cabecera NOSNIFF evita que Internet Explorer utilizando la detecci&oacute;n tipo MIME para cambiar el tipo de contenido declarado por el servidor.<br /><br />
		<strong>Forzar guardado</strong>.Para las aplicaciones Web que necesitan para servir archivos HTML no son de confianza, Internet Explorer 8 contiene un mecanismo que obliga a los usuarios guardar archivos HTML que no se conf&iacute;a de forma local antes de abrir para ayudar a prevenir el contenido no es de confianza de la seguridad del sitio comprometer.<br /><br />
	</blockquote>
	Fuente: <a href="https://technet.microsoft.com/en-us/library/dd919181%28v=WS.10%29.aspx">Microsoft TechNet article</a>';
$helptxt['ila_display_exif'] = 'Cuando se utiliza en combinaci&oacute;n con el <a href="http://custom.simplemachines.org/mods/index.php?mod=169">EXIF</a> mod, esta opci&oacute;n le permite visualizar cualquier informaci&oacute;n EXIF que los mod puede tirar de la imagen.<br /><br />
	<strong>What EXIF information is:</strong>
	<blockquote class="bbc_standard_quote">
		EXIF es la abreviatura de archivo de imagen intercambiable, un formato que es un est&aacute;ndar para el almacenamiento de informaci&oacute;n de intercambio en la fotograf&iacute;a digital de archivos de im&aacute;genes utilizando la compresi&oacute;n JPEG. Casi todas las nuevas c&aacute;maras digitales utilizan la anotaci&oacute;n EXIF, el almacenamiento de informaci&oacute;n en la imagen, como la velocidad del obturador, la compensaci&oacute;n de exposici&oacute;n, el número F, lo que el sistema de medici&oacute;n se utiliz&oacute;, si un flash se utiliza, el número ISO, la fecha y la hora se tom&oacute; la imagen, blanco equilibrio, lentes auxiliares que se utilizaron y resoluci&oacute;n. Algunas im&aacute;genes pueden incluso almacenar la informaci&oacute;n del GPS para que pueda ver f&aacute;cilmente d&oacute;nde se tomaron las im&aacute;genes!
	</blockquote>
	Fuente: <a href="www.exifdata.com">EXIFdata.com</a>';
//$helptxt['ila_enable_responsive'] = 'Checking this option dynamically resizes the images so that they stay inside the post area of the forum, regardless of the size of the window.  Not having this option checked and not having a specific width/height defined will result in images that spill over the post area and result in the need to use the scrollbars to view the entire image.';

?>
<?php
/**********************************************************************************
* InlineAttachmentsAdmin.spanish_latin-utf8.php - Latin Spanish language file
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
$txt['ila_new_version'] = 'Correos y adjuntos PM en línea tiene una versión %s disponible para su descarga!';
$txt['ila_no_update'] = 'Su instalación de correos y PM adjuntos en línea se encuentra actualizado a la fecha!';
$txt['ila_completed_singular'] = '1 mensaje con etiquetas de datos adjuntos en línea se han actualizado!';
$txt['ila_completed_plural'] = '%d mensajes con datos adjuntos en línea, las etiquetas se han actualizado!';

$txt['ila_title'] = 'Correos y adjuntos PM en línea';
$txt['ila_insert_tag'] = 'Tag a utilizar al insertar archivos adjuntos en línea:';
$txt['ila_highslide'] = '¿Habilitar efectos deslizantes para datos adjuntos en línea? ';
$txt['ila_one_based_numbering'] = 'En caso de que la primera unión debe ser numerada &quot;1&quot;?';
//$txt['ila_one_based_numbering_ask'] = 'Do you want to adjust all inline attachment IDs so that they still work the same as before?  Press \"OK\" to do this upon saving.';
//$txt['ila_enable_responsive'] = 'Enable responsive CSS for inline attachments?';
$txt['ila_allow_quoted_images'] = '¿Permitir el citado imágenes de fijación de otro(s) tema(s) y/o mensaje(s)?';
$txt['ila_duplicate'] = '¿Eliminar imagen del adjunto puesto después de su uso en un(os) tema(s) y/o mensaje(s)?';
$txt['ila_download_count'] = 'El enlace de descarga y ajuste del contador:';
$txt['ila_download_count_n'] = 'Deshabilitar';
$txt['ila_download_count_f'] = 'Sólo el nombre del archivo';
$txt['ila_download_count_fs'] = 'Nombre del archivo y el tamaño';
$txt['ila_download_count_fsd'] = 'Nombre de archivo, tamaño y dimensiones';
$txt['ila_download_count_fsdc'] = 'Nombre de archivo, tamaño, dimensiones y descripción';
$txt['ila_download_count_fsdc2'] = 'Nombre de archivo, tamaño, dimensiones y descripción (2 líneas)';
$txt['ila_download_count_fsdc3'] = 'Nombre de archivo, tamaño, dimensiones y descripción (3 líneas)';
$txt['ila_transparent'] = 'Las imágenes no aprobadas que se muestran transparentes: (%)<div class="smalltext">NOTA: Usar <strong>0</strong> para desactivar mostrar imágenes no aprobados</div>';
//$txt['ila_popup_help'] = 'Include link for ILA popup window parameters?';

$txt['ila_embed_video_files'] = '¿Incrustar formatos de vídeo compatibles en el tema/mensaje?';
$txt['ila_video_default_width'] = 'Ancho predeterminado de vídeo cuando no se especifica el ancho:';
$txt['ila_video_default_height'] = 'Altura por defecto de vídeo cuando no se especifica la altura:';
$txt['ila_video_show_download_link'] = '¿Mostrar enlace de descarga de vídeos?';
$txt['ila_video_html5'] = 'Compruebe para utilizar etiquetas de vídeo HTML5 para mostrar vídeo:';

$txt['ila_embed_svg_files'] = '¿Insertar archivos SVG dentro del tema/mensaje?';
$txt['ila_embed_txt_files'] = '¿Incrustar archivos de texto como parte del mensaje?';
$txt['ila_embed_pdf_files'] = '¿Incrustar archivos PDF en el tema/mensaje?';

$txt['ila_attach_same_as_attachment'] = '&quot;adjuntar&quot; bbcode igual que &quot;adjunto archivo&quot;?';
$txt['ila_turn_nosniff_off'] = '¿Vueltas &quot;nosniff&quot; para opción de apagado para IE8+?';
$txt['ila_display_exif'] = '¿Ver la información EXIF debajo de la imagen?';

//$txt['ila_max_width'] = 'Restrict images to maximum width of:<div class="smalltext">NOTE: <strong>0</strong> = disabled</div>';
//$txt['ila_max_height'] = 'Restrict images to maximum height of:<div class="smalltext">NOTE: <strong>0</strong> = disabled</div>';
//$txt['ila_insert_format'] = 'Format to insert new attachment tags:';

// Help language strings:
$helptxt['ila_insert_tag'] = 'Esta opción le permite elegir qué etiqueta tendra el adjuntos en línea para su uso con el&quot;Insertar Archivo Adjunto&quot; vínculo después de cada archivo adjunto cargado.<br /><br />
	Las opciones son:
	<blockquote class="bbc_standard_quote">
		<strong>Archivo Adjunto</strong> - Mostrar archivo adjunto de imagen de tamaño completo,<br />
		<strong>Adjuntar</strong> - Muestra los datos adjuntos como una miniatura, ampliable a tamaño completo.<br />
		<strong>Adjuntar Hoja</strong> - Muestra miniaturas no expansibles de los datos adjuntos.<br />
		<strong>Adjuntar Archivo Mini</strong> - Muestra los datos adjuntos como una miniatura, ampliable a tamaño completo. Conteo de la descarga y el nombre se omite por debajo (independientemente de la configuración de la ILA).
		<strong>Adjuntar URL</strong> => Muestra el archivo adjunto como usted utilizara una [b]url[/b] etiqueta en lugar de otra etiqueta.
	</blockquote>
	La etiqueta de datos adjuntos en línea por defecto es <strong>Archivo Adjunto</strong>.';
$helptxt['ila_attach_same_as_attachment'] = 'Cuando está activada, esta opción cambia el <strong>Archivo Adjunto</strong> para que la etiqueta muestre los datos adjuntos como una miniatura, ampliable a tamaño completo, al igual que el <strong>Adjuntar</strong> hace la etiqueta.<br /><br />La configuración por defecto es (<strong>sin restricción</strong>) que es para mostrar los datos adjuntos como tamaño completo.';
$helptxt['ila_highslide'] = 'Cuando está activada, esta opción utiliza uno de los mods compatibles para visualizar la imagen utilizando <a href="http://www.highslide.com/">High slide</a> efectos.<br /><br />Los siguientes mods son compatibles:
	<blockquote class="bbc_standard_quote">
		<strong><a href="https://github.com/Spuds/SMF-HS4SMF">HS4SMF v0.8.1</a></strong> (required to be installed prior to ILA!)<br />
		<strong><a href="http://custom.simplemachines.org/mods/index.php?mod=1450">Highslide Image Viewer</a></strong><br />
		<strong><a href="http://custom.simplemachines.org/mods/index.php?mod=1605">JQLightBox</a></strong>
	</blockquote>';
$helptxt['ila_one_based_numbering'] = 'Cuando se activa, esta opción cambia todos los archivos adjuntos en línea de manera que se numera el primer archivo adjunto <strong>1</strong> (uno), en comparación con el valor por defecto <strong>0</strong> (Cero).<br /><br />Tenga en cuenta que cambiar esta opción hará que el mod para alterar todas las etiquetas adjuntos en línea a través de su foro para que esta opción se mostrará correctamente con el ajuste cambiado.';
$helptxt['ila_allow_quoted_images'] = 'Cuando está marcada y sin <a href="https://tapatalk.com/download_SimpleMachines.php">Tapatalk</a> SMF plugin, se puede citar imágenes y tienen el adjuntos en línea se muestran correctamente. De lo contrario, el adjuntos en línea se sustituye con una cadena de texto de marcador de posición que indica el que la unión en línea estaba en el tema citado.<br /><br />Con el <a href="https://tapatalk.com/download_SimpleMachines.php">Tapatalk</a> SMF plugin instalado, esta opción no está disponible para su uso, ya que rompe la aplicación Tapatalk por alguna razón. Las futuras versiones de este mod pueden resolver este problema.';
$helptxt['ila_duplicate'] = 'Cuando se activa, esta opción elimina la fijación de la lista de fijación después del mensaje.<br /><br />El valor predeterminado es <strong>comprobado</strong>.';
$helptxt['ila_download_count'] = 'Esta opción controla lo que se muestra debajo de la línea del archivo adjunto.  Las siguientes opciones están presentes:
	<blockquote class="bbc_standard_quote">
		<strong>Desactivado</strong> - Sin texto que se muestra debajo.<br />
		<strong>Sólo el nombre de archivo</strong><br />
		<strong>Nombre del archivo y el tamaño</strong><br />
		<strong>Nombre de archivo, tamaño y dimensiones</strong><br />
		<strong>Nombre de archivo, tamaño, dimensiones y descripción</strong><br />
		<strong>Nombre de archivo, tamaño, dimensiones y descripción (2 líneas)</strong><br />
		<strong>Nombre de archivo, tamaño, dimensiones y descripción (3 líneas)</strong><br />
	</blockquote><br />
	Con el <strong>Nombre de archivo, tamaño, dimensiones y descripción</strong> opción, todo es pantalla en una línea, como esto:
	<blockquote class="bbc_standard_quote">
		<img src="Themes/default/images/icons/clip.gif" alt="*" align="middle" border="0"></img>Desert.jpg (826.11 kB . 1024x768 - visto 5 veces) ::)
	</blockquote><br />
	Con la opción de 2 líneas, enlace de descarga está en la primera línea; Tamaño, dimensiones y número de descargas se encuentran en la segunda línea. Ejemplo:
	<blockquote class="bbc_standard_quote">
		<img src="Themes/default/images/icons/clip.gif" alt="*" align="middle" border="0"></img>Desert.jpg<br />
		(826.11 kB . 1024x768 - visto 3 veces) ::)
	</blockquote><br />
	Con la opción de 3 líneas, enlace de descarga está en la primera línea; El tamaño y las dimensiones son en la segunda línea; Conteo de la descarga está en la tercera línea.
	<blockquote class="bbc_standard_quote">
		<img src="Themes/default/images/icons/clip.gif" alt="*" align="middle" border="0"></img>Desert.jpg<br />
		(826.11 kB . 1024x768)<br />
		(Visto 2 veces)<br />
	</blockquote>';
$helptxt['ila_transparent'] = 'Esta opción permite cambiar la transparencia de las imágenes son aprobados, como porcentaje de <strong>0</strong> a <strong>100</strong>. Al establecer este valor <strong>0</strong> desactivado esta opción. Los miembros que no pueden ver las imágenes no autorizadas no se ven afectados por esta opción. <br /> <br /> El valor por defecto es <strong>40</strong>,como en <strong>40%</strong>.';
$helptxt['ila_embed_video_files'] = 'Cuando se activa, esta opción le permite incluir los siguientes archivos de vídeo en un puesto:
	<blockquote class="bbc_standard_quote">
		<strong>AVI</strong> - played using <strong><a href="http://www.divx.com">DivX</a></strong>\'s player.  Assumes the DivX codec is installed on the OS being browsed.<br />
		<strong>WMV</strong> - played using Windows Media Player.<br />
		<strong>MP4</strong> - played using HTML5 tags (when &quot;Video HTML5&quot; is checked), with fallback HTML provided by <a href="http://www.jwplayer.com">JWPlayer</a>\'s Flash player.<br />
		<strong>WebM</strong> - played using HTML5 tags (when &quot;Video HTML5&quot; is checked), with fallback HTML provided by <a href="http://www.jwplayer.com">JWPlayer</a>\'s Flash player.<br />
		<strong>OGV</strong> - played using HTML5 tags (when &quot;Video HTML5&quot; is checked), with no fallback HTML provided.<br />
	</blockquote>';
$helptxt['ila_video_default_width'] = 'Esta opción especifica el ancho de la pantalla por defecto de los datos adjuntos de vídeo en línea. Puede ser anulado por el uso de la <strong>anchura</strong> parámetros en el uso de la etiqueta adjuntos en línea, tales como:<code class="bbc_code">[Archivo Adjunto id=x width=640]</code><br/>El valor por defecto es <strong>640</strong>.';
$helptxt['ila_video_default_height'] = 'Esta opción especifica la altura de la pantalla por defecto de los datos adjuntos de vídeo en línea. Puede ser anulado por el uso de la <strong>altura</strong> parámetros en el uso de la etiqueta adjuntos en línea, tales como:<code class="bbc_code">[Archivo Adjunto id=x height=640]</code><br/>El valor por defecto es <strong>400</strong>.';
$helptxt['ila_video_show_download_link'] = 'Cuando se activa, esta opción proporciona un enlace de descarga para el usuario, de manera que si el vídeo no se reproduce en la página web, el usuario puede descargar el video para poder reproducir de forma local.';
$helptxt['ila_video_html5'] = 'Cuando está activada, esta opción envía las etiquetas HTML5 con el fin de intentar reproducir <strong>MP4</strong>, <strong>ogv</strong>, y <strong>WebM</strong> como formatos de archivo. Independientemente de este ajuste, se proporciona el uso de código HTML de repliegue <a href="http://www.jwplayer.com">JWPlayer</a>\'s Flash player.<br /><br /><strong>RESTRICCIONES:</strong> Con el fin de reproducir archivos de vídeo con éxito utilizando HTML5 sin necesidad de utilizar el código HTML de reserva, se requiere que el póster para cargar archivos de vídeo en todos los <strong> </ strong> 3 formatos. Si todos los formatos no se proporcionan y las etiquetas HTML de vídeo no se pueden reproducir el formato para el navegador, el código HTML de retorno será utilizado para intentar reproducir el archivo de vídeo. Tenga en cuenta que el archivo de vídeo no puede residir en un <strong>localhost</strong>, <strong>127.0.0.1</strong>, o red interna (<strong>192.168.x.x</strong>) dirección IP.';
$helptxt['ila_embed_svg_files'] = 'Cuando se activa, esta opción le permite incrustar imágenes SVG (Scalable Vector Graphics) en su puesto, como un regular <strong>JPG</strong>, <strong>GIF</strong>, o <strong>PNG</strong> adjuntos en línea. De lo contrario, adjuntos en SVG no se pueden mostrar con normalidad.<br /><br />El valor predeterminado es <strong>sin restricción</strong>.';
$helptxt['ila_embed_txt_files'] = 'When checked, this option allows you to embed the contents of a TXT file into the post.<br /><br />Default is <strong>unchecked</strong>.';
$helptxt['ila_embed_pdf_files'] = 'When checked, this option allows you to embed an attached PDF file into the post using the Google Docs service.  Note that Google Docs cannot pull the attachment from <strong>localhost</strong> and <strong>127.0.0.1</strong> addresses, nor unresolvable IP addresses (most notably network IPs behind a router, for example: <strong>192.168.1.1</strong>).<br /><br />Default is <strong>unchecked</strong>.';
$helptxt['ila_turn_nosniff_off'] = 'Al activar esta opción puede ayudar a resolver cuestiones en las que el tipo MIME de un archivo adjunto no coincide con el tipo real de los datos adjuntos y los usuarios están utilizando IE8+.<br /><br />
	<strong>What the &quot;nosniff&quot; option does in IE 8+:</strong>
	<blockquote class="bbc_standard_quote">
		<strong>MIME-cambios de manipulación</strong>. Los siguientes cambios se realizan en los Explorer 8 Multipurpose Internet Mail Extensions (MIME) de Internet algoritmos de detección de tipo:<br /><br />
		<strong>Restringir detección del tipo de MIME</strong>. Internet Explorer 8 impide la detección, de los datos de sniffing, de los archivos de imagen con /*tipos de contenido MIME en HTML o script. Si un archivo contiene la escritura y el servidor declara que se trata de un archivo de imagen, Internet Explorer 8 no se ejecuta la secuencia de comandos incrustada.<br /><br />
		<strong>Evitar detección del tipo de MIME</strong>. Las aplicaciones web ahora pueden impedir la detección tipo MIME. El envío de los nuevos X-Content-Type-Opciones: cabecera NOSNIFF evita que Internet Explorer utilizando la detección tipo MIME para cambiar el tipo de contenido declarado por el servidor.<br /><br />
		<strong>Forzar guardado</strong>.Para las aplicaciones Web que necesitan para servir archivos HTML no son de confianza, Internet Explorer 8 contiene un mecanismo que obliga a los usuarios guardar archivos HTML que no se confía de forma local antes de abrir para ayudar a prevenir el contenido no es de confianza de la seguridad del sitio comprometer.<br /><br />
	</blockquote>
	Fuente: <a href="https://technet.microsoft.com/en-us/library/dd919181%28v=WS.10%29.aspx">Microsoft TechNet article</a>';
$helptxt['ila_display_exif'] = 'Cuando se utiliza en combinación con el <a href="http://custom.simplemachines.org/mods/index.php?mod=169">EXIF</a> mod, esta opción le permite visualizar cualquier información EXIF que los mod puede tirar de la imagen.<br /><br />
	<strong>What EXIF information is:</strong>
	<blockquote class="bbc_standard_quote">
		EXIF es la abreviatura de archivo de imagen intercambiable, un formato que es un estándar para el almacenamiento de información de intercambio en la fotografía digital de archivos de imágenes utilizando la compresión JPEG. Casi todas las nuevas cámaras digitales utilizan la anotación EXIF, el almacenamiento de información en la imagen, como la velocidad del obturador, la compensación de exposición, el número F, lo que el sistema de medición se utilizó, si un flash se utiliza, el número ISO, la fecha y la hora se tomó la imagen, blanco equilibrio, lentes auxiliares que se utilizaron y resolución. Algunas imágenes pueden incluso almacenar la información del GPS para que pueda ver fácilmente dónde se tomaron las imágenes!
	</blockquote>
	Fuente: <a href="www.exifdata.com">EXIFdata.com</a>';
//$helptxt['ila_enable_responsive'] = 'Checking this option dynamically resizes the images so that they stay inside the post area of the forum, regardless of the size of the window.  Not having this option checked and not having a specific width/height defined will result in images that spill over the post area and result in the need to use the scrollbars to view the entire image.';

?>
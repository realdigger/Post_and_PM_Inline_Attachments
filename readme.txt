[hr]
[center][color=red][size=16pt][b]POST & PM INLINE ATTACHMENTS v6.3[/b][/size][/color]
[url=http://www.simplemachines.org/community/index.php?action=profile;u=253913][b]By Dougiefresh[/b][/url] -> [url=http://custom.simplemachines.org/mods/index.php?mod=3770]Link to Mod[/url]
[/center]
[hr]

[color=blue][b][size=12pt][u]Introduction[/u][/size][/b][/color]
This mod adds the ability to position your attachments in either your forum post or your personal message post using [attachment=n][/attachment] bbcode (where [b]n[/b] is the number of the attachment in the post, eg first = 0, second = 1).

[b]NOTICE:[/b]  In order to support inline attachments in personal messages (PMs), you are [b]REQUIRED[/b] to have the [url=https://custom.simplemachines.org/mods/index.php?mod=1974]PM Attachments[/url] mod [b]VERSION 2.6 OR BETTER[/B] installed, prior to this installation of this mod!!

[color=blue][b][size=12pt][u]New BBcodes[/u][/size][/b][/color]
This mod supports 5 new bbcodes in order to position your attachments inline:
o [b]attachment[/b] => Show full expanded picture
o [b]attach[/b] => Show thumbnail, expandable to full picture
o [b]attachthumb[/b] => Show thumbnail ONLY, not expandable
o [b]attachmini[/b] => Show thumbnail, expandable to full picture
o [b]attachurl[/b] => Shows attachment size, iamge dimensions, and download count; no picture

[color=blue][b][size=12pt][u]BBcodes Parameters[/u][/size][/b][/color]
Each new BBCode accepts the following formats:
[code=Version 1.x]
[nobbc][attach=[/nobbc][b]{id}[/b]][/attach]
[nobbc][attach=[/nobbc][b]{id}[/b],[b]{width}[/b]][/attach]
[nobbc][attach=[/nobbc][b]{id}[/b],[b]{width}[/b],[b]{height}[/b]][/attach]
[/code]
In each case, [b]{id}[/b] is the attachment number relative to the topic, [b]{width}[/b] is the max desired width, [b]{height}[/b] is the max desired height, [b]{pixels}[/b] is the number of pixels surrounding the image, and [b]{float}[/b] can be either [b]left[/b], [b]right[/b], or [b]center[/b].  All text between the opening and closing attachment tags is discarded.

[color=blue][b][size=12pt][u]Version 2.0+ BBcode Parameters[/u][/size][/b][/color]
Version 2.0+ introduced a new format that allows the following parameters:
[code=Version 2.x]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] {parameter}={value}][/attachment]
[/code]
Allowed parameters:
[table]
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
[/table]
In each case, [b]{id}[/b] is the attachment number relative to the topic, [b]{width}[/b] is the max desired width, [b]{height}[/b] is the max desired height, [b]{pixels}[/b] is the number of pixels surrounding the image, and [b]{float}[/b] can be either [b]left[/b], [b]right[/b], or [b]center[/b].  All text between the opening and closing attachment tags is discarded.

[color=blue][b][size=12pt][u]Version 3.0+ BBcode Format[/u][/size][/b][/color]
[b]Version 3.0[/b] makes further changes and allows the use of the inline attachments bbcodes [b]WITHOUT[/b] closing brackets, as well as using attachments from another post!

[b]Version 3.11[/b] makes further changes and allows the use of closed tags, like [b][nobbc][attach][/nobbc][/b].  This new form is autonumbered!  Note that the [b][nobbc][attach][/nobbc][/b] tag is processed first, then [b][nobbc][attachment][/nobbc][/b], then [b][nobbc][attachmini][/nobbc][/b], then [b][nobbc][attachthumb][/nobbc][/b], then [b][nobbc][attachurl][/nobbc][/b].

[color=blue][b][size=12pt][u]Other Mod Features[/u][/size][/b][/color]
o Error Text strings are shown for invalid/missing/deleted attachments.
o Inline attachment processes takes place in the [b]parse_bbc[/b] function, which means any parsing requests can benefit from this mod!
o Text string is shown as alternative in code
o Adds [Insert Attachment x] next to each attachment/upload box to insert the bbcode.
o Attachments used by the inline attachments mod can be omitted from the attachment display at the bottom of the post
o Reloads the attachments for Ajax Editing.
o Removing an attachment removes the attachment bbcode for that attachment & changes remaining attachment tags to ensure proper post appearance.
o Text between inline attachment brackets are removed (as of version 3.0).
o Automatic modification of boilerplates that use the ILA tags within them when changing "1-based" numbering option.

[color=blue][b][size=12pt][u]Admin Settings[/u][/size][/b][/color]
The bbcode may be disabled by going to [b][i]Admin[/i] -> [i]Forums[/i] -> [i]Posts and Topics[/i] -> [i]Bulletin Board Code[/i][/b] and unchecking the [b]attachment[/b] bbcode.

On the [b][i]Admin[/i] -> [i]Layout[/i] -> [i]Attachments and Avatars[/i] -> [i]Inline Attachments[/i][/b] page, there are several new options:
o Remove attachment image under post after in-post use.
o Use "One based numbering" for attachment IDs (first attachment is 1 instead of 0).
o Allow quoted attachment images from another post.
o Show download link and counter under inline attachment, like non-inline attachments.
o Turn off "nosniff" option for IE and Chrome browsers.
o Whether "attach" tag is the same as the "attachment" tag.
o Allow playing inline attachments that are videos.
o Use Highslide effects for inline attachments. (only if supported Highslide mod is installed)
o Show EXIF information (only if [url=http://custom.simplemachines.org/mods/index.php?mod=169]EXIF[/url] mod is installed)

[color=blue][b][size=12pt][u]Compatibility Notes[/u][/size][/b][/color]
This mod was tested on SMF 2.0.13, but should work on SMF 2.1 Beta 3, as well as SMF 2.0 and up.  SMF 2.1 Beta 1, SMF 2.1 Beta 2, and SMF 1.x will not be supported.

For SMF 2.1 Beta 3, this mod contains no functionality for PM attachments, and posting regular attachments has been changed slightly to allow only 1 file per input box.

These mods can be installed at any time (not required):
o [url=http://custom.simplemachines.org/mods/index.php?mod=1605]JQLightBox[/url]
o [url=http://custom.simplemachines.org/mods/index.php?mod=3594]SCEditor4Smf[/url]
o [url=http://custom.simplemachines.org/mods/index.php?mod=169]EXIF[/url]
o [url=http://custom.simplemachines.org/mods/index.php?mod=2233]Boilerplates for Posts[/url]

These mods should be installed before this mod (not required):
o [url=http://custom.simplemachines.org/mods/index.php?mod=1450]Highslide Image Viewer[/url]
o [url=https://github.com/Spuds/SMF-HS4SMF]HS4SMF v0.8.1[/url]
o [url=http://custom.simplemachines.org/mods/index.php?mod=1974]PM Attachments[/url]
o [url=http://custom.simplemachines.org/mods/index.php?mod=2758]Custom View of Attachments[/url]

[color=blue][b][size=12pt][u]Changelog[/u][/size][/b][/color]
The changelog has been removed and can be seen at [url=http://www.xptsp.com/board/index.php?topic=12.msg137#msg137]XPtsp.com[/url].

[color=blue][b][size=12pt][u]License[/u][/size][/b][/color]
[quote]Copyright (c) 2013 - 2018, Douglas Orend
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
[/quote]
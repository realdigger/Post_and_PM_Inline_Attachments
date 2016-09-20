[hr]
[center][color=red][size=16pt][b]POST & PM INLINE ATTACHMENTS v3.8[/b][/size][/color]
[url=http://www.simplemachines.org/community/index.php?action=profile;u=253913][b]By Dougiefresh[/b][/url] -> [url=http://custom.simplemachines.org/mods/index.php?mod=3770]Link to Mod[/url]
[/center]
[hr]

[color=blue][b][size=12pt][u]Introduction[/u][/size][/b][/color]
This mod adds the ability to position your attachments in either your forum post or your personal message post using [attachment=n][/attachment] bbcode (where [b]n[/b] is the number of the attachment in the post, eg first = 0, second = 1).

[color=blue][b][size=12pt][u]BBcode Usage Forms[/u][/size][/b][/color]
[b]Version 1.0[/b] introduced the following forms:
[quote]
[nobbc][attachment=[/nobbc][b]{id}[/b]][/attachment]
[nobbc][attachment=[/nobbc][b]{id}[/b],[b]{width}[/b]][/attachment]
[nobbc][attachment=[/nobbc][b]{id}[/b],[b]{width}[/b],[b]{height}[/b]][/attachment]
[/quote]
[b]Version 2.0[/b] keeps the version 1.0 forms, plus introduces more natural forms:
[quote]
[nobbc][attachment[/nobbc] id=[b]{id}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] margin=[b]{pixels}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] float=[b]{float}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] float=[b]{float}[/b] margin=[b]{pixels}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] width=[b]{width}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] width=[b]{width}[/b] margin=[b]{pixels}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] width=[b]{width}[/b] float=[b]{float}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] width=[b]{width}[/b] float=[b]{float}[/b] margin=[b]{pixels}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] width=[b]{width}[/b] height=[b]{height}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] width=[b]{width}[/b] height=[b]{height}[/b] margin=[b]{pixels}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] width=[b]{width}[/b] height=[b]{height}[/b] float=[b]{float}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] width=[b]{width}[/b] height=[b]{height}[/b] float=[b]{float}[/b] margin=[b]{pixels}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] height=[b]{height}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] height=[b]{height}[/b] margin=[b]{pixels}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] height=[b]{height}[/b] float=[b]{float}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] height=[b]{height}[/b] float=[b]{float}[/b] margin=[b]{pixels}[/b]][/attachment]
[/quote]
[b]Version 2.1[/b] keeps the version 1.0 and 2.0 forms, plus introduces more BBCodes:
[quote]
[b]attach[/b] => Shows the attachment as a thumbnail, expandable to full size.
[b]attachthumb[/b] => Shows only the thumbnail of the attachment.
[b]attachmini[/b] => Shows the attachment, omitting the download count and filename beneath.
[/quote]
[b]Version 2.2[/b] introduces one more BBCode:
[quote]
[b]attachurl[/b] => Shows the attachment like you used an [b]img[/b] tag instead of this tag.
[/quote]
Each of these new BBCodes uses the same format as the [b][nobbc][attachment][/nobbc][/b] BBCodes.

[b]Version 3.0[/b] makes further changes and allows the use of the inline attachments bbcodes [b]WITHOUT[/b] closing brackets, as well as using attachments from another post!

In each case, [b]{id}[/b] is the attachment number relative to the topic, [b]{width}[/b] is the max desired width, [b]{height}[/b] is the max desired height, [b]{pixels}[/b] is the number of pixels surrounding the image, and [b]{float}[/b] can be either [b]left[/b], [b]right[/b], or [b]center[/b].  All text between the opening and closing attachment tags is discarded.

If width and height are not specified, max image width and height settings set by admin are respected.  Attachment image will be scaled proportionally to meet desired width/height settings.

[color=blue][b][size=12pt][u]Other Mod Features[/u][/size][/b][/color]
o Error Text strings are shown for invalid/missing/deleted attachments.
o Inline attachment processes takes place in the [b]parse_bbc[/b] function, which means any parsing requests can benefit from this mod!
o Text string is shown as alternative in code
o Adds [Insert Attachment x] next to each attachment/upload box to insert the bbcode.
o Attachments used by the inline attachments mod can be omitted from the attachment display at the bottom of the post
o Reloads the attachments for Ajax Editing.
o Removing an attachment removes the attachment bbcode for that attachment & changes remaining attachment tags to ensure proper post appearance.
o Text between inline attachment brackets are removed (as of version 3.0).

[color=blue][b][size=12pt][u]Admin Settings[/u][/size][/b][/color]
The bbcode may be disabled by going to [b][i]Admin[/i] -> [i]Forums[/i] -> [i]Posts and Topics[/i] -> [i]Bulletin Board Code[/i][/b] and unchecking the [b]attachment[/b] bbcode.

On the [b][i]Admin[/i] -> [i]Configuration[/i] -> [i]Modification Settings[/i] -> [i]ILA[/i][/b] page, there are several new options:
o Remove attachment image under post after in-post use.
o Show download link and counter under inline attachment, like non-inline attachments.
o Turn off "nosniff" option for IE and Chrome browsers.
o Use "One based numbering" for attachment IDs (first attachment is 1 instead of 0).
o Allow quoted attachment images from another post.
o Use Highslide effects for inline attachments.

[color=blue][b][size=12pt][u]Compatibility Notes[/u][/size][/b][/color]
This mod was tested on SMF 2.0.9, but should work on SMF 2.1 Beta 1, as well as SMF 2.0 and up.  SMF 1.x is not and will not be supported.

For SMF 2.1 Beta 1, this mod contains no functionality for PM attachments, and posting regular attachments has been changed slightly to allow only 1 file per input box.

These mods can be installed at any time (not required):
o [url=http://custom.simplemachines.org/mods/index.php?mod=1450]Highslide Image Viewer[/url]
o [url=http://custom.simplemachines.org/mods/index.php?mod=1605]JQLightBox[/url]
o [url=http://custom.simplemachines.org/mods/index.php?mod=3594]SCEditor4Smf[/url]
o [url=http://custom.simplemachines.org/mods/index.php?mod=169]EXIF[/url]

These mods should be installed before this mod (not required):
o [url=https://github.com/Spuds/SMF-HS4SMF]HS4SMF v0.8.1[/url]
o [url=http://custom.simplemachines.org/mods/index.php?mod=1974]PM Attachments[/url]
o [url=http://custom.simplemachines.org/mods/index.php?mod=2758]Custom View of Attachments[/url]

[color=blue][b][size=12pt][u]Changelog[/u][/size][/b][/color]
The changelog has been removed and can be seen at [url=http://www.xptsp.com/board/index.php?topic=12.msg137#msg137]XPtsp.com[/url].

[color=blue][b][size=12pt][u]License[/u][/size][/b][/color]
Copyright (c) 2015, Douglas Orend
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

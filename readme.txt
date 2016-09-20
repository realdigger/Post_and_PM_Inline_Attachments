[hr]
[center][color=red][size=16pt][b]POST & PM INLINE ATTACHMENTS v2.1[/b][/size][/color]
[url=http://www.simplemachines.org/community/index.php?action=profile;u=253913][b]By Dougiefresh[/b][/url] -> [url=http://custom.simplemachines.org/mods/index.php?mod=3770]Link to Mod[/url]
[/center]
[hr]

[color=blue][b][size=12pt][u]Introduction[/u][/size][/b][/color]
This mod adds the ability to position your attachments in either your forum post or your personal message post using [attachment=n][/attachment] bbcode (where [b]n[/b] is the number of the attachment in the post, eg first = 0, second = 1).

[color=blue][b][size=12pt][u]BBcode Usage Forms[/u][/size][/b][/color]
Version 1.0 introduced the following forms:
[quote]
[nobbc][attachment=[/nobbc][b]{id}[/b]][/attachment]
[nobbc][attachment=[/nobbc][b]{id}[/b],[b]{width}[/b]][/attachment]
[nobbc][attachment=[/nobbc][b]{id}[/b],[b]{width}[/b],[b]{height}[/b]][/attachment]
[/quote]
Version 2.0 keeps the version 1.0 forms, plus introduces more natural forms:
[quote]
[nobbc][attachment[/nobbc] id=[b]{id}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] margin=[b]{pixels}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] float=[b]{float}[/b]][/attachment]
[nobbc][attachment[/nobbc] id=[b]{id}[/b] float=[b]{float}[/b] margin=[b]{pixels}[/b]][/attachment]
[nobbc][attachment=[/nobbc] id=[b]{id}[/b] width=[b]{width}[/b]][/attachment]
[nobbc][attachment=[/nobbc] id=[b]{id}[/b] width=[b]{width}[/b] margin=[b]{pixels}[/b]][/attachment]
[nobbc][attachment=[/nobbc] id=[b]{id}[/b] width=[b]{width}[/b] float=[b]{float}[/b]][/attachment]
[nobbc][attachment=[/nobbc] id=[b]{id}[/b] width=[b]{width}[/b] float=[b]{float}[/b] margin=[b]{pixels}[/b]][/attachment]
[nobbc][attachment=[/nobbc] id=[b]{id}[/b] width=[b]{width}[/b] height=[b]{height}[/b]][/attachment]
[nobbc][attachment=[/nobbc] id=[b]{id}[/b] width=[b]{width}[/b] height=[b]{height}[/b] margin=[b]{pixels}[/b]][/attachment]
[nobbc][attachment=[/nobbc] id=[b]{id}[/b] width=[b]{width}[/b] height=[b]{height}[/b] float=[b]{float}[/b]][/attachment]
[nobbc][attachment=[/nobbc] id=[b]{id}[/b] width=[b]{width}[/b] height=[b]{height}[/b] float=[b]{float}[/b] margin=[b]{pixels}[/b]][/attachment]
[nobbc][attachment=[/nobbc] id=[b]{id}[/b] height=[b]{height}[/b]][/attachment]
[nobbc][attachment=[/nobbc] id=[b]{id}[/b] height=[b]{height}[/b] margin=[b]{pixels}[/b]][/attachment]
[nobbc][attachment=[/nobbc] id=[b]{id}[/b] height=[b]{height}[/b] float=[b]{float}[/b]][/attachment]
[nobbc][attachment=[/nobbc] id=[b]{id}[/b] height=[b]{height}[/b] float=[b]{float}[/b] margin=[b]{pixels}[/b]][/attachment]
[/quote]
Version 2.1 keeps the version 1.0 and 2.0 forms, plus introduces more BBCodes:
[quote]
[b]attach[/b] => Shows the attachment as a thumbnail, expandable to full size.
[b]attachthumb[/b] => Shows only the thumbnail of the attachment.
[b]attachmini[/b] => Shows the attachment, omitting the download count and filename beneath.
[/quote]
Each of these new BBCodes uses the same format as the [b][nobbc][attachment][/nobbc][/b] BBCodes.

In each case, [b]{id}[/b] is the attachment number relative to the topic, [b]{width}[/b] is the max desired width, [b]{height}[/b] is the max desired height, [b]{pixels}[/b] is the number of pixels surrounding the image, and [b]{float}[/b] can be either [b]left[/b], [b]right[/b], or [b]center[/b].  All text between the opening and closing attachment tags is discarded.

If width and height are not specified, max image width and height settings set by admin are respected.  Attachment image will be scaled proportionally to meet desired width/height settings.

[color=blue][b][size=12pt][u]Other Mod Features[/u][/size][/b][/color]
o Error Text strings are shown for invalid/missing/deleted attachments.
o Inline attachment processes takes place in the [b]parse_bbc[/b] function, which means any parsing requests can benefit from this mod!
o Text string is shown as alternative when quoted or in code
o Adds [Insert Attachment x] next to each attachment/upload box to insert the bbcode.
o Attachments used by the inline attachments mod can be omitted from the attachment display at the bottom of the post
o Reloads the attachments for Ajax Editing
o Text string shown in place of attachment for Recent posts/Previewing and Topic&Reply History
o Removing an attachment removes the attachment bbcode for that attachment & changes remaining attachment tags to ensure proper post appearance.

[color=blue][b][size=12pt][u]Admin Settings[/u][/size][/b][/color]
The bbcode may be disabled by going to [b][i]Admin[/i] -> [i]Forums[/i] -> [i]Posts and Topics[/i] -> [i]Bulletin Board Code[/i][/b] and unchecking the [b]attachment[/b] bbcode.

On the [b][i]Admin[/i] -> [i]Configuration[/i] -> [i]Modification Settings[/i] -> [i]Miscellaneous[/i][/b] page, there are two new options under the heading [i][b]Inline Attachments[/b][/i]:
o Remove attachment image under post after in-post use
o Show download link and counter under inline attachment, like non-inline attachments

[color=blue][b][size=12pt][u]Compatibility Notes[/u][/size][/b][/color]
This mod was tested on SMF 2.0.8, but should work on SMF 2.0 and up.  SMF 1.1 is not and will not be supported, so please don't ask.

These mods can be installed at any time (not required):
o [url=http://custom.simplemachines.org/mods/index.php?mod=1450]Highslide Image Viewer[/url]
o [url=http://custom.simplemachines.org/mods/index.php?mod=1605]JQLightBox[/url]

These mods should be installed before this mod (not required):
o [url=https://github.com/Spuds/SMF-HS4SMF]HS4SMF v0.8.1[/url]
o [url=http://custom.simplemachines.org/mods/index.php?mod=1974]PM Attachments[/url]
o [url=http://custom.simplemachines.org/mods/index.php?mod=2758]Custom View of Attachments[/url]

[color=blue][b][size=12pt][u]Changelog[/u][/size][/b][/color]
[quote]
[b][u]v2.1 - December 19th, 2014[/u][/b]
o New BBCodes added: [b]attach[/b], [b]attachthumb[/b], and [b]attachmini[/b].
o Some reorganization of the code to accommodate the new BBCodes.
o Image not scaled if both width and height are specified.
o Parameter validation functions fixed to prevent negative values from being passed.
o No highslide features if image size is smaller than specified max image dimensions.
o Fixed image placement code by removing "block_level" requirements from all BBcodes...

[b][u]v2.0 - December 7th, 2014[/u][/b]
o Added new form of the [b]attachment[/b] bbcode, as explained above.
o Fixed preview capability in non-WYSIWYG mode for already saved attachments in posts...
o Changed code that scales image to use global settings only if no size is specified by the user.
o Modified link building code for HS4SMF so that it properly groups the attachments.
o Added support for [url=http://custom.simplemachines.org/mods/index.php?mod=1450]Highslide Image Viewer[/url].
o Added support for [url=http://custom.simplemachines.org/mods/index.php?mod=1605]JQLightBox[/url].

[b][u]v1.5 - December 6th, 2014[/u][/b]
o Fixed attachments not being hidden after use in post with [url=http://custom.simplemachines.org/mods/index.php?mod=2758]Custom View of Attachments[/url] installed.

[b][u]v1.4 - August 23th, 2014[/u][/b]
o Fixed multiple issues in the inline attachment validation function.

[b][u]v1.3 - August 17th, 2014[/u][/b]
o Fixed javascript code for issue with pressing "More Attachments" in Posts.

[b][u]v1.2 - August 11th, 2014[/u][/b]
o Fixed some undefined language string errors found in mod
o Modified code to insert attachments after pressing "More Attachments" in Posts and PMs

[b][u]v1.1 - July 28th, 2014[/u][/b]
o Fixed two undeclared array element errors in [b]PersonalMessage.template.php[/b]...

[b][u]v1.0 - July 21th, 2014[/u][/b]
o Initial Release of the mod
[/quote]

[hr]
[url=http://creativecommons.org/licenses/by/3.0][img]http://i.creativecommons.org/l/by/3.0/80x15.png[/img][/url]
This work is licensed under a [url=http://creativecommons.org/licenses/by/3.0]Creative Commons Attribution 3.0 Unported License[/url]

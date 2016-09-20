[hr]
[center][color=red][size=16pt][b]POST & PM INLINE ATTACHMENTS v1.2[/b][/size][/color]
[url=http://www.simplemachines.org/community/index.php?action=profile;u=253913][b]By Dougiefresh[/b][/url] -> [url=http://custom.simplemachines.org/mods/index.php?mod=3770]Link to Mod[/url]
[/center]
[hr]

[color=blue][b][size=12pt][u]Introduction[/u][/size][/b][/color]
This mod adds the ability to position your attachments in either your forum post or your personal message post using [attachment=n][/attachment] bbcode (where [b]n[/b] is the number of the attachment in the post, eg first = 0, second = 1).

[color=blue][b][size=12pt][u]BBcode Features[/u][/size][/b][/color]
o Adds [attachment=n][/attachment] bbcode to position attachments within the post (where [b]n[/b] is the number of the attachment in the post, eg first = 0, second = 1)
o BBcode can also take the form [attachment=n,width][/attachment] (where [b]n[/b] is the number of the attachment in the post and [b]width[/b] is the max desired width)
o BBcode can also take the form [attachment=n,width,height][/attachment] (where [b]n[/b] is the number of the attachment in the post, [b]width[/b] is the max desired width, and [b]height[/b] is the max desired height)
o If width and height are not specified, max image width and height settings set by admin are respected.
o Attachment image will be scaled proportionally to meet desired width/height settings.
o Error Text string shown for invalid/missing/deleted attachments
o All text between the opening and closing attachment tags is discarded unless the tag is disabled.

[color=blue][b][size=12pt][u]Other Mod Features[/u][/size][/b][/color]
o Inline attachment processes takes place in the [b]parse_bbc[/b] function, which means any parsing requests can benefit from this mod!
o Text string is shown as alternative when quoted or in code
o Adds [Insert Attachment x] next to each attachment/upload box to insert the bbcode.
o Attachments used by the inline attachments mod can be omitted from the attachment display at the bottom of the post
o Reloads the attachments for Ajax Editing
o Text string shown in place of attachment for Recent posts/Previewing and Topic&Reply History
o Removing an attachment removes the attachment bbcode for that attachment & changes remaining attachment tags to ensure proper post appearance.
o The mod is HS4SMF aware, if the highslide mod is installed it will work on the attachment (assuming its not full size)

[color=blue][b][size=12pt][u]Admin Settings[/u][/size][/b][/color]
The bbcode may be disabled by going to [b][i]Admin[/i] -> [i]Forums[/i] -> [i]Posts and Topics[/i] -> [i]Bulletin Board Code[/i][/b] and unchecking the [b]attachment[/b] bbcode.

On the [b][i]Admin[/i] -> [i]Configuration[/i] -> [i]Modification Settings[/i] -> [i]Miscellaneous[/i][/b] page, there are two new options under the heading [i][b]Inline Attachments[/b][/i]:
o Enable Highslide effects for inline attachment
o Remove attachment image under post after in-post use
o Show download link and counter under inline attachment, like non-inline attachments

[color=blue][b][size=12pt][u]Compatibility Notes[/u][/size][/b][/color]
This mod was tested on SMF 2.0.8, but should work on SMF 2.0 and up.  SMF 1.1 is not and will not be supported, so please don't ask.

If you use [url=http://custom.simplemachines.org/mods/index.php?mod=1974]PM Attachments[/url] mod, it should be installed before this mod because the PM inline attachments requires PM attachments....

If you want to use the [url=http://www.simplemachines.org/community/index.php?topic=379200]Highslide4SMF v0.8.1[/url] mod (which has been removed from SMF's Modifications area), it can be found at [url=https://github.com/Spuds/SMF-HS4SMF]GitHub.com[/url].

[color=blue][b][size=12pt][u]Changelog[/u][/size][/b][/color]
[b][u]v1.2 - August 11th, 2014[/u][/b]
o Fixed some undefined language string errors found in mod
o Modified code to insert attachments after pressing "More Attachments" in Posts and PMs

[b][u]v1.1 - July 28th, 2014[/u][/b]
o Fixed two undeclared array element errors in [b]PersonalMessage.template.php[/b]...

[b][u]v1.0 - July 21th, 2014[/u][/b]
o Initial Release of the mod

[hr]
[url=http://creativecommons.org/licenses/by/3.0][img]http://i.creativecommons.org/l/by/3.0/80x15.png[/img][/url]
This work is licensed under a [url=http://creativecommons.org/licenses/by/3.0]Creative Commons Attribution 3.0 Unported License[/url]

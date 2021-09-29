# Recycled Words
This is my personal blog running on [Yellow CMS](https://github.com/datenstrom/yellow). Changes are automatically published with the help of [FTP Deploy Action](https://github.com/SamKirkland/FTP-Deploy-Action). Pictures are automatically optimized with [Imgbot](https://imgbot.net/). I use [Atom](https://atom.io/) (on my desktop) and [Working Copy](https://workingcopyapp.com/) (on my mobile) for edits.

Visit [my blog](https://gaehn.org), and follow me on [Twitter](https://twitter.com/flschr), [LinkedIn](https://www.linkedin.com/in/flschr) and [Komoot](https://www.komoot.de/user/848543125284).

## How it works
The ```main``` branch of this repository is my [live system](https://gaehn.org) while the temporary ```stage``` branch is my playground for testing more extensive modifications before publishing them to my website (f.e. testing updates of Yellow, new plugins, design and layout customizations). All commits are automatically published by [FTP Deploy Action](https://github.com/SamKirkland/FTP-Deploy-Action) to the corresponding ```main``` and ```stage``` directory on my web server.

### How blogging works
Depending on the type of the blog article and the current situation I'll use [Atom](https://atom.io/) on my desktop or [Working Copy](https://workingcopyapp.com/) on my iPhone for edits. For more elaborated content I usually use Atom. For quick notes, photo-blogging or just because I'm on the go, I'll love to use Working Copy on my smartphone.

#### Workflow automatizations on my iPhone
I'm a lazy guy and thats why I created a few Siri shortcuts to simplify the process for creating new content as much as possible.

As I use my iPhone for taking all my photos, I'll needed a smart way to push photos into my repository. The solution I came up with, exists out of 3 Siri shortcuts. [The first one](https://www.icloud.com/shortcuts/2b39f0741b384e8c8c360be84486c3b2) runs photos from the iOS share sheet through the following workflow:

- Resize photos to ```1280px*auto-height```.
- Save photos to a local iOS photo album named ```Blog```.
- Ask if a new blog post should be created (to finish blogging on the smartphone) or else if all pictures should just get synced to the remote repository (to finish blogging on the desktop).

When you choose to only sync the photos to the remote repository, [this Siri shortcut](https://www.icloud.com/shortcuts/65279c78a73048bfb6dd485b597afbf0) is executed which simply writes every photo to ```/media/images/yyyy-mm-dd-hh-mm-ss.jpeg``` and syncs all changes with the remote repository. Finally all photos inside the album ```Blog``` are deleted.

When you choose to continue blogging on your mobile, [this Siri shortcut](https://www.icloud.com/shortcuts/070cb0396611432693c5ec67e84a877b) is running this workflow:

- Ask for the title of the new blog post.
- Create a new file named ```/content/1-blog/yyyy-mm-dd-hh-title-of-the-new-blog-post.md```. The file already contains the Yellow CMS blog header with the current date and the title of the article.
- Write every photo to ```/media/images/yyyy-mm-dd-hh-mm-ss.jpeg```.
- Append ```[image "yyyy-mm-dd-hh-mm-ss.jpeg" ""]``` for every photo to ```/content/1-blog/yyyy-mm-dd-hh-title-of-the-new-blog-post.md```.
- Delete all photos inside the album ```Blog```.
- Start "Working Copy" with ```/content/1-blog/yyyy-mm-dd-hh-title-of-the-new-blog-post.md``` in edit mode.

#### Image optimizations
A few moments after syncing new pictures to the remote repository, they automatically got optimized by [Imgbot](https://imgbot.net/) to reduce the file size with a lossless compression.

### Updating Yellow CMS
The disadvantage by using a Github repository as powerhouse for content creation, website management and deployment of a website running on Yellow is, that you can't use the [standard procedures](https://github.com/datenstrom/yellow-extensions/tree/master/source/update) for updating Yellow CMS to a new version. But anyway, as Yellow only consists out of a a few ```PHP``` and ```HTML``` files, it is not that hard to perform a manual update. When you customized Yellow to your own needs, its even easier to use the tools provided by Atom and Github to migrate your customizations to a new version of Yellow.

#### Steps to update Yellow CMS
Follow this guide for a manual update of Yellow CMS. Depending on the level of your own customizations, you'll probably need 5-10 minutes to update Yellow CMS.

1. Download the [latest Yellow release](https://github.com/datenstrom/yellow/archive/master.zip) and unzip it to a local ```$temp-directory```.
2. Unzip ```blog.php``` from ```$temp-dir\system\extensions\install-blog.zip``` to ```$temp-dir\system\extensions```.
3. Unzip ```german.php```, ```german.txt```, ```english.php```, ```english.txt``` from ```$temp-dir\system\extensions\install-languages.zip``` to ```$temp-dir\system\extensions```.
4. As I don't need the edit extension at all, I delete all ```edit.*``` files, the  ```yellow-user.ini``` and ```install.php``` from ```$temp-dir\system\extensions```. You also can safely delete all ```*.zip``` files from this directory.
5. Open Atom and create the ```stage``` branch.
6. Drag & drop all files from ```$temp-dir\system\extensions``` to the Yellow extension directory in your Atom project. Atom will automatically highlight all files orange that include changes from the repository. All even files, won't be highlighted and you can ignore them.
7. For migrating ```yellow-system.ini``` I suggest to make a diff against the ```main``` repository to see if the updated file contains any new settings. If there are no new settings, I discard all changes of this file.
8. Drag and drop ```$temp-dir\yellow.php``` and all files from ```$temp-dir\system\layouts``` to your Atom project. As I customized nearly every layout file, I diff the local copy against the ```main``` branch to spot the differences in detail. If there are no necessary changes, I discard the changes.
9. Push all changes to your remote repository and wait a few seconds for the automatic sync with your web server. Check your stage environment and if your website is still running fine merge the ```stage``` and ```main``` branch.
10. Finally delete the ```stage``` branch within Atom with ```Ctrl + Shift + H```. Thats it!

 ![yellow-update-atom](https://user-images.githubusercontent.com/23475184/115261122-a3e48a80-a133-11eb-977c-df82aec8237f.jpg)

#### Updating Yellow CMS extensions
Updating Yellow extensions works the same way as updating Yellow. Simply download and unzip the extension you want to update. Drag and drop all necessary files in the corresponding folders of your Atom project and proceed like described above.

##### List of Yellow extensions used in this repository
- [Feed](https://github.com/datenstrom/yellow-extensions/tree/master/source/feed)
- [Fontawesome](https://github.com/datenstrom/yellow-extensions/tree/master/source/fontawesome)
- [Googlemap](https://github.com/datenstrom/yellow-extensions/tree/master/source/googlemap)
- [Random](https://github.com/schulle4u/yellow-extensions-schulle4u/tree/master/random)
- [Search](https://github.com/datenstrom/yellow-extensions/tree/master/source/search)
- [Sitemap](https://github.com/datenstrom/yellow-extensions/tree/master/source/sitemap)
- [Youtube](https://github.com/datenstrom/yellow-extensions/tree/master/source/youtube)

## Forking this repository
### :warning: Duplicate content warning!
If you want to fork this repository, make sure to delete all ```*.md``` files inside ```/content/blog-1``` before publishing it to your own website. Otherwise this 1:1 reuse of content would lead to [duplicate content](https://en.wikipedia.org/wiki/Duplicate_content) which harms the visibility of your and my site in search engines. Its a complex but interesting topic you can [read more about here](https://www.bruceclay.com/seo/duplicate-content/). You may also want to delete all files in ```/content/media```, ```/content/2-about``` and ```/content/downloads```.

## Blog content license
My blog articles are filed under the [CC BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/) license. Basically you are free to reuse my content for non-commercial purposes under the obligation to publish it under the same license. You'll need to give credit and link back to the source article by attributing every article with

```Source: [René Fischer](https://gaehn.org/link-to-the-article), [CC BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/)```

If you credit and link back to the source, search engines usually see your website not as duplicate content.

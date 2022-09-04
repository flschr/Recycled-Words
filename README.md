# Recycled Words
This is my personal blog running on [Yellow CMS](https://github.com/datenstrom/yellow). I use [Visual Studio Code](https://code.visualstudio.com/) on my Mac desktop and [Working Copy](https://workingcopyapp.com/) on my mobile device for edits. For adding photos from my iPhone, I created a simple workflow. All photos are automatically optimized by the [Tinify Image Action](https://github.com/marketplace/actions/tinify-image-action). All edits are automatically published with the help of [FTP Deploy Action](https://github.com/SamKirkland/FTP-Deploy-Action) to my web server.

Visit [my blog](https://gaehn.org), and follow me on [Twitter](https://twitter.com/flschr), [LinkedIn](https://www.linkedin.com/in/flschr) and [Komoot](https://www.komoot.de/user/848543125284).

## How it works
The ```main``` branch of this repository is my [live system](https://gaehn.org). For testing extensive modifications (f.e. testing updates of Yellow, new plugins, design and layout customizations) I create a temporary ```stage``` branch as independent playground. Commits to all branches are automatically published by [FTP Deploy Action](https://github.com/SamKirkland/FTP-Deploy-Action) to the corresponding ```main``` and ```stage``` directory on my web server.

### How blogging works
Depending on the type of the blog article, my mood and current location I'll use [Visual Studio Code](https://code.visualstudio.com/) on my Mac desktop or [Working Copy](https://workingcopyapp.com/) on my iPhone for edits. For more elaborated content I usually use Visual Studio Code. For quick notes, photo-blogging or just because I'm on the go, I'll love to use Working Copy on my smartphone.

#### Workflow automatization on my iPhone
I'm a lazy guy and thats why I created a Siri shortcut to simplify the content creation process as much as possible.

As I use a iPhone as my camera, I'll need a smart way to push photos to my repository. The solution I came up with, is this [Siri shortcut](https://www.icloud.com/shortcuts/e6d934f840f349f38ab5857db9ffc441) which runs photos from the iOS share sheet through the following workflow:
- Save all photos to the local iOS photo album named ```Blog```.
- Ask for the title of the new blog post.
- Create a new file named ```/content/1-blog/yyyy-mm-dd-hh-title-of-the-new-blog-post.md```. The file already contains the Yellow CMS blog header with the current date and the title of the article.
- Write every photo to ```/media/images/yyyy-mm-dd-hh-mm-ss.jpeg```.
- Append ```!["alt text"](yyyy-mm-dd-hh-mm-ss.jpeg)``` for every photo to ```/content/1-blog/yyyy-mm-dd-hh-title-of-the-new-blog-post.md```.
- Remove all photos from the temporary local iOS photo album.
- Start "Working Copy" and open ```/content/1-blog/yyyy-mm-dd-hh-title-of-the-new-blog-post.md``` in edit mode.

If I only want to sync photos to the remote repository, I run [this Siri shortcut](https://www.icloud.com/shortcuts/053ba94bed7f4903a9b0152d8d33d6e2) from the iOS share menu. It simply writes every photo to ```/media/images/yyyy-mm-dd-hh-mm-ss.jpeg``` and syncs all changes to the remote repository. After that, the content of the local photo album ```Blog``` is removed. So I can finishing writing my blog article later from my desktop.

#### Image optimizations
All new photos are automatically processed by the [Tinify Image Action](https://github.com/marketplace/actions/tinify-image-action). They will get resized to ```1280px*auto height``` and than pushed through the [TinyPNG API](https://tinypng.com/) to further reduce the file size with a lossless compression.

### Updating Yellow CMS
The disadvantage by using a Github repository as powerhouse for content creation, website management and deployment of a website running on Yellow is, that you can't use the [standard procedures](https://github.com/datenstrom/yellow-extensions/tree/master/source/update) for updating Yellow CMS to a new version. But anyway, as Yellow only consists out of a a few ```PHP``` and ```HTML``` files, it is not that hard to perform a manual update. When you customized Yellow to your own needs, its even easier to use the tools provided by Visual Studio Code and Github to migrate your customizations to a new version of Yellow.

#### Steps to update Yellow CMS
Follow this guide for a manual update of Yellow CMS. Depending on the level of your own customizations, you'll probably need 5-10 minutes to update Yellow CMS.

1. Download the [latest Yellow release](https://github.com/datenstrom/yellow/archive/master.zip) and unzip it to a local ```$temp-directory```.
2. Rename ```$temp-dir\system\extensions\install-blog.bin``` to ```$temp-dir\system\extensions\install-blog.zip``` and unzip ```blog.php``` to ```$temp-dir\system\extensions``` and ```blog.html``` as well as ```blog-start.html``` to ```$temp-dir\system\layouts```.
3. Rename ```$temp-dir\system\extensions\install-languages.bin``` to ```$temp-dir\system\extensions\install-languages.zip``` and unzip ```german.php```, ```german.txt```, ```english.php```, ```english.txt``` from ```$temp-dir\system\extensions\install-languages.zip``` to ```$temp-dir\system\extensions```.
4. As I don't need the edit extension at all, I delete all ```edit.*``` files, the  ```yellow-user.ini``` and ```install.php``` from ```$temp-dir\system\extensions```. You also can safely delete all ```*.zip``` and all ```update*.*``` files from this directory.
5. Open Visual Studio Code and create the temporary ```stage``` branch.
6. Drag & drop all files from ```$temp-dir\system\extensions``` to the Yellow extension directory in your Visual Studio Code project. Visual Studio Code will automatically highlight all files that include changes. All even files, won't be highlighted and you can ignore them.
7. For migrating ```yellow-system.ini``` I suggest to make a diff against the ```main``` repository to see if the updated file contains any new settings. If there are no new settings, I discard all changes of this file.
8. Drag and drop ```$temp-dir\yellow.php``` and all files from ```$temp-dir\system\layouts``` to your Visual Studio Code project. As I customized nearly every layout file, I diff the local copy against the ```main``` branch to spot the differences in detail. If there are no necessary changes, I discard the changes.
9. Push all changes to your remote repository and wait a few seconds for the automatic sync with your web server. Check your stage environment and if your website is still running fine, merge ```stage``` and ```main``` branch.
10. Finally delete the ```stage``` branch. Thats it!

#### Updating Yellow CMS extensions
Updating Yellow extensions works the same way as updating Yellow. Simply download and unzip the extension you want to update. Drag and drop all necessary files in the corresponding folders of your Visual Studio Code project and proceed like described above.

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

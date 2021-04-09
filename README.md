# Recycled Words
This is my personal blog running on [Yellow CMS](https://github.com/datenstrom/yellow). Changes are automatically published with the help of [FTP Deploy Action](https://github.com/SamKirkland/FTP-Deploy-Action). Pictures are automatically optimized with [Imgbot](https://imgbot.net/).

Visit [my blog](https://gaehn.org), and follow me on [Twitter](https://twitter.com/flschr), [LinkedIn](https://www.linkedin.com/in/flschr) and [Komoot](https://www.komoot.de/user/848543125284).

## How it works
This repository exists out of 2 permanent branches. ```main``` is my [live system](https://gaehn.org) while ```stage``` is my [little playground](https://test.gaehn.org) for testing more extensive modifications before publishing them to my website (f.e. test Yellow updates and new plugins but also design and layout customizations). All commits are automatically published by [FTP Deploy Action](https://github.com/SamKirkland/FTP-Deploy-Action) to the corresponding ```main``` and ```stage``` directory on my web server.

### How blogging works
For creating new content I always use the ```main``` branch. Usually I use [Atom](https://atom.io/) on my desktop to write new articles and make other edits. If, for whatever reason, I need to write a article on the go, I'll use [Working Copy](https://workingcopyapp.com/) as my preferred editor.

#### Handling of pictures
As I use my iPhone for taking photos only, I'll need a smart way to push pictures into my repository. For that I've created this [Siri shortcut](https://www.icloud.com/shortcuts/2b41352b03fb469e954fac53165a8268) which runs photos from the iOS share sheet through the following workflow:

- Resize picture to ```1280px*auto-height```
- Convert picture to JPEG (can't make use of HEIC)
- Reduce image quality to ~90%
- Write picture to ```/media/images/yyyy-mm-dd-hh-mm-ss.jpeg``` within Working Copy
- For ease of use, append the ready to use markup ```[image yyyy-mm-dd-hh-mm-ss.jpeg]``` to ```/content/1-blog/_latest-pics.txt```
- Commit changes
- Choice for automatic fetch, pull and push repository within Working Copy


The pictures can than to be used in blog articles within Atom and Working Copy. A few moments later, all pictures are automatically optimized by [Imgbot](https://imgbot.net/) to further reduce the file size with a lossless compression.

### Updating Yellow CMS
(will follow soooooon)

## Forks of this repository
Before you fork this repository, please make sure you've read and understand the following section. **Please make sure your fork isn't violating this conditions!**

#### Duplicate content warning!
If you want to fork this repository, make sure to delete all ```*.md``` files inside ```/content/blog-1``` before publishing it to your own website. Otherwise this 1:1 reuse of content would lead to [duplicate content](https://en.wikipedia.org/wiki/Duplicate_content) which harms the visibility of your and my site in search engines. Its a complex but interesting topic you can [read more about here](https://www.bruceclay.com/seo/duplicate-content/).

#### License of my content (blog articles)
All my blog articles filed under the [CC BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/) license. So you are free to my reuse my content for non commercial purposes under the obligation to publish it under the same license again. You'll always need to give credit and link back to the source by attributing every article with

```Source: [René Fischer](https://gaehn.org/link-to-the-article), [CC BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/)```

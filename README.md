# Recycled Words
This is my personal blog running on [Yellow CMS](https://github.com/datenstrom/yellow). Changes are automatically published with the help of [FTP Deploy Action](https://github.com/SamKirkland/FTP-Deploy-Action). Pictures are automatically optimized with [Imgbot](https://imgbot.net/).

Visit [my blog](https://gaehn.org), and follow me on [Twitter](https://twitter.com/flschr), [LinkedIn](https://www.linkedin.com/in/flschr) and [Komoot](https://www.komoot.de/user/848543125284).

## How it works
This repository exists out of 2 permanent branches. ```main``` is my [live system](https://gaehn.org) while ```stage``` is my [little playground](https://test.gaehn.org) for testing more extensive modifications before publishing them to my website (f.e. test Yellow updates and new plugins but also design and layout customizations). All commits are automatically published by [FTP Deploy Action](https://github.com/SamKirkland/FTP-Deploy-Action) to the corresponding ```main``` and ```stage``` directory on my web server.

### How blogging works
For creating new content I always use the ```main``` branch. Usually I use [Atom](https://atom.io/) on my desktop to write new articles and make other edits. If, for whatever reason, I need to write a article on the go, I'll use [Working Copy](https://workingcopyapp.com/) as my preferred editor.

#### Handling of pictures
As I use my iPhone for taking photos only, I'll need a smart way to push pictures into my repository. For that I've created this [Siri shortcut](https://www.icloud.com/shortcuts/fedf63ab19b7445486e840eea5606ff7) which runs photos from the iOS share sheet through the following workflow:

- Resize picture to ```1280px*auto-height```
- Convert picture to JPEG (can't make use of HEIC)
- Reduce image quality to 85%
- Write picture to ```/media/images/yyyy-mm-dd-hh-mm-ss.jpeg``` within Working Copy
- Commit change
- Choice for automatic fetch, pull and push repository within Working Copy

The picture is than ready to be used in blog articles within Atom and Working Copy. After that all pictures are automatically optimized with [Imgbot](https://imgbot.net/) to reduce the file size with a lossless compression.

### Updating Yellow CMS
(will follow soooooon)

# Recycled Words
This is my personal blog running on [Yellow CMS](https://github.com/datenstrom/yellow). Changes are automatically published with the help of [FTP Deploy Action](https://github.com/SamKirkland/FTP-Deploy-Action). Pictures are automatically optimized with [Imgbot](https://imgbot.net/).

Visit [my blog](https://gaehn.org), or follow me on [Twitter](https://twitter.com/flschr), [LinkedIn](https://www.linkedin.com/in/flschr) or [Komoot](https://www.komoot.de/user/848543125284).

## How it works
This repository exists out of 2 permanent branches. ```main``` is my [live system](https://gaehn.org) while ```stage``` is my [little playground](https://test.gaehn.org) for testing more extensive modifications before publishing them to my website (f.e. test Yellow updates and new plugins but also design and layout customizations). All edits are automatically published with the help of [FTP Deploy Action](https://github.com/SamKirkland/FTP-Deploy-Action).

### How blogging works
For creating new content I always use the ```main``` branch. Usually I use [Atom](https://atom.io/) on my desktop to write new articles and make other edits. If, for whatever reason, I need to write a article on the go, I'll use [Working Copy](https://workingcopyapp.com/) as my preferred editor.

#### Handling of pictures
As I only use my iPhone for taking photos, I'll need a simple way to push pictures into my repository. For that I've created this [Siri shortcut](https://www.icloud.com/shortcuts/d8658830d5cb4ba4bff8ba827e11b054) for handling photos from the iOS sharesheet with the following workflow:

- Resize picture to ```1280px*auto-height```
- Convert picture to JPEG (can't make use of HEIC)
- Reduce image quality to 85%
- Write picture to ```/media/images/yyyy-mm-dd-hh-mm-ss.jpeg``` within Working Copy
- Fetch, pull, commit and push repository within Working Copy

The picture is than ready to be used in blog articles within Atom and Working Copy. Later on all pictures are automatically optimized with [Imgbot](https://imgbot.net/) to reduce the file size with a lossless compression.

### Updating Yellow CMS
(will follow soon)

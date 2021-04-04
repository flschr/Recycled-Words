<?php
// Blog extension, https://github.com/datenstrom/yellow-extensions/tree/master/source/blog

class YellowBlog {
    const VERSION = "0.8.12";
    public $yellow;         // access to API
    
    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
        $this->yellow->system->setDefault("blogLocation", "");
        $this->yellow->system->setDefault("blogNewLocation", "@title");
        $this->yellow->system->setDefault("blogPagesMax", "5");
        $this->yellow->system->setDefault("blogPaginationLimit", "5");
    }
    
    // Handle page content of shortcut
    public function onParseContentShortcut($page, $name, $text, $type) {
        $output = null;
        if (substru($name, 0, 4)=="blog" && ($type=="block" || $type=="inline")) {
            switch($name) {
                case "blogarchive": $output = $this->getShorcutBlogarchive($page, $name, $text); break;
                case "blogauthors": $output = $this->getShorcutBlogauthors($page, $name, $text); break;
                case "blogpages":   $output = $this->getShorcutBlogpages($page, $name, $text); break;
                case "blogchanges": $output = $this->getShorcutBlogchanges($page, $name, $text); break;
                case "blogrelated": $output = $this->getShorcutBlogrelated($page, $name, $text); break;
                case "blogtags":    $output = $this->getShorcutBlogtags($page, $name, $text); break;
            }
        }
        return $output;
    }
        
    // Return blogarchive shortcut
    public function getShorcutBlogarchive($page, $name, $text) {
        $output = null;
        list($location, $pagesMax) = $this->yellow->toolbox->getTextArguments($text);
        if (empty($location)) $location = $this->yellow->system->get("blogLocation");
        if (empty($location)) $location = "unknown";
        if (strempty($pagesMax)) $pagesMax = $this->yellow->system->get("blogPagesMax");
        $blog = $this->yellow->content->find($location);
        $pages = $this->getBlogPages($location);
        $page->setLastModified($pages->getModified());
        $months = $this->getMonths($pages, "published");
        if (count($months)) {
            if ($pagesMax!=0) $months = array_slice($months, -$pagesMax);
            uksort($months, "strnatcasecmp");
            $months = array_reverse($months);
            $output = "<div class=\"".htmlspecialchars($name)."\">\n";
            $output .= "<ul>\n";
            foreach ($months as $key=>$value) {
                $output .= "<li><a href=\"".$blog->getLocation(true).$this->yellow->toolbox->normaliseArguments("published:$key")."\">";
                $output .= htmlspecialchars($this->yellow->language->normaliseDate($key))."</a></li>\n";
            }
            $output .= "</ul>\n";
            $output .= "</div>\n";
        } else {
            $page->error(500, "Blogarchive '$location' does not exist!");
        }
        return $output;
    }
    
    // Return blogauthors shortcut
    public function getShorcutBlogauthors($page, $name, $text) {
        $output = null;
        list($location, $pagesMax) = $this->yellow->toolbox->getTextArguments($text);
        if (empty($location)) $location = $this->yellow->system->get("blogLocation");
        if (empty($location)) $location = "unknown";
        if (strempty($pagesMax)) $pagesMax = $this->yellow->system->get("blogPagesMax");
        $blog = $this->yellow->content->find($location);
        $pages = $this->getBlogPages($location);
        $page->setLastModified($pages->getModified());
        $authors = $this->getMeta($pages, "author");
        if (count($authors)) {
            $authors = $this->yellow->lookup->normaliseUpperLower($authors);
            if ($pagesMax!=0 && count($authors)>$pagesMax) {
                uasort($authors, "strnatcasecmp");
                $authors = array_slice($authors, -$pagesMax);
            }
            uksort($authors, "strnatcasecmp");
            $output = "<div class=\"".htmlspecialchars($name)."\">\n";
            $output .= "<ul>\n";
            foreach ($authors as $key=>$value) {
                $output .= "<li><a href=\"".$blog->getLocation(true).$this->yellow->toolbox->normaliseArguments("author:$key")."\">";
                $output .= htmlspecialchars($key)."</a></li>\n";
            }
            $output .= "</ul>\n";
            $output .= "</div>\n";
        } else {
            $page->error(500, "Blogauthors '$location' does not exist!");
        }
        return $output;
    }

    // Return blogpages shortcut
    public function getShorcutBlogpages($page, $name, $text) {
        $output = null;
        list($location, $pagesMax, $author, $tag) = $this->yellow->toolbox->getTextArguments($text);
        if (empty($location)) $location = $this->yellow->system->get("blogLocation");
        if (empty($location)) $location = "unknown";
        if (strempty($pagesMax)) $pagesMax = $this->yellow->system->get("blogPagesMax");
        $blog = $this->yellow->content->find($location);
        $pages = $this->getBlogPages($location);
        if (!empty($author)) $pages->filter("author", $author);
        if (!empty($tag)) $pages->filter("tag", $tag);
        $pages->sort("title");
        $page->setLastModified($pages->getModified());
        if (count($pages)) {
            if ($pagesMax!=0) $pages->limit($pagesMax);
            $output = "<div class=\"".htmlspecialchars($name)."\">\n";
            $output .= "<ul>\n";
            foreach ($pages as $pageBlog) {
                $output .= "<li><a".($pageBlog->isExisting("tag") ? " class=\"".$this->getClass($pageBlog)."\"" : "");
                $output .=" href=\"".$pageBlog->getLocation(true)."\">".$pageBlog->getHtml("title")."</a></li>\n";
            }
            $output .= "</ul>\n";
            $output .= "</div>\n";
        } else {
            $page->error(500, "Blogpages '$location' does not exist!");
        }
        return $output;
    }
    
    // Return blogchanges shortcut
    public function getShorcutBlogchanges($page, $name, $text) {
        $output = null;
        list($location, $pagesMax, $author, $tag) = $this->yellow->toolbox->getTextArguments($text);
        if (empty($location)) $location = $this->yellow->system->get("blogLocation");
        if (empty($location)) $location = "unknown";
        if (strempty($pagesMax)) $pagesMax = $this->yellow->system->get("blogPagesMax");
        $blog = $this->yellow->content->find($location);
        $pages = $this->getBlogPages($location);
        if (!empty($author)) $pages->filter("author", $author);
        if (!empty($tag)) $pages->filter("tag", $tag);
        $pages->sort("published", false);
        $page->setLastModified($pages->getModified());
        if (count($pages)) {
            if ($pagesMax!=0) $pages->limit($pagesMax);
            $output = "<div class=\"".htmlspecialchars($name)."\">\n";
            $output .= "<ul>\n";
            foreach ($pages as $pageBlog) {
                $output .= "<li><a".($pageBlog->isExisting("tag") ? " class=\"".$this->getClass($pageBlog)."\"" : "");
                $output .=" href=\"".$pageBlog->getLocation(true)."\">".$pageBlog->getHtml("title")."</a></li>\n";
            }
            $output .= "</ul>\n";
            $output .= "</div>\n";
        } else {
            $page->error(500, "Blogchanges '$location' does not exist!");
        }
        return $output;
    }
        
    // Return blogrelated shortcut
    public function getShorcutBlogrelated($page, $name, $text) {
        $output = null;
        list($location, $pagesMax) = $this->yellow->toolbox->getTextArguments($text);
        if (empty($location)) $location = $this->yellow->system->get("blogLocation");
        if (empty($location)) $location = "unknown";
        if (strempty($pagesMax)) $pagesMax = $this->yellow->system->get("blogPagesMax");
        $blog = $this->yellow->content->find($location);
        $pages = $this->getBlogPages($location);
        $pages->similar($page->getPage("main"));
        $page->setLastModified($pages->getModified());
        if (count($pages)) {
            if ($pagesMax!=0) $pages->limit($pagesMax);
            $output = "<div class=\"".htmlspecialchars($name)."\">\n";
            $output .= "<ul>\n";
            foreach ($pages as $pageBlog) {
                $output .= "<li><a".($pageBlog->isExisting("tag") ? " class=\"".$this->getClass($pageBlog)."\"" : "");
                $output .= " href=\"".$pageBlog->getLocation(true)."\">".$pageBlog->getHtml("title")."</a></li>\n";
            }
            $output .= "</ul>\n";
            $output .= "</div>\n";
        } else {
            $page->error(500, "Blogrelated '$location' does not exist!");
        }
        return $output;
    }
    
    // Return blogtags shortcut
    public function getShorcutBlogtags($page, $name, $text) {
        $output = null;
        list($location, $pagesMax) = $this->yellow->toolbox->getTextArguments($text);
        if (empty($location)) $location = $this->yellow->system->get("blogLocation");
        if (empty($location)) $location = "unknown";
        if (strempty($pagesMax)) $pagesMax = $this->yellow->system->get("blogPagesMax");
        $blog = $this->yellow->content->find($location);
        $pages = $this->getBlogPages($location);
        $page->setLastModified($pages->getModified());
        $tags = $this->getMeta($pages, "tag");
        if (count($tags)) {
            $tags = $this->yellow->lookup->normaliseUpperLower($tags);
            if ($pagesMax!=0 && count($tags)>$pagesMax) {
                uasort($tags, "strnatcasecmp");
                $tags = array_slice($tags, -$pagesMax);
            }
            uksort($tags, "strnatcasecmp");
            $output = "<div class=\"".htmlspecialchars($name)."\">\n";
            $output .= "<ul>\n";
            foreach ($tags as $key=>$value) {
                $output .= "<li><a href=\"".$blog->getLocation(true).$this->yellow->toolbox->normaliseArguments("tag:$key")."\">";
                $output .= htmlspecialchars($key)."</a></li>\n";
            }
            $output .= "</ul>\n";
            $output .= "</div>\n";
        } else {
            $page->error(500, "Blogtags '$location' does not exist!");
        }
        return $output;
    }
    
    // Handle page layout
    public function onParsePageLayout($page, $name) {
        if ($name=="blogpages") {
            $pages = $this->getBlogPages($page->location);
            $pagesFilter = array();
            if ($page->isRequest("tag")) {
                $pages->filter("tag", $page->getRequest("tag"));
                array_push($pagesFilter, $pages->getFilter());
            }
            if ($page->isRequest("author")) {
                $pages->filter("author", $page->getRequest("author"));
                array_push($pagesFilter, $pages->getFilter());
            }
            if ($page->isRequest("published")) {
                $pages->filter("published", $page->getRequest("published"), false);
                array_push($pagesFilter, $this->yellow->language->normaliseDate($pages->getFilter()));
            }
            $pages->sort("published");
            $pages->pagination($this->yellow->system->get("blogPaginationLimit"));
            if (!$pages->getPaginationNumber()) $page->error(404);
            if (!empty($pagesFilter)) {
                $text = implode(" ", $pagesFilter);
                $page->set("titleHeader", $text." - ".$page->get("sitename"));
                $page->set("titleContent", $page->get("title").": ".$text);
                $page->set("title", $page->get("title").": ".$text);
            } else {
                $page->set("titleContent", "");
            }
            $page->setPages("blog", $pages);
            $page->setLastModified($pages->getModified());
            $page->setHeader("Cache-Control", "max-age=60");
        }
        if ($name=="blog") {
            $location = $this->yellow->system->get("blogLocation");
            if (empty($location)) $location = $this->yellow->lookup->getDirectoryLocation($page->location);
            $blog = $this->yellow->content->find($location);
            $page->setPage("blog", $blog);
        }
    }
    
    // Handle content file editing
    public function onEditContentFile($page, $action, $email) {
        if ($page->get("layout")=="blog") $page->set("pageNewLocation", $this->yellow->system->get("blogNewLocation"));
    }

    // Return blog pages
    public function getBlogPages($location) {
        $pages = $this->yellow->content->clean();
        $blog = $this->yellow->content->find($location);
        if ($blog) {
            if ($location==$this->yellow->system->get("blogLocation")) {
                $pages = $this->yellow->content->index(!$blog->isVisible());
            } else {
                $pages = $blog->getChildren(!$blog->isVisible());
            }
            $pages->filter("layout", "blog");
        }
        return $pages;
    }
    
    // Return class for page
    public function getClass($page) {
        $class = "";
        if ($page->isExisting("tag")) {
            foreach (preg_split("/\s*,\s*/", $page->get("tag")) as $tag) {
                $class .= " tag-".$this->yellow->toolbox->normaliseArguments($tag, false);
            }
        }
        return trim($class);
    }
    
    // Return meta data from page collection
    public function getMeta($pages, $key) {
        $data = array();
        foreach ($pages as $page) {
            if ($page->isExisting($key)) {
                foreach (preg_split("/\s*,\s*/", $page->get($key)) as $entry) {
                    if (!isset($data[$entry])) $data[$entry] = 0;
                    ++$data[$entry];
                }
            }
        }
        return $data;
    }
    
    // Return months from page collection
    public function getMonths($pages, $key) {
        $data = array();
        foreach ($pages as $page) {
            if (preg_match("/^(\d+\-\d+)\-/", $page->get($key), $matches)) {
                if (!isset($data[$entry])) $data[$entry] = 0;
                ++$data[$matches[1]];
            }
        }
        return $data;
    }
}

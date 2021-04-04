<?php
// Draft extension, https://github.com/datenstrom/yellow-extensions/tree/master/source/draft

class YellowDraft {
    const VERSION = "0.8.11";
    public $yellow;         // access to API
    
    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
        $this->yellow->system->setDefault("draftPaginationLimit", "30");
    }
    
    // Handle page meta data
    public function onParseMeta($page) {
        if ($page->get("status")=="draft") $page->visible = false;
    }
    
    // Handle page layout
    public function onParsePageLayout($page, $name) {
        if ($this->yellow->page->get("status")=="draft" && $this->yellow->getRequestHandler()=="core") {
            $pageError = "";
            if ($this->yellow->extension->isExisting("edit")) {
                $pageError .= "<a href=\"".$this->yellow->page->get("pageEdit")."\">";
                $pageError .= $this->yellow->language->getText("draftPageError")."</a>";
            }
            $this->yellow->page->error(420, $pageError);
        }
        if ($name=="draftpages") {
            $pages = $this->yellow->content->index(true, false)->filter("status", "draft");
            $pages->diff($this->yellow->content->index(true, false)->filter("layout", "draftpages"));
            $pages->sort("title", false);
            $pages->pagination($this->yellow->system->get("draftPaginationLimit"));
            if ($page->isRequest("page") && !$pages->getPaginationNumber()) $this->yellow->page->error(404);
            $this->yellow->page->setPages("draft", $pages);
            $this->yellow->page->setLastModified($pages->getModified());
            $this->yellow->page->setHeader("Cache-Control", "max-age=60");
            $this->yellow->page->set("status", count($pages) ? "done" : "empty");
        }
    }
}

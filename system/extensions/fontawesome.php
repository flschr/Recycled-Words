<?php
// Fontawesome extension, https://github.com/datenstrom/yellow-extensions/tree/master/source/fontawesome

class YellowFontawesome {
    const VERSION = "0.8.7";
    public $yellow;         // access to API
    
    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
        $this->yellow->system->setDefault("fontawesomeToolbarButtons", ":fa-star: :fa-heart: :fa-exclamation-triangle: :fa-tag: :fa-comment: :fa-file-o: :fa-file-text-o: :fa-file-picture-o: :fa-envelope-o: :fa-phone: :fa-twitter: :fa-github: :fa-calendar: :fa-clock-o: :fa-map-marker: :fa-check:");
    }

    // Handle page content of shortcut
    public function onParseContentShortcut($page, $name, $text, $type) {
        $output = null;
         if (($name=="fa" && $type=="inline") || $type=="symbol") {
            list($shortname, $style) = $this->yellow->toolbox->getTextArguments($text);
            if (preg_match("/fa-(.+)/", $shortname, $matches)) {
                $shortname = $matches[1];
                $class = trim("fa fa-$shortname $style");
                $output = "<i class=\"".htmlspecialchars($class)."\"></i>";
            }
        }
        return $output;
    }
    
    // Handle page extra data
    public function onParsePageExtra($page, $name) {
        $output = null;
        if ($name=="header") {
            $extensionLocation = $this->yellow->system->get("coreServerBase").$this->yellow->system->get("coreExtensionLocation");
            $output = "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"{$extensionLocation}fontawesome.css\" />\n";
        }
        return $output;
    }
}

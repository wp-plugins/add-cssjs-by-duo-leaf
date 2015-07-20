<?php

class dl_acj_Injector {

    public $pluginInfo;

    /**
     * Constructor
     */
    public function __construct($pluginInfo) {
        $this->pluginInfo = $pluginInfo;
    }

    /**
     * Inject JS/CSS into page 
     */
    function execute($header) {

        if (is_admin() OR is_feed() OR is_robots() OR is_trackback()) {
            return;
        }

        $resources = $this->getResources($header);

        foreach ($resources as $resource) {

            if ($this->verifyIfShoundInject($resource)) {
                $this->inject($resource);
            }
        }
    }

    function getResources($header) {

        global $wpdb;

        $sql = $wpdb->prepare('SELECT * FROM `' . $this->pluginInfo->cssjsTableName . '` WHERE header = %d;', $header);

        return $wpdb->get_results($sql);
    }

    function verifyIfShoundInject($resource) {

        $currentUrl = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

        $shouldInject = true;

        $urls = $resource->urls;

        $urls = trim($urls);

        if (!empty($urls)) {

            $shouldInject = false;

            $urls = explode(PHP_EOL, $urls);

            foreach ($urls as $url) {

                $url = stripslashes($url);

                $url = trim($url);

                if (!empty($url) && strpos($currentUrl, $url) !== false) {

                    $shouldInject = true;
                    break;
                }
            }
        }

        return $shouldInject;
    }

    function inject($resource) {

        if ($resource->type == "CSS") {
            echo '<style ' . stripslashes($resource->attributes) . '>' . stripslashes($resource->content) . '</style>';
        } else {
            echo '<script ' . stripslashes($resource->attributes) . '>' . stripslashes($resource->content) . '</script>';
        }
    }

}

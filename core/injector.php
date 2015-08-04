<?php

class dl_acj_Injector {

    /** @var dl_acj_PluginInfo */
    public $pluginInfo;

    /** @var dl_acj_Storage */
    public $storage;

    /** @var array */
    public $server;

    public function __construct($pluginInfo, $storage, $server) {

        $this->pluginInfo = $pluginInfo;
        $this->storage = $storage;
        $this->server = $server;

        add_action('wp_head', array(&$this, 'injectJSHeader'));
        add_action('wp_footer', array(&$this, 'injectJSFooter'));
    }

    function execute($location) {

        if (is_admin() OR is_feed() OR is_robots() OR is_trackback()) {
            return;
        }

        $resources = $this->storage->getResourceByLocationAndEnabled($location, true);

        foreach ($resources as $resource) {

            if ($this->verifyIfShoundInject($resource)) {
                $this->inject($resource);
            }
        }
    }

    function verifyIfShoundInject($resource) {

        $currentUrl = 'http' . (isset($this->server['HTTPS']) ? 's' : '') . '://' . "{$this->server['HTTP_HOST']}{$this->server['REQUEST_URI']}";

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

        if ($resource->type == dl_acj_ResourceType::CSS) {
            echo '<style ' . stripslashes($resource->attributes) . '>' . stripslashes($resource->content) . '</style>';
        } else {
            echo '<script ' . stripslashes($resource->attributes) . '>' . stripslashes($resource->content) . '</script>';
        }
    }

    function injectJSHeader() {

        $this->execute(dl_acj_ResourceLocation::Header);
    }

    function injectJSFooter() {

        $this->execute(dl_acj_ResourceLocation::Footer);
    }

}

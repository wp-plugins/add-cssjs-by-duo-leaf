<?php

class dl_acj_ActionResourceList {

    /** @var dl_acj_PluginInfo */
    public $pluginInfo;

    /** @var dl_acj_Storage */
    public $storage;

    public function __construct($pluginInfo, $storage) {

        $this->pluginInfo = $pluginInfo;
        $this->storage = $storage;
    }

    public function execute() {
        $view = new stdClass();
        $view->pluginInfo = $this->pluginInfo;
        $view->resources = $this->storage->getAllResources();
        $view->resourceTypes = $this->storage->getAllResourceTypes();
        return $view;
    }

}

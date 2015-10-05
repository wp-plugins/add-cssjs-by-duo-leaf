<?php

class dl_acj_ActionResourceForm {

    /** @var dl_acj_PluginInfo */
    public $pluginInfo;

    /** @var dl_acj_Storage */
    public $storage;

    /** @var array */
    public $get;

    /** @var array */
    public $post;

    public function __construct($pluginInfo, $storage, $get, $post) {

        $this->pluginInfo = $pluginInfo;
        $this->storage = $storage;
        $this->get = $get;
        $this->post = $post;
    }

    public function execute() {
        $view = new stdClass();

        $view->resourceLocations = $this->storage->getAllResourceLocations();
        $view->resourceTypes = $this->storage->getAllResourceTypes();
        $view->pluginInfo = $this->pluginInfo;
        
        $view->onceName = $this->pluginInfo->name . '_nonce';

        $view->errorMessage = $this->getErrorsForm($view->onceName);

        $view->resource = $this->getCurrentResource($this->getCurrentID());

        if (!empty($view->errorMessage)) {
            return $view;
        }

        if (isset($this->post['submit'])) {
            $this->fillResourceObject($view->resource);

            $this->saveResource($view->resource);

            $view->message = __('Saved successfully.', $this->pluginInfo->name);
        }



        return $view;
    }

    public function getCurrentID() {

        $currentId = 0;

        if (isset($this->get['resourceID']) && $this->get['resourceID'] != 0) {
            $currentId = $this->get['resourceID'];
        } elseif (isset($this->post['resourceID']) && $this->post['resourceID'] != 0) {
            $currentId = $this->post['resourceID'];
        }

        return $currentId;
    }

    public function getErrorsForm($onceName) {
        $errorMessage = "";

        if (!isset($this->post[$onceName])) { // Missing nonce	
            $this->errorMessage = __('nonce field is missing. Settings NOT saved.', $this->pluginInfo->name);
        } elseif (!wp_verify_nonce($this->post[$onceName], $this->pluginInfo->name)) { // Invalid nonce
            $this->errorMessage = __('Invalid nonce specified. Settings NOT saved.', $this->pluginInfo->name);
        }
        return $errorMessage;
    }

    public function getCurrentResource($currentId) {
        if ($currentId != 0) {
            return $this->storage->getResourceByID($currentId);
        } else {
            return new dl_acj_Resource();
        }
    }

    public function fillResourceObject($resource) {

        $resource->name = $this->post['resourceName'];
        $resource->content = $this->post['resourceContent'];
        $resource->type = $this->post['resourceType'];
        $resource->attributes = $this->post['resourceAttributes'];
        $resource->urls = $this->post['resourceUrls'];
        $resource->location = $this->post['resourceLocation'];
        $resource->enabled = isset($this->post['resourceEnabled']);

        return $resource;
    }

    public function saveResource($resource) {

        $ressourceArray = get_object_vars($resource);

        if ($resource->id == 0) {
            $resource->id = $this->storage->insertResource($ressourceArray);
        } else {
            $this->storage->updateResource($ressourceArray, $resource->id);
        }
    }

}

<?php

$this->view->onceName = $this->pluginInfo->name . '_nonce';

if (isset($_GET['resourceID']) && $_GET['resourceID'] != 0) {
    $this->view->resource = $this->resourcesAccess->getById($_GET['resourceID']);
} elseif (isset($_POST['resourceID']) && $_POST['resourceID'] != 0) {
    $this->view->resource = $this->resourcesAccess->getById($_POST['resourceID']);
} else {
    $this->view->resource = new dl_acj_Resource();
}

if (isset($_POST['submit'])) {

    // Check nonce
    if (!isset($_POST[$this->view->onceName])) {
        // Missing nonce	
        $this->errorMessage = __('nonce field is missing. Settings NOT saved.', $this->pluginInfo->name);
    } elseif (!wp_verify_nonce($_POST[$this->view->onceName], $this->pluginInfo->name)) {
        // Invalid nonce
        $this->errorMessage = __('Invalid nonce specified. Settings NOT saved.', $this->pluginInfo->name);
    } else {

        $this->view->resource->name = $_POST['resourceName'];
        $this->view->resource->content = $_POST['resourceContent'];
        $this->view->resource->type = $_POST['resourceType'];
        $this->view->resource->attributes = $_POST['resourceAttributes'];
        $this->view->resource->urls = $_POST['resourceUrls'];
        $this->resourcesAccess->update($this->view->resource);

        $this->message = __('Settings Saved.', $this->name);
    }
}

include_once(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/views/resource-form.php');

<?php

$this->view->onceName = $this->pluginInfo->name . '_nonce';

global $wpdb;

$currentId = 0;

if (isset($_GET['resourceID']) && $_GET['resourceID'] != 0) {
    $currentId = $_GET['resourceID'];
} elseif (isset($_POST['resourceID']) && $_POST['resourceID'] != 0) {
    $currentId = $_POST['resourceID'];
}

if ($currentId != 0) {
    $this->view->resource = $wpdb->get_row($wpdb->prepare('SELECT * FROM `' . $this->pluginInfo->cssjsTableName . '` WHERE id = %d;', $currentId));
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

        $this->view->resource->id = $currentId;
        $this->view->resource->name = $_POST['resourceName'];
        $this->view->resource->content = $_POST['resourceContent'];
        $this->view->resource->type = $_POST['resourceType'];
        $this->view->resource->attributes = $_POST['resourceAttributes'];
        $this->view->resource->urls = $_POST['resourceUrls'];
        $this->view->resource->header = $_POST['resourceLocation'];

        $ressourceArray = get_object_vars($this->view->resource);

        if ($currentId == 0) {
            $wpdb->insert($this->pluginInfo->cssjsTableName, $ressourceArray);
            $this->view->resource->id = $wpdb->insert_id;
        } else {
            $wpdb->update($this->pluginInfo->cssjsTableName, $ressourceArray, array('id' => $currentId));
        }

        $this->message = __('Settings Saved.', $this->name);
    }
}



include_once(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/views/resource-form.php');

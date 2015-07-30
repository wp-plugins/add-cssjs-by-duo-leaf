<?php

global $wpdb;

$this->resources = $wpdb->get_results('SELECT * FROM `' . $this->pluginInfo->cssjsTableName . '`;');

include_once(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/views/resources-list.php');

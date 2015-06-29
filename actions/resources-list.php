<?php

require_once(WP_PLUGIN_DIR . '/add-cssjs-by-duo-leaf/core/resources-list-table.php');

global $wpdb;

$results = $wpdb->get_results('SELECT * FROM `' . $this->pluginInfo->cssjsTableName . '`;');

$this->resourcesListTable = new dl_acj_ResourcesListTable($results, $this->pluginInfo);

$this->resourcesListTable->prepare_items();

include_once(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/views/resources-list.php');

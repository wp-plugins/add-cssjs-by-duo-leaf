<?php

require_once(WP_PLUGIN_DIR . '/add-css-js/core/resources-list-table.php');

$this->resourcesListTable = new dl_acj_ResourcesListTable($this->resourcesAccess->getAll(), $this->pluginInfo);

$this->resourcesListTable->prepare_items();

include_once(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/views/resources-list.php');

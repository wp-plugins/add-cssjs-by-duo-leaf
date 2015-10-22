<?php

class dl_acj_PluginInfo {

    /**
     * Properties
     */
    public $name;
    public $displayName;
    public $smallDisplayName;
    public $tableNamePrefix;
    public $cssjsTableName;
    public $currentVersion;

    /**
     * Constructor
     */
    public function __construct() {

        $this->name = "add-cssjs-by-duo-leaf";
        $this->smallDisplayName = "Add CSS/Js";
        $this->displayName = $this->smallDisplayName . " by Duo Leaf";

        $this->currentVersion = '1.0.5';


        global $wpdb;
        $this->tableNamePrefix = "dl_acj";
        $this->cssjsTableName = $wpdb->prefix . $this->tableNamePrefix . "_cssjs";
    }

}

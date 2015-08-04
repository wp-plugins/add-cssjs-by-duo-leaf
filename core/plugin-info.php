<?php


class dl_acj_PluginInfo {

    /**
     * Properties
     */
    public $name;
    public $displayName;
    public $tableNamePrefix;
    public $cssjsTableName;
    public $currentVersion;
    
    
    

    /**
     * Constructor
     */
    public function __construct() {

        $this->name = "add-cssjs-by-duo-leaf";
        $this->displayName = "Add CSS/Js by Duo Leaf";
        
        $this->currentVersion = '1.0.4';
        
        
        global $wpdb;
        $this->tableNamePrefix = "dl_acj";
        $this->cssjsTableName = $wpdb->prefix . $this->tableNamePrefix . "_cssjs";
    }

}
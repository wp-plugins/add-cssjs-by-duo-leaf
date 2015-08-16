<?php

class dl_acj_UpgradeManager {

    /** @var dl_acj_PluginInfo */
    public $pluginInfo;

    public function __construct($pluginInfo) {

        $this->pluginInfo = $pluginInfo;

        register_activation_hook(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/index.php', array(&$this, 'activate'));

        add_action('plugins_loaded', array(&$this, 'upgrade'));
    }

    public function upgrade() {

        global $wpdb;

        $optionName = $this->pluginInfo->name . "-version";
        $oldVersionValue = get_option($optionName, '1.0.0');

        if ($oldVersionValue != $this->pluginInfo->currentVersion) {

            if (in_array($oldVersionValue, array('1.0.0', '1.0.1', '1.0.2', '1.0.3'))) {
                
                $wpdb->query('UPDATE `' . $this->pluginInfo->cssjsTableName . '` SET type = \'0\' WHERE type = \'CSS\';');
                $wpdb->query('UPDATE `' . $this->pluginInfo->cssjsTableName . '` SET type = \'1\' WHERE type = \'Javascript\';');
               
                $this->activate();
                
                $wpdb->query('UPDATE `' . $this->pluginInfo->cssjsTableName . '` SET location = 0 WHERE header = 1;');
                $wpdb->query('UPDATE `' . $this->pluginInfo->cssjsTableName . '` SET location = 1 WHERE header = 0;');
                
                $wpdb->query('ALTER TABLE `' . $this->pluginInfo->cssjsTableName . '` DROP `header`;');
                
                $oldVersionValue = '1.0.3';
            }
            update_option($optionName, $this->pluginInfo->currentVersion);
        }
    }

    public function activate() {

        global $wpdb;

        $sql = 'CREATE TABLE `' . $this->pluginInfo->cssjsTableName . '` (
                `id` INT( 11 ) NOT NULL AUTO_INCREMENT,
                `name` VARCHAR( 100 ) NOT NULL ,
                `content` TEXT NOT NULL,
                `type` INT NOT NULL DEFAULT 0,
                `attributes` VARCHAR( 100 ) NOT NULL,
                `urls` TEXT NOT NULL,
                `location` INT NOT NULL DEFAULT 1,
                `enabled` BOOLEAN NOT NULL DEFAULT 1,
                PRIMARY KEY  (id)
                );';

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

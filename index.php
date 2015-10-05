<?php

/**
 * Plugin Name: Add CSS/Js by Duo Leaf
 * Plugin URI: http://DuoLeaf.com/
 * Version: 1.0.6
 * Author: Duo Leaf
 * Author URI: http://DuoLeaf.com/add-css-js-wordpress-plugin/
 * Description: Allows you to insert custom CSS and javascript in your wordpress site.
 * License: GPLv3 or later
 */
require_once(WP_PLUGIN_DIR . '/add-cssjs-by-duo-leaf/duo-leaf/duoleaf.php');
require_once(WP_PLUGIN_DIR . '/add-cssjs-by-duo-leaf/core/plugin-info.php');
require_once(WP_PLUGIN_DIR . '/add-cssjs-by-duo-leaf/core/types.php');
require_once(WP_PLUGIN_DIR . '/add-cssjs-by-duo-leaf/core/injector.php');
require_once(WP_PLUGIN_DIR . '/add-cssjs-by-duo-leaf/core/storage.php');
require_once(WP_PLUGIN_DIR . '/add-cssjs-by-duo-leaf/core/admin-area.php');
require_once(WP_PLUGIN_DIR . '/add-cssjs-by-duo-leaf/core/upgrade-manager.php');
require_once(WP_PLUGIN_DIR . '/add-cssjs-by-duo-leaf/core/pro-manager.php');

class dl_acj_AddCssJs {

    /** @var dl_acj_PluginInfo */
    public $pluginInfo;

    /** @var dl_acj_Inject */
    public $injector;

    /** @var dl_acj_storage */
    public $storage;

    /** @var dl_acj_AdminArea */
    public $adminArea;

    /**
     * Constructor
     */
    public function __construct($pluginInfo, $storage, $injector, $adminArea) {

        $this->pluginInfo = $pluginInfo;
        $this->injector = $injector;
        $this->adminArea = $adminArea;
        $this->storage = $storage;
    }

}

$dl_acj_pluginInfo = new dl_acj_PluginInfo();

$dl_acj_ProManager = new dl_acj_ProManager($dl_acj_pluginInfo);

if (!$dl_acj_ProManager->removeFreePlugin()) {

    $dl_acj_upgradeManager = new dl_acj_UpgradeManager($dl_acj_pluginInfo);

    $dl_acj_Storage = new dl_acj_Storage($dl_acj_pluginInfo);

    $dl_acj_AdminArea = new dl_acj_AdminArea($dl_acj_pluginInfo, $dl_acj_Storage, $_GET, $_POST);
    $dl_acj_Injector = new dl_acj_Injector($dl_acj_pluginInfo, $dl_acj_Storage, $_SERVER);

    $dl_acj_addCssJs = new dl_acj_AddCssJs($dl_acj_pluginInfo, $dl_acj_Storage, $dl_acj_Injector, $dl_acj_AdminArea);
}



<?php

/**
 * Plugin Name: Add CSS/Js by Duo Leaf
 * Plugin URI: http://DuoLeaf.com/
 * Version: 1.0.2
 * Author: Duo Leaf
 * Author URI: http://DuoLeaf.com/add-css-js-wordpress-plugin/
 * Description: Allows you to insert custom CSS and javascript in your wordpress site.
 * License: GPLv3 or later
 */
require_once(WP_PLUGIN_DIR . '/add-cssjs-by-duo-leaf/core/plugin-info.php');
require_once(WP_PLUGIN_DIR . '/add-cssjs-by-duo-leaf/core/resource.php');
require_once(WP_PLUGIN_DIR . '/add-cssjs-by-duo-leaf/core/injector.php');

register_activation_hook(__FILE__, 'dl_acj_pluginActivation');

function dl_acj_pluginActivation() {

    global $wpdb;

    $pluginInfo = new dl_acj_PluginInfo();

    $sql = "CREATE TABLE `$pluginInfo->cssjsTableName` (
                `id` INT( 11 ) NOT NULL AUTO_INCREMENT,
                `name` VARCHAR( 100 ) NOT NULL ,
                `content` TEXT NOT NULL,
                `type` VARCHAR( 10 ) NOT NULL,
                `attributes` VARCHAR( 100 ) NOT NULL,
                `urls` TEXT NOT NULL,
                `header` BOOLEAN NOT NULL,
                PRIMARY KEY  (id)
                );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

class dl_acj_AddCssJs {

    /** @var dl_acj_PluginInfo */
    public $pluginInfo;

    /** @var dl_acj_Inject */
    public $injector;

    /**
     * Constructor
     */
    public function __construct($pluginInfo, $injector) {

        $this->pluginInfo = $pluginInfo;
        $this->injector = $injector;

        // Hooks
        add_action('admin_menu', array(&$this, 'adminPanelsAndMetaBoxes'));
        add_action('admin_enqueue_scripts', array(&$this, 'adminEnqueueScripts'));

        add_action('wp_head', array(&$this, 'injectJSHeader'));
        add_action('wp_footer', array(&$this, 'injectJSFooter'));
    }

    /**
     * Register the plugin settings panel
     */
    function adminPanelsAndMetaBoxes() {
        add_submenu_page('options-general.php', $this->pluginInfo->displayName, $this->pluginInfo->displayName, 'manage_options', $this->pluginInfo->name, array(&$this, 'adminPanel'));
    }

    /**
     * Output the Administration Panel
     * Save POSTed data from the Administration Panel into a WordPress option
     */
    function adminPanel() {

        $this->view = new stdClass();

        if (isset($_GET['action']) && $_GET['action'] == 'resource-form') {

            include_once(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/actions/resource-form.php');
        } else if (isset($_GET['action']) && $_GET['action'] == 'delete-resource') {

            global $wpdb;
            $wpdb->query($wpdb->prepare('DELETE FROM `' . $this->pluginInfo->cssjsTableName . '` WHERE id = %d', $_GET['resourceID']));

            include_once(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/actions/resources-list.php');
        } else {

            include_once(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/actions/resources-list.php');
        }
    }

    function injectJSHeader() {
        
        $this->injector->execute(true);

    }

    function injectJSFooter() {
        
        $this->injector->execute(false);
        
    }

    function adminEnqueueScripts() {
        wp_register_script('dl_acj_customJS', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/js/custom.js', array('jquery'), NULL);
        wp_enqueue_script('dl_acj_customJS');
        wp_register_script('dl_acj_bootstrap', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/js/bootstrap.min.js', array('jquery'), NULL);
        wp_enqueue_script('dl_acj_bootstrap');

        wp_enqueue_style('dl_acj_css_custom', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/css/custom.css', array(), null, 'all');
        wp_enqueue_script('dl_acj_css_custom');
        wp_enqueue_style('dl_acj_css_bootstrap', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/css/bootstrap-iso.css', array(), null, 'all');
        wp_enqueue_script('dl_acj_css_bootstrap');
        wp_enqueue_style('dl_acj_css_bootstrap_theme', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/css/bootstrap-theme.css', array(), null, 'all');
        wp_enqueue_script('dl_acj_css_bootstrap_theme');
    }

}

$dl_acj_pluginInfo = new dl_acj_PluginInfo();
$dl_acj_Injector = new dl_acj_Injector($dl_acj_pluginInfo);

$dl_acj_addCssJs = new dl_acj_AddCssJs($dl_acj_pluginInfo, $dl_acj_Injector);



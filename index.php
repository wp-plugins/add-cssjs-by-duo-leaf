<?php

/**
 * Plugin Name: Add CSS/Js by Duo Leaf
 * Plugin URI: http://DuoLeaf.com/
 * Version: 1.0.0
 * Author: Duo Leaf
 * Author URI: http://DuoLeaf.com/add-css-js-wordpress-plugin/
 * Description: Allows you to insert custom CSS and javascript in your wordpress site.
 * License: GPLv3 or later
 */
require_once(WP_PLUGIN_DIR . '/add-css-js/core/plugin-info.php');
require_once(WP_PLUGIN_DIR . '/add-css-js/core/resource.php');
require_once(WP_PLUGIN_DIR . '/add-css-js/core/resources-access.php');

register_activation_hook(__FILE__, 'dl_acj_pluginActivation');

function dl_acj_pluginActivation() {

    global $wpdb;

    $pluginInfo = new dl_acj_PluginInfo();


    $tablename = str_replace('-', '_', $wpdb->prefix . $pluginInfo->name . '_resources');

    if ($wpdb->get_var("SHOW TABLES LIKE '$tablename'") != $tablename) {

        $sql = "CREATE TABLE `$tablename` (
                `id` INT( 11 ) NOT NULL AUTO_INCREMENT,
                `name` VARCHAR( 100 ) NOT NULL ,
                `content` TEXT NOT NULL,
                `type` VARCHAR( 10 ) NOT NULL,
                `attributes` VARCHAR( 100 ) NOT NULL,
                `urls` TEXT NOT NULL,
                PRIMARY KEY(id)
                );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

class dl_acj_AddCssJs {

    /** @var dl_acj_PluginInfo */
    public $pluginInfo;

    /** @var dl_acj_ResourcesAccess */
    public $resourcesAccess;

    /**
     * Constructor
     */
    public function __construct($pluginInfo, $resourcesAccess) {


        $this->pluginInfo = $pluginInfo;
        $this->resourcesAccess = $resourcesAccess;

        // Hooks
        add_action('admin_menu', array(&$this, 'adminPanelsAndMetaBoxes'));
        add_action('wp_head', array(&$this, 'injectJS'));
        add_action('admin_enqueue_scripts', array(&$this, 'adminEnqueueScripts'));
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

            wp_enqueue_script('dl_tabs');
        } else if (isset($_GET['action']) && $_GET['action'] == 'delete-resource') {

            $this->resourcesAccess->delete($_GET['resourceID']);

            include_once(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/actions/resources-list.php');
        } else {

            include_once(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/actions/resources-list.php');
        }
    }

    /**
     * Inject JS/CSS into page 
     */
    function injectJS() {

        if (is_admin() OR is_feed() OR is_robots() OR is_trackback()) {
            return;
        }

        $currentUrl = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

        foreach ($this->resourcesAccess->getAll() as $resource) {

            $shouldInject = true;

            $urls = $resource->urls;

            $urls = trim($urls);

            if (!empty($urls)) {


                $shouldInject = false;

                $urls = explode(PHP_EOL, $urls);

                foreach ($urls as $url) {

                    $url = stripslashes($url);
                    
                    $url = trim($url);
                    
                    if (!empty($url) && strpos($currentUrl, $url) !== false ) {

                        $shouldInject = true;
                        break;
                    }
                }
            }

            if ($shouldInject) {
                if ($resource->type == "CSS") {
                    echo '<style ' . stripslashes($resource->attributes) . '>' . stripslashes($resource->content) . '</style>';
                } else {
                    echo '<script ' . stripslashes($resource->attributes) . '>' . stripslashes($resource->content) . '</script>';
                }
            }
        }
    }

    function adminEnqueueScripts() {

        wp_register_script('dl_tabs', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/js/tabs.js', array('jquery'), NULL);
    }

}

$dl_acj_pluginInfo = new dl_acj_PluginInfo();
$dl_acj_resourcesAccess = new dl_acj_ResourcesAccess($dl_acj_pluginInfo);
$dl_acj_addCssJs = new dl_acj_AddCssJs($dl_acj_pluginInfo, $dl_acj_resourcesAccess);



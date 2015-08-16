<?php

class dl_acj_AdminArea {

    /** @var dl_acj_PluginInfo */
    public $pluginInfo;

    /** @var dl_acj_Storage */
    public $storage;

    /** @var array */
    public $get;

    /** @var array */
    public $post;

    public function __construct($pluginInfo, $storage, $get, $post) {

        $this->pluginInfo = $pluginInfo;
        $this->storage = $storage;
        $this->get = $get;
        $this->post = $post;

        // Hooks
        add_action('admin_menu', array(&$this, 'adminPanelsAndMetaBoxes'));
    }

    function adminPanelsAndMetaBoxes() {

        add_submenu_page('duo-leaf', $this->pluginInfo->smallDisplayName, $this->pluginInfo->smallDisplayName, 'manage_options', $this->pluginInfo->name, array(&$this, 'adminPanel'));
        add_action('admin_enqueue_scripts', array(&$this, 'adminEnqueueScripts'));
    }

    public function adminPanel() {

        $this->adminRegisterScripts();

        $this->view = new stdClass();

        if (isset($_GET['action']) && $_GET['action'] == 'resource-form') {

            include_once(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/actions/resource-form.php');
            $action = new dl_acj_ActionResourceForm($this->pluginInfo, $this->storage, $this->get, $this->post);
            $this->view = $action->execute();
            include(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/views/resource-form.php');
        } else {


            if (isset($_GET['action']) && $_GET['action'] == 'delete-resource') {
                $this->storage->deleteResoruceByID($_GET['resourceID']);
            }

            include_once(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/actions/resources-list.php');
            $action = new dl_acj_ActionResourceList($this->pluginInfo, $this->storage);
            $this->view = $action->execute();
            include_once(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/views/resources-list.php');
        }
    }

    public function adminEnqueueScripts() {
        wp_register_script('dl_acj_bootstrap', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/js/bootstrap.min.js', array('jquery'), NULL);
        wp_register_script('dl_acj_bootstrapToggle', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/js/bootstrap-toggle.min.js', array('jquery'), NULL);
        wp_register_script('dl_acj_customJS', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/js/custom.js', array('jquery'), NULL);


        wp_enqueue_style('dl_acj_css_custom', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/css/custom.css', array(), null, 'all');
        wp_enqueue_style('dl_acj_css_bootstrap', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/css/bootstrap-iso.css', array(), null, 'all');
        wp_enqueue_style('dl_acj_css_bootstrap_theme', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/css/bootstrap-theme.css', array(), null, 'all');
        wp_enqueue_style('dl_acj_css_bootstrap_toggle', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/css/bootstrap-toggle.min.css', array(), null, 'all');
    }

    public function adminRegisterScripts() {
        wp_enqueue_script('dl_acj_customJS');
        wp_enqueue_script('dl_acj_bootstrap');
        wp_enqueue_script('dl_acj_bootstrapToggle');


        wp_enqueue_script('dl_acj_css_custom');
        wp_enqueue_script('dl_acj_css_bootstrap');
        wp_enqueue_script('dl_acj_css_bootstrap_theme');
        wp_enqueue_script('dl_acj_css_bootstrap_toggle');
    }

}

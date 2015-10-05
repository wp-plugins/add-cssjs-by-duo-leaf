<?php

if (!class_exists('duo_leaf_core')) {

    class duo_leaf_core {

        public $adminUrl = '';
        public $duoLeafPlugins;

        function __construct($duoLeafPlugins, $adminUrl) {

            $this->adminUrl = $adminUrl;
            $this->duoLeafPlugins = $duoLeafPlugins;

            // Hooks
            add_action('admin_menu', array(&$this, 'adminPanelsAndMetaBoxes'));
            add_action('admin_enqueue_scripts', array(&$this, 'adminRegisterScripts'));
        }

        function adminPanelsAndMetaBoxes() {
            add_menu_page('Duo Leaf', 'Duo Leaf', 'manage_options', 'duo-leaf', array(&$this, 'adminPanel'), plugin_dir_url(__FILE__) . 'img/icon_16.png');
        }

        public function adminPanel() {
            $this->adminEnqueeScripts();

            $this->view = new stdClass();

            $this->view->duoLeafPlugins = $this->duoLeafPlugins;
            $this->view->currentPlugins = get_plugins();
            $this->view->adminUrl = $this->adminUrl;

            include('duoleafview.php');
        }

        function adminRegisterScripts() {
            wp_register_script('dl_js_custom', plugins_url('js/custom.js', __FILE__), array('jquery'), NULL);
            wp_register_script('dl_js_bootstrap', plugins_url('js/bootstrap.min.js', __FILE__), array('jquery'), NULL);

            wp_register_style('dl_css_custom', plugins_url('css/custom.css', __FILE__), array(), null, 'all');
            wp_register_style('dl_css_bootstrap', plugins_url('css/bootstrap-iso.css', __FILE__), array(), null, 'all');
            wp_register_style('dl_css_bootstrap_theme', plugins_url('css/bootstrap-theme.css', __FILE__), array(), null, 'all');
        }

        function adminEnqueeScripts() {
            wp_enqueue_script('dl_js_custom');
            wp_enqueue_script('dl_js_bootstrap');

            wp_enqueue_style('dl_css_custom');
            wp_enqueue_style('dl_css_bootstrap');
            wp_enqueue_style('dl_css_bootstrap_theme');
        }

    }

    $duoLeafPlugins = array(
        'add-cssjs-by-duo-leaf/index.php' => array(
            'name' => 'Add CSS & Javascript',
            'key' => 'add-cssjs-by-duo-leaf',
            'description' => 'A quick and easy way to include CSS and/or JavaScript in your Wordpress site without getting your hands dirty by editing the theme manually.',
            'image' => plugins_url('/img/', __FILE__) . 'Cover-Add-Css-Javascript-Wodpress-Plugin.png',
            'install' => 'plugin-install.php?tab=search&type=term&s=Add+CSS+Js+by+Duo+Leaf',
            'settingsPage' => 'admin.php?page=add-cssjs-by-duo-leaf'
        ),
        'toaster-contact-form-by-duo-leaf/index.php' => array(
            'name' => 'Toaster Contact Form WordPress plugin',
            'key' => 'toaster-contact-form-by-duo-leaf',
            'description' => 'This plugin creates contact simple form on the bottom right corner of your site, with a ‘toaster’ like effect. The form contains name, email and message.',
            'image' => plugins_url('/img/', __FILE__) . 'Cover-Toaster-Form-Wordpress-Plugin.png',
            'install' => 'plugin-install.php?tab=search&type=term&s=Toaster+Contact+Form+by+Duo+Leaf',
            'settingsPage' => 'admin.php?page=toaster-contact-form-by-duo-leaf'
        ),
        '404-error-log-report-by-duo-leaf/index.php' => array(
            'name' => '404 Error log report WordPress Plugin',
            'key' => '404-error-log-report-by-duo-leaf',
            'description' => 'Generate a report of 404 errors that occurs in your site.',
            'image' => plugins_url('/img/', __FILE__) . 'Cover-404-Error-Log-Report-Wordpress-Plugin.png',
            'install' => 'plugin-install.php?tab=search&type=term&s=404+Error+log+report+by+Duo+Leaf',
            'settingsPage' => 'admin.php?page=404-error-log-report-by-duo-leaf'
        ),
        'toaster-widget-by-duo-leaf/index.php' => array(
            'name' => 'Toaster Widget Area',
            'key' => 'toaster-widget-by-duo-leaf',
            'description' => 'This plugin creates a widget area on the bottom right corner of your site, with a ‘toaster’ like effect.',
            'image' => plugins_url('/img/', __FILE__) . 'Cober-Toaster-Widget-Area-Wordpress-Plugin.png',
            'install' => 'plugin-install.php?tab=search&type=term&s=Toaster+Widget+by+Duo+Leaf',
            'settingsPage' => 'admin.php?page=toaster-widget-by-duo-leaf'
        ),
        'benchmark-by-duo-leaf/index.php' => array(
            'name' => 'Benchmark',
            'key' => 'benchmark-by-duo-leaf',
            'description' => 'A simple way to check how long it takes to load each page to your users.',
            'image' => plugins_url('/img/', __FILE__) . '/Cover-Benchmark-Wordpress-Plugin.png',
            'install' => 'plugin-install.php?tab=search&type=term&s=Benchmark+by+Duo+Leaf',
            'settingsPage' => 'admin.php?page=benchmark-by-duo-leaf'
        )
    );

    $adminUrl = admin_url('/');

    $duoLeaf = new duo_leaf_core($duoLeafPlugins, $adminUrl);
}


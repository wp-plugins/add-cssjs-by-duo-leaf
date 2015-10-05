<?php

class dl_acj_ProManager {

    /** @var dl_acj_PluginInfo */
    public $pluginInfo;
    public $remoteServer;

    public function __construct($pluginInfo) {

        $this->pluginInfo = $pluginInfo;
        $this->remoteServer = 'http://duoleaf.com';
    }

    public function execute($licenceKey) {

        $rawResponse = $this->sendLicenseKeyToRemoteServer($licenceKey, $this->remoteServer);

        if ($this->verifyResponseLicenseCheck($rawResponse)) {

            $response = maybe_unserialize(wp_remote_retrieve_body($rawResponse));

            $this->saveLicenseOptions($licenceKey);

            $downloadToken = $this->getDownloadTokenFromResponse($response);

            $pluginContents = $this->downloadPlugin($downloadToken, $this->remoteServer);

            $this->installPlugin($pluginContents);

            $this->activePlugin();
        }
    }

    public function sendLicenseKeyToRemoteServer($licenceKey, $remoteServer) {

        $to_send = array();
        $to_send["license_key"] = $licenceKey;
        $to_send["plugin_name"] = $this->pluginInfo->name . '-pro';
        $to_send["site_url"] = get_bloginfo('url');

        $options = array(
            'timeout' => ((defined('DOING_CRON') && DOING_CRON ) ? 30 : 3 ),
            'body' => array('plugin' => serialize($to_send)),
        );

        $raw_response = wp_remote_post($remoteServer . '/check/1.0/', $options);

        return $raw_response;
    }

    public function verifyResponseLicenseCheck($rawRresponse) {

        if (is_wp_error($rawRresponse) || 200 != wp_remote_retrieve_response_code($rawRresponse)) {
            throw new dl_acj_ProManagerException(__("Something went wrong. Please try again later. If the error appears again, please contact us", 'duo-leaf'));
        }

        $response = maybe_unserialize(wp_remote_retrieve_body($rawRresponse));

        if (!is_array($response) || empty($response)) {
            throw new dl_acj_ProManagerException(__("Something went wrong. Please try again later. If the error appears again, please contact us", 'duo-leaf'));
        }

        foreach ($response as $key => $value) {
            if ("request_error" == $key) {
                throw new dl_acj_ProManagerException(__("Unfortunately, an error occurred.", 'duo-leaf'));
            } elseif ("wrong_license_key" == $key) {
                throw new dl_acj_ProManagerException(__("Wrong license key", 'duo-leaf'));
            } elseif ("wrong_domain" == $key) {
                throw new dl_acj_ProManagerException(__("This license key is bind to another site", 'duo-leaf'));
            } elseif ("you_are_banned" == $key) {
                throw new dl_acj_ProManagerException(__("Unfortunately, you have exceeded the number of available tries per day. Please, upload the plugin manually.", 'duo-leaf'));
            } elseif ("time_out" == $key) {
                throw new dl_acj_ProManagerException(__("Unfortunately, Your license has expired. To continue getting top-priority support and plugin updates you should extend it in your", 'duo-leaf'));
            }
        }

        return true;
    }

    public function getDownloadTokenFromResponse($response) {
        foreach ($response as $key => $value) {
            if ("token" == $key) {
                return $value;
            }
        }
    }

    public function downloadPlugin($token, $remoteServer) {

        if (!class_exists('ZipArchive') && !class_exists('Phar')) {
            throw new dl_acj_ProManagerException(__("Your server does not support either ZipArchive or Phar. Please, upload the plugin manually", 'duo-leaf'));
        }


        $uploadDir = wp_upload_dir();
        if (!is_writable($uploadDir["path"])) {
            throw new dl_acj_ProManagerException(__("UploadDir is not writable. Please, upload the plugin manually", 'duo-leaf'));
        }


        $received_content = file_get_contents($remoteServer . '/download_plugin/?token=' . $token);
        if (!$received_content) {
            throw new dl_acj_ProManagerException(__("Failed to download the zip archive. Please, upload the plugin manually", 'duo-leaf'));
        }

        $file_put_contents = $uploadDir["path"] . "/plugin.zip";
        if (!file_put_contents($file_put_contents, $received_content)) {
            throw new dl_acj_ProManagerException(__("Failed to download the zip archive. Please, upload the plugin manually", 'duo-leaf'));
        }

        return $file_put_contents;
    }

    public function installPlugin($file_put_contents) {

        @chmod($file_put_contents, octdec(755));
        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive();
            if ($zip->open($file_put_contents) === TRUE) {
                $zip->extractTo(WP_PLUGIN_DIR);
                $zip->close();
            } else {
                throw new dl_acj_ProManagerException(__("Failed to open the zip archive. Please, upload the plugin manually", 'duo-leaf'));
            }
        } elseif (class_exists('Phar')) {
            $phar = new PharData($file_put_contents);
            $phar->extractTo(WP_PLUGIN_DIR);
        }

        @unlink($file_put_contents);
    }

    public function activePlugin() {

        $current = get_option('active_plugins');
        $plugin = plugin_basename(trim($this->pluginInfo->name . '-pro/index.php'));

        if (!in_array($plugin, $current)) {
            $current[] = $plugin;
            sort($current);
            do_action('activate_plugin', trim($plugin));
            update_option('active_plugins', $current);
            do_action('activate_' . trim($plugin));
            do_action('activated_plugin', trim($plugin));
        }
    }

    public function saveLicenseOptions($licenceKey) {

        $options = array();

        $options['license'] = $licenceKey;
        $options['verified'] = true;

        update_option($this->pluginInfo->name . "-pro-options", $options);
    }

    public function removeFreePlugin() {

        if (!(isset($GLOBALS['duoleaf-development-environment']) && $GLOBALS['duoleaf-development-environment'] = true)) {
            
            if (!function_exists('get_plugins')) {
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
            }

            $currentPlugins = get_plugins();

            if (isset($currentPlugins[$this->pluginInfo->name . '-pro/index.php'])) {
                $this->rrmdir(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name);
                return true;
            }
        }
        return false;
    }

    function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir")
                        $this->rrmdir($dir . "/" . $object);
                    else
                        unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

}

class dl_acj_ProManagerException extends Exception {
    
}

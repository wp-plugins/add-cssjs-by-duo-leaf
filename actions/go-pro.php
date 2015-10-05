<?php

class dl_go_proAction {

    public $pluginInfo;

    /** @var array */
    public $post;

    public function __construct($pluginInfo, $post) {
        $this->pluginInfo = $pluginInfo;
        $this->post = $post;
    }

    public function execute() {

        $view = new stdClass();
        $view->onceName = $this->pluginInfo->name . '_nonce';
        $view->pluginInfo = $this->pluginInfo;
        $view->licenseKey = '';
        
        if (isset($this->post['submit'])) {
            $view->licenseKey = $this->post['licenseKey'];
            try {
                $this->validadeLicense();
                $view->message = __('Plugin upgrade successful! Wait while we redirect you to the Pro version or ', $this->pluginInfo->name) . '<a id="url-redirect" href="?page=' . $this->pluginInfo->name . '-pro">' . __('click here', $this->pluginInfo->name) . '</a>. ';
            } catch (dl_acj_ProManagerException $exc) {
                $view->errorMessage = $this->handleErrors($exc);
            }
        }
        return $view;
    }

    public function validadeLicense() {
        require_once(dirname(__FILE__) . '/../core/pro-manager.php');
        $dl_acj_ProManager = new dl_acj_ProManager($this->pluginInfo);
        $dl_acj_ProManager->execute($this->post['licenseKey']);
    }

    public function handleErrors($exception) {
        return $exception->getMessage();
    }

}

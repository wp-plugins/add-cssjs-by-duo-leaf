
<div class="bootstrap-iso">
    <h1>Duo Leaf Plugins</h1>
    <hr />
    <div class="container">
        <div clss="row">
            <?php foreach ($this->view->duoLeafPlugins as $dl_pluginKey => $dl_plugin) { ?>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="home-plugin-panel">

                        <a href="http://duoleaf.com/toaster-widget-area-wordpress-plugin/">    
                            <img class="home-plugin-panel-cover-img" src="<?php echo $dl_plugin['image']; ?>" style="width:100%; height:auto;">
                        </a>
                        <a href="http://duoleaf.com/toaster-widget-area-wordpress-plugin/" class="home-plugin-panel-title"><?php echo $dl_plugin['name']; ?></a>
                        <p><?php echo $dl_plugin['description']; ?></p>
                        <?php $dl_pluginProKey = $dl_plugin['key'] . '-pro/index.php'; ?>
                        <?php if (isset($this->view->currentPlugins[$dl_pluginKey]) || isset($this->view->currentPlugins[$dl_pluginProKey])) { ?>

                            <?php if (is_plugin_active($dl_pluginKey) || isset($this->view->currentPlugins[$dl_pluginProKey])) { ?>
                                <a class="btn btn-default btn-sm" href="<?php echo $this->view->adminUrl . $dl_plugin['settingsPage'] . (isset($this->view->currentPlugins[$dl_pluginProKey]) ? '-pro' : '' ); ?>">
                                    <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Manage Options
                                </a>
                            <?php } else { ?>
                                <a class="btn btn-default btn-sm" href="<?php echo $this->view->adminUrl . 'plugins.php'; ?>">
                                    <span class="glyphicon glyphicon glyphicon-off" aria-hidden="true"></span> Ativate
                                </a>
                            <?php } ?>

                            <div class="ribbon"><span>Installed</span></div>

                        <?php } else { ?>
                            <a class="btn btn-success btn-sm" href="<?php echo $this->view->adminUrl . $dl_plugin['install']; ?>">
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Install
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="bootstrap-iso">
    <h1>Duo Leaf Plugins</h1>
    <hr />
    <div class="container">
        <div clss="row-fluid">
            <?php foreach ($this->view->duoLeafPlugins as $dl_pluginKey => $dl_plugin) { ?>
                <div class="col-xs-12 col-sm-6 col-md-6 home-plugin-panel-parent">
                    <div class="home-plugin-panel">
                        <div class="home-plugin-banner" style="background-image: url(<?php echo $dl_plugin['image']; ?>);">
                            <a href="#" class="home-plugin-title"><?php echo $dl_plugin['name']; ?></a>
                        </div>


                        <p class="home-plugin-text"><?php echo $dl_plugin['description']; ?></p>
                        <?php $dl_pluginProKey = $dl_plugin['key'] . '-pro/index.php'; ?>
                        <?php if (isset($this->view->currentPlugins[$dl_pluginKey]) || isset($this->view->currentPlugins[$dl_pluginProKey])) { ?>

                            <?php if (is_plugin_active($dl_pluginKey) || is_plugin_active($dl_pluginProKey)) { ?>
                                <a class="btn btn-default btn-sm" href="<?php echo $this->view->adminUrl . $dl_plugin['settingsPage'] . (isset($this->view->currentPlugins[$dl_pluginProKey]) ? '-pro' : '' ); ?>">
                                    <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Manage Options
                                </a>
                            <?php } else { ?>
                                <a class="btn btn-default btn-sm" href="<?php echo $this->view->adminUrl . 'plugins.php?s=' . $dl_plugin['key'];
                                ?>">
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
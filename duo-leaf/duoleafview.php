
<div class="bootstrap-iso">
    <h1>Duo Leaf Plugins</h1>
    <hr />
    <div class="container">
        <div clss="row">
            <?php foreach ($this->view->duoLeafPlugins as $pluginKey => $plugin) { ?>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="home-plugin-panel">

                        <a href="http://duoleaf.com/toaster-widget-area-wordpress-plugin/">    
                            <img class="home-plugin-panel-cover-img" src="<?php echo $plugin['image']; ?>" style="width:100%; height:auto;">
                        </a>
                        <a href="http://duoleaf.com/toaster-widget-area-wordpress-plugin/" class="home-plugin-panel-title"><?php echo $plugin['name']; ?></a>
                        <p><?php echo $plugin['description']; ?></p>

                        <?php if (isset($this->view->currentPlugins[$pluginKey])) { ?>
                            <a class="btn btn-default btn-sm" href="<?php echo $this->view->adminUrl . $plugin['settingsPage']; ?>">
                                <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Manage Options
                            </a>
 
                                <div class="ribbon"><span>Installed</span></div>
 
                        <?php } else { ?>
                            <a class="btn btn-success btn-sm" href="<?php echo $this->view->adminUrl . $plugin['install']; ?>">
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Install
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
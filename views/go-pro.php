<?php

class dl_go_proView {

    public $view;

    public function __construct($view) {
        $this->view = $view;
    }

    public function execute() {
        ?>
        <div class = "bootstrap-iso">
            <h2><?php echo $this->view->pluginInfo->displayName;
        ?></h2>
            <hr />
            <div class="wrap">
                <div class="row">
                    <div class="col-md-9">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <span class="glyphicon glyphicon-heart"></span> What you get
                            </div> 
                            <div class="panel-body">
                                <div class="features-table table-responsive col-md-8">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>Free</th>
                                                <th>Pro</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Choose where the code will be injected (header or footer)</td>
                                                <td class="text-center"><span class="glyphicon glyphicon-ok text-success"></span></td>
                                                <td class="text-center"><span class="glyphicon glyphicon-ok text-success"></span></td>
                                            </tr>
                                            <tr>
                                                <td>Easily Manage multiple scripts CSS and Javascript</td>
                                                <td class="text-center"><span class="glyphicon glyphicon-ok text-success"></span></td>
                                                <td class="text-center"><span class="glyphicon glyphicon-ok text-success"></span></td>
                                            </tr>
                                            <tr>
                                                <td>Specify which urls each code takes effect</td>
                                                <td class="text-center"><span class="glyphicon glyphicon-ok text-success"></span></td>
                                                <td class="text-center"><span class="glyphicon glyphicon-ok text-success"></span></td>
                                            </tr>
                                            <tr>
                                                <td>Manage tag attributes of &lt;script&gt; and &lt;styles&gt;</td>
                                                <td class="text-center"><span class="glyphicon glyphicon-ok text-success"></span></td>
                                                <td class="text-center"><span class="glyphicon glyphicon-ok text-success"></span></td>
                                            </tr>
                                            <tr>
                                                <td>Code highlight</td>
                                                <td class="text-center"><span class="glyphicon glyphicon-remove text-danger"></span></td>
                                                <td class="text-center"><span class="glyphicon glyphicon-ok text-success"></span></td>
                                            </tr>
                                            <tr>
                                                <td>Auto minify files</td>
                                                <td class="text-center"><span class="glyphicon glyphicon-remove text-danger"></span></td>
                                                <td class="text-center"><span class="glyphicon glyphicon-ok text-success"></span></td>
                                            </tr>
                                            <tr>
                                                <td>Use files as external</td>
                                                <td class="text-center"><span class="glyphicon glyphicon-remove text-danger"></span></td>
                                                <td class="text-center"><span class="glyphicon glyphicon-ok text-success"></span></td>
                                            </tr>
                                            <tr>
                                                <td>Use regex to filter which pages the script will be injected</td>
                                                <td class="text-center"><span class="glyphicon glyphicon-remove text-danger"></span></td>
                                                <td class="text-center"><span class="glyphicon glyphicon-ok text-success"></span></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center"><a class="btn btn-success btn-xs" href="http://duoleaf.com/add-css-js-wordpress-plugin/">I want more!</a></td>
                                            </tr>
                                        </tbody>
                                    </table></div>
                            </div> 
                        </div> 


                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <span class="glyphicon glyphicon-plus"></span> GO PRO
                            </div> 
                            <div class="panel-body">
                                <form action="admin.php?page=<?php echo $this->view->pluginInfo->name ?>&action=go-pro" method="post">
                                    <?php
                                    if (!empty($this->view->message)) {
                                        ?>
                                        <div class="alert alert-success" role="alert">
                                            <span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span>
                                            <span id="success-message"><?php echo $this->view->message; ?></span>
                                            <script>
                                                jQuery(document).ready(function () {
                                                    jQuery('#success-message').append('<span id="timer-refresh">5</span>');
                                                    setInterval(function () {
                                                        var seconds = jQuery('#timer-refresh').text();


                                                        if (seconds !== '0' && seconds !== 'refeshing...') {
                                                            seconds = parseInt(seconds) - 1;
                                                        } else {
                                                            if (seconds === '0') {
                                                                window.location = jQuery('#url-redirect').attr('href');
                                                            }
                                                            seconds = 'refeshing...';
                                                        }
                                                        jQuery('#timer-refresh').text(seconds.toString());
                                                    }, 1000);
                                                });
                                            </script>
                                        </div>
                                        <?php
                                    }
                                    if (!empty($this->view->notices) && count($this->view->notices) > 0) {
                                        ?>
                                        <div class="alert alert-info" role="alert">
                                            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                            <?php foreach ($this->view->notices as $notice) { ?>
                                                <span><?php echo $notice; ?></span>
                                            <?php } ?>
                                        </div>
                                        <?php
                                    }
                                    if (!empty($this->view->errorMessage)) {
                                        ?>
                                        <div class="alert alert-danger" role="alert">
                                            <p><?php echo $this->view->errorMessage; ?></p>
                                        </div>  
                                        <?php
                                    }
                                    ?> 


                                    <!-- Tab panes -->
                                    <?php wp_nonce_field($this->view->pluginInfo->name, $this->view->onceName); ?>
                                    <div class="col-md-5 col-xs-8">
                                        <label for="licenseKey"><strong><?php _e('License Key', $this->view->pluginInfo->name); ?></strong></label>
                                        <input type="text" name="licenseKey" id="licenseKey" class="form-control"  value="<?php echo $this->view->licenseKey; ?>" size="50">
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <hr />
                                        <button name="submit" type="submit" class="btn btn-success pull-right" id="saveResource">
                                            <span class="glyphicon glyphicon-floppy-disk"></span>
                                            <?php _e('Save', $this->view->pluginInfo->name); ?>
                                        </button>
                                        <a class="btn btn-default" href="admin.php?page=<?php echo $this->view->pluginInfo->name ?>" >
                                            <span class="glyphicon glyphicon-arrow-left"></span>
                                            <?php _e('Back', $this->view->pluginInfo->name); ?>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php include 'panel.php'; ?>
                </div> 
            </div> 
        </div> 
        <?php
    }

}

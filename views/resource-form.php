
<script type="text/javascript">
    jQuery(document).ready(function () {

        if (jQuery('#resourceID').val() === '0')
            jQuery('#resourceAttributes').val('type=\'text/css\' media=\'all\'');

        jQuery("#resourceType").change(function () {
            if (jQuery(' option:selected', this).text() === 'CSS') {
                jQuery('#resourceAttributes').val('type=\'text/css\' media=\'all\'');
            }
            if (jQuery(' option:selected', this).text() === 'Javascript') {
                jQuery('#resourceAttributes').val('type=\'text/javascript\'');
            }
        });
    });
</script>

<div class="wrap st_wrap">
    <h2><?php echo $this->pluginInfo->displayName; ?></h2>
    <hr />
    <div class="wrap">
        <form action="options-general.php?page=<?php echo $this->pluginInfo->name ?>&action=resource-form" method="post">
            <?php
            if (isset($this->message)) {
                ?>
                <div class="updated fade"><p><?php echo $this->message; ?></p></div>  
                <?php
            }
            if (isset($this->errorMessage)) {
                ?>
                <div class="error fade"><p><?php echo $this->errorMessage; ?></p></div>  
                <?php
            }
            ?> 

            <h2 class="nav-tab-wrapper">
                <a id="content-tab" class="nav-tab nav-tab-active" href="#content">Content</a>
                <a id="urls-tab" class="nav-tab" href="#urls">Urls</a>
            </h2>
            <div class="group" id="content" style="display: none;">

                <?php wp_nonce_field($this->pluginInfo->name, $this->view->onceName); ?>
                <input type="hidden" name="resourceID" id="resourceID" value="<?php echo $this->view->resource->id; ?>">
                <p>
                    <label for="resourceName"><strong><?php _e('Name', $this->pluginInfo->name); ?></strong></label>
                    <input type="text" name="resourceName" id="resourceName" class=""  value="<?php echo $this->view->resource->name; ?>" size="50"><?php ?></textarea>
                    <label for="resourceType"><strong><?php _e('Type', $this->pluginInfo->name); ?></strong></label>
                    <select name="resourceType" id="resourceType">
                        <option value="CSS" <?php echo $this->view->resource->type == 'CSS' ? 'selected="true"' : ''; ?> >CSS</option>
                        <option value="Javascript" <?php echo $this->view->resource->type == 'Javascript' ? 'selected="true"' : ''; ?> >Javascript</option>
                    </select>
                    <label for="resourceAttributes"><strong><?php _e('Attributes', $this->pluginInfo->name); ?></strong></label>                                
                    <input type="text" name="resourceAttributes" id="resourceAttributes" size="30" value="<?php echo stripslashes($this->view->resource->attributes); ?>" ><?php ?></textarea>
                </p>
                <p>
                    <label for="resourceContent"><strong><?php _e('Your Content', $this->pluginInfo->name); ?></strong></label>                                
                    <textarea name="resourceContent" id="resourceContent" class="widefat" rows="15" style="font-family:Courier New;"><?php echo stripslashes($this->view->resource->content); ?></textarea>
                </p>    
            </div>
            <div class="group" id="urls" style="display: none;">
                <p>
                    <label for="resourceUrls"><strong><?php _e('Urls', $this->pluginInfo->name); ?></strong></label>                                
                    <textarea name="resourceUrls" id="resourceUrls" class="widefat" rows="8" style="font-family:Courier New;"><?php echo stripslashes($this->view->resource->urls); ?></textarea>
                </p>            
                <p>The above field you can specify the urls in your code will take effect. It can be specified the complete url or just part of it. If you type a line with 'some-content' your code will run on all urls who contain the text 'some-content'.</p>
            </div>
            <p>
                <input name="submit" type="submit" name="Submit" class="button button-primary" value="<?php _e('Save', $this->pluginInfo->name); ?>" /> 
            </p>
    </div> 
</form>
</div>



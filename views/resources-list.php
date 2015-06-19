
<style type="text/css">
    .column-edit { width: 8%; }
    .column-delete { width: 10%; }
</style>

<div class="wrap">
    <h2><?php echo $this->pluginInfo->displayName; ?></h2>
    <hr />
    <a href="?page=<?php echo $this->pluginInfo->name ?>&action=resource-form" class="button button-primary">Add new</a>
    <?php $this->resourcesListTable->display(); ?>
</div>

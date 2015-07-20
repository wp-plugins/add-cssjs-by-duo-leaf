<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<div class="bootstrap-iso">
    <h2><?php echo $this->pluginInfo->displayName; ?></h2>
    <hr />

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading">
                     <span class="glyphicon glyphicon-th-list"></span> List of CSS/JS
                </div> 
                <div class="panel-body">
                    <a href="?page=<?php echo $this->pluginInfo->name ?>&action=resource-form" class="btn btn-success btn-sm">
                        <span class="glyphicon glyphicon-plus"></span>
                        Add new
                    </a>
                    <hr />
                    <?php if (Count($this->resources) != 0) { ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th class="col-xs-1">Edit</th>
                                    <th class="col-xs-1">Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($this->resources as $resource) { ?>
                                    <tr>
                                        <td><?php echo $resource->name; ?></td>
                                        <td><?php echo $resource->type; ?></td>
                                        <td>
                                            <a href="?page=add-cssjs-by-duo-leaf&action=resource-form&resourceID=<?php echo $resource->id; ?>" class="btn btn-default btn-sm">
                                                <span class="glyphicon glyphicon-pencil"></span>
                                                Edit
                                            </a>
                                        </td>
                                        <td>
                                            <a href="?page=add-cssjs-by-duo-leaf&action=delete-resource&resourceID=<?php echo $resource->id; ?>" class="btn btn-default btn-sm" onclick="return confirm('Are you sure?')">
                                                <span class="glyphicon glyphicon-trash"></span>
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <p>Ready to start? Click in  <a href="?page=<?php echo $this->pluginInfo->name ?>&action=resource-form" >Add new</a> to add your first css or javascript.</javascriptp>
                        <?php } ?>
                </div>
            </div>
        </div>
        <?php include 'panel.php'; ?>
    </div>
</div>

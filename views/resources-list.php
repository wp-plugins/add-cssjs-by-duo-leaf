<?php

class dl_acj_ViewResourceList {

    public $view;

    public function __construct($view) {
        $this->view = $view;
    }

    public function execute() {
        ?>
        <div class="bootstrap-iso">
            <h2><?php echo $this->view->pluginInfo->displayName; ?></h2>
            <hr />
            <div class="row">
                <div class="col-md-9">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-th-list"></span> List of CSS/JS
                        </div> 
                        <div class="panel-body">
                            <a href="?page=<?php echo $this->view->pluginInfo->name ?>&action=resource-form" class="btn btn-success btn-sm">
                                <span class="glyphicon glyphicon-plus"></span>
                                Add new
                            </a>
                            <hr />
                            <?php if (Count($this->view->resources) != 0) { ?>
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

                                        <?php foreach ($this->view->resources as $resource) { ?>
                                            <tr>
                                                <td><?php echo $resource->name; ?></td>
                                                <td><?php echo $this->view->resourceTypes[$resource->type]; ?></td>
                                                <td>
                                                    <a href="?page=<?php echo $this->view->pluginInfo->name ?>&action=resource-form&resourceID=<?php echo $resource->id; ?>" class="btn btn-default btn-sm">
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                        Edit
                                                    </a>
                                                </td>
                                                <td>
                                                    <button class="btn btn-default btn-sm" data-href="?page=<?php echo $this->view->pluginInfo->name ?>&action=delete-resource&resourceID=<?php echo $resource->id; ?>" data-toggle="modal" data-target="#confirm-delete">
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <strong>Confirmation</strong>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <a class="btn btn-danger btn-ok">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php } else { ?>
                                <p>Ready to start? Click in  <a href="?page=<?php echo $this->view->pluginInfo->name ?>&action=resource-form" >Add new</a> to add your first css or javascript.</javascriptp>
                                <?php } ?>
                        </div>
                    </div>
                </div>
                <?php include 'panel.php'; ?>
            </div>
        </div>
        <?php
    }
}

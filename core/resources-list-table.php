<?php

if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class dl_acj_ResourcesListTable extends WP_List_Table {

    /** @var array */
    public $resources;

    /** @var dl_acj_PluginInfo */
    public $pluginInfo;

    public function __construct($resources, $pluginInfo) {

        parent::__construct();

        $this->resources = $resources;
        $this->pluginInfo = $pluginInfo;
    }

    function get_columns() {
        $columns = array(
            'name' => 'Name',
            'type' => 'Type',
            'edit' => 'Edit',
            'delete' => 'Delete'
        );
        return $columns;
    }

    function prepare_items() {

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $this->resources;
    }

    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'name':
                return $item->name;
            case 'type':
                return $item->type;
            case 'edit':
                return '<a href="?page=' . $this->pluginInfo->name . '&action=resource-form&resourceID=' . $item->id . '" class="button button-primary">Edit</a>';
            case 'delete':
                return '<a href="?page=' . $this->pluginInfo->name . '&action=delete-resource&resourceID=' . $item->id . '" class="button button-primary" onclick="return confirm(\'Are you sure?\')">Delete</a>';
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

}

<?php

class dl_acj_ResourcesAccess {

    /** @var dl_acj_PluginInfo */
    public $pluginInfo;
    public $tablename;

    public function __construct($pluginInfo) {

        global $wpdb;

        $this->pluginInfo = $pluginInfo;
        $this->tableName = $wpdb->prefix . $pluginInfo->name . '_resources';
    }

    public function getById($id) {

        global $wpdb;

        $sql = $wpdb->prepare("SELECT * FROM `$this->tableName` WHERE id = %s;", $id);

        $results = $wpdb->get_row($sql);

        return $results;
    }

    public function getAll() {
        global $wpdb;

        $sql = "SELECT * FROM `$this->tableName`;";
        $results = $wpdb->get_results($sql);

        return $results;
    }

    public function update(dl_acj_Resource $resource) {

        global $wpdb;

        $ressourceArray = get_object_vars($resource);
        
        if ($resource->id == 0) {

            $wpdb->insert($this->tableName, $ressourceArray);
            
        } else {

            $where = $wpdb->prepare(" WHERE id = %s", $resource->id);

            $wpdb->update($this->tableName, $ressourceArray, array('id' => $resource->id));

        }
    }

    public function delete($id) {

        global $wpdb;
        $wpdb->query($wpdb->prepare("DELETE FROM `$this->tableName` WHERE id = %d", $id));
    }
}

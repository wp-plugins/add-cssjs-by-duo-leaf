<?php

class dl_acj_Storage {

    /** @var dl_ac_PluginInfo */
    public $pluginInfo;

    public function __construct($pluginInfo) {
        $this->pluginInfo = $pluginInfo;
    }

    /** @var array */
    private $resourceLocations;
    function getAllResourceLocations() {

        if (empty($this->resourceLocations)) {
            $this->resourceLocations = array();
            $this->resourceLocations[dl_acj_ResourceLocation::Header] = 'Header';
            $this->resourceLocations[dl_acj_ResourceLocation::Footer] = 'Footer';
        }

        return $this->resourceLocations;
    }

    /** @var array */
    private $resourceTypes;
    function getAllResourceTypes() {

        if (empty($this->resourceTypes)) {
            $this->resourceTypes = array();
            $this->resourceTypes[dl_acj_ResourceType::CSS] = 'CSS';
            $this->resourceTypes[dl_acj_ResourceType::Javascript] = 'Javascript';
        }

        return $this->resourceTypes;
    }

    
    
    
    public function getResourceByID($id) {
        global $wpdb;

        $sql = $wpdb->prepare('SELECT * FROM `' . $this->pluginInfo->cssjsTableName . '` WHERE id = %d;', $id);

        return $wpdb->get_row($sql);
    }

    public function getAllResources() {
        global $wpdb;

        return $wpdb->get_results('SELECT * FROM `' . $this->pluginInfo->cssjsTableName . '`;');
    }

    public function updateResource($ressourceArray, $id) {
        global $wpdb;

        $wpdb->update($this->pluginInfo->cssjsTableName, $ressourceArray, array('id' => $id));
    }

    public function insertResource($ressourceArray) {
        global $wpdb;

        $wpdb->insert($this->pluginInfo->cssjsTableName, $ressourceArray);

        return $wpdb->insert_id;
    }

    public function deleteResoruceByID($id) {
        global $wpdb;

        $sql = $wpdb->prepare('DELETE FROM `' . $this->pluginInfo->cssjsTableName . '` WHERE id = %d', $id);

        $wpdb->query($sql);
    }

    function getResourceByLocationAndEnabled($location, $enabled) {

        global $wpdb;

        $sql = $wpdb->prepare('SELECT * FROM `' . $this->pluginInfo->cssjsTableName . '` WHERE location = %d AND enabled = %d;', $location, $enabled);

        return $wpdb->get_results($sql);
    }

}

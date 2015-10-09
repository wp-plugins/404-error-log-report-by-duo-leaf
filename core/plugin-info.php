<?php

class dl_elr_PluginInfo {

    /**
     * Properties
     */
    public $name;
    public $smallDisplayName;
    public $displayName;
    public $tableLogName;
    public $currentVersion;

    /**
     * Constructor
     */
    public function __construct() {

        $this->name = "404-error-log-report-by-duo-leaf";
        $this->smallDisplayName = "404 Error log report";
        $this->displayName = $this->smallDisplayName . " by Duo Leaf";
        $this->currentVersion = '1.0.3';

        global $wpdb;

        $this->tableLogName = $wpdb->prefix . str_replace('-', '_', $this->name . '_log');
    }

}

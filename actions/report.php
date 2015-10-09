<?php

class dl_erl_ActionReport {

    /** @var dl_erl_PluginInfo */
    public $pluginInfo;

    /** @var dl_erl_Storage */
    public $storage;

    /** @var array */
    public $get;

    /** @var array */
    public $post;

    public function __construct($pluginInfo, $storage, $get, $post) {

        $this->pluginInfo = $pluginInfo;
        $this->storage = $storage;
        $this->get = $get;
        $this->post = $post;
    }

    public function execute() {

        $view = new stdClass();

        global $wpdb;

        $view->logs = $wpdb->get_results('SELECT * FROM ' . $this->pluginInfo->tableLogName . ' ORDER BY date DESC;');
        $view->pluginInfo = $this->pluginInfo;
        
        return $view;
    }

}

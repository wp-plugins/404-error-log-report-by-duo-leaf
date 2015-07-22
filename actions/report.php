<?php

global $wpdb;

$this->logs = $wpdb->get_results('SELECT * FROM `' . $this->pluginInfo->tableLogName . '`;');

include_once(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/views/report.php');

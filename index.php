<?php

/**
 * Plugin Name: 404 Error log report by Duo Leaf
 * Plugin URI: http://DuoLeaf.com/
 * Version: 1.0.5
 * Author: Duo Leaf
 * Author URI: http://DuoLeaf.com/404-error-log-report/
 * Description: Generate a report of 404 (page not found) errors that occurs in your site.
 * License: GPLv3 or later
 */
require_once(WP_PLUGIN_DIR . '/404-error-log-report-by-duo-leaf/duo-leaf/duoleaf.php');
require_once(WP_PLUGIN_DIR . '/404-error-log-report-by-duo-leaf/core/plugin-info.php');
require_once(WP_PLUGIN_DIR . '/404-error-log-report-by-duo-leaf/core/types.php');
require_once(WP_PLUGIN_DIR . '/404-error-log-report-by-duo-leaf/core/storage.php');
require_once(WP_PLUGIN_DIR . '/404-error-log-report-by-duo-leaf/core/logger.php');
require_once(WP_PLUGIN_DIR . '/404-error-log-report-by-duo-leaf/core/admin-area.php');
require_once(WP_PLUGIN_DIR . '/404-error-log-report-by-duo-leaf/core/upgrade-manager.php');

class dl_elr_ErrorLogReport {

    /** @var dl_elr_PluginInfo */
    public $pluginInfo;

    /** @var dl_elr_Storage */
    public $storage;

    /** @var dl_elr_AdminArea */
    public $adminArea;

    /** @var dl_elr_UpgradeManager */
    public $upgradeManager;

    /** @var dl_elr_Logger */
    public $logger;

    /**
     * Constructor
     */
    public function __construct($pluginInfo, $storage, $adminArea, $upgradeManager, $logger) {
        $this->pluginInfo = $pluginInfo;
        $this->storage = $storage;
        $this->adminArea = $adminArea;
        $this->upgradeManager = $upgradeManager;
        $this->logger = $logger;
        
    }

}

$dl_elr_pluginInfo = new dl_elr_PluginInfo();
$dl_elr_Storage = new dl_elr_Storage($dl_elr_pluginInfo);
$dl_elr_UpgradeManager = new dl_elr_UpgradeManager($dl_elr_pluginInfo);
$dl_elr_AdminArea = new dl_elr_AdminArea($dl_elr_pluginInfo, $dl_elr_Storage, $_GET, $_POST);
$dl_elr_Logger = new dl_elr_Logger($dl_elr_pluginInfo);

$dl_elr_ErrorLogReport = new dl_elr_ErrorLogReport($dl_elr_pluginInfo, $dl_elr_Storage, $dl_elr_AdminArea, $dl_elr_UpgradeManager, $dl_elr_Logger);

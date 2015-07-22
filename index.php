<?php

/**
 * Plugin Name: 404 Error log report by Duo Leaf
 * Plugin URI: http://DuoLeaf.com/
 * Version: 1.0.0
 * Author: Duo Leaf
 * Author URI: http://DuoLeaf.com/404-error-log-report/
 * Description: 
 * License: GPLv3 or later
 */
require_once(WP_PLUGIN_DIR . '/404-error-log-report-by-duo-leaf/core/plugin-info.php');
require_once(WP_PLUGIN_DIR . '/404-error-log-report-by-duo-leaf/core/log.php');


register_activation_hook(__FILE__, 'dl_elr_pluginActivation');

function dl_elr_pluginActivation() {

    global $wpdb;

    $pluginInfo = new dl_elr_PluginInfo();

    if ($wpdb->get_var("SHOW TABLES LIKE '$pluginInfo->tableLogName'") != $pluginInfo->tableLogName) {

        $sql = "CREATE TABLE `$pluginInfo->tableLogName` (
                `id` INT( 11 ) NOT NULL AUTO_INCREMENT,
                `url` TEXT NOT NULL,
                `date` TIMESTAMP NULL,
                PRIMARY KEY(id)
            );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

class dl_elr_ErrorLogReport {

    /** @var dl_ift_PluginInfo */
    public $pluginInfo;

    /**
     * Constructor
     */
    public function __construct($pluginInfo) {
        $this->pluginInfo = $pluginInfo;

        add_action('admin_menu', array(&$this, 'adminPanelsAndMetaBoxes'));
        add_action('template_redirect', array($this, 'log'));
    }

    function adminPanelsAndMetaBoxes() {
        add_submenu_page('tools.php', $this->pluginInfo->displayName, $this->pluginInfo->displayName, 'manage_options', $this->pluginInfo->name, array(&$this, 'adminPanel'));
        add_action('admin_enqueue_scripts', array(&$this, 'adminEnqueueScripts'));
    }

    function adminPanel() {

        $this->view = new stdClass();

        include_once(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/actions/report.php');
    }

    function log() {
        if (!is_404())
            return;

        global $wpdb;
        
        $log = new dl_elr_Log();
        $log->url = $_SERVER['REQUEST_URI'];
        $log->date = current_time('mysql');
        
        $logArray = get_object_vars($log);

        $wpdb->insert($this->pluginInfo->tableLogName, $logArray);
        $this->view->resource->id = $wpdb->insert_id;
        
        $this->removeOldRecords();
    }

    function removeOldRecords() {

        global $wpdb;

        $qtdRegistros = $wpdb->get_row('SELECT COUNT(*) AS Qtd FROM ' . $this->pluginInfo->tableLogName . ';');

        echo $qtdRegistros->Qtd;

        if ($qtdRegistros->Qtd > 100) {

            $qtdRemover = $qtdRegistros->Qtd - 100;

            $wpdb->query($wpdb->prepare('DELETE FROM `' . $this->pluginInfo->tableLogName . '` ORDER BY date ASC LIMIT %d ;', $qtdRemover));
        }
    }
    
    function adminEnqueueScripts() {
        wp_register_script('dl_acj_customJS', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/js/custom.js', array('jquery'), NULL);
        wp_enqueue_script('dl_acj_customJS');
        wp_register_script('dl_acj_bootstrap', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/js/bootstrap.min.js', array('jquery'), NULL);
        wp_enqueue_script('dl_acj_bootstrap');

        wp_enqueue_style('dl_acj_css_custom', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/css/custom.css', array(), null, 'all');
        wp_enqueue_script('dl_acj_css_custom');
        wp_enqueue_style('dl_acj_css_bootstrap', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/css/bootstrap-iso.css', array(), null, 'all');
        wp_enqueue_script('dl_acj_css_bootstrap');
        wp_enqueue_style('dl_acj_css_bootstrap_theme', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/css/bootstrap-theme.css', array(), null, 'all');
        wp_enqueue_script('dl_acj_css_bootstrap_theme');
    }

}

$dl_elr_pluginInfo = new dl_elr_PluginInfo();
$dl_elr_ErrorLogReport = new dl_elr_ErrorLogReport($dl_elr_pluginInfo);



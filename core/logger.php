<?php

class dl_elr_Logger {

    /** @var dl_elr_PluginInfo */
    public $pluginInfo;

    /**
     * Constructor
     */
    public function __construct($pluginInfo) {
        $this->pluginInfo = $pluginInfo;

        add_action('template_redirect', array($this, 'log'));
    }

    function log() {

        if (!is_404())
            return;

        global $wpdb;

        $log = new dl_elr_Log();
        $log->url = $_SERVER['REQUEST_URI'];
        $log->date = current_time('mysql');
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $log->useragent = $_SERVER['HTTP_USER_AGENT'];
        } else {
            $log->useragent = '';
        }



        $logArray = get_object_vars($log);

        $wpdb->insert($this->pluginInfo->tableLogName, $logArray);

        $this->removeOldRecords();
    }

    function removeOldRecords() {

        global $wpdb;

        $qtdRegistros = $wpdb->get_row('SELECT COUNT(*) AS Qtd FROM ' . $this->pluginInfo->tableLogName . ';');

        if ($qtdRegistros->Qtd > 100) {

            $qtdRemover = $qtdRegistros->Qtd - 100;

            $wpdb->query($wpdb->prepare('DELETE FROM `' . $this->pluginInfo->tableLogName . '` ORDER BY date ASC LIMIT %d ;', $qtdRemover));
        }
    }

}

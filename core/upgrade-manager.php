<?php

class dl_elr_UpgradeManager {

    /** @var dl_elr_PluginInfo */
    public $pluginInfo;

    public function __construct($pluginInfo) {

        $this->pluginInfo = $pluginInfo;

        register_activation_hook(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/index.php', array(&$this, 'activate'));

        add_action('plugins_loaded', array(&$this, 'upgrade'));
    }

    public function upgrade() {


        $optionName = $this->pluginInfo->name . "-version";
        $oldVersionValue = get_option($optionName, '1.0.0');

        if ($oldVersionValue != $this->pluginInfo->currentVersion) {

            if (in_array($oldVersionValue, array('1.0.0', '1.0.2'))) {
                
                $this->activate();
                
                global $wpdb;
                $wpdb->query('UPDATE ' . $this->pluginInfo->tableLogName . ' SET useragent = \'\' WHERE 1 = 1;');
                
                $oldVersionValue = '1.0.3';
                
            }
            
            update_option($optionName, $this->pluginInfo->currentVersion);
        }
    }

    public function activate() {

        global $wpdb;

        $pluginInfo = new dl_elr_PluginInfo();

        $sql = "CREATE TABLE $pluginInfo->tableLogName (
                id INT( 11 ) NOT NULL AUTO_INCREMENT,
                url TEXT NOT NULL,
                date TIMESTAMP NULL,
                useragent TEXT NULL,
                PRIMARY KEY(id)
            );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

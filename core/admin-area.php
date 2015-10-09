<?php

class dl_elr_AdminArea {

    /** @var dl_elr_PluginInfo */
    public $pluginInfo;

    /** @var dl_elr_Storage */
    public $storage;

    /** @var array */
    public $get;

    /** @var array */
    public $post;

    /**
     * Constructor
     */
    public function __construct($pluginInfo, $storage, $get, $post) {
        $this->pluginInfo = $pluginInfo;
        $this->storage = $storage;
        $this->get = $get;
        $this->post = $post;

        add_action('admin_menu', array(&$this, 'adminPanelsAndMetaBoxes'));

        add_action('admin_enqueue_scripts', array(&$this, 'adminRegisterScripts'));
    }

    function adminPanelsAndMetaBoxes() {
        add_submenu_page('duo-leaf', $this->pluginInfo->smallDisplayName, $this->pluginInfo->smallDisplayName, 'manage_options', $this->pluginInfo->name, array(&$this, 'adminPanel'));
    }

    public function adminPanel() {

        require_once(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/actions/report.php');
        require_once(WP_PLUGIN_DIR . '/' . $this->pluginInfo->name . '/views/report.php');

        $action = new dl_erl_ActionReport($this->pluginInfo, $this->storage, $this->get, $this->post);
        $viewData = $action->execute();
        $view = new dl_erl_ViewReport($viewData);
        $view->execute();

        $this->adminEnqueueScripts();
    }

    function adminRegisterScripts() {
        wp_register_script('dl_acj_customJS', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/js/custom.js', array('jquery'), NULL);
        wp_register_script('dl_acj_bootstrap', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/js/bootstrap.min.js', array('jquery'), NULL);

        wp_enqueue_style('dl_acj_css_custom', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/css/custom.css', array(), null, 'all');
        wp_enqueue_style('dl_acj_css_bootstrap', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/css/bootstrap-iso.css', array(), null, 'all');
        wp_enqueue_style('dl_acj_css_bootstrap_theme', WP_PLUGIN_URL . '/' . $this->pluginInfo->name . '/assets/css/bootstrap-theme.css', array(), null, 'all');
    }

    function adminEnqueueScripts() {
        wp_enqueue_script('dl_acj_customJS');
        wp_enqueue_script('dl_acj_bootstrap');

        wp_enqueue_script('dl_acj_css_custom');
        wp_enqueue_script('dl_acj_css_bootstrap');
        wp_enqueue_script('dl_acj_css_bootstrap_theme');
    }

}

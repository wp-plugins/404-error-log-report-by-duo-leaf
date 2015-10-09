<?php

class dl_elr_Storage {

    /** @var dl_elr_PluginInfo */
    public $pluginInfo;

    /**
     * Constructor
     */
    public function __construct($pluginInfo) {
        $this->pluginInfo = $pluginInfo;
    }

}

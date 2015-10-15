<?php

class dl_erl_ViewReport {

    public $view;

    public function __construct($view) {
        $this->view = $view;
    }

    public function execute() {
        ?>
        <div class="bootstrap-iso">
            <h2><?php echo $this->view->pluginInfo->displayName; ?></h2>
            <hr />

            <div class="row">
                <div class="col-md-9">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-th-list"></span> List of 404 erros
                        </div> 
                        <div class="panel-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Url</th>
                                        <th>Date</th>
                                        <th class="col-xs-3">Browser</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($this->view->logs as $log) { ?>
                                        <tr>
                                            <td><?php echo $log->url; ?></td>
                                            <td>
                                                <?php echo $log->date; ?>
                                            </td>
                                            <td>
                                                <img src="<?php echo  WP_PLUGIN_URL . '/' . $this->view->pluginInfo->name . '/assets/img/browsers/' . $this->view->userAgentIdentification->getBrowserLabel($log->useragent); ?>.png" />
                                                <span data-toggle="tooltip" data-placement="top" title="<?php echo 'User agent: ' . $log->useragent; ?>"><?php echo $this->view->userAgentIdentification->getBrowserLabel($log->useragent); ?><span>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php include 'panel.php'; ?>
            </div>
        </div>
        <?php
    }
}

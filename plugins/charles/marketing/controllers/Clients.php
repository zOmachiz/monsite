<?php namespace Charles\Marketing\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

use Cloudder;

/**
 * Clients Back-end Controller
 */
class Clients extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Charles.Marketing', 'marketing', 'side-menu-clients');
    }

    public function onTest() {
        trace_log("test");
        trace_log(Cloudder::show('test_toile'));



    }
}

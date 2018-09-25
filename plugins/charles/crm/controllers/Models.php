<?php namespace Charles\Crm\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Models Back-end Controller
 */
class Models extends Controller
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

        BackendMenu::setContext('Charles.Crm', 'crm', 'side-menu-models');
    }
}

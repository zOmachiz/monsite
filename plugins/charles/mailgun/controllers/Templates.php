<?php namespace Charles\Mailgun\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Templates Back-end Controller
 */
class Templates extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Charles.Mailgun.Behaviors.DuplicateModel'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $duplicateConfig = 'config_duplicate.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Charles.Mailgun', 'mailgun', 'templates');
    }
}
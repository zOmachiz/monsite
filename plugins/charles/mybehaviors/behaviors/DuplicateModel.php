<?php namespace Charles\Mybehaviors\Behaviors;

use Backend\Classes\ControllerBehavior;

use October\Rain\Support\Collection;
use October\Rain\Exception\ApplicationException;
use Flash;
use Redirect;


class DuplicateModel extends ControllerBehavior
{
    /**
     * @inheritDoc
     */
    protected $requiredProperties = ['duplicateConfig'];

    /**
     * @var array Configuration values that must exist when applying the primary config file.
     */
    protected $requiredConfig = ['modelClass'];

    /**
     * @var Model Import model
     */
    public $model;

    protected $duplicateWidget;




	//protected $exportExcelWidget;

	public function __construct($controller)
    {
        parent::__construct($controller);

        /*
         * Build configuration
         */
        $this->config = $this->makeConfig($controller->duplicateConfig, $this->requiredConfig);
        $this->duplicateWidget = $this->createDuplicateFormWidget();
        

        


        //$this->exportExcelWidget = $this->createExportExcelFormWidget();
    }


     //ci dessous tous les calculs pour permettre l'import excel. 

    public function onLoadDuplicateForm()
    {
        $this->model = $this->exportGetModel();
        $title = $this->getConfig('title');

        $this->vars['modelId'] = post('id');

        return $this->makePartial('$/charles/mybehaviors/behaviors/duplicatemodel/_duplicate_form.htm');

    }

    public function createDuplicateFormWidget() {
        $configDuplication = new Collection($this->getConfig('duplication'));
        //opération pour retourver l'objet fields
        // !! attention l'objet field doit être en dernier !
        $configDuplication = $configDuplication->take(-1)->toArray();

        $config = $this->makeConfig($configDuplication);
        $config->alias = 'myduplicateformWidget';

        $config->arrayName = 'duplicate_array';
        //$config->redirect = $this->getConfig('redirect').':id';

        $modelName = $this->getConfig('modelClass');
        $config->model = new $modelName;

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);
        $widget->bindToController();

        return $widget;
    }

    public function onDuplicateValidation(){
        $data = $this->duplicateWidget->getSaveData();

        $transformations = new Collection($this->getConfig('duplication[transformation]'));
        $manipulations = new Collection($this->getConfig('duplication[fields]'));
        $relations = $this->getConfig('duplication[relations]');
        //$relationsManyToMany = new Collection($this->getConfig('duplication[relationsManyToMany]'));

        $modelName = $this->getConfig('modelClass');
        $sourceModel = $modelName::find(post('id'));
        $cloneModel = $sourceModel->replicate();

        

        if($transformations) {
            foreach($transformations as $key => $value ) {
                //if(!$value) $value = null;
                $cloneModel[$key] = $value;
            }
        }
       
        if($manipulations) {
            foreach($manipulations as  $key => $value ) { 
                //Verification si le champs ne commence pas par _ ( instruction de ne pas enregistrer ) et si la valeur existe ( cas ches champs caché)
                if(!starts_with($key , '_') && $data[$key]) $cloneModel[$key] = $data[$key];
            }
        }

        
        
        $cloneModel->save();

        //load relations on EXISTING MODEL
        if($relations) {
            $sourceModel->load($relations);
            //re-sync everything
            foreach ($sourceModel->getRelations() as $relationName => $values){
                $cloneModel->{$relationName}()->sync($values);
            }
        }

        // if($relations) {
        //     foreach($relations as $Keyrelation => $fieldRelation  ) {
                
        //         foreach($sourceModel[$Keyrelation] as $related ) { 
        //             $new_relation = $related->replicate();
        //             // suppression des champs nested si existe
        //             if($new_relation->parent_id) $new_relation->parent_id = null;
        //             $new_relation[$fieldRelation] = $cloneModel->id;
        //             $new_relation->save();
        //         }
        //     }
        // } 
        // if($relationsManyToMany) {
        //     foreach($relationsManyToMany as $Keyrelation => $fieldRelation  ) {
        //         foreach($sourceModel[$Keyrelation] as $related ) { 
        //             $cloneModel->attach($related);
        //         }
        //         trace_log('----');
        //     }
        // }  

        Flash::info("Duplication effectuée");
        return  Redirect::to($this->getConfig('redirect').$cloneModel->id);
        //return true;

    }

    public function exportGetModel()
    {
        if ($this->model !== null) {
            return $this->model;
        }

        $modelClass = $this->getConfig('modelClass');

        if (!$modelClass) {
            throw new ApplicationException('Please specify the modelClass property for exporting');
        }

        return $this->model = new $modelClass;
    }

    
}
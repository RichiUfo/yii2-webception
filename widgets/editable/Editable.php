<?php

namespace frontend\modules\accounting\widgets\editable;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

class Editable extends \yii\base\Widget{

	// Widgets Parameters
    public $container = 'h1';
    public $containerOptions = [
        'class' => '', 
    ];
    public $text = '';
    public $element = [
        'id' => 0,
        'property' => '',
        'action' => '#'
    ];
    
    public function init(){
        parent::init();
        
        // Assets Registration
		EditableAsset::register($this->getView());
		
		// Starts output buffering
        ob_start();
        ob_implicit_flush(false);
	}
    public function run(){
		
		// Main Container
		echo Html::beginTag('div', [
		    'class' => 'fp-editable',
		    'ng-app' => 'editableApp',
		    'ng-controller' => 'EditableController'
	    ]);
		
		// Standard Display
		$this->containerOptions['class'] .= ' editable';
		$this->containerOptions['ng-hide'] = 'editionMode';
		$this->containerOptions['ng-click'] = 'editionMode=true'; 
		echo Html::tag($this->container, Html::encode($this->text), $this->containerOptions);
		
		// Edition Form
		$form = ActiveForm::begin([
		    'id' => 'account-title-edit-form', 
		    'class' => 'form-inline'
	    ]); 
        echo Html::input('hidden', 'id', $this->element['id']);
        echo Html::input('text', 'value', '', [
            'id' => 'account-title-edit-form-field',
            'class' => 'form-field-invisible text-center h1',
            'ng-show' => 'editionMode',
            'ng-model' => 'value'
        ]);
        echo Html::beginTag('div', ['class' => 'buttons-line pull-right form-inline']);
        echo Html::button('Default', [
            'id' => 'account-title-edit-form-reset-button',
            'class' => 'btn btn-xs',
        ]); 
        echo Html::button('Save', [
            'id' => 'account-title-edit-form-button',
            'class' => 'btn btn-xs btn-primary',
            'ng-click' => 'save()'
        ]);
        echo Html::endTag('div');
        
        $form->end();
        
        echo Html::endTag('div');
        
		// Register the JS
	    $this->getView()->registerJs('window.fpEditableInitial = '.$this->text.';', POS_HEAD); 
		
		return ob_get_clean();
    }
    
}

?>

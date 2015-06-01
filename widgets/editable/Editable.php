<?php
namespace frontend\modules\accounting\widgets\editable;

class Editable extends \yii\base\Widget{

	// Widgets Parameters
    public $container = 'h1';
    public $containerOptions = [
        'class' => '',    
    ];
    public $text = '';
    public $action = '#';
    public $element = [
        'id' => 0,
        'property' => '',
        'value' => '',
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
		
		// Standard Display
		$this->containerOptions['class'] .= ' editable';
		echo Html::tag($this->container, Html::encode($this->text), $this->containerOptions);
		
		// Edition Form
		$form = ActiveForm::begin([
		    'id' => 'account-title-edit-form', 
		    'class' => 'form-inline'
	    ]); 
        echo Html::input('hidden', 'id', $this->element['id']);
        echo Html::input('text', 'value', $this->element['id'], [
            'id' => 'account-title-edit-form-field',
            'class' => 'form-field-invisible text-center h1',
        ]);
        echo Html::beginTag('div', ['class' => 'buttons-line pull-right form-inline']);
        Html::button('Default', [
            'id' => 'account-title-edit-form-reset-button',
            'class' => 'btn btn-xs'
        ]); 
        Html::button('Save', [
            'id' => 'account-title-edit-form-button',
            'class' => 'btn btn-xs btn-primary'
        ]);
        echo Html::endTag('div');
        $form->end();
        
		// Register the JS
		//$this->getView()->registerJs('ajaxModalInit("'.$linkid.'","'.$modal->getId().'");'); 
		
		return ob_get_clean();
    }
    
}

?>

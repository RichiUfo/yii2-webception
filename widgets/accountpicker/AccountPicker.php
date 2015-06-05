<?php

namespace frontend\modules\accounting\widgets\accountpicker;

use yii\helpers\Html;

class AccountPicker extends \yii\base\Widget{

    // Initialize the widget
    public function init(){
        parent::init();
        
        // Assets Registration
		AccountPickerAsset::register($this->getView());
		
		// Starts output buffering
        ob_start();
        ob_implicit_flush(false);
	}
	
	// Rendering
    public function run(){
		
		// WIDGET HERE //
        
		// Register the initial values to be passed to the angular app
	    $this->getView()->registerJs('window.fpEditableId = "'.$this->identifier.'";', 1);
		
		return ob_get_clean();
    }
    
}

?>

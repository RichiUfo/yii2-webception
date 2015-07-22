<?php

namespace frontend\modules\accounting\widgets\overview;

use yii\helpers\Html;

class OverviewEntity extends \yii\base\Widget{

    // Initialize the widget
    public function init(){
        parent::init();
        
        // Assets Registration
		//OverviewAsset::register($this->getView());
		
		// Starts output buffering
        ob_start();
        ob_implicit_flush(false);
	}
	
	// Rendering
    public function run(){
		
		echo Html::tag('div', 'Widget Content');
		
		return ob_get_clean();
    }
    
}

?>

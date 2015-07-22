<?php

namespace frontend\modules\accounting\widgets\overview;

use yii\helpers\Html;
use yii\helpers\Url;

class OverviewEntity extends \yii\base\Widget{

    // Initialize the widget
    public function init(){
        parent::init();
        
        // Assets Registration
		//OverviewAsset::register($this->getView());
		
		// Starts output buffering
        ob_start();
        ob_implicit_flush(false);
        
        // Render the container
		echo Html::beginTag('div', ['class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-4 account-overview']);
		echo Html::beginTag('div', ['class' => 'box']);
		
		echo Html::beginTag('span', ['class' => 'title']);
		echo Html::tag('a', 'Accounting', ['href' => Url::toRoute('/accounting')]);
		echo Html::endTag('span');
		
		echo Html::beginTag('div', ['class' => 'row overview-row']);
		echo Html::beginTag('div', ['class' => 'col-lg-12']);
        
	}
	
	// Rendering
    public function run(){
		
		echo 'Widget in development ...';
		
		echo Html::endTag('div');
		echo Html::endTag('div');
		echo Html::endTag('div');
		echo Html::endTag('div');
		
		return ob_get_clean();
    }
    
}

?>

<?php

namespace frontend\modules\accounting\widgets\overview;

use yii\helpers\Html;
use yii\helpers\Url;

use frontend\widgets\box\Box;

class OverviewEntity extends Box {

    // Initialize the widget
    public function init(){
        parent::init();
	}
	
	// Rendering
    public function run(){
		echo 'Widget in development ...';
		
		parent::run();
		return ob_get_clean();
    }
    
}

?>

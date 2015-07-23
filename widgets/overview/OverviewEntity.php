<?php

namespace frontend\modules\accounting\widgets\overview;

use yii\helpers\Html;
use yii\helpers\Url;

use frontend\widgets\box\Box;

class OverviewEntity extends \yii\base\Widget {

    public function init(){
        parent::init();
		
		// Starts output buffering
        ob_start();
        ob_implicit_flush(false);
	}
    
    public function run(){
        Box::begin([
            'title' => 'Accounting',
            'route' => '/accounting'
        ]);
        echo 'It Works !';
        Box::end();
        
        return ob_get_clean();
    }
    
}

?>

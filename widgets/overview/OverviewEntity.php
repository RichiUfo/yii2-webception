<?php

namespace frontend\modules\accounting\widgets\overview;

use yii\helpers\Html;
use yii\helpers\Url;

use frontend\widgets\box\Box;

class OverviewEntity extends Box {

    public function init(){
        
	}
    
    public function run(){
        parent::begin();
        echo 'It Works !';
        parent::end();
    }
    
}

?>

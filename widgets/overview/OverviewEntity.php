<?php

namespace frontend\modules\accounting\widgets\overview;

use yii\helpers\Html;
use yii\helpers\Url;

use frontend\widgets\box\Box;

class OverviewEntity extends \frontend\widgets\box\Box {

    public function init(){
        
	}
    
    public function run(){
        Box::begin();
        echo 'It Works !';
        Box::end();
    }
    
}

?>

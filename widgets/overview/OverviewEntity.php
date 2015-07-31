<?php

namespace frontend\modules\accounting\widgets\overview;

use yii\helpers\Html;
use yii\helpers\Url;

use frontend\widgets\box\Box;

use frontend\modules\accounting\controllers\BalancesheetController;

class OverviewEntity extends \yii\base\Widget {

    public function init(){
        parent::init();
		
		// Get the data
		$balance_sheet = BalancesheetController::getFinancialData();
		
		// Starts output buffering
        ob_start();
        ob_implicit_flush(false);
	}
    
    public function run(){
        Box::begin([
            'title' => 'Accounting',
            'route' => '/accounting'
        ]);
        var_dump($balance_sheet);
        Box::end();
        
        return ob_get_clean();
    }
    
}

?>

<?php

namespace frontend\modules\accounting\widgets\overview;

use yii\helpers\Html;
use yii\helpers\Url;

use frontend\widgets\box\Box;

use frontend\modules\accounting\controllers\BalancesheetController;

class OverviewEntity extends \yii\base\Widget {

    private $balance_sheet;

    public function init(){
        parent::init();
		
		// Get the data
		$this->balance_sheet = BalancesheetController::getFinancialData();
		
		// Starts output buffering
        ob_start();
        ob_implicit_flush(false);
	}
    
    public function run(){
        Box::begin([
            'title' => 'Accounting',
            'route' => '/accounting'
        ]);
        echo Html::beginTag('ul');
        echo Html::tag('li', 'Assets '.$this->balance_sheet['total_assets']);
        echo Html::tag('li', 'Equity '.$this->balance_sheet['total_equity']);
        echo Html::tag('li', 'Liabilities '.$this->balance_sheet['total_liabilities']);
        echo Html::tag('li', 'Debt Ratio '.$this->balance_sheet['debt_ratio']);
        echo Html::endTag('ul');
        Box::end();
        
        return ob_get_clean();
    }
    
}

?>

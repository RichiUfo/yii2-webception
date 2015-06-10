<?php

namespace frontend\modules\accounting\models;

use Yii;

use frontend\components\ExchangeController;

/**
 * This is the model class for table "acc_accounts" supercharged with extra functionnalities
 */
class AccountPlus extends Account
{
    public $has_children;
    public $root_account;
    public $statement;
    public $sign;
    public $display_value;
    
    public function afterFind(){
        
        parent::afterFind();

        $this->root_account = $this;
        while ($this->root_account->parent_id != 0) {
            $this->root_account = AccountPlus::findOne($this->root_account->parent_id);
        }
   
        $rootname = $this->root_account->name;
        if (($rootname == "Assets") or ($rootname == "Equity") or ($rootname == "Liabilities")){
            $this->statement = "balance_sheet";
        } 
        else {
            $this->statement = "profits_and_losses";
        }
        
        $this->sign = ( ($this->root_account->name=='Assets') ) ? -1:1;
        $this->display_value = $this->sign * $this->value;
        
        $this->alias = ($this->alias=='')?$this->name:$this->alias;
        
        // Account Values (in original and system currencies)
        $this->display_value = $this->sign * $this->value;
        if ($this->currency !== Yii::$app->user->identity->acc_currency){
            
            $this->display_value = ExchangeController::get('finance', 'currency-conversion', [
                'value' => $this->display_value,
                'from' => $this->currency,
                'to' => \Yii::$app->user->identity->acc_currency,
            ]);
            
        }
        
            
    }
}
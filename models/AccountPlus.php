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
    public $value_converted;
    
    public function afterFind(){
        
        parent::afterFind();

        // Hierarchy
        $this->root_account = $this;
        while ($this->root_account->parent_id != 0) {
            $this->root_account = AccountPlus::findOne($this->root_account->parent_id);
        }
        
        $children = AccountPlus::find()->where(['parent_id' => $this->id])->all();
        if($children) {
            $this->has_children = true;
            $this->value = 0;
            $this->currency = \Yii::$app->user->identity->acc_currency; 
            foreach($children as $child) {
                $this->value += $child->value_converted;
            }
        }
        else {
            $this->has_children = false;
        }
        
   
        $rootname = $this->root_account->name;
        if (($rootname == "Assets") or ($rootname == "Equity") or ($rootname == "Liabilities")){
            $this->statement = "balance_sheet";
        } 
        else {
            $this->statement = "profits_and_losses";
        }
        
        /* 
        * Account Name
        */
        $this->alias = ($this->alias=='')?$this->name:$this->alias;
        
        /* 
        * Account Values (in original and system currencies)
        */
        
        $this->sign = ($this->root_account->name=='Assets')?-1:1;
        $this->value_converted = $this->value;
        if ($this->currency !== Yii::$app->user->identity->acc_currency) {
            
            $this->value_converted = ExchangeController::get('finance', 'currency-conversion', [
                'value' => $this->value,
                'from' => $this->currency,
                'to' => \Yii::$app->user->identity->acc_currency,
            ]);
            
        }
        
            
    }
}
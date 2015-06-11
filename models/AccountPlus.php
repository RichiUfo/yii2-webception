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

        $this->getType();
        $this->calcValue();
        $this->getName();

    }
    
    /**
     * public function calcValue()
     * Update the class variables related to the account value
     * Class variables modified :
     *      - value
     *      - sign
     *      - value_converted
     *      - has_children
     * Prerequisites :
     *      - root_account
     * Requires the finance module for currency conversion
     */
    public function calcValue() {
        
        // If the account has children, its value is the sum of its children
        $children = AccountPlus::find()->where(['parent_id' => $this->id])->all();
        $this->has_children = false;
        if(!empty($children)) {
            $this->has_children = true;
            $this->value = 0;
            $this->currency = \Yii::$app->user->identity->acc_currency; 
            foreach($children as $child) 
                $this->value += $child->value_converted;
        }
        // Values of special accounts
        else {
            switch ($this->special_class) {
                case 'forex_trading' :   
                    $acc = $this->accountForex; 
                    $this->value = $acc->value; 
                    break;
                default :
                    $this->value = $this->value;
            }
        }
        
        // Convert the value to the system currency
        $this->value_converted = $this->value;
        if ($this->currency !== Yii::$app->user->identity->acc_currency) {
            
            $this->value_converted = ExchangeController::get('finance', 'currency-conversion', [
                'value' => $this->value,
                'from' => $this->currency,
                'to' => \Yii::$app->user->identity->acc_currency,
            ]);
            
        }
    }
    /**
     * public function getType()
     * Update the class variables related to the account type (credit or debit)
     * Also provide the root account and the sign of the account value for display purposes
     * Class variables modified :
     *      - sign
     *      - root_account
     *      - statement (balance_sheet or profits_and_losses)
     * Prerequisites :
     *      - 
     */
    public function getType() {
        
        // Get the root account (on top of the current account hierarchy)
        $this->root_account = $this;
        while ($this->root_account->parent_id != 0)
            $this->root_account = Account::findOne($this->root_account->parent_id);
        
        // Identify which statement the account belongs to
        $rootname = $this->root_account->name;
        if (($rootname == "Assets") or ($rootname == "Equity") or ($rootname == "Liabilities")){
            $this->statement = "balance_sheet";
        } 
        else {
            $this->statement = "profits_and_losses";
        }
        
        // Sign of the account (debit or credit)
        $this->sign = ($this->root_account->name=='Assets')?-1:1;
        
    }
    /**
     * public function getName()
     * Update the class variables related to the account name (alias management)
     * Class variables modified :
     *      - alias (= name if there is no alias specified in database)
     * Prerequisites :
     *      - N/A
     */
    public function getName() {
        $this->alias = ($this->alias=='')?$this->name:$this->alias;
    }
}
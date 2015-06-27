<?php

namespace frontend\modules\accounting\models;

use Yii;

/**
 * This is the model class for extended Transactions.
 * This is the only class that should be used when dealing with transactions.
 * 
 * How to access accounts involved :
 *      ->accountDebit
 *      ->accountCredit
 *      ->accountForex
 * 
 * How to access transaction values for each side
 *      ->valueDebit
 *      ->valueCredit
 * 
 */
class TransactionPlus extends Transaction
{
    public $valueDebit;
    public $valueCredit;
    public $updated_balance = 0;
    public $debug;
    
    public function afterFind() {
        
        parent::afterFind();

        // Values
        $is_forex = ($this->transactionForex) ? true : false;
        if($is_forex) {
            
            $this->debug = $this->accountForex;
            
            $for_cur = Account::findOne($this->accountForex['id'])->accountForex['forex_currency'];
            $deb_cur = $this->accountDebit['currency'];
            $cre_cur = $this->accountCredit['currency'];
            
            $this->valueDebit = ($for_cur === $deb_cur) ? $this->transactionForex['forex_value'] : $this->value ;
            $this->valueCredit = ($for_cur === $cre_cur) ? $this->transactionForex['forex_value'] : $this->value ;
            
        }
        else {
            $this->valueDebit = $this->value;
            $this->valueCredit = $this->value;
        }
        
    }
    
}
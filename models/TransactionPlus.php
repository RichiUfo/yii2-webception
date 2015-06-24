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
    
    public function afterFind() {
        
        parent::afterFind();

        // Values
        $is_forex = ($this->transactionForex) ? true : false;
        if($is_forex) {
            
            $for_cur = $this->accountForex['forex_currency'];
            $deb_cur = $this->accountDebit['currency'];
            $cre_cur = $this->accountCredit['currency'];
            
            $this->valueDebit = $deb_cur; //($for_cur === $deb_cur) ? $this->value : $this->transactionForex['forex_value'];
            $this->valueCredit = $cre_cur; //($for_cur === $cre_cur) ? $this->value : $this->transactionForex['forex_value'];
            
        }
        else {
            $this->valueDebit = $this->value;
            $this->valueCredit = $this->value;
        }
        
    }
    
}
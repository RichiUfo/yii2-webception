<?php

namespace frontend\modules\accounting\models;

use Yii;

use frontend\components\ExchangeController;

class AccountForex extends \frontend\components\ActiveRecord
{
    public $value;
    public $unrealized;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accounts_forex';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'forex_currency'], 'required'],
            [['account_id'], 'integer'],
            [['forex_value', 'realized'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_id' => 'Account ID',
            'forex_currency' => 'Forex Currency',
            'forex_value' => 'Forex Value',
            'realized' => 'Realized P and L',
        ];
    }
    /**
     * Model Specific Calculations
     */
    public function afterFind() {
        
        parent::afterFind();
        
        // Current Value Calculation
        $currency_main = $this->account->currency;
        $currency_foreign = $this->forex_currency;
        $value_main = $this->account->value;
        $value_forex = $this->forex_value;
        
        $value_forex_converted = ExchangeController::get('finance', 'currency-conversion', [
            'value' => $value_forex,
            'from' => $currency_foreign,
            'to' => $currency_main,
        ]);
        
        $this->value = $value_forex_converted + $value_main; 
        $this->unrealized = $this->value - $this->realized;
        
    }
    
    /**
     * Relations
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_id']); 
    }
}

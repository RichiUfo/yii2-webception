<?php

namespace frontend\modules\accounting\models;

use Yii;

class AccountForex extends \frontend\components\ActiveRecord
{
    public $value;
    
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
            [['forex_value'], 'number'],
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
        ];
    }
    /**
     * Model Specific Calculations
     */
    public function afterFind(){
        
        parent::afterFind();
        
        // Current Value Calculation
        $currency_main = $this->account->currency;
        $currency_foreign = $this->forex_currency;
        $value_main = $this->account->value;
        $value_forex = $this->forex_value;
        
        
    }
    
    /**
     * Relations
     */
    public function getAccount()
    {
        return $this->hasOne(AccountPlus::className(), ['id' => 'account_id']);
    }
}

<?php

namespace frontend\modules\accounting\models;

use Yii;

class TransactionForex extends \frontend\components\ActiveRecord
{
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transactions_forex';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transaction_id', 'forex_currency', 'forex_amount'], 'required'],
            [['transaction_id'], 'integer'],
            [['forex_value'], 'number'],
            [['forex_currency'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaction_id' => 'Transaction ID',
            'forex_currency' => 'Forex Currency',
            'forex_value' => 'Forex Value',
        ];
    }
    
    /**
     * Relations
     */
    public function getTransaction()
    {
        return $this->hasOne(Transaction::className(), ['id' => 'transaction_id']);
    }
}
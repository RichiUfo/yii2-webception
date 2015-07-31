<?php

namespace frontend\modules\accounting\models;

use Yii;

class TransactionForex extends \frontend\components\ActiveRecord
{
    
    public $rate;
    
    public function afterFind(){
        
        parent::afterFind();

        $this->rate = $this->forex_value / $this->transaction->value;

    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transactions_forex';
    }
    
    
    
    public static function getDb()
	{
		return \Yii::$app->getModule('accounting')->db;
   	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transaction_id', 'account_forex_id', 'forex_value'], 'required'],
            [['transaction_id', 'account_forex_id'], 'integer'],
            [['forex_value'], 'number']
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
            'account_forex_id' => 'Forex Account ID',
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
    public function getForexAccount()
    {
        return $this->hasOne(AccountForex::className(), ['id' => 'account_']);
    }
}

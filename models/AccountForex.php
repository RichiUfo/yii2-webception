<?php

namespace frontend\modules\accounting\models;

use Yii;

class AccountForex extends \frontend\components\ActiveRecord
{
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
            [['account_id'], 'required'],
            [['account_id'], 'integer'],
            [['forex_value'], 'number'],
            [['forex_currency'], 'string', 'max' => 255]
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
     * Relations
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['account_id' => 'id']);
    }
}

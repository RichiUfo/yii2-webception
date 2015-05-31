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
            [['account_id', 'bank_id'], 'required'],
            [['account_id', 'bank_id'], 'integer'],
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
            'bank_id' => 'Bank ID',
        ];
    }
    
    /**
     * Relations
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['bank_id' => 'id']);
    }
}

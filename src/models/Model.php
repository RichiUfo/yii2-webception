<?php

namespace godardth\yii2webception\models;

use Yii;

/**
 * This is the model class for table "acc_accounts".
 *
 * @property integer $id
 * @property integer $owner_id
 * @property integer $parent_id
 * @property integer $system
 * @property integer $display_position
 * @property string $name
 * @property string $alias
 * @property double $value
 * @property string $currency
 * @property string $special_class
 */
class Account extends \frontend\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accounts';
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
            [['number', 'owner_id', 'parent_id', 'name', 'value', 'currency'], 'required'],
            [['number', 'owner_id', 'parent_id', 'system', 'display_position', 'last_transaction_id'], 'integer'],
            [['value'], 'number'],
            [['date_value'], 'safe'],
            [['name', 'alias', 'special_class'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => 'Owner ID',
            'parent_id' => 'Parent Account',
            'number' => 'Account Number',
            'system' => 'System',
            'display_position' => 'Display Position',
            'name' => 'Name',
            'alias' => 'Alias',
            'value' => 'Value',
            'last_transaction_id' => 'Last Transaction taken into account for valuation',
            'date_value' => 'Last Value Updated',
            'currency' => 'Currency',
            'special_class' => 'Special Class',
        ];
    }
    
    /**
     * Relations
     */
    public function getCreditTransactions()
    {
        return $this->hasMany(Transaction::className(), ['account_credit_id' => 'id']);
    }
    public function getDebitTransactions()
    {
        return $this->hasMany(Transaction::className(), ['account_debit_id' => 'id']);
    }
    public function getAccountForex()
    {
        return $this->hasOne(AccountForex::className(), ['account_id' => 'id']); //->inverseOf('account');
    }
}

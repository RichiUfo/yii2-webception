<?php

namespace frontend\modules\accounting\models;

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
class Account extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id', 'parent_id', 'name', 'value', 'currency'], 'required'],
            [['owner_id', 'parent_id', 'system', 'display_position'], 'integer'],
            [['value'], 'number'],
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
            'system' => 'System',
            'display_position' => 'Display Position',
            'name' => 'Name',
            'alias' => 'Alias',
            'value' => 'Value',
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
}

<?php

namespace frontend\modules\accounting\models;

use Yii;

/**
 * This is the model class for table "acc_transactions".
 *
 * @property integer $id
 * @property integer $account_debit_id
 * @property integer $account_credit_id
 * @property string $date
 * @property string $name
 * @property string $description
 */
class Transaction extends ActiveRecord
{
    
    public $debit = false;  // Indicates if the transaction is a debit (true)
    public $credit = false;  // Indicates if the transaction is a credit (true)
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transactions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_debit_id', 'account_credit_id', 'date_value', 'name', 'value'], 'required'],
            [['account_debit_id', 'account_credit_id'], 'integer'],
            [['date_value'], 'safe'],
            [['name', 'description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_debit_id' => 'Debit',
            'account_credit_id' => 'Credit',
            'date_value' => 'Transaction Date',
            'name' => 'Name',
            'description' => 'Comment (optional)',
            'value' => 'Value',
        ];
    }
}

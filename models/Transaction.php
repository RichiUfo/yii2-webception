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
class Transaction extends \frontend\components\ActiveRecord
{
    
    public $debit = ['isDebit' => false, 'value' => null, 'currency' => null];  // Indicates if the transaction is a debit (true)
    public $credit = ['isCredit' => false, 'value' => null, 'currency' => null];  // Indicates if the transaction is a credit (true)
    
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
            'name' => 'Description',
            'description' => 'Comment (optional)',
            'value' => 'Value',
        ];
    }
    
    /**
     * Relations
     */
    public function getAccountCredit()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_credit_id']);
    }
    public function getAccountDebit()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_debit_id']);
    }
    public function getTransactionForex()
    {
        return $this->hasOne(TransactionForex::className(), ['transaction_id' => 'id'])->inverseOf('transaction');
    }
}

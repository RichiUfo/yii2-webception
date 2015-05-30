<?php

namespace app\modules\accounting\models;

use Yii;

/**
 * This is the model class for table "acc_accounts".
 *
 * @property integer $id
 * @property integer $owner_id
 * @property integer $parent_id
 * @property string $name
 * @property double $value
 * @property string $currency
 * @property string $special_class
 */
class AccountHierarchy extends AccountPlus
{
    public $children;
    public $id_table;
    public $currencies;
    
    public function afterFind(){
     
        parent::afterFind();
        
        $this->children = AccountHierarchy::find()
            ->where(['parent_id' => $this->id])
            ->orderBy('display_position')
            ->all();
        $this->has_children = ($this->children!=null) ? true:false;
        
        // Find all currencies of this account and children
        $this->currencies = array($this->currency);
        foreach ($this->children as $child){
            foreach($child->currencies as $currency){
                if(!in_array($currency, $this->currencies)){
                    array_push($this->currencies, $currency);
                }
            }
        }
    
    }
    
    private function recGetChildrenId(&$arr, $account){
        array_push($arr, $account->id);
        foreach ($account->children as $child)
            $this->recGetChildrenId($arr, $child);
        return $arr;
    }
    
    public function getChildrenIdList(){
        $arr = array();
        return $this->recGetChildrenId($arr, $this);
    }
}
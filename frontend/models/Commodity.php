<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "OC_Commodity".
 *
 * @property integer $COID
 * @property string $CName
 * @property string $Unit
 * @property string $Description
 * @property string $Price
 * @property string $Images
 * @property double $Guaranteeperiod
 * @property string $Remark
 * @property string $ExpiredTime
 * @property string $CreatedTime
 * @property string $UpdatedTime
 * @property integer $State
 */
class Commodity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'OC_Commodity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CName', 'CreatedTime'], 'required'],
            [['Description', 'Images'], 'string'],
            [['Price', 'Guaranteeperiod'], 'number'],
            [['ExpiredTime', 'CreatedTime', 'UpdatedTime'], 'safe'],
            [['State'], 'integer'],
            [['CName'], 'string', 'max' => 2048],
            [['Unit'], 'string', 'max' => 128],
            [['Remark'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'COID' => 'Coid',
            'CName' => 'Cname',
            'Unit' => 'Unit',
            'Description' => 'Description',
            'Price' => '商品自身的价格',
            'Images' => 'Images',
            'Guaranteeperiod' => 'Guaranteeperiod',
            'Remark' => 'Remark',
            'ExpiredTime' => '商品到期日',
            'CreatedTime' => 'Created Time',
            'UpdatedTime' => 'Updated Time',
            'State' => '0:无效; 1:有效; 2:删除',
        ];
    }

    public function getPrice()
    {
        return $this->hasOne(Price::className(), ['COID' => 'COID']);
    }
}

<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "OC_Price".
 *
 * @property integer $PRID
 * @property integer $COID
 * @property string $CName
 * @property integer $STID
 * @property string $Price
 * @property integer $Count
 * @property string $CreatedTime
 * @property string $UpdatedTime
 * @property integer $State
 */
class Price extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'OC_Price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['COID', 'STID', 'Price'], 'required'],
            [['COID', 'STID', 'Count', 'State'], 'integer'],
            [['Price'], 'number'],
            [['CreatedTime', 'UpdatedTime'], 'safe'],
            [['CName'], 'string', 'max' => 2048],
            [['COID', 'STID'], 'unique', 'targetAttribute' => ['COID', 'STID'], 'message' => 'The combination of Coid and Stid has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PRID' => 'Prid',
            'COID' => 'Coid',
            'CName' => '冗余，便于查询输出',
            'STID' => 'Stid',
            'Price' => 'Price',
            'Count' => '该店铺对应当前商品数量(库存明细表的总结，快速查询)',
            'CreatedTime' => 'Created Time',
            'UpdatedTime' => 'Updated Time',
            'State' => '0:无效；1:有效',
        ];
    }

    public function getCommodity()
    {
        return $this->hasOne(Commodity::className(), ['COID' => 'COID']);
    }
}

<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "OC_StoreInventory".
 *
 * @property integer $SIID
 * @property integer $STID
 * @property integer $COID
 * @property integer $Amount
 * @property string $Type
 * @property string $CreatedTime
 */
class StoreInventory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'OC_StoreInventory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STID', 'COID', 'Amount', 'CreatedTime'], 'required'],
            [['STID', 'COID', 'Amount'], 'integer'],
            [['CreatedTime'], 'safe'],
            [['Type'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SIID' => 'Siid',
            'STID' => 'Stid',
            'COID' => 'Coid',
            'Amount' => '门店该商品的进出数量记录，正数，增加；负数，减少',
            'Type' => '操作说明文本：比如，进店；购买；回库；盘点等等',
            'CreatedTime' => 'Created Time',
        ];
    }
}

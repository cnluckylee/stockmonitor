<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "OC_OrderDetail".
 *
 * @property integer $DDID
 * @property integer $ODID
 * @property integer $URID
 * @property integer $STID
 * @property integer $PRID
 * @property string $Price
 * @property string $CName
 * @property integer $Amount
 * @property string $Total
 * @property string $CreatedTime
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'OC_OrderDetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ODID', 'STID', 'Price', 'CreatedTime'], 'required'],
            [['ODID', 'URID', 'STID', 'PRID', 'Amount'], 'integer'],
            [['Price', 'Total'], 'number'],
            [['CreatedTime'], 'safe'],
            [['CName'], 'string', 'max' => 2048]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DDID' => 'Ddid',
            'ODID' => 'Odid',
            'URID' => '用户id(冗余)',
            'STID' => 'Stid',
            'PRID' => 'Prid',
            'Price' => '下单时价格快照',
            'CName' => '下单时商品品名快照',
            'Amount' => '单件商品购买数量',
            'Total' => '该商品支付总金额',
            'CreatedTime' => 'Created Time',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord){
                $this->CreatedTime = date('Y-m-d H:i:s');
            }
            return true;
        } else {
            return false;
        }
    }

    public function getCommodity()
    {
        $sqlData = Commodity::find()->leftJoin(Price::tableName().' as p','OC_Commodity.COID=p.COID')->where(['PRID'=>$this->PRID])->one();
        return $sqlData;
    }

    public static function getGoodsByODID($odid)
    {
        $sqlData = OrderDetail::findAll(['ODID'=>$odid]);
        $result =[];
        foreach($sqlData as $k=>$v)
        {
            $co = $v->commodity;
            $a = $co->attributes;
            $a['Price'] = number_format($v->Price,2);
            $a['Count'] = $v->Amount;
            $a['STID'] = $v->STID;
            $result[] = $a;
        }
        return $result;
    }
}



































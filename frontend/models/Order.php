<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "OC_Order".
 *
 * @property integer $ODID
 * @property integer $URID
 * @property string $OrderNumber
 * @property integer $STID
 * @property string $Total
 * @property string $PayAmount
 * @property integer $PayType
 * @property string $OrderID
 * @property integer $State
 * @property string $PayTime
 * @property string $CreatedTime
 * @property string $UpdatedTime
 * @property string $PayString
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'OC_Order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['URID', 'OrderNumber', 'STID'], 'required'],
            [['URID', 'STID', 'PayType', 'State'], 'integer'],
            [['Total', 'PayAmount'], 'number'],
            [['PayTime', 'CreatedTime', 'UpdatedTime'], 'safe'],
            [['OrderNumber'], 'string', 'max' => 128],
            [['PayString'], 'string'],
            [['SCode'], 'string', 'max' => 16],
            [['OrderID'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ODID' => 'Odid',
            'URID' => '用户id',
            'OrderNumber' => '大订单编号，系统生成。后续对同一订单进行的补单，退单，部分退单，使用相同编号。',
            'STID' => 'Stid',
            'Total' => '订单总金额',
            'SCode' => 'Scode',
            'PayAmount' => '实际支付金额',
            'PayType' => '1:支付宝；2:微信',
            'OrderID' => '支付平台交易号',
            'State' => '订单状态:0, 等待知付；1，支付成功；2，订单取消',
            'PayTime' => '支付时间',
            'CreatedTime' => 'Created Time',
            'UpdatedTime' => 'Updated Time',
            'PayString' => '支付回调数据',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord){
                $this->CreatedTime = $this->UpdatedTime = date('Y-m-d H:i:s');
            }else
                $this->UpdatedTime = date('Y-m-d H:i:s');
            return true;
        } else {
            return false;
        }
    }

    public static function CreatedOrderNumber($type = 1)
    {
        $code = '';
        switch ($type)
        {
            case 1:
                //新单
                $code = 'C'.date('YmdHis').rand(1000,9999);
                break;
            case 2:
                $code =  'T'.date('YmdHis').rand(1000,9999);
                break;
            default:
                break;
        }
        return $code;
    }

    public function getDetail()
    {
        return $this->hasMany(OrderDetail::className(), ['ODID' => 'ODID']);
    }
}

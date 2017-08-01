<?php

namespace common\models;

use Yii;

/**
 * This is the model class for collection "stock".
 *
 * @property \MongoId|string $_id
 * @property mixed $uid
 * @property mixed $coin
 * @property mixed $name
 * @property mixed $count
 * @property mixed $price
 * @property mixed $createdtime
 * @property mixed $type
 * @property mixed $percent
 * @property mixed $starttime
 * @property mixed $endtime
 */
class Stock extends \yii\mongodb\ActiveRecord
{
    //uid,coin,count,price,createdtime,type,percent,starttime,endtime
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['jubi', 'stock'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'uid',
            'coin',
            'name',
            'count',
            'price',
            'createdtime',
            'type',
            'percent',
            'starttime',
            'endtime',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'coin','name', 'count', 'price', 'createdtime', 'type', 'percent', 'starttime', 'endtime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'uid' => 'Uid',
            'coin' => 'Coin',
            'name' => 'Name',
            'count' => 'Count',
            'price' => 'Price',
            'createdtime' => 'Createdtime',
            'type' => 'Type',
            'percent' => 'Percent',
            'starttime' => 'Starttime',
            'endtime' => 'Endtime',
        ];
    }
}

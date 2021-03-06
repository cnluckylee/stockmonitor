<?php

namespace common\models;

use Yii;

/**
 * This is the model class for collection "runstock".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $uid
 * @property mixed $coin
 * @property mixed $count
 * @property mixed $price
 * @property mixed $createdtime
 * @property mixed $type
 * @property mixed $percent
 * @property mixed $starttime
 * @property mixed $endtime
 * @property mixed $state
 * @property mixed $maxprice
 * @property mixed $minprice
 */
class Runstock extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['jubi', 'runstock'];
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
            'count',
            'price',
            'createdtime',
            'type',
            'percent',
            'starttime',
            'endtime',
            'state',
            'maxprice',
            'minprice',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'coin', 'count', 'price', 'createdtime', 'type', 'percent', 'starttime', 'endtime', 'state', 'maxprice', 'minprice'], 'safe']
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
            'count' => 'Count',
            'price' => 'Price',
            'createdtime' => 'Createdtime',
            'type' => 'Type',
            'percent' => 'Percent',
            'starttime' => 'Starttime',
            'endtime' => 'Endtime',
            'state' => 'State',
            'maxprice' => 'Maxprice',
            'minprice' => 'Minprice',
        ];
    }
}

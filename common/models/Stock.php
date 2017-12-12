<?php

namespace common\models;

use Yii;

/**
 * This is the model class for collection "stock".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $code
 * @property mixed $high
 * @property mixed $low
 * @property mixed $name
 * @property mixed $open
 * @property mixed $percent
 * @property mixed $price
 * @property mixed $symbol
 * @property mixed $turnover
 * @property mixed $updown
 * @property mixed $volume
 * @property mixed $wb
 * @property mixed $yestclose
 * @property mixed $no
 */
class Stock extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['stock', 'stock'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'code',
            'high',
            'low',
            'name',
            'open',
            'percent',
            'price',
            'symbol',
            'turnover',
            'updown',
            'volume',
            'wb',
            'yestclose',
            'no',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'high', 'low', 'name', 'open', 'percent', 'price', 'symbol', 'turnover', 'updown', 'volume', 'wb', 'yestclose', 'no'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'code' => 'Code',
            'high' => 'High',
            'low' => 'Low',
            'name' => 'Name',
            'open' => 'Open',
            'percent' => 'Percent',
            'price' => 'Price',
            'symbol' => 'Symbol',
            'turnover' => 'Turnover',
            'updown' => 'Updown',
            'volume' => 'Volume',
            'wb' => 'Wb',
            'yestclose' => 'Yestclose',
            'no' => 'No',
        ];
    }
}

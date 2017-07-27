<?php

namespace common\models;

use Yii;

/**
 * This is the model class for collection "reserve".
 *
 * @property \MongoId|string $_id
 * @property mixed $uid
 * @property mixed $coin
 * @property mixed $count
 * @property mixed $price
 * @property mixed $createdtime
 * @property mixed $type
 * @property mixed $percent
 * @property mixed $state
 */
class Reserve extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['jubi', 'reserve'];
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
            'state',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'coin', 'count', 'price', 'createdtime', 'type', 'percent', 'state'], 'safe']
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
            'state' => 'State',
        ];
    }
}

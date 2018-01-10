<?php

namespace common\models;

use Yii;

/**
 * This is the model class for collection "UserStock".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $URID
 * @property mixed $Code
 * @property mixed $MinPrice
 * @property mixed $MaxPrice
 * @property mixed $Scale
 * @property mixed $CreatedTime
 * @property mixed $UpdatedTime
 * @property mixed $State
 * @property mixed $Count
 * @property mixed $BuyPrice
 * @property mixed $SellPrice
 */
class UserStock extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['stock', 'UserStock'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'URID',
            'Code',
            'MinPrice',
            'MaxPrice',
            'Scale',
            'CreatedTime',
            'UpdatedTime',
            'State',
            'Count',
            'BuyPrice',
            'SellPrice',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['URID', 'Code', 'MinPrice', 'MaxPrice', 'Scale', 'CreatedTime', 'UpdatedTime', 'State', 'Count', 'BuyPrice', 'SellPrice'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'URID' => 'Urid',
            'Code' => 'Code',
            'MinPrice' => 'Min Price',
            'MaxPrice' => 'Max Price',
            'Scale' => 'Scale',
            'CreatedTime' => 'Created Time',
            'UpdatedTime' => 'Updated Time',
            'State' => 'State',
            'Count' => 'Count',
            'BuyPrice' => 'Buy Price',
            'SellPrice' => 'Sell Price',
        ];
    }
}

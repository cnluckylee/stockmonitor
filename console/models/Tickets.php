<?php

namespace app\models;

use Yii;

/**
 * This is the model class for collection "tickets".
 *
 * @property \MongoId|string $_id
 * @property mixed $high
 * @property mixed $low
 * @property mixed $buy
 * @property mixed $sell
 * @property mixed $last
 * @property mixed $vol
 * @property mixed $volume
 * @property mixed $name
 * @property mixed $maxsell
 * @property mixed $minsell
 */
class Tickets extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['jubi', 'tickets'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'high',
            'low',
            'buy',
            'sell',
            'last',
            'vol',
            'volume',
            'name',
            'maxsell',
            'minsell',
            'updatedtime'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['high', 'low', 'buy', 'sell', 'last', 'vol', 'volume', 'name', 'maxsell', 'minsell','updatedtime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'high' => 'High',
            'low' => 'Low',
            'buy' => 'Buy',
            'sell' => 'Sell',
            'last' => 'Last',
            'vol' => 'Vol',
            'volume' => 'Volume',
            'name' => 'Name',
            'maxsell' => 'Maxsell',
            'minsell' => 'Minsell',
            'updatedtime' =>'updatedtime',
        ];
    }


}

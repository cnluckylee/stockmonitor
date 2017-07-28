<?php

namespace common\models;

use Yii;

/**
 * This is the model class for collection "order".
 *
 * @property \MongoId|string $_id
 * @property mixed $jid
 * @property mixed $coin
 * @property mixed $type
 * @property mixed $count
 * @property mixed $amount
 */
class Order extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['jubi', 'order'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'jid',
            'coin',
            'type',
            'count',
            'amount',
            'createdtime'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jid', 'coin', 'type', 'count', 'amount','createdtime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'jid' => 'Jid',
            'coin' => 'Coin',
            'type' => 'Type',
            'count' => 'Count',
            'amount' => 'Amount',
            'createdtime' => 'Createdtime'
        ];
    }
}

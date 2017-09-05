<?php

namespace common\models;

use Yii;

/**
 * This is the model class for collection "exchange".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $id
 * @property mixed $rate
 * @property mixed $minrate
 * @property mixed $maxrate
 * @property mixed $state
 * @property mixed $val
 * @property mixed $updatedtime
 */
class Exchange extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['jubi', 'exchange'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'id',
            'rate',
            'minrate',
            'maxrate',
            'state',
            'val',
            'updatedtime',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'rate', 'minrate', 'maxrate', 'state', 'val', 'updatedtime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'id' => 'Id',
            'rate' => 'Rate',
            'minrate' => 'Minrate',
            'maxrate' => 'Maxrate',
            'state' => 'State',
            'val' => 'Val',
            'updatedtime' => 'Updatedtime',
        ];
    }
}

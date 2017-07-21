<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "OC_Store".
 *
 * @property integer $STID
 * @property string $SCode
 * @property string $SName
 * @property string $Images
 * @property string $Address
 * @property string $Latitude
 * @property string $Longitude
 * @property string $Telephone
 * @property string $CreatedTime
 * @property string $UpdatedTime
 * @property integer $State
 */
class Store extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'OC_Store';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SName', 'CreatedTime'], 'required'],
            [['Images'], 'string'],
            [['Latitude', 'Longitude'], 'number'],
            [['CreatedTime', 'UpdatedTime'], 'safe'],
            [['State'], 'integer'],
            [['SCode'], 'string', 'max' => 16],
            [['SName'], 'string', 'max' => 1024],
            [['Address'], 'string', 'max' => 4096],
            [['Telephone'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'STID' => 'Stid',
            'SCode' => 'Scode',
            'SName' => 'Sname',
            'Images' => 'Images',
            'Address' => 'Address',
            'Latitude' => 'Latitude',
            'Longitude' => 'Longitude',
            'Telephone' => 'Telephone',
            'CreatedTime' => 'Created Time',
            'UpdatedTime' => 'Updated Time',
            'State' => '0:close; 1:open; 2:delete',
        ];
    }
}

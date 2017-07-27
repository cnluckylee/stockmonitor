<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "OC_User".
 *
 * @property integer $URID
 * @property string $UserName
 * @property string $Password
 * @property string $NewPassword
 * @property string $Email
 * @property string $Phone
 * @property string $CreatedTime
 * @property string $LastLogin
 * @property string $LoginId
 * @property integer $Sex
 * @property string $Birthday
 * @property integer $State
 * @property string $NickName
 * @property string $UDID
 * @property string $Platform
 * @property string $Ver
 * @property string $UImg
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'OC_User';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CreatedTime', 'LastLogin', 'Birthday'], 'safe'],
            [['Sex', 'State'], 'integer'],
            [['UserName', 'Email', 'NickName', 'UDID', 'Ver', 'UImg'], 'string', 'max' => 255],
            [['Password', 'NewPassword'], 'string', 'max' => 40],
            [['Phone'], 'string', 'max' => 20],
            [['LoginId', 'Platform'], 'string', 'max' => 16],
            [['UserName'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'URID' => '用户ID主键',
            'UserName' => 'User Name',
            'Password' => 'Password',
            'NewPassword' => 'New Password',
            'Email' => '邮件地址，用于重置密码',
            'Phone' => '电话号码',
            'CreatedTime' => '创建时间',
            'LastLogin' => '最后一次登录时间',
            'LoginId' => '登陆的特别标识',
            'Sex' => '性别：1-男，2-女',
            'Birthday' => '生日',
            'State' => '状态：0-正常,1-anonymous',
            'NickName' => '用户昵称',
            'UDID' => 'Udid',
            'Platform' => 'Platform',
            'Ver' => 'Ver',
            'UImg' => '头像URL',
        ];
    }

    /**
     * 创建新用户
     * @return User
     */
    public static function createUser()
    {
        $model = new User();
        $model->LoginId = substr(md5(Yii::$app->request->csrfToken),8,16);
        $model->State = 1;
        $model->CreatedTime = $model->LastLogin = date('Y-m-d H:i:s');
        $model->save();
        return $model;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord){
                $this->State = 1;
                $this->CreatedTime = $this->LastLogin = date('Y-m-d H:i:s');
            }else
                $this->LastLogin = date('Y-m-d H:i:s');
            return true;
        } else {
            return false;
        }
    }
}

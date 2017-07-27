<?php

namespace common\models;

use Yii;
use common\models\Tools;
/**
 * This is the model class for collection "account".
 *
 * @property \MongoId|string $_id
 * @property mixed $uid
 * @property mixed $key
 * @property mixed $idkey
 * @property mixed $asset
 * @property mixed $cny
 * @property mixed $data
 */
class Account extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['jubi', 'account'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'uid',
            'key',
            'idkey',
            'asset',
            'cny',
            'data',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'key', 'idkey', 'asset', 'cny', 'data'], 'safe']
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
            'key' => 'Key',
            'idkey' => 'Idkey',
            'asset' => 'Asset',
            'cny' => 'Cny',
            'data' => 'Data',
        ];
    }
    public static function getKey()
    {
        return 'zs77t-ryq3n-cqrn2-cy39g-r83nw-426xe-2w793';
    }
    public static function getIdKey()
    {
        $idkey =  md5('~!4W5-V7[CX-,;U^6-dPpjp-ftrun-Xye*Q-m*OrQ');
        return $idkey;
    }

    public static function getNonce()
    {
        return microtime(true)*10000;
    }

    public static function getUid()
    {
        return 582018;
    }

    public static function getCoinNum($uid,$coin)
    {
        $account = Account::getAccount($uid);
        foreach($account->data as $k=>$v)
        {
            if($v['name'] == $coin)
            {
                return $v['count'];
            }
        }
    }

    public static function getAccount($uid = null)
    {
        if($uid)
        {
            $model = Account::findOne(['uid'=>$uid]);
            return $model;
        }
        $url = 'https://www.jubi.com/api/v1/balance/';
        $nonce = self::getNonce();
        $params = ['key'=>self::getKey(),'nonce'=>$nonce];
        $str = http_build_query($params);
        $signature = hash_hmac("sha256",$str,self::getIdKey());
        $params['signature'] = $signature;
        $page = Tools::send_post($url,$params);
        $data = json_decode($page,true);
        $account = [];
        $account['uid'] = $data['uid'];
        $account['key'] = 'ni5su-g43bt-zqknh-xs3cx-rxj36-ciaph-ub1z4';
        $account['idkey'] = self::getIdKey();
        $account['asset'] = $data['asset'];//RMB
        $account['cny']  = $data['cny_balance'];//RMB
        foreach($data as $k=>$num){
            if((strpos($k,'balance') != false || strpos($k,'lock') != false) && $num>1) {
                if(strpos($k,'balance') != false)
                    $coin = str_replace('_balance','',$k);
                else if(strpos($k,'lock') != false)
                    $coin = str_replace('_lock','',$k);
                if($num>0.1){
                    $myticket['name'] = $coin;
                    $myticket['count'] = $num;
                    $account['data'][] = $myticket;
                }
            }
        }

        $model = Account::findOne(['uid'=>$account['uid']]);
        if(!$model){
            $model = new Account();
            $model->attributes = $account;
            $model->save();
        }else{
            Account::updateAll($account,['_id'=>$model->_id]);
            $model=Account::findOne(['_id'=>$model->_id]);
        }
        return $model;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: living
 * Date: 12/29/15
 * Time: 4:56 PM
 */

namespace common\models;

use Yii\web\Cookie;
use Yii;

class Tools
{

    /**
     * 获取参数
     */
    public static function getParam($name,$default='',$method='get')
    {
        if($method == 'post')
            $var = filter_input(INPUT_POST, $name, FILTER_SANITIZE_SPECIAL_CHARS);
        else
            $var = filter_input(INPUT_GET, $name, FILTER_SANITIZE_SPECIAL_CHARS);
        if(is_null($var))
            $var = $default;
        return $var;
    }
    /**
     * 获取get数组参数
     */
    public static function getArrayParam($name,$default='',$method='get')
    {
        if($method=='get')
            return isset($_GET[$name])?$_GET[$name]:$default;
        else
            return isset($_POST[$name])?$_POST[$name]:$default;
    }
    /**
     * 获取手机系统
     * @return string
     */
    public static function mobileOS()
    {
        $useragent = strtolower($_SERVER["HTTP_USER_AGENT"]);
        // iphone
        $is_iphone = strripos($useragent, 'iphone');

        $is_ios = strripos($useragent, 'ios');
        $is_ipad = strripos($useragent, 'ipad');
        $is_ipod = strripos($useragent, 'ipod');

        if ($is_iphone || $is_ios || $is_ipad || $is_ipod) {
            return 'ios';
        }
        // android
        $is_android = strripos($useragent, 'android');
        if ($is_android) {
            return 'android';
        }
        return 'other';
    }

    public static function jsonOut($array)
    {
        $str = '';
        if (is_array($array))
            $str = json_encode($array);
        else {
            $arrays = array($array);
            $str = json_encode($arrays);
        }
        exit($str);
    }

    /**
     * jsonpout
     * array to json and output jsonp
     */
    public static function jsonpOut($data)
    {
        $callback = Yii::$app->getRequest()->getQueryParam('callback');
        echo $callback . '(' . json_encode($data) . ');';
        exit;
    }

    /**
     * 设置cookie
     */
    public static function TCookie($key, $val = null, $time = 31536000)
    {
        $obj = "";
        if (empty($val)) {
            $obj = Yii::$app->request->cookies->get($key);
        } else {
            $cookie = new \yii\web\Cookie([
                'name' => $key,
                'value' => $val,
                'expire' => time() + $time
            ]);
            $obj = Yii::$app->response->cookies->add($cookie);
        }
        return $obj;
    }

    public static function FormatKm($m)
    {
        $strlen = strlen($m);
        $unit = 'm';
        if ($strlen > 3) {
            $m = round($m / 1000, 2);
            $unit = 'km';
        }
        return array('m' => $m, 'unit' => $unit);
    }



    /**
     * 设置cache
     */
    public static function TCache($key, $val = null, $time = 31536000)
    {
        $TCache = Yii::$app->cache;
        if (empty($val)) {
            $cacheData = $TCache->get($key);
            return $cacheData;
        } else {
            if ($val)
                $cacheData = $TCache->set($key, $val, $time);
        }
    }

    /**
     * 设置cache
     */
    public static function TFile($key, $val = null)
    {
        $file = dirname(Yii::$app->basePath). '/forms/'.$key;
        if($val)
        {
            $myfile = fopen($file, "w") or die("Unable to open file!");
            fwrite($myfile, $val);
            fclose($myfile);
        }else{
            $val = file_get_contents($file);
            return $val;
        }
    }

    public static function TCacheDel($key)
    {
        $TCache = Yii::$app->cache;
        $TCache->delete($key);
    }

    /**
     * ip地址国别判断
     */
    public static function getCountryByIp($ip = null)
    {
        $country = Tools::TCookie('country');
        if (!$country) {
            $country = 'en';
            $ip = $ip ? $ip : Yii::app()->request->userHostAddress;
            if ($ip == '127.0.0.1')
                return 'cn';
            $c = Yii::$app->ip2location->getCountryCode($ip);
            if(strtolower($c) == 'cn')
                $country = 'cn';
            /*
            //阿里ip地址判断
            $url = 'http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip;
            $opts = array(
                'http' => array(
                    'method' => "GET",
                    'timeout' => 3,//单位秒
                )
            );
            $page = file_get_contents($url, false, stream_context_create($opts));
            if ($page) {
                $chinaIPS = array('cn', 'hk', 'tw');
                $pageArray = json_decode($page, true);
                $country_id = isset($pageArray['data']['country_id']) ? strtolower($pageArray['data']['country_id']) : "en";
                if (in_array($country_id, $chinaIPS)) {
                    $country = 'cn';
                } else
                    $country = 'en';
            }
            */
            Tools::TCookie('country', $country);
        }
        return $country;
    }

    public static function getLg()
    {
        return Yii::$app->language ? Yii::$app->language : self::TCookie('lg');
    }


    public static function remote($tmpurls, $reffer = null, $header = true, $charset = null, $encoding = "", $httpheader = "",$postdata='')
    {
        $urls = array();
        if ($tmpurls && !is_array($tmpurls)) {
            $urls[$tmpurls] = $tmpurls;
        } else if (is_array($tmpurls)) {
            $urls = $tmpurls;
        } else {
            return false;
        }

        /**
         * 判断是否启动了cache
         * 由于是一次获取的，此处可以通过统一判断，即要存在都存在，不存在就都不存在
         */


        $user_agents = array(
            "Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/6.0)", //来路
            "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:35.0) Gecko/20100101 Firefox/35.0", //来路
            "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)", //来路
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.2; Trident/6.0)", //来路
            "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)", //来路
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/6.0)", //来路
        );
        $user_agent = $user_agents[rand(0, 5)];
        $curl = $text = array();
        $handle = curl_multi_init();
        foreach ($urls as $k => $v) {
//         $nurl[$k]= preg_replace('~([^:\/\.]+)~ei', "rawurlencode('\\1')", $v);
            $nurl[$k] = $v;
            $curl[$k] = curl_init($nurl[$k]);
            curl_setopt($curl[$k], CURLOPT_HEADER, $header);
            if ($httpheader)
                curl_setopt($curl[$k], CURLOPT_HTTPHEADER, $httpheader);
            curl_setopt($curl[$k], CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl[$k], CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl[$k], CURLOPT_NOBODY, false);

            if ($encoding)
                curl_setopt($curl[$k], CURLOPT_ENCODING, $encoding);
            if ($reffer)
                curl_setopt($curl[$k], CURLOPT_REFERER, $reffer); //来路地址
            curl_setopt($curl[$k], CURLOPT_USERAGENT, $user_agent);
            $timeout = 30;
            curl_setopt($curl[$k], CURLOPT_TIMEOUT, $timeout); //过期时间
            if($postdata)
            {
                curl_setopt($curl[$k], CURLOPT_POST, 1);//post方式提交
                curl_setopt($curl[$k], CURLOPT_POSTFIELDS, $postdata);//要提交的信息
            }



            curl_multi_add_handle($handle, $curl[$k]);
        }

        $active = null;
        do {
            $mrc = curl_multi_exec($handle, $active);
        } while ($active);


        foreach ($curl as $k => $v) {
            if (curl_error($curl[$k]) == "") {

                if ($charset) {
                    $texttmp = (string)curl_multi_getcontent($curl[$k]);
//            		$text[$k] = mb_convert_encoding($texttmp, "utf-8",$charset);
                    $text[$k] = html_entity_decode(mb_convert_encoding($texttmp, 'UTF-8', $charset), ENT_QUOTES, 'UTF-8');
                } else {
                    $texttmp = (string)curl_multi_getcontent($curl[$k]);
                    $p = '/http-equiv="Content-Type" content="(.*?)"/';
                    preg_match($p, $texttmp, $out);
                    $tmp = isset($out[1]) ? strtolower($out[1]) : "";
                    $p2 = '/charset=(.*)/';
                    preg_match($p2, $tmp, $out2);
                    $charset = isset($out2[1]) ? strtolower($out2[1]) : "UTF-8";
                    if (strpos($charset, 'utf'))
                        $text[$k] = $texttmp;
                    else {
                        $text[$k] = html_entity_decode(mb_convert_encoding($texttmp, 'UTF-8', $charset), ENT_QUOTES, 'UTF-8');
                    }
                }
            }
            curl_multi_remove_handle($handle, $curl[$k]);
            curl_close($curl[$k]);
        }
        curl_multi_close($handle);
        return $text;
    }

    /**
     * 模拟post进行url请求
     * @param string $url
     * @param string $param
     */
    public  static function request_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {
            return false;
        }

        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        return $data;
    }

    public static function  curl_post_302($url) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL,  $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        $data = curl_exec($ch);
        $Headers =  curl_getinfo($ch);
        curl_close($ch);
        if ($data != $Headers){
            return $Headers["redirect_url"];
        }else{
            return false;
        }

    }

    ////获得访客浏览器语言
    public static function Get_Lang()
    {
        $lang = 'en';
        if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $str = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
            $str = substr($str, 0, 5);
            if(preg_match("/zh/i", $str)) {
                $lang = "cn";
            }
        }
        return $lang;
    }

    public static function formatInfos($info)
    {
        $tmp = str_replace(array('lng', 'lat','r'), array('"lng"','"lat"','"r"'), $info);
        $tmp = '{'.$tmp.'}';
        $infos = json_decode($tmp,true);
        if(isset($infos['lat']))
        {
            $infos['lat'] = round($infos['lat'],3);
            $infos['lng'] = round($infos['lng'],3);
        }
        return $infos;
    }

    /**
     * get Month By Date
     * @param null $date
     * @return array
     */
    public static function getMonth($sdate = null,$edate = null,$day=29)
    {
        $sdate = $sdate?strtotime($sdate):strtotime(' -'.$day.' day');
        $edate = $edate?strtotime($edate):time();
        $result = array();
        for($i=$sdate;$i<=$edate;$i=$i+86400)
        {
            $result[] = date('Ymd',$i);
        }
        return $result;
    }


    public static function getBestZoomlevel($distance) {
        $r = $distance/(1128.497220 * 0.0027);
        return 21-round(log($r,2),2);
    }

    /**
     * 根据输入的地点坐标计算中心点（适用于400km以下的场合）
     */

    public static function  GetCenterPointFromListOfCoordinates($geoCoordinateList)
    {
        //以下为简化方法（400km以内）
        $total = count($geoCoordinateList);
        $lat = $lon = 0;
        foreach ($geoCoordinateList as $k => $g) {
            if($g['lng']>=73.66 && $g['lng']<=135.05 && $g['lat']>=3.86 && $g['lat']<=53.55)
            {
                $lat += $g['lat'] * PI() / 180;
                $lon += $g['lng'] * PI() / 180;
            }else{
                $total--;
            }
        }
        $lat = $lat / $total;
        $lon = $lon / $total;
        return array('lat' => $lat * 180 / PI(), 'lng' => $lon * 180 / PI());
    }

    public static function asyncjob($asyurl, $host, $port)
    {
        $fp = fsockopen($host, $port, $errno, $errstr, 1);
        if (!$fp) {
            //todo
            //file_put_contents(APPLICATION_PATH.'/data/err_'.self::getClient(), $asyurl."\n", FILE_APPEND);
            //self::reportException($errno, $errstr);
            return 0;
        } else {
            $out = "GET $asyurl HTTP/1.1\r\n";
            $out .= "Host: $host\r\n";
            $out .= "Connection: Close\r\n\r\n";
            fputs($fp, $out);
            fclose($fp);
            return 1;
            //file_put_contents(APPLICATION_PATH.'/data/success_'.self::getClient(), $asyurl."\n", FILE_APPEND);
        };
    }

    public static function getIp()
    {
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];
        else if (isset($_SERVER['HTTP_X_REAL_IP']) && $_SERVER['HTTP_X_REAL_IP'] && strcasecmp($_SERVER['HTTP_X_REAL_IP'], "unknown"))
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        else
            $ip = "unknown";
        return ($ip);
    }

    public static function makeTokenBySTID($stid, $username)
    {

//		$finduser = Model_lUserMgt::find ( $urid );
        $strname = md5($username);
        $strshort = substr($strname, 0, 3);
        $newid = $stid * 983 + 1013;
        //$strhex = dechex ( $newid );
        $strhex = self::Num2Str($newid);
        $str = $strshort . $strhex;
        return $str;
    }

    public static function Str2Num($str)
    {
        $remain = $str;
        $num = 0;
        while ($remain) {
            $c = substr($remain, 0, 1);
            $mod = ord($c);
            if ($mod < 91) {
                $n = $mod - 65;
            } else {
                $n = $mod - 97 + 26;
            }
            $remain = substr($remain, 1);
            $num += $n * pow(52, strlen($remain));
        }
        return $num;
    }

    public static function Num2Str($num)
    {
        $remain = $num;
        $str = "";
        while ($remain > 0) {
            $mod = $remain % 52;
            if ($mod < 26) {
                $c = chr($mod + 65);
            } else {
                $c = chr($mod - 26 + 97);
            }
            $str = $c . $str;
            $remain = intval(($remain - $mod) / 52);
        }
        return $str;
    }

    public static function getURIDByToken($token)
    {
        if (strlen($token) < 5) {
            return 0;
        }
        $strhex = substr($token, 3);
        //$newid = hexdec($strhex);
        $newid = self::Str2Num($strhex);
        $newid -= 1013;
        if ($newid % 983 == 0) {
            $stid = $newid / 983;
        } else {
            return 0;
        }
        return $stid;
    }

    /**
     * 整数加密
     * @param $num
     * @param $key
     * @return string
     */
    public static function encodeNum($num, $key=null)
    {
        if(empty($key))
        {
            $s = time();
            $key = md5($s);
            $strshort = substr($key, 0, 3);
        }else
            $strshort = substr($key, 0, 3);

        $newid = $num * 983 + 1013;
        $strhex = self::Num2Str($newid);
        $str = $strshort . $strhex;
        return $str;
    }

    /**
     * 整数揭秘
     * @param $str
     * @return float|int
     */
    public static function decodeNum($str)
    {
        if (strlen($str) < 5) {
            return 0;
        }
        $strhex = substr($str, 3);
        $newid = self::Str2Num($strhex);
        $newid -= 1013;
        if ($newid % 983 == 0) {
            $num = $newid / 983;
        } else {
            return 0;
        }
        return $num;
    }

    /**
     * 字符串加密
     * @param $arr
     * @return string
     */
    public static function encodeStr($decodestr)
    {
        $str = 'adfasdfasfsfohjkhfiwuykfhskfayfiusyidfy';
        return substr($str,rand(0,strlen($str)),2).base64_encode('loco'.base64_encode($decodestr).'lsn');
    }

    /**
     * 字符串解密
     * @param $decodestr
     * @return string
     */
    public static function decodeStr($encodestr)
    {
        $str = 'adfasdfasfsfohjkhfiwuykfhskfayfiusyidfy';
        $encodestr = substr($encodestr,2);
        $encodestr = base64_decode($encodestr);
        $encodestr = substr($encodestr,4);
        $encodestr = substr($encodestr,0,strlen($encodestr)-3);
        $encodestr = base64_decode($encodestr);
        return $encodestr;
    }


    /**
     *
     * @param $k
     * @param null $v
     * @param null $timeout
     * @return mixed|void
     */
    public static function TSession($k,$v=null,$timeout=null)
    {
        $session = Yii::$app->session;
        if($v)
            $session->set($k,$v);
        else
        {
            if($session->has($k))
            {
                return $session->get($k);
            }
        }
        if($timeout)
            $session->timeout = $timeout;
        return ;

    }

    /**
     *
     * @param $k
     * @param null $v
     * @param null $timeout
     * @return mixed|void
     */
    public static function TSessionDel($k=null)
    {
        $session = Yii::$app->session;
        if($k)
        {
            if($session->has($k))
            {
                return $session->destroySession($k);
            }
        }else{
            return $session->destroy();
        }

        return ;

    }


    /**图片上传
     * @param $image
     * @param null $post
     * @return string|void
     */
    public static function uploadimg($image,$post = null)
    {
        if(empty($image))
            return ;
        $arg1 = "&urid=-1021";
        $arg2 = "&login_id=android.com";
        $arg3 = "&v=0.0.1";
        $arg4 = "&udid=0";
        $arg5 = "&type=2";
        $arg6 = "&compress=no";
        $urlcons = "http://sh.loco-app.com:8000/file/upload?os=pc".$arg1.$arg2.$arg3.$arg4.$arg5.$arg6;
        if(!$post)
            $post = file_get_contents($image->tempName);
        $ch = curl_init();//初始化curl
        curl_setopt($ch,CURLOPT_URL, $urlcons);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        $data = json_decode($data,true);
        print_r($data);
        if($data['errno'] == 0)
            return $data['url'];
        else
            return "";
    }

    public static function uploadPic($images,$origin = 0)
    {
        $return = array();
        foreach($images as $k=>$image)
        {
            $arg1 = "&urid=-1021";
            $arg2 = "&login_id=android.com";
            $arg3 = "&v=0.0.1";
            $arg4 = "&udid=0";
            $arg5 = "&type=2";
            if($origin)
                $arg6 = "&origin=".$origin;
            else
                $arg6 = "&compress=no";
            $urlcons = "http://sh.loco-app.com:8000/file/upload?os=pc".$arg1.$arg2.$arg3.$arg4.$arg5.$arg6;
//            echo $urlcons;exit;
            $post = file_get_contents($image->tempName);
            $sizes = getimagesize($image->tempName);
            $info = round($sizes[0]/$sizes[1],2);
            $ch = curl_init();//初始化curl
            curl_setopt($ch,CURLOPT_URL, $urlcons);//抓取指定网页
            curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
            curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $data = curl_exec($ch);//运行curl
            curl_close($ch);
            $upreturn = json_decode($data,true);
            if(isset($upreturn['url']) && $upreturn['url']){
                $img = array('url'=>$upreturn['url'],'name'=>$image->name,'size'=>$image->size,
                    'type'=>$image->type,'original'=>$image->name,'info'=>'r:'.$info,'ctime'=>time());
                $return[] = $img;
            }
        }
        return $return;
    }

    public static function uploadRes($files,$origin = 0)
    {
        $return = array();
        foreach($files as $k=>$file)
        {
            $arg1 = "&urid=-1021";
            $arg2 = "&login_id=android.com";
            $arg3 = "&v=0.0.1";
            $arg4 = "&udid=0";
            $arg5 = "&type=2";
            $arg6 = "&compress=no";
            $arg6 = "&origin=".$origin;
            $urlcons = "http://sh.loco-app.com:8000/file/uploadres?os=pc".$arg1.$arg2.$arg3.$arg4.$arg5.$arg6;
//            echo $urlcons;exit;
            $post = file_get_contents($file->tempName);
            $ch = curl_init();//初始化curl
            curl_setopt($ch,CURLOPT_URL, $urlcons);//抓取指定网页
            curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
            curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $data = curl_exec($ch);//运行curl
            curl_close($ch);
            $upreturn = json_decode($data,true);
            if(isset($upreturn['url']) && $upreturn['url']){
                $img = array('url'=>$upreturn['url'],'name'=>$file->name,'size'=>$file->size,
                    'type'=>$file->type,'original'=>$file->name);
                $return[] = $img;
            }
        }
        return $return;
    }


    public  static function uploadFile($file,$type,$act="create",$fileurl='',$filename=null){

        if(!empty($fileurl)&&$act==='update'){
            $deleteFile=Yii::app()->basePath.'/../'.$fileurl;
            if(is_file($deleteFile))
                unlink($deleteFile);
        }
        $uploadDir=Yii::$app->basePath.'/../Uploads/'.$type;
        self::recursionMkDir($uploadDir);
        if(!$filename)
            $filename=time().'-'.rand() . '.'.$file->extensionName;
        $uploadPath=$uploadDir.'/'.$filename;
        $filePath='/uploads/'.$type.'/'.$filename;
        file_put_contents($uploadPath,$file); // 上传图片
        return $filePath;
    }
    public static function recursionMkDir($dir){
        if(!is_dir($dir)){
            if(!is_dir(dirname($dir))){
                self::recursionMkDir(dirname($dir));
                mkdir($dir,'0777');
            }else{
                mkdir($dir,'0777');
            }
        }
    }



    public static function makeRange($location)
    {
        $lat = $location['lat'];
        $lng = $location['lng'];
        $dis = $location['dist'];  //meter
        $lat_dist = round($dis * 10000 / 111000);
        $lat_min = (round($lat * 10000) - $lat_dist) / 10000;
        $lat_max = (round($lat * 10000) + $lat_dist) / 10000;
        $lng_dist = round($dis * 10000 / (111000 * cos(deg2rad($lat))));  //geyingjun modified
        $lng_min = (round($lng * 10000) - $lng_dist) / 10000;
        $lng_max = (round($lng * 10000) + $lng_dist) / 10000;
        $range['lat_min'] = $lat_min;
        $range['lat_max'] = $lat_max;
        $range['lng_min'] = $lng_min;
        $range['lng_max'] = $lng_max;
        return $range;
    }


    /**
     * 计算两点地理坐标之间的距离
     * @param  Decimal $longitude1 起点经度
     * @param  Decimal $latitude1  起点纬度
     * @param  Decimal $longitude2 终点经度
     * @param  Decimal $latitude2  终点纬度
     * @param  Int     $unit       单位 1:米 2:公里
     * @param  Int     $decimal    精度 保留小数位数
     * @return Decimal
     */
    public static function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit=2, $decimal=2){
        $EARTH_RADIUS = 6370.996; // 地球半径系数
        $PI = 3.1415926;
        $radLat1 = $latitude1 * $PI / 180.0;
        $radLat2 = $latitude2 * $PI / 180.0;
        $radLng1 = $longitude1 * $PI / 180.0;
        $radLng2 = $longitude2 * $PI /180.0;
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $distance = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
        $distance = $distance * $EARTH_RADIUS * 1000;
        if($unit==2){
            $distance = $distance / 1000;
        }
        return round($distance, $decimal);
    }

    public static function getBestZoomlevelByLatLng($latlngs)
    {
        $zoom = 14;

        if(count($latlngs)>1)
        {
            $dist = 0;
            foreach($latlngs as $k=>$v)
            {
                foreach($latlngs as $kk=>$vv)
                {
                    if($k!=$kk)
                    {
                        if(!$v['lng'] || $v['lat'] || $vv['lng'] || $vv['lat'])
                            continue;
                        $d =  self::getDistance($v['lng'],$v['lat'],$vv['lng'],$vv['lat'],1);
                        if($d>$dist)
                            $dist = $d;
                    }
                }
            }
            if($dist>0)
            {
                $zoom = self::getBestZoomlevel($dist);
                $zoom = ceil($zoom);
            }
        }
        return $zoom;
    }

    public static function getHowWeek($time)
    {
        $re = '';
        $weekarray=array("日","一","二","三","四","五","六");
        if(Yii::$app->language =='cn')
            $re = "星期".$weekarray[date("w",$time)];
        else
            $re = date('l',$time);
        return $re;
    }
    public static function getHost()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'];
        return $host;
    }


    public  static function getUrlArray($url=null)
    {
        if(!$url)
            return ;
        $querys = parse_url($url);
        $query = $querys['query'];
        $queryParts = explode('&', $query);
        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }
    /**
     * 将参数变为字符串
     * @param $array_query
     * @return string string 'm=content&c=index&a=lists&catid=6&area=0&author=0&h=0®ion=0&s=1&page=1'(length=73)
     */
    public static  function getUrlQuery($array_query)
    {
        $tmp = array();
        foreach($array_query as $k=>$param)
        {
            $tmp[] = $k.'='.$param;
        }
        $params = implode('&',$tmp);
        return $params;
    }

    /**
     * 格式化日期
     * @param $time
     * @return string
     */
    public static function format_date($time,$op=1){
        if(!is_numeric($time)){
            $time=strtotime($time);
        }
        if($time<=0)
            return '';
        if($op == 1)
            $t=time()-$time;
        else
            $t=$time - time();
        $f=array(
//            '31536000'=>'年',
//            '2592000'=>'个月',
//            '604800'=>'星期',
            '86400'=>'天',
            '3600'=>'小时',
//            '60'=>'分钟',
//            '1'=>'秒'
        );
        $str = '';
        foreach ($f as $k=>$v)
        {
            if (0 !=$c=floor($t/(int)$k)) {
                if($k == 86400)
                    $t -= $c*86400;
                else if($k == 3600)
                    $t -= $c*3600;
                $str .= '<span class="pink">'.$c.'</span>'.$v;
            }
        }
        return $str;
    }

    public static function transformLat($x, $y)
    {
        $lat = -100.0 + 2.0 * $x + 3.0 * $y + 0.2 * $y * $y + 0.1 * $x * $y + 0.2 * sqrt(abs($x));
        $lat += (20.0 * sin(6.0 * $x * pi()) + 20.0 * sin(2.0 * $x * pi())) * 2.0 / 3.0;
        $lat += (20.0 * sin($y * pi()) + 40.0 * sin($y / 3.0 * pi())) * 2.0 / 3.0;
        $lat += (160.0 * sin($y / 12.0 * pi()) + 320 * sin($y * pi() / 30.0)) * 2.0 / 3.0;
        return $lat;
    }

    public static function transformLon($x, $y)
    {
        $lon = 300.0 + $x + 2.0 * $y + 0.1 * $x * $x + 0.1 * $x * $y + 0.1 * sqrt(abs($x));
        $lon += (20.0 * sin(6.0 * $x * pi()) + 20.0 * sin(2.0 * $x * pi())) * 2.0 / 3.0;
        $lon += (20.0 * sin($x * pi()) + 40.0 * sin($x / 3.0 * pi())) * 2.0 / 3.0;
        $lon += (150.0 * sin($x / 12.0 * pi()) + 300.0 * sin($x / 30.0 * pi())) * 2.0 / 3.0;
        return $lon;
    }

    public static function isInChina($flat, $flng)
    {
        return true;
        //暂时都是true
        $data = self::searchgeo3($flat, $flng);
        if(!empty($data))
        {
            if($data[0]['ID_0'] == 49)
                return true;
        }

        return false;
    }

    /**
     *
     * @param $lat
     * @param $lng
     * @param $flag
     * @return mixed
     */
    public static function adjust_china($lat, $lng, $flag)
    {
        $ee = 0.00669342162296594323;
        $a = 6378245.0;

        $ret['lat'] = $lat;
        $ret['lng'] = $lng;

        if(!self::isInChina($lat, $lng))
        {
            return $ret;
        }
        $adjustLat = self::transformLat($lng - 105.0, $lat - 35.0);
        $adjustLng = self::transformLon($lng - 105.0, $lat - 35.0);


        $radLat = $lat / 180.0 * pi();
        $magic = sin($radLat);
        $magic = 1 - $ee * $magic * $magic;
        $sqrtMagic = sqrt($magic);
        $adjustLat = ($adjustLat * 180.0) / (($a * (1 - $ee)) / ($magic * $sqrtMagic) * pi());
        $adjustLng = ($adjustLng * 180.0) / ($a / $sqrtMagic * cos($radLat) * pi());
        if($flag)
        {
            $ret['lat'] = $lat + $adjustLat;
            $ret['lng'] = $lng + $adjustLng;
        }
        else
        {
            $ret['lat'] = $lat - $adjustLat;
            $ret['lng'] = $lng - $adjustLng;
        }

        return $ret;
    }

    public static function is_weixin()
    {
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            return true;
        }
        return false;
    }

    public static function is_qq()
    {
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'QQ') !== false ) {
            return true;
        }
        return false;
    }

    public static function httpcopy($url, $file = '', $timeout = 60)
    {
        $result = '';
        if ($file) {
            $file = empty($file) ? pathinfo($url, PATHINFO_BASENAME) : $file;
            $dir = pathinfo($file, PATHINFO_DIRNAME);
            !is_dir($dir) && @mkdir($dir, 0755, true);
        }
        $url = str_replace(' ', "%20", $url);
        $url = urldecode($url);
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $temp = curl_exec($ch);
            if (!curl_error($ch)) {
                if ($file)
                    @file_put_contents($file, $temp);
                $result = $temp;
            }
        } else {
            $opts = array(
                'http' => array(
                    'method' => 'GET',
                    'header' => '',
                    'timeout' => $timeout
                )
            );
            $context = stream_context_create($opts);
            if ($file && @copy($url, $file, $context)) {
                $result = $context;
            }
        }
        return $result;
    }

    /**
     * 内网IP
     * @param $ip
     * @return bool
     */
    public  static  function isneiwang($ip) {
        $i = explode('.', $ip);
        if ($i[0] == 10) return true;
        if ($i[0] == 172 && $i[1] > 15 && $i[1] < 32) return true;
        if ($i[0] == 192 && $i[1] == 168) return true;
        return false;
    }


    /**
     * 发送post请求
     * @param string $url 请求地址
     * @param array $post_data post键值对数据
     * @return string
     */
    public  static function send_post($url, $post_data) {
        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return $result;
    }

    /**
     * 发送post请求
     * @param string $url 请求地址
     * @param array $post_data post键值对数据
     * @return string
     */
    public  static function send_get($url) {
        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Content-type:application/x-www-form-urlencoded',
//                'content' => $postdata,
                'timeout' => 15 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

    public static function Log($k,$v)
    {
        $myfile = fopen("/tmp/log.log", "a+");
        $txt = $k.":".$v."\n";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    /**
     * 发送post请求
     * @param string $url 请求地址
     * @param array $post_data post键值对数据
     * @return string
     */
    public  static function getUrl($url,$params =[]) {
        $postdata = http_build_query($params);
        $url .= $postdata?'?'.$postdata:'';
        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Content-type:application/x-www-form-urlencoded',
//                'content' => $postdata,
                'timeout' => 15 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
}
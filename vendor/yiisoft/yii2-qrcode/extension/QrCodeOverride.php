<?php
    namespace dosamigos\qrcode\extension;

    use Imagine\Gd\Font;
    use Imagine\Image\Box;
    use Imagine\Image\Color;
    use Imagine\Image\Point;
    use yii\imagine\Image;
    use dosamigos\qrcode\QrCode;


    /**
     * $Object = new QrCodeOverride([
     *  'text'    => $this->getQrCodeText(),
     *  'outfile' => $FullFilePath,
     *  'level'   => 0,
     *  'size'    => 100,
     *  'margin'  => 0
     *  ],'jpg');
     *
     * 生成原始的二维码成功
     * if(!$Object->CreateQrCode()){
     *    return false;
     *  }
     *  $Object->run($this->title."( ID:".$this->id." )",'bottom')
     *
     * Class QrCodeOverride
     * @package dosamigos\qrcode\extension
     */
    class QrCodeOverride{

        public $type = 'jpg'; //二维码格式

        public $QrCodeOption;   //二维码生成代码

        public $FontFile;    //文字字体

        public $Color = '#000000';  //文字颜色

        public $FontSize = 50;  //文字大小

        public $Override = 70;  //比原来二维码超出多少像素

        public $FontMargin = 0;  //文字与头部之间的区间

        public $LineTextNumner = 30;    //一行只能写入多少字符

        private $outFile = false;    //最终保存的文件

        /**
         * @param array $option
         * @param $type
         */
        public function __construct($option = [],$type){
            $this->QrCodeOption = $option;
            if($option){
                $this->outFile = $option['outfile'];
            }

            if(in_array($type,['jpg','png'])){
                $this->type = $type;
            }

            $this->FontFile = __DIR__."/../font/Black.ttf";
        }

        /**
         * 根据QrCodeOption生成原始的二维码文件
         */
        public function CreateQrCode(){
             $option = $this->QrCodeOption;

//             if($this->outFile){
//                 $filePathInfo = pathinfo($option['outfile']);
//
//                 $option['outfile'] = $filePathInfo["dirname"].'/'.md5($option['outfile']).rand(1,100).".".$filePathInfo['extension'];
//                 $this->QrCodeOption['outfile'] = $option['outfile'];
//             }

             call_user_func_array(array("\dosamigos\qrcode\QrCode",$this->type),$option);

             if(!file_exists($option['outfile'])){
                return false;
             }

            return true;
        }

        /**
         * 获取一个存在的图片实例
         * @param $File
         * @return \Imagine\Image\ImageInterface
         */
        public function OpenImage($File){
            return Image::getImagine()->open($File);
        }

        /**
         * 获取当前已经拥有的图片实例
         * @return \Imagine\Image\ImageInterface
         */
        public function getOriginalQrImage(){
            return $this->OpenImage($this->QrCodeOption['outfile']);
        }

        /**
         * 写入文字
         * @param $draw
         * @param $FontPoints
         */
        public function writeText($draw,$FontPoints){
            foreach($FontPoints as $FontPoint){
                $Color = new Color($this->Color);
                $Font = new Font($this->FontFile,$this->FontSize,$Color);

                $draw->text($FontPoint['text'],$Font,$FontPoint['point']);
            }

            return $draw;
        }

        /**
         * 字符串切割
         * @param $OverrideText
         * @param string $encode
         * @return array
         */
        public function StringSbuStr($OverrideText,$encode = 'utf8'){
            $strlen = mb_strlen($OverrideText,$encode);
            if($strlen <=$this->LineTextNumner) return [$OverrideText];

            $num = ceil($strlen/$this->LineTextNumner);
            $Re = [];
            for($i=1;$i<=$num;$i++){
                $Re[] = mb_substr($OverrideText,($i-1)*$this->LineTextNumner,$this->LineTextNumner,$encode);
            }
            return $Re;
        }

        /**
         * 重载图片 并且写入对应的值
         * @param $OverrideText
         * @param $Orientation
         * @return bool
         */
        public function run($OverrideText,$Orientation){
            $QrCodeImage = $this->getOriginalQrImage();

            $height = $QrCodeImage->getSize()->getHeight();    //宽度
            $width  = $QrCodeImage->getSize()->getWidth();    //宽度;

            $strlen   = mb_strlen($OverrideText,'utf8');
            $Line = ceil($strlen/$this->LineTextNumner);

            $SubString = $this->StringSbuStr($OverrideText);
            $FontPoints = [];

            //打水印
            switch($Orientation){
                case 'bottom':
                    $Box   = new Box($width,$height+$this->Override*$Line);
                    $Point = new Point(0,0);

                    foreach($SubString as $key =>$text){
                        $FontPoints[]=[
                            'text'  => $text,
                            'point' => new Point(0,$height+$this->FontMargin+(($this->FontSize+$this->FontMargin)*$key))
                        ];
                    }

                    break;
                case 'top':
                    $Box   = new Box($width,$height+$this->Override*$Line);
                    $Point = new Point(0,0+$this->Override);

                    foreach($SubString as $key =>$text){
                        $FontPoints[]=[
                            'text'  => $text,
                            'point' => new Point(0,0+$this->FontSize*$key)
                        ];
                    }

                    break;
            }

            //重载新的图片
            $newQrCodeImage = Image::getImagine()->create($Box);
            $newQrCodeImage->paste($QrCodeImage,$Point);

            //写入文字
            $draw = $newQrCodeImage->draw();
            $this->writeText($draw,$FontPoints);

            $newQrCodeImage->save($this->outFile);

            @unlink($this->QrCodeOption['outfile']);

            return $this->outFile;
        }


    }
# yii2-qrcode
基于yii2-qrcode-helper写的二维码扩展,加入了二维码图片重写的功能,如果你想在二维码图片上面或者下面写入文字信息，可以使用本扩展
## 关于yii2-qrcode-helper
你可以在这里查看[yii2-qrcode-helper](https://github.com/2amigos/yii2-qrcode-helper)相应的信息
##依赖
图片操作部分依赖[Imagine](https://github.com/yiisoft/yii2-imagine)扩展
##使用
    use dosamigos\qrcode\extension\QrCodeOverride;
    
    $Object = new QrCodeOverride([生成原始二维码的参数],'jpg或者Png');
    $Object->CreateQrCode() //生成原始的二维码
    $Object->FontSize = 30; //设置文字对应的属性
  
    $Object->run("写入文字",'bottom');

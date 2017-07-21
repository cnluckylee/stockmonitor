<?php
return [
    'cdn_website'=>'http://backend.dhhtrade.com',
    'alipay'=>[
        'app_id' => "2017062607572094",

        //商户私钥，您的原始格式RSA私钥
        'merchant_private_key' => "MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCGRNs3InJBGXsZLhrqDs3CjxLc5FunoQN7pZUJa2NJVJeT4kTnyjwNu1PC1QAJdtwavBv+zOCCc0+L7i9X7s9b3QX0kuPNTqViQsnafr6D+wcOpYa4BorEN+rNSwi3ReTJtdxjr2JYW8SAk6v8Dm+QYa4xgmam/ufstd5NSRD+d6+Ld+dURwYplz6qiPGjlupNBwQ/mKbiVF2LP3vncbQaPl70HLG7j3q5Vsqy58UcK6pbfsEJmsDVjAUR8XJox/yeO+QVWRmy1mTd8jIZ7yQIQJYW7fPazhQOE2sXyl4jzsAMEU1xCATNdVhM12nEVk6jKh7BcxpZA/tJ0xg4nGb9AgMBAAECggEBAINJNpP9gXw3/w6K71QnL3fqz8XfH+OTY8V2DXlNYKKmLSQzna6LJxdCMM+T19ppNySJBFKrX2cOexxWxEIVxvmK7zTKoCXynXGr3pVfUsfYH3lpzoWIGA1uo48irB4QIHo+8YUjS2UcLdKPEh5+uwWRDXNpjxgArSPeXMRzCkPVto1nJrxkCSwwybM+RWVaqe9Fw4dY/ky3UxkMob6C9QYVLyDYgXkhg1V+ZtBm/+QBH+ZtsD6Snxzc8JHFz3es9lvTYO/vNI3Q+QiTG7Fx1ms5TRQ9uKFt5cNIns3kfozjcFvxvgKU074viA02buW4UCmRvu51n05jd5k2PLHpBp0CgYEAwa8s7DcMS59LenMz9UWnq5wkdlXDcR7PYE+BHJmhMZzAMH4cSxYOT7nlyqyiwZ369Hm6eqc8AeSwZNunnBgfYRpgtBgbuBpzG8s07BYGut6MKlvOOCxa+XOaMUuSyLOX5k2u8aRcamsrgjaKIXWaTFH2uLR+mnHMMENcktkDs0sCgYEAsXfu33iTIGT3pTcauJMAzjWmcHE4K5DZYAjqw9H25R8IGBbRymnnb8lnIaBye6D9e9M+I1TiOozrkWNSaMu1jAYFQEygcSClMM0+JC4MY8oaVq/6lrIWP6jn3pAp95rEuNX3SUok6IJOipd482PyXFkD550iZwfXcGa2vHBrmdcCgYEAslKJZrZMELgJ8yRsGw9Vj2/ENltCBT1bqw2oDt/3hEkQvdTuUcdtx8OdKRwHAYJlUn9czJ56ZjfanBGMYO/ovCtgC5ACvV9Eybsu74pcCeLqY/mAhUF5RSBFP8uXykdnvDebsYklOSmQtmNmi+XN+SShpm8v/Rx25Zyvd9hsSr8CgYAgTBpd8xybfaSQHcowIxi3bo4e0owNaawVzSmkf5a2NgKMF8MQWluzPW0WcpPDKhZXracWWQFe9Hx+lhvOVJxyojncbNWaIP3PNtsDTJoWoxZOBnLNcBWaekvQdl4c4L7CgLYjUWoMIoLWuCBb8ymNYunSAgfbxlKP8zF4c+ExOwKBgGbrvgKgkLSIfbaC0OCVss3U1gxewO5u49yr4s+jgPHiafoq9Meft0luiEAPdwrDUvuh6fBFcwVY8AVlRqVR0j/ugSkOCS+xR8+AXNyh/caPNFkvom+BoIkc52zuBZ0l5iVNylaldBcxqaGbbzBL0NGCBUaOXmR15FnwbEU1lOzT",

        //异步通知地址
        'notify_url' => "http://h5.dhhtrade.com/pay/notify",

        //同步跳转
        'return_url' => "http://h5.dhhtrade.com/pay/return",

        //编码格式
        'charset' => "UTF-8",

        //签名方式
        'sign_type'=>"RSA2",

        //支付宝网关
        'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

        //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAlmf6wUfW5HygVE6J3Wxb8HzKVHIxpqI0VPR5R+NYiHUaS1m06rTKqylgqZC0SLeaU9/UGTFzdEmoim/cbsQiXBEt8nFe9a0oNnb919yuSjmar0PSFndpB+Xkvjh4AMLfxbPNuvfBUKgHvdvijfbKlIudYSWdVzMDkpC8Rcw78t7dKPWT0JyKGk+8zckj7jJE/+frXhRwauX0z/ZeavP0GZ5xhZmVD7rEk/zKu/KQTKLD39kgsQRPt76L85MSjh2VtU8NG2Qx4jNEFiw5KagXIDAzfZ23S+Ff3PmpUF0TGXLJ8Fec0tNukv2TpkKLAxlqnCwzUcf0AMsEMXASPY6C1wIDAQAB",

    ],
    'wxpay'=>[
        "notifyurl"=>"http://h5.dhhtrade.com/pay/notify",
        "appid" => 'wxcf2a0874b078b026',
	    "mchid" => '1484275422',
        "key" => '8934e7d15453e97507ef794cf7b0519d',
        "appsecret"=> '8f8656dca78aea5b191a534af80f6b1c',
        'curl_proxy_host'=>  "0.0.0.0",//"10.152.18.220";
        'curl_proxy_port'=>0,
    ],
];

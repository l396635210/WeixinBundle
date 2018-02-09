微信接口相关Bundle
====================================
## Use
```php
    //app/AppKernel.php
   public function registerBundles()
    {
        $bundles = [
            ...
            new AppBundle\AppBundle(),
            new Liz\WeiXinBundle\LizWeiXinBundle(),
            ...
        ];
        ...
    }
````
Config
----------------
````yml
liz_wei_xin:
    base:
        token: your_token
        app_id: your_app_id
        app_secret: your_app_secret
    material:
        local_dir: your_material_local_dir 
````
- Base    
- [x] 接口接入验证
```php
    $res = $this->get("liz_wx.service.base")
                ->start();
    echo $res; die;                
```
- [x] 获取access_token：       
此操作会将access_token以file_system缓存存在%kernel.cache_dir%."/liz_wx"文件夹下，    
保存时间7000秒，返回获取token
添加command：php bin/console lizwx:actk:update 更新access_token    
2017年8月1日更新： liz_wx.service.base添加getAccessToken()如果本地actk过期更新并返回
````php
    $token = $this->get('liz_wx.service.base')
            ->updateAccessToken();
````
- [x] 获取微信服务器ip
````php
    $ipList = $this->get('liz_wx.service.base')
                ->fetchWeiXinServerIP();
````
- 自定义菜单
- [x] 自定义菜单创建、修改 返回response body|array
````php
//button_arrays填写参照官方文档以数组格式传入
//文档链接：https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141013
    $this->get('liz_wx.service.menu')->create([
        "button"=> button_arrays[]
    ]);
````
>service的ButtonFactory也提供了一些按钮创建的方法示例代码： 
```php
$this->get('liz_wx.service.menu')->create([
    "button"=>[
        ButtonFactory::createViewButton()
            ->setUrl("http://buk4af.natappfree.cc")
            ->setName("按钮1")
            ->addSubButton(
                ButtonFactory::createViewButton()
                    ->setUrl("http://buk4af.natappfree.cc")
                    ->setName("按钮1-1")
            )
            ->serialize(),
        ButtonFactory::createClickButton(ClickButton::TYPE_PIC_SYSPHOTO)//设置type如果使用类常量不要忘记use
            ->setKey("V1001_GOOD")
            ->setName("按钮2")
            ->serialize(),
    ]
]);
```    
- [x] 自定义菜单查询 返回response body|array
```php
$res = $this->get("liz_wx.service.menu")
    ->get();
````
- [x] 自定义菜单删除 返回response body|array
```php
$res = $this->get("liz_wx.service.menu")
    ->delete();
```
- [x] 接收消息，判断消息类型，被动回复
```php
    $wxMessageService = $this->get("liz_wx.service.message");
    $receiveMsg = $wxMessageService
        ->receiveMsg();
    if($receiveMsg instanceof EventMsg){
        //事件推送
        $receiveMsg->isSubscribe();//事件类型 subscribe
        $receiveMsg->isUnSubscribe();//事件类型 unsubscribe
        $receiveMsg->isClick();// 事件类型 CLICK
        $receiveMsg->isScan(); //事件类型，SCAN
        $receiveMsg->is....等等
    }else{
        //普通消息
        $receiveMsg->isText(); //文本类型
        $receiveMsg->isVoice(); //语音类型
        $receiveMsg->isImage(); //图片
    }
    //被动回复消息
    $replyMsg = $wxMessageService->replyMsg('text',[
        'Content' => '你好',
    ]);
    dump($replyMsg);
    return new Response($replyMsg);
```
文本消息、图片消息、语音消息、视频消息、音乐消息都是上述格式    

图文消息示例如下:
```php
    //被动回复图文消息
    $replyMsg = $wxMessageService->replyMsg('news',[
        [
            'Title' => 'Title',
            'Description' => 'Description',
            'PicUrl' => 'http://photocdn.sohu.com/20151126/mp44520144_1448521145792_2.jpeg',
            'Url' => 'http://www.sohu.com/a/44520144_180738',
        ],
        [
            'Title' => 'Title',
            'Description' => 'Description',
            'PicUrl' => 'http://photocdn.sohu.com/20151126/mp44520144_1448521145792_2.jpeg',
            'Url' => 'http://www.sohu.com/a/44520144_180738',
        ]
    ]);
```

- [ ] 待完成客服消息

- [x] 上传图片|上传图文消息内的图片获取URL return $body|array，返回的url就是上传图片的URL，可放置图文消息中使用。
```php
    $file = [
        'name'     => 'media',
        'contents' => fopen($this->get('kernel')->getRootDir()."/../web/uploads/Tulips.jpg", 'r'),
        'filename' => 'Tulips.jpg'
    ];
    $res = $this->get("liz_wx.service.media")->uploadImg($file);
    dump($res);
```

- [x] 新增临时素材 return $body|array
```php
    //鉴于微信api地址，函数起名为upload了....
    $file = [
        'name'     => 'media',
        'contents' => fopen($this->get('kernel')->getRootDir()."/../web/uploads/Lighthouse-thumb.jpg", 'r'),
        'filename' => 'Tulips.jpg'
    ];
    $res = $this->get("liz_wx.service.media")->upload($file, 'thumb');
```

- [x] 新增临时图文素材
```php
    $res = $this->get('liz_wx.service.media')
        ->uploadNews([
            [
                "title"=> "title",
                "thumb_media_id" => "SKBIPd9Y48KAjHSk7clpjnaaokbO7Lz9qnff_wpEQ6wfLNMOsAfXiXoryqX48K4J",
                "author" => "李征",
                "digest" => "这是啥三十岁四十岁时",
                "show_cover_pic" => 1,
                "content" => "这是啥三十岁四十岁时这是啥三十岁四十岁时这是啥三十岁四十岁时这是啥三十岁四十岁时这是啥三十岁四十岁时这是啥三十岁四十岁时这是啥三十岁四十岁时",
                "content_source_url"=> "http://www.baidu.com",
            ],
        ]);
    dump($res);
```

- [x] 获取临时素材 @return array|resource    
   ```public function get($mediaId){}```    
   当mediaID为video类型时,返回数组[video_url=>'url'],其他格式，返回resource
```php
    $res = $this->get('liz_wx.service.media')
        ->get("ZW45AoBACJ2ZUmloqAlEWB1dOMGwbgb3hvg45gxAElvHvEAMc8kDh0kg8wQy09qy", 'thumb');
    dump($res);
``` 
- [x] 新增除图文外其他永久素材 return mixed|array $body，
新增永久视频素材需要传入$description参数(image、thumb类型上传成功，video类型，测试号上传失败，voice待测试)
```php
    $file = [
        'name'     => 'media',
        'contents' => fopen($this->get('kernel')->getRootDir()."/../web/uploads/girl.jpg", 'r'),
        'filename' => 'girl.jpg'
    ];
    $res = $this->get('liz_wx.service.material')->addMaterial($file, 'thumb');
```

- [x] 新增永久图文素材 return array|mixed $body
```php
    $res = $this->get('liz_wx.service.material')
        ->addNews([
           [
                "title"=> "title",
                "thumb_media_id" => "dEWqOQKN8q3XPHBZuyEh0TtiEoOuQ3oTGo7tEmWKIBI",
                "author" => "李征",
                "digest" => "这是啥三十岁四十岁时",
                "show_cover_pic" => 1,
                "content" => "这是啥三十岁四十岁时这是啥三十岁四十岁时这是啥三十岁四十岁时这是啥三十岁四十岁时这是啥三十岁四十岁时这是啥三十岁四十岁时这是啥三十岁四十岁时",
                "content_source_url"=> "http://www.baidu.com",
            ],
        ]);
    dump($res);
```
- [x] 获取非图文永久素材: 当mediaID为video时，返回数组，其余返回resource
```php
    $mediaId = 'dEWqOQKN8q3XPHBZuyEh0eiGYZimMOB2j198_VkWqPc';
    $res = $this->get('liz_wx.service.material')
        ->get($mediaId);
    $fs = new Filesystem();
    $fs->dumpFile($mediaId.'.jpg', $res);
```

- [x] 删除永久素材
```php
    $mediaId = 'dEWqOQKN8q3XPHBZuyEh0eiGYZimMOB2j198_VkWqPc';
    $res = $this->get('liz_wx.service.material')
        ->delMaterial($mediaId);
    dump($res);
```

- [x] 短地址生成
```php
    $longUrl = "https://baidu.com";
    $res = $this->get('liz_wx.service.short_url')->trans($longUrl);
    dump($res);
```

- [x] 地址有效性验证
```php
    $url = "https://w.url.cn/s/AYru4Vj";
    $verify = $this->get('liz_wx.service.short_url')->verify($url);
    dump($verify);
```
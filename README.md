微信接口相关Bundle
====================================
Bundle Config
----------------
````yml
liz_wei_xin:
    base:
        token: your_token
        app_id: your_app_id
        app_secret: your_app_secret
````
- Base    
- [x] 接口接入验证
```php
    $this->get("liz_wx.service.base")
                ->start();
```
- [x] 获取access_token：       
此操作会将access_token以file_system缓存存在%kernel.cache_dir%."/liz_wx"文件夹下，    
保存时间7000秒，返回获取token
添加command：php bin/console lizwx:actk:update 更新access_token
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
    }else{
        //普通消息
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
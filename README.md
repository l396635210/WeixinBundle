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
-[x] 获取access_token：       
此操作会将access_token以file_system缓存存在%kernel.cache_dir%."/liz_wx"文件夹下，    
保存时间7000秒，返回获取token
````php
    $token = $this->get('liz_wx.service.base')
            ->updateAccessToken();
````
-[x] 获取微信服务器ip
````php
    $ipList = $this->get('liz_wx.service.base')
                ->fetchWeiXinServerIP();
````
- 自定义菜单
-[x] 自定义菜单创建、修改 返回response body|array
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
            ->toArray(),
        ButtonFactory::createClickButton(ClickButton::TYPE_PIC_SYSPHOTO)//设置type如果使用类常量不要忘记use
            ->setKey("V1001_GOOD")
            ->setName("按钮2")
            ->toArray(),
    ]
]);
```    
-[x] 自定义菜单查询 返回response body|array
```php
$res = $this->get("liz_wx.service.menu")
    ->get();
````
-[x] 自定义菜单删除 返回response body|array
```php
$res = $this->get("liz_wx.service.menu")
    ->delete();
```
- 
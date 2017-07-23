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
网站验证已完成
````php
    $this->get("liz_wx.service.base")
                ->start();
````                
获取access_token已完成：       
此操作会将access_token以file_system缓存存在%kernel.cache_dir%."/liz_wx"文件夹下，    
保存时间7000秒，可以根据$cache->fetch(md5("{AppID}_{AppSecret}"))取到该值
````php
    $this->get('liz_wx.service.base')
            ->updateAccessToken();
````
获取微信服务器ip完成
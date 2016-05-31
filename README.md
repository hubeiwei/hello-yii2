# 说明

这是我在空闲时间做来练手的项目，目前还在开发中，在此分享给大家，希望能得到些指点和建议，多学到点东西，也希望有同样热爱yii2的同学和我多多交流，互相学习。

写了很多注释，主要的都在`Music`相关的代码里了，如果哪里看不懂或者代码还有更好的写法的话，就多多和我交流吧，我的QQ是494364222。

除了框架本身的**入口文件**/web/index.php和**配置文件**/config/web.php以及**数据库配置文件**/config/db.php以外（这句话写给初学者的），其他你只需关注的地方如下：

目录 | 说明
---|---
/models | model
/modules | 模块，主要的东西都在这里了，模块的注释在**配置文件**里
/views | 只是放一个布局文件而已

# 项目搭建

## 安装

1. yii2需要开启的PHP的openssl、pdo、pdo_mysql扩展，我弄了文件上传的功能，需要fileinfo扩展。（因为还没开始学缓存什么的，所以可以用php7，速度很快）

2. 你要有[composer](http://docs.phpcomposer.com/)，以及创建一个utf8数据库，在**数据库配置文件**配置好相关参数后，执行以下命令：
```
composer install
yii migrate --migrationPath=@yii/rbac/migrations
yii migrate/to m140602_111327_create_menu_table --migrationPath=@mdm/admin/migrations
yii migrate/to m160523_015948_init
```

3. **配置文件**里的```$config['components']['urlManager']```这一部分我给注释掉了，如果开启apache的rewrite并把站点根目录设置为/web的话，就可以把整个```if```取消掉注释了。

## 安装遇到问题怎么办？

我只测试过migration能正常导入数据而已，项目刚传上来还没测试过别人拿到手之后能不能跑，有问题加QQ联系吧。

# 捐赠

如果觉得我的项目做的好的话，就给我打赏吧，以后我会用这些钱来学习以及购买服务器。

![wechat](https://raw.githubusercontent.com/hubeiwei/laohu-yii2/master/wechat_1464710844970.png "微信") ![alipay](https://raw.githubusercontent.com/hubeiwei/laohu-yii2/master/alipay_1464710933517.jpg "支付宝")

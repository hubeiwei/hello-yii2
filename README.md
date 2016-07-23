# 说明

建立了该分支是为了研究[mdmsoft/yii2-admin](https://github.com/mdmsoft/yii2-admin)模块里一套用户相关的功能，用该模块自带的用户表替换了原有的用户表，现在应该可以使用了，还没发现什么问题。

这是我在空闲时间用yii2-basic来练手的项目，目前还在学习中，在此分享给大家，希望能得到些指点和建议，多学到点东西，也希望有同样热爱yii2的同学和我多多交流，互相学习，我的QQ是494364222。

我的代码是在gii生成的基础上修改而来的，如果哪里看不懂或者代码还有更好的写法的话，就多多和我交流吧。

另外就是我强迫症很严重，所以有可能会经常把代码简化，或者删改注释，或者把一些封装方式和方法的顺序以及一些命名会经常改来改去的，请见谅。

（写给初学者的）除了框架本身的**入口文件**`/web/index.php`和**配置文件**`/config/web.php`以及**数据库配置文件**`/config/db.php`以外，其他你只需关注的地方如下：

目录 | 说明
---|---
/models | model
/modules | 模块，主要的东西都在这里了，模块的注释在**配置文件**里
/views | 只是放一个布局文件而已

# 项目部署

## 配置

* 在php扩展方面，composer和yii2都需要openssl扩展；我用的是mysql，需要pdo_mysql扩展；弄了文件上传的功能，需要fileinfo扩展。（因为还没开始学缓存什么的，所以可以用php7，速度很快）

* 因为要上传文件，需要去`php.ini`把`post_max_size`和`upload_max_filesize`两个值配置一下，程序上的文件大小限制在FileHelper类里，目前的设置是20MB

## 安装

* 你要有[composer](http://docs.phpcomposer.com/)，以及创建一个`utf8`数据库，因为用了新的用户表结构，所以不能和master分支共用一个数据库，在**数据库配置文件**配置好相关参数后，执行以下命令：

```
composer self-update
composer global require "fxp/composer-asset-plugin:^1.2.0"
composer install
yii migrate --migrationPath=@yii/rbac/migrations
yii migrate --migrationPath=@mdm/admin/migrations
yii migrate
```

* 因为路由规则与后台菜单需要，需要把站点根目录设置为`/web`，apache需要开启rewrite，nginx还没用过，自行解决吧，以后再考虑如何处理这个问题。

## 使用

* 虽然我在**配置文件**配置好了我的163邮箱，但还是请改成自己的，谢谢合作。

* 后台的侧边菜单只能支持到二级，所以在添加菜单的时候需要注意，以后我再尝试解决这个问题。

* 用户名和密码如下：

身份 | 用户名 | 密码 |
---|---|---
超级管理员 | hu | hbw12345
普通用户 | test | qwer1234

## 部署遇到问题怎么办？

我只测试过migration能正常导入数据而已，自己很懒，没有深入测，也没有人看过这个项目给我反馈问题，遇到问题加QQ联系吧。

# 打赏

如果觉得我的项目做的好的话，就给我打赏吧，以后我会用这些钱来学习以及购买服务器。

![wechat](https://raw.githubusercontent.com/hubeiwei/laohu-yii2/master/web/wechat_pay.png "微信")

![alipay](https://raw.githubusercontent.com/hubeiwei/laohu-yii2/master/web/ali_pay.jpg "支付宝")

# 说明

这是我在空闲时间用yii2-basic来练手的项目，目前还在学习中，在此分享给大家，希望能得到些指点和建议，多学到点东西，也希望有同样热爱yii2的同学和我多多交流，互相学习，我的QQ是494364222。

写了很多注释，都是我的一些理解，主要的都在`Music`相关的代码里了，如果哪里看不懂或者代码还有更好的写法的话，就多多和我交流吧。

另外就是我强迫症很严重，所以有可能会经常把代码简化，或者把一些封装方式和方法的顺序以及一些命名会经常改来改去的，请见谅。

（写给初学者的）除了框架本身的**入口文件**`/web/index.php`和**配置文件**`/config/web.php`以及**数据库配置文件**`/config/db.php`以外，其他你只需关注的地方如下：

目录 | 说明
---|---
/models | model
/modules | 模块，主要的东西都在这里了，模块的注释在**配置文件**里
/views | 只是放一个布局文件而已

# 项目部署

## 安装

1. yii2需要开启的PHP的openssl扩展，我用的是mysql，要开pdo_mysql扩展，弄了文件上传的功能，需要fileinfo扩展。（因为还没开始学缓存什么的，所以可以用php7，速度很快）

2. 你要有[composer](http://docs.phpcomposer.com/)，以及创建一个`utf8`数据库，在**数据库配置文件**配置好相关参数后，执行以下命令：

```
composer install
yii migrate --migrationPath=@yii/rbac/migrations
yii migrate/to m140602_111327_create_menu_table --migrationPath=@mdm/admin/migrations
yii migrate
```

## 使用

1. 因为后台菜单需要，需要把站点根目录设置为`/web`，apache需要开启rewrite，nginx还没用过，自行解决吧，以后再考虑如何处理这个问题。

2. 用户名和密码如下：

身份 | 用户名 | 密码 |
---|---|---
超级管理员 | hu | hbw12345
普通用户 | test | qwer1234

## 部署遇到问题怎么办？

1. 我只测试过migration能正常导入数据而已，自己很懒，没有深入测，也没有人看过这个项目给我反馈问题，遇到问题加QQ联系吧。

2. 可能有些同学执行`composer install`后，`/vendor`目录里没有`bower`目录，尝试执行以下命令再重新执行一次`composer install`，[参考链接](https://segmentfault.com/q/1010000004047286)

```
composer global require "fxp/composer-asset-plugin:~1.1.1"
```

# 打赏

如果觉得我的项目做的好的话，就给我打赏吧，以后我会用这些钱来学习以及购买服务器。

![wechat](https://raw.githubusercontent.com/hubeiwei/laohu-yii2/master/web/wechat_pay.png "微信")

![alipay](https://raw.githubusercontent.com/hubeiwei/laohu-yii2/master/web/ali_pay.jpg "支付宝")

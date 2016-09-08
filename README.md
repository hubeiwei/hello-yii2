# 说明

这是我在空闲时间用yii2-basic来练手的项目，目前还在学习中，在此分享给大家，希望能得到些指点和建议，多学到点东西，也希望有同样热爱yii2的同学和我多多交流，互相学习，我的QQ是494364222。

建立了该分支是为了研究[mdmsoft/yii2-admin](https://github.com/mdmsoft/yii2-admin)模块里的邮件找回密码功能（现在发现这貌似就是advanced版自带的），用该模块自带的用户表替换了原有的用户表(现在发现这貌似就是advanced版的用户表)。

我强迫症很严重，所以有可能会经常把代码简化，或者删改注释，或者把一些封装方式和方法的顺序以及一些命名会经常改来改去的，请见谅。

# 结构

## 文件和目录

（写给初学者的）除了**入口文件**`/web/index.php`、**配置文件**`/config/web.php`、**数据库配置文件**`/config/db.php`以外，其他你只需关注的地方如下：

目录 | 说明
---|---
models | Model
modules | 模块，主要的东西都在这里了，模块的注释在**配置文件**里
views | 目前只是放布局文件而已

## 视图布局

```
master(最外层)
├ frontend(前台外层)
│ ├ main(前台)
│ └ user_form(用户模块表单)
└ backend(后台)
```

## Model

我的代码是在gii生成的model和CRUD代码上修改而来的，如果你也是这个套路的话，那我的代码应该不怎么难理解，需要说明一下的是model这一部分，首先我用gii生成model到`/models/base`目录下，取名为'ModelBase'，接着会在`/models`目录下新建一个'Model'来继承'ModelBase'，以后有代码都写到'Model'里。

这样做的好处是修改了数据库表结构后重新生成model可以直接覆盖'ModelBase'。

# 项目部署

## PHP配置

* 在php扩展方面，composer和yii2都需要openssl扩展；我用的是mysql，需要pdo_mysql扩展；弄了文件上传的功能，需要fileinfo扩展。

* 因为要上传文件，需要去`php.ini`把`post_max_size`和`upload_max_filesize`两个值配置一下，程序上的文件大小限制在`app\models\Music`类里，目前的设置是20MB

## 安装

你要有[composer](http://docs.phpcomposer.com/)，执行以下命令：

```
composer self-update
composer global require "fxp/composer-asset-plugin:^1.2.0"
composer install
```

创建一个`utf8`数据库，因为用了新的用户表结构，所以不能和master分支共用一个数据库，在**数据库配置文件**配置好相关参数后，执行以下命令：

```
yii migrate --migrationPath=@yii/rbac/migrations
yii migrate --migrationPath=@mdm/admin/migrations
yii migrate
```

## 服务器配置

因为路由规则与后台菜单需要，需要把`/web`设置为站点根目录。

apache需要开启rewrite，`.htaccess`文件我已经配置好放在`/web`目录里了。vhost配置可以和以下那么简单：

```
<VirtualHost *:80>
    DocumentRoot "path/to/hello-yii2/web"
    ServerName hello-yii2.dev
</VirtualHost>
```

nginx可以参考[这篇文章](http://www.getyii.com/topic/31)。

详情可以直接参考[官方文档](http://www.yiiframework.com/doc-2.0/guide-start-installation.html#configuring-web-servers)。

## 使用

* 虽然我在**配置文件**配置好了我的163邮箱，但希望还是改成自己的邮箱，谢谢。

* 后台的侧边菜单代码目前只能支持到二级，所以在添加菜单的时候需要注意。

* 用户名和密码如下：

身份 | 用户名 | 密码 |
---|---|---
超级管理员 | hu | hbw12345
普通用户 | test | qwer1234

## 部署遇到问题怎么办？

我只测试过migration能正常导入数据而已，自己很懒，没有深入测，也没有人看过这个项目给我反馈问题，遇到问题加QQ联系吧。

# 打赏

如果觉得我的项目做的好的话，就给我打赏吧，以后我会更有动力去学习和分享更多yii2的内容。

![wechat](https://raw.githubusercontent.com/hubeiwei/hello-yii2/master/web/wechat_pay.png "微信")

![alipay](https://raw.githubusercontent.com/hubeiwei/hello-yii2/master/web/ali_pay.jpg "支付宝")

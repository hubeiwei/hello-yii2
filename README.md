# 说明

这是我在空闲时间用yii2-basic来练习各种杂七杂八的插件的项目。

建立了该分支是为了研究[mdmsoft/yii2-admin](https://github.com/mdmsoft/yii2-admin)模块里的邮件找回密码功能（现在发现这貌似就是advanced版自带的），用该模块自带的用户表替换了原有的用户表(现在发现这貌似就是advanced版的用户表)，现在master分支算是废弃了。

我强迫症很严重，所以有可能会经常把代码简化，或者删改注释，或者把一些封装方式和方法的顺序以及一些命名会经常改来改去的，请见谅。

# 结构

## 文件和目录

（写给初学者的）除了**入口文件**`/web/index.php`、**配置文件**`/config/web.php`、**数据库配置文件**`/config/db.php`以外，其他你只需关注的地方如下：

目录 | 说明
---|---
models | Model，详情请[往下拉](#model)
modules | 模块，主要的东西都在这里了，模块的注释在**配置文件**里
views | 目前只是放布局文件而已，布局结构详情请[往下拉](#视图布局文件)

## Model

我的代码是在gii生成的model和CRUD代码上修改而来的，如果你也是这个套路的话，那我的代码应该不怎么难理解，需要说明一下的是model这一部分，首先我用gii生成model到`/models/base`目录下，取名为'ModelBase'，接着会在`/models`目录下新建一个'Model'来继承'ModelBase'，以后有代码都写到'Model'里。

这样做的好处是修改了数据库表结构后重新生成model可以直接覆盖'ModelBase'。

## 视图布局文件

```
master(最外层)
├ frontend(前台外层)
│ ├ main(前台)
│ └ user_form(用户模块表单)
└ backend(后台)
```

# 项目部署

## PHP配置

* 扩展：openssl、pdo_mysql、fileinfo

* 程序上的上传文件大小限制在`app\models\Music`里，目前的设置是20MB，`php.ini`的`post_max_size`和`upload_max_filesize`两个值需要配置一下，

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

因为路由规则需要，需要把`/web`设置为站点根目录。

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

* 用户名和密码如下：

身份 | 用户名 | 密码
---|---|---
超级管理员 | hu | hbw12345
普通用户 | test | qwer1234

## 部署遇到问题怎么办？

发起一个issues。

# 打赏

如果觉得我做的内容对你有帮助的话，求打赏，以后我会有更多动力去学习和分享更多yii2的内容。

![wechat](https://raw.githubusercontent.com/hubeiwei/hello-yii2/master/web/wechat_pay.png "微信")

![alipay](https://raw.githubusercontent.com/hubeiwei/hello-yii2/master/web/ali_pay.jpg "支付宝")

感谢以下这些朋友的支持。

捐赠人 | QQ | 金额
---|---|---
誓言 | 443536249 | 50.00
东方不拔 | 790292520 | 30.00
[a boy with a mission](https://github.com/xiaocai314) | 727492986 | 8.88

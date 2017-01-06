# 目录

* [说明](#说明)

* [项目部署](#项目部署)

    * [PHP配置](#php配置)

    * [安装第三方扩展和创建数据库表](#安装第三方扩展和创建数据库表)

    * [服务器配置](#服务器配置)

    * [使用](#使用)

* [结构说明](#结构说明)

    * [文件和目录](#文件和目录)

    * [Model](#model)

    * [Layout](#layout)

* [打赏](#打赏)

# 说明

这是我在空闲时间用 yii2-basic 来研究各种新奇玩意的项目，请多关注，里面的业务代码不一定能在实际工作中使用，也不一定是最好的写法，仅供参考。

为了减少代码量，我改写和封装了好多东西，在公司也这么用，虽然不能满足所有人的口味，但如果你觉得好的话，你可以拿我的 common 目录的东西去用。在 tools 目录，我放了一些我在 PHPStorm 常用的 Live Templates。

# 项目部署

## PHP配置

* 扩展：openssl、pdo_mysql、fileinfo

* 程序上的上传文件大小限制在 `app\models\Music` 里，目前的设置是 20MB，`php.ini` 的 `post_max_size` 和 `upload_max_filesize` 两个值需要配置一下，

## 安装第三方扩展和创建数据库表

你要有 [composer](http://docs.phpcomposer.com/)，执行以下命令：

```
composer self-update
composer global require "fxp/composer-asset-plugin:^1.2.0"
composer install
```

创建一个 `utf8` 数据库，在 `config/db.php` 文件配置好 MySql 相关参数后，执行以下命令：

```
php yii migrate --migrationPath=@yii/rbac/migrations
php yii migrate --migrationPath=@mdm/admin/migrations
php yii migrate
php yii migrate --migrationPath=@kartik/dynagrid/migrations
```

## 服务器配置

因为路由规则需要，需要开启 rewrite 而且把 `web` 目录设置为站点根目录。

apache 的 `.htaccess` 文件我已经配置好放在 `web` 目录里了，windows 环境下用集成环境的话，可以试一下软件提供的添加网站功能，其他情况下的搭建方法自行 google 吧。

nginx 可以参考[这篇文章](http://www.getyii.com/topic/31)。

详情可以直接参考[官方文档](http://www.yiiframework.com/doc-2.0/guide-start-installation.html#configuring-web-servers)。

## 使用

* 在 `config/web.php` 里找到[邮箱的配置](https://github.com/hubeiwei/hello-yii2/blob/master/config/web.php#L83)并配置好，才能用找回密码的功能。

* 用户名和密码如下：

身份 | 用户名 | 密码
---|---|---
超级管理员 | hu | hbw12345
普通用户 | test | qwer1234

# 结构说明

我的代码是从 gii 生成的 model 和 CRUD 代码上修改而来的，如果你也是这个套路的话，那我的代码应该还算容易看懂，就 model 和原来的有些区别，详情请[往下拉](#model)。

## 文件和目录

```
common                 一些我自己封装的代码和改写的类

config
    db.php             数据库配置
    modules.php        模块配置
    web.php            框架配置

models                 放 model 的地方，详情请[往下拉](#model)

modules
    backend/           后台模块
    frontend/          前台模块
    user/              用户相关，例如登入登出、用户中心

views                  目前只是放布局文件而已，布局结构详情请[往下拉](#layout)
```

另外没提到的资源、邮件模板、翻译、数据库迁移的文件不重要，想看的随便看看就好。

## Model

首先我用 gii 生成 model 到 `models/base` 目录下，取名为 'ModelBase'，接着会在 `models` 目录下新建一个 'Model' 来继承 'ModelBase'，以后有代码都写到 'Model' 里，这样做的好处是修改了数据库表结构后重新生成 model 可以直接覆盖 'ModelBase'。

## Layout

```
master(最外层，layout 不直接指向这里)
├ frontend(前台外层，layout 不直接指向这里)
│ ├ main(前台)
│ ├ user(用户模块)
│ └ user_form(用户模块的表单)
└ backend(后台)
```

layout 会统一在 `config/modules.php` 里配置

# 打赏

如果觉得我做的内容对你有帮助的话，求打赏，以后我会有更多动力去学习和分享更多yii2的内容。

![alipay](https://raw.githubusercontent.com/hubeiwei/hubeiwei.github.io/master/images/pay/ali_pay.jpg "支付宝")

![wechat](https://raw.githubusercontent.com/hubeiwei/hubeiwei.github.io/master/images/pay/wechat_pay.png "微信")

感谢以下这些朋友的支持。

打赏人 | QQ | 金额
---|---|---
誓言 | 443536249 | 50.00
山中石 | 1146283 | 50.00
东方不拔 | 790292520 | 30.00
欲买桂花同载酒。 | 1054828207 | 18.88
[a boy with a mission](https://github.com/xiaocai314) | 727492986 | 8.88
hello world! | 85307097 | 1.00

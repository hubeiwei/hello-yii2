## 目录

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

## 说明

这是我在空闲时间用 yii2-basic 来研究各种玩意的项目，请多关注，里面的代码不一定能在实际工作中使用，也不一定是最好的写法，仅供参考。

目前可能是你能学到破姿势的地方：

前台文章首页（/frontend/article/index）：使用 DataProvider 遍历数据、分页、排序（虽然很基础，但比起传统的手动加 offset、limit、order by 方便多了）。

个人中心（/user/home）：这里的页面加载你看起来感觉会很快，因为我用了 pjax，不过目前有个 bug，点击链接时我会把链接的文字加到右边面板上，但是后退的时候就尴尬了，我现在有两个方案，但还懒得去改。

你可以随便提交一些表单，或者删除一些数据，你会看到我是怎么提示消息的，如果你觉得代码太多，找不到关键点，可以[来这里看看](https://github.com/hubeiwei/yii2-tools#消息提示)

用到 GridView、DynaGrid（也就是表格）的地方，你可以看看我是怎么做导出的.

另外你还可以看一下我表格上的日期和枚举字段的搜索我是怎么处理的，如果你觉得代码太多，找不到关键点，可以[来这里看看](https://github.com/hubeiwei/yii2-tools#widget)。

## 项目部署

### PHP配置

扩展：openssl、pdo_mysql、fileinfo

程序上的上传文件大小限制在 `app\models\Music::MUSIC_SIZE`，我随便设置了一个 20MB，php 的 `post_max_size` 和 `upload_max_filesize` 两个值需要配置一下。

### 安装 vendor 目录（composer 包）

首先你要有 [composer](http://docs.phpcomposer.com/)，然后按顺序执行以下命令，如果你觉得速度慢的话，可以参考我的[这篇文章](http://laohu321.cc/2017/01/terminal-accelerate)。

```
composer self-update
composer global require "fxp/composer-asset-plugin:^1.3.1"
composer install --prefer-dist
```

### 生成本地配置文件

```
php init --env=Development --overwrite=all
```

### 创建数据库表

在 MySql 创建一个 utf8 数据库，在 config/db.php 文件配置好之后，按顺序执行以下命令：

```
php yii migrate --migrationPath=@yii/rbac/migrations
php yii migrate/to m140602_111327_create_menu_table --migrationPath=@mdm/admin/migrations
php yii migrate --migrationPath=@kartik/dynagrid/migrations
php yii migrate
```

### 搭建网站

因为路由规则需要，需要开启 rewrite 并把 web 目录设置为站点根目录，这也是 yii2 的正确使用方式。

nginx 可以参考[这篇文章](http://www.getyii.com/topic/31)。

或者直接参考[官方文档](https://github.com/yiisoft/yii2/blob/master/docs/guide-zh-CN/start-installation.md#配置-web-服务器-)，我的 nginx 配置就是直接抄官方文档里面的。

### 使用

在 config/components-local.php 里找到邮箱的配置并配置好，才能用找回密码的功能。

已经生成好的用户名和密码如下：

身份 | 用户名 | 密码
---|---|---
超级管理员 | admin | asdf1234
普通用户 | test | asdf1234

## 结构说明

完成上面的步骤后你就可以使用了，如果你想了解我的项目的话，可以看看这一节。

我的代码是从 gii 生成的 model 和 CRUD 代码上修改而来的，如果你也是这个套路的话，那我的代码应该还算容易看懂，就 model 和原来的有些区别，详情请[往下拉](#model)。

### 文件和目录

没列出的文件随便看看就好。

```
common                    一些我自己封装的代码和改写的类

config
├ components.php          组件配置
├ components-local.php    本地组件配置，在 environments 里通过 init 生成
├ db.php                  数据库配置，在 environments 里通过 init 生成
├ modules.php             模块配置
└ web.php                 框架配置

models                    放 model 的地方，下面有详细说明

modules
├ backend                 后台模块
├ frontend                前台模块
└ user                    用户相关，例如登入登出、个人中心、找回密码等

views                     放布局文件和错误页面用，下面有详细说明
```

### models 目录

我用 gii 生成 model 到 models/base 目录下，取名为 'ModelBase'，然后在 models 目录下新建一个 'Model' 来继承 'ModelBase'，以后只编辑 'Model'，这样做的好处是重新生成 model 可以直接覆盖。

用 gii 生成 crud 代码，其中有一项 “Search Model Class”，我把它生成到 models/search 目录下。

### views/layout 目录

布局结构和说明：

```
base_html5.php         最外层，最基础的 html 结构，所有人都能用，layout 不直接指向这里
└ master.php           根据自己项目自定义的最外层，layout 不直接指向这里
  ├ frontend.php       前台外层，layout 不直接指向这里
  │ ├ main.php         前台，框架默认指向的地方
  │ ├ user.php         用户模块
  │ └ user_form.php    用户模块的表单
  └ backend.php        后台
```

layout 会统一在 config/modules.php 里配置，frontend 模块里两个控制器的 `beforeAction()` 方法里也有修改布局的代码。

只做输出用的文件，在同级的 include 目录下：

```
layout/frontend.php
└ include/frontend_nav.php    顶部 bootstrap 的菜单

layout/backend.php
├ include/backend_menu.php    左侧菜单
└ include/bacnend_nav.php     顶部 bootstrap 的菜单
```

## 打赏

如果觉得我做的东西对你有帮助的话，求打赏一杯 coffee，这样我会有更多动力去分享更多 yii2 的内容。

<img src="https://raw.githubusercontent.com/hubeiwei/hubeiwei.github.io/master/images/pay/ali_pay.jpg" width="500px" alt="支付宝">

<img src="https://raw.githubusercontent.com/hubeiwei/hubeiwei.github.io/master/images/pay/wechat_pay.png" width="500px" alt="微信">

感谢以下这些朋友的支持。

打赏人 | QQ | 金额
---|---|---
若 | 921520651 | 88.88
誓言 | 443536249 | 50.00
山中石 | 1146283 | 50.00
东方不拔 | 790292520 | 30.00
欲买桂花同载酒。 | 1054828207 | 18.88
一缕云烟 | 494644368 | 13.80
[a boy with a mission](https://github.com/xiaocai314) | 727492986 | 8.88
hello world! | 85307097 | 1.00

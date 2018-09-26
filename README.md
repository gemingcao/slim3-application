# Slim Framework 3 Gemingcao Application

使用此框架应用程序快速设置并开始处理新的Slim Framework 3应用程序。此应用程序使用最新的Slim 3和Twig-View模板渲染器。它还使用Monolog记录器。

此框架应用程序是为Composer构建的。这样可以快速轻松地设置新的Slim Framework应用程序。

## 安装应用程序

从要安装新Slim Framework应用程序的目录中运行此命令。

    php composer.phar create-project gemingcao/slim3-application [your-app-name]
    //composer create-project gemingcao/slim3-application [your-app-name]

替换[your-app-name]为新应用程序的所需目录名称。你想要：

* 将虚拟主机文档根目录指向新应用程序的`public/`目录。
* 确保`application/logs/`可写。
* 创建数据库，如`slim3-application`，导入数据库文件`slim3-application.sql`便于测试。
* 配置`application/configs/settings.php`中`database settings`的数据库用户名和密码。

要在开发中运行应用程序，可以运行这些命令

    cd [your-app-name]
    php composer.phar start
    //composer start

在浏览器中运行测试

    http://localhost:8080/index
    http://localhost:8080/hello/world
    http://localhost:8080/admin

就这样了！

![license](https://camo.githubusercontent.com/8addc1e46efd92165de0d5fa6d5fd6a3817251a50a45544710ae4eaf486e3fe5/68747470733a2f2f696d672e736869656c64732e696f2f6769746875622f6c6963656e73652f626979756568752f6b6f746f72692d626f743f636f6c6f723d64656570677265656e)
![stars](https://img.shields.io/github/stars/biyuehu/hulicore)
![commits](https://img.shields.io/github/commit-activity/t/biyuehu/hulicore)

**HULICore**(接口管理核心系统)是基于原生PHP制造一整套框架，主要封装了数据库操作、伪静态路由、功能函数等功能，框架遵守MVC架构，应用实例由Controller控制器、Model模型、View视图三部分组成，并在一定基础上参考了typecho，由着网站主题Theme与插件Plugin两样用户级的功能

> 使用HULICore运行的网站:[HULIAPI](https://api.imlolicon.tk)

其它文档懒得写了，自己研究，由于前后端不分离，所以可能性能有点不好

## 环境要求
**Os:** Windows 或 Linux(CentOs, Ubuntu...)
**Server:** Nginx 或 Apache
**PHP:** 已知可稳定运行版本 7.3.4~7.4.3

## 安装
- 先创建数据库,然后导入`sql/database.sql`
- 配置好`config/database.php`的数据库配置文件
- 创建站点，选择符合要求的PHP版本
- 设置伪静态
Nginx
```nginx
location / {
  if (!-e $request_filename){
    rewrite ^(.*)$ /index.php;
  }
}
```
Apache
```apache
RewriteRule '^(.*)$$' /index.php; [L] 
```
- 根据地址访问/user/login目录
- 默认管理员账号: `admin@qq.com` 密码:`123456`

## 目录结构
- HULICore
    - app 应用目录
        - core 核心目录
            - func
                - function.php 公共函数
            - common.php 数据库核心
            - route.php 路由核心
        - base 实例目录
            - Controllers 控制器目录
                - Admin
                - Other
                - Site
                - Sys
                - User
                - Controller.php
                - IndexController.php
                - Method.php
            - Models 模型目录
                - Models.php
            - view 视图目录
                - article 文章目录
                  ...html
                - ...html
        - lib 库目录
        - app.php 全局路由
        - const.ini.php 全局用户常量
    - config 配置目录
        - config.php 总配置
        - database.php 数据库配置
        - method.php 允许请求类型配置
        - apicode.php 状态码配置
        - article.php 文章页路由配置
        - assets.php 静态资源格式对照配置
        - theme.php 请勿更改
        - website.php 子站接口接入APIKEY配置
    - data 数据目录
      - account 用户头像目录
      - api 接口目录
        - res
        - src
        - temp
        - ...php
    - public 网站目录
        - api 静态接口目录
          ...
          humodule.js
        - images 图片资源目录
        - res 资源文件目录
        - tool 工具箱目录
        - favicon.ico 图标文件
        - help.html 帮助页面
        - index.php 重定向文件
    - sql SQL目录
    - usr 用户目录
      - plugins 插件目录
        - email Email插件
      - theme 主题目录
        - air
        - default
    - Hulicore.php 主程序文件

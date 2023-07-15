![license](https://camo.githubusercontent.com/8addc1e46efd92165de0d5fa6d5fd6a3817251a50a45544710ae4eaf486e3fe5/68747470733a2f2f696d672e736869656c64732e696f2f6769746875622f6c6963656e73652f626979756568752f6b6f746f72692d626f743f636f6c6f723d64656570677265656e)
![stars](https://img.shields.io/github/stars/biyuehu/hulicore)
![commits](https://img.shields.io/github/commit-activity/t/biyuehu/hulicore)

**HULICore**(接口管理核心系统)是基于原生PHP制造一整套框架，主要封装了数据库操作、伪静态路由、功能函数等功能，框架遵守MVC架构，应用实例由Controller控制器、Model模型、View视图三部分组成，并在一定基础上参考了typecho，由着网站主题Theme与插件Plugin两样用户级的功能

> 使用HULICore运行的网站:[HULIAPI](https://api.imlolicon.tk)

其它文档懒得写了，自己研究，由于前后端不分离，所以可能性能有点不好

## 环境要求
**Server:** Nginx 或 Apache
**PHP:** 已知可稳定运行版本 7.3.4~7.4.3

## 安装
- 先创建数据库,然后导入`database.sql`
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

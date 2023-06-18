**HULICore**(接口管理核心系统)是基于原生PHP制造一整套框架，主要封装了数据库操作、伪静态路由、功能函数等功能，框架遵守MVC架构，应用实例由Controller控制器、Model模型、View视图三部分组成，并在一定基础上参考了typecho，由着网站主题Theme与插件Plugin两样用户级的功能

> 使用HULICore运行的网站:[HULIAPI](https://api.imlolicon.tk)

其它文档懒得写了，自己研究，由于前后端不分离，所以可能性能有点不好

## 环境要求
**Server:** Nginx 或 Apache
**PHP:** 已知可稳定运行版本 7.3.4~7.4.3

## 安装
先创建数据库,然后导入`database.sql`,最好配置好`config/database.php`的数据库配置文件
默认管理员账号: `Admin` 密码:`123456`

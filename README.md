## swoole-phalcon-cms
swoole与phalcon框架结合，cms

## 环境要求
* PHP 5.5+
* Phalcon 2.0.13
* Swoole 1.7.16
* Linux and Windows support (Thinks to cygwin)

##swoole的ide智能提示
```sh
git clone --depth=1 https://github.com/eaglewu/swoole-ide-helper
```
然后new一个swoole的libraries，将swoole-ide-helper/src目录Add External folder，以后新项目选中创建的swoole即可。


##phalcon的ide智能提示
```sh
git clone --depth=1 https://github.com/phalcon/phalcon-devtools.git
```
然后new一个phalcon的libraries,然后将phalcon-devtools/ide/stubs/Phalcon目录Add External folder，以后新项目选中创建的phalcon即可。

#安装AB工具
```sh
sudo apt-get install apache2-utils
ab -c 100 -n 10000 http://172.17.0.7:8080/
```

## 如何启动
####普通方式(php命令行方式)
```sh
/usr/local/php/bin/php $PATH/swoole-phalcon-cms/public/server.php
```

####docker方式(php:cli容器)
先参照https://github.com/zhaojianhui129/docker制作装好phalcon+swoole扩展的phpcli镜像
```sh
docker run -it --rm --name phpcli -v /home/qianxun/website/swoole-phalcon-cms/:/data/swoole-phalcon-cms/ -w /data/swoole-phalcon-cms/public/ --link redis:redis_server --link mysql:mysql_server -p 8080:8080 zhaojianhui129/php:cli php server.php
```
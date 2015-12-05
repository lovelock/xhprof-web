<<<<<<< HEAD
# 简介

项目基于Facebook的开源项目xhprof，用于检测系统性能瓶颈。

xhprof本身是一个非常好用的工具，但由于yaf的路由规则，xhprof默认的设置方法会产生问题，这里将适合Yaf框架的解决方案给出详细的说明。

# 部署
## 安装xhprof的PHP扩展

执行 `php -m | grep xhprof`，如果有输出，则表示已经安装了这个扩展。

> 我们的环境已经默认安装了xhprof扩展，所以通常这一步可以略过。

## 新建Nginx/Apache vhost配置文件

将`vhost`目录中的相应的Nginx/Apache vhost文件拷贝或软链接到服务器的配置目录。重启Web服务(根据自己的实际情况)。

1. Nginx `sudo /etc/init.d/nginx restart`
2. Apache `sudo /usr/local/sbin/httpd -k restart`

## 嵌入要检测的代码

在要检测性能的函数**调用处**上方插入

```php
xhprof_enable();
```

在要检测性能的函数**调用处**下方插入

```php
include_once "/paht/to/xhprof-web/include.php";
```

## 打开Web图形界面

调用你的接口，会看到有一行类似`http://xhprof.yoursite.com/index.php?run_id=xxxxx&source=xhprof`的链接，打开链接即可看到函数调用的统计报表即统计图。

## 分析方法

简单来讲，需要关注的数据有两点，ct和wt。前者是函数被执行的次数，wt是函数执行的耗时。当然最重要的是可以看到哪个过程耗费了主要的时间，重点关注红色区域。具体的使用要看具体情况。

# 常见问题解决

1. 无法打开图表界面
`Error: either we can not find profile data for run_id 5655698164865 or the threshold 0.01 is too small or you do not have 'dot' image generation utility installed.`

引起这个错误可能有两个原因。
    * php.ini中`xhprof.output_dir=/data1/xhprof_output`这条配置有问题。可能是该指定的目录不存在，也可能是目录不可写，也可能是目录满了，自行确认一下即可。如果要改动这条配置，切记需要重启`php-fpm`才生效。
    * 系统上graphviz未安装。如果编译安装，请先安装`libpng`的依赖，因为xhprof用的是png格式的图片，需要在编译graphviz时加上`--with-png=yes`参数。如果使用yum，则需要安装`graphviz/graphviz-devel/libpng/libpng-devel`（可能不太准确，自行判断吧）。
2. Nginx的配置不用按照自己的具体情况而定，一般仿照自己项目的写法即可。

LaraDuoshuo
----

多说将于 2017 年 6 月 1 号关闭，此为我即兴写的私有评论系统，初步设计用于 Hexo，下一步准备支持煎蛋那样的单页面多评论需求。

# live demo

[https://autolayout.club](https://autolayout.club/)



# 激活附带的 demo

## 后端跑起来

生成 .env 文件和密钥：

```bash
cp .env.example .env
php artisan key:generate
cd public
php -S 0.0.0.0:9000
```

然后将数据库配置修改为真实值，并将根目录下的 LaraDuoshuo.sql 导入数据库。

## demo 跑起来

```bash
npm install hexo-cli -g
cd hexo-demo
hexo serve
```

# 用法

## 后端

部署到自己的服务器，指一个域名过去即可。

## 前端

### Hexo 默认主题

在 `themes/landscape/layout/_partial/article.ejs` 第 36 行 `</article>` 的后面添加如下代码：

```ejs
<% if (!index) { -%>
<link rel="stylesheet" href="//fuck.io:9000/css/static.css">
<div id="comments"></div>
<% } -%>
```

将 `themes/landscape/layout/_partial/after-footer.ejs` 第 17 行 `<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>` 替换为：

```ejs
<script src="//apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//fuck.io:9000/js/static.js"></script>
<script>
LaraDuoshuo.APP_KEY = 'base64:nMYxR20sgL9zbiRrMS8GekiVzPSLBId9QAoTepx+nuk=';
</script>
```

请将上面的 `LaraDuoshuo.APP_KEY` 的值替换为你服务端 .env 中的 APP_KEY 的值。

### 著名的 NexT 主题

在 `themes/next/layout/_layout.swig` 中 `{% if page.comments %}` 这一行的下面增加：

```swig
<link rel="stylesheet" href="//fuck.io:9000/css/static.css">
<div id="comments"></div>
```

在 `<script type="text/javascript" src="//cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>` 这一行的下面增加：

```swig
<script src="//fuck.io:9000/js/static.js"></script>
<script>
LaraDuoshuo.APP_KEY = 'base64:nMYxR20sgL9zbiRrMS8GekiVzPSLBId9QAoTepx+nuk=';
</script>
```

同样，请将上面的 `LaraDuoshuo.APP_KEY` 的值替换为你服务端 .env 中的 APP_KEY 的值。

### 替换域名

别忘了将上文中的 `fuck.io:9000` 替换为你真实的域名端口。
LaraDuoshuo
----

多说将于 2017 年 6 月 1 号关闭，此为我即兴写的私有评论系统，初步设计用于 Hexo，下一步准备支持煎蛋那样的单页面多评论需求。

## demo

### 后端跑起来

生成 .env 文件和密钥：

```bash
cp .env.example .env
php artisan key:generate
```

然后将数据库配置修改为真实值，并将根目录下的 LaraDuoshuo.sql 导入数据库。

### demo 跑起来

```bash
npm install hexo-cli -g
cd hexo-demo
hexo serve
```
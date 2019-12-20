# mantraCMS
关于文献的CMS

### vendor and env files
链接: https://pan.baidu.com/s/1mw1_CS97hkyw2n5s-RZxmw 提取码: 4m52  
下载后解压缩到工程根目录。

### mysql dump file
链接: 链接: https://pan.baidu.com/s/1lXNT5iFmSKCr6oXUalbv6g 提取码: pugq  

### Apache vhost configuration (Apache或Nginx自行选择)
```shell
<VirtualHost *:80>
    ServerName mantra.locl

    RewriteEngine on
    # the main rewrite rule for the frontend application
    RewriteCond %{HTTP_HOST} ^mantra.locl$ [NC] 
    RewriteCond %{REQUEST_URI} !^/(backend/web|admin|storage/web)
    RewriteRule !^/frontend/web /frontend/web%{REQUEST_URI} [L]
    
    # redirect to the page without a trailing slash (uncomment if necessary)
    #RewriteCond %{REQUEST_URI} ^/admin/$
    #RewriteRule ^(/admin)/ $1 [L,R=301]
    
    # disable the trailing slash redirect
    RewriteCond %{REQUEST_URI} ^/admin$
    RewriteRule ^/admin /backend/web/index.php [L]
    
    # the main rewrite rule for the backend application
    RewriteCond %{REQUEST_URI} ^/admin
    RewriteRule ^/admin(.*) /backend/web$1 [L]

    DocumentRoot D:/develop/php/mantraCMS
    <Directory />
        Options FollowSymLinks
        AllowOverride None
        AddDefaultCharset utf-8
    </Directory>
    
    <Directory "D:/develop/php/mantraCMS/frontend/web">
        RewriteEngine on
        # if a directory or a file exists, use the request directly
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        # otherwise forward the request to index.php
        RewriteRule . index.php

        Require all granted
    </Directory>
    
    <Directory "D:/develop/php/mantraCMS/backend/web">
        RewriteEngine on
        # if a directory or a file exists, use the request directly
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        # otherwise forward the request to index.php
        RewriteRule . index.php

        Require all granted
    </Directory>
    
    <Directory "D:/develop/php/mantraCMS/storage/web">
        RewriteEngine on
        # if a directory or a file exists, use the request directly
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        # otherwise forward the request to index.php
        RewriteRule . index.php

        Require all granted
    </Directory>
    
    <FilesMatch \.(htaccess|htpasswd|svn|git)>
        Require all denied
    </FilesMatch>
</VirtualHost>
```
### Nginx vhost configuration
https://github.com/yii2-starter-kit/yii2-starter-kit/blob/master/docker/nginx/vhost_single_domain.conf

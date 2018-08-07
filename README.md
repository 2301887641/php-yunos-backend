基于THINKPHP5.0的权限验证
===============

[![Total Downloads](https://poser.pugx.org/topthink/think/downloads)](https://packagist.org/packages/topthink/think)
[![Latest Stable Version](https://poser.pugx.org/topthink/think/v/stable)](https://packagist.org/packages/topthink/think)
[![Latest Unstable Version](https://poser.pugx.org/topthink/think/v/unstable)](https://packagist.org/packages/topthink/think)
[![License](https://poser.pugx.org/topthink/think/license)](https://packagist.org/packages/topthink/think)

1.基于ThinkPHP5框架开发的后台权限验证：

    + 支持两级菜单验证
    + 使用bootstrap


2.下载后请使用composer进行安装:   

    在项目根目录执行composer install
   
3.账号和密码:
   账号：admin
   密码：123456
   当前不输入用户名和密码会直接跳转undefined页面
   
4.解决PHP5.6版本“No input file specified”的问题
    
    原因在于使用的PHP5.6是fast_cgi模式，而在某些情况下，不能正确识别path_info所造成的错误
    默认的.htaccess里面的规则：
      
      Options +FollowSymlinks
      RewriteEngine On
    
      RewriteCond %{REQUEST_FILENAME} !-d
      RewriteCond %{REQUEST_FILENAME} !-f
      RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
      

“No input file specified.”，是没有得到有效的文件路径造成的。
修改后的伪静态规则，如下：
    
    Options +FollowSymlinks
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php?/$1 [QSA,PT,L]
      
      
    
    
          
          
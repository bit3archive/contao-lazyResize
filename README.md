LazyResize for Contao
=====================

This extension resize images when they are loaded and not on request.

How to use
----------

Put this into your .htaccess, just after RewriteBase or your www-Rewrite

```
  ##
  # Lazy Resize
  ##
  RewriteCond %{REQUEST_FILENAME} system/images/([^_].*\.(png|jpe?g|gif))$
  RewriteRule .* system/images/_%1

  # Rewrite pixel ratio changes
  RewriteCond %{REQUEST_FILENAME} !pixelRatio
  RewriteCond %{HTTP_COOKIE} lazyResizePixelRatio=(\d+) [NC]
  RewriteRule system/images/(.*) system/images/_pixelRatio%1$1

  # Rewrite resolution changes
  RewriteCond %{REQUEST_FILENAME} !resolution
  RewriteCond %{HTTP_COOKIE} lazyResizeResolution=(\d+) [NC]
  RewriteRule system/images/(.*) system/images/_resolution%1$1

  # Generate image if not exists
  RewriteCond %{REQUEST_FILENAME} system/images/
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule (.*)/.* system/modules/lazyResize/resize.php [L]
```

Remove this from your .htaccess

```
  ##
  # Do not rewrite requests for static files or folders such as style sheets,
  # images, movies or text documents. Do not add the URL suffix here!
  ##
  <FilesMatch "\.(png|gif|jpe?g|js|css|ico|php|xml|csv|txt|gz|swf|flv|eot|woff|svg|ttf|htm)$">
    RewriteEngine Off
  </FilesMatch>
```

and replace with

```
  ##
  # Do not rewrite requests for static files or folders such as style sheets,
  # images, movies or text documents. Do not add the URL suffix here!
  ##
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
```

Hint: the RewriteEngine does not realy work with FilesMatch!

How to detect a lazy resize
---------------------------

The constant LAZY_RESIZE show you, that the current call of getImage is a lazy resize call.

```php
if (defined('LAZY_RESIZE')) {
    // lazy resize
}
```

How to temporarily disable lazy resize
--------------------------------------

If you want to disable lazy resize temporarily, just change the flag `$GLOBALS['lazyResize']` to `false` or `true`.

```php
<?php
// disable lazy resize
$GLOBALS['lazyResize'] = false;

// output some images, using Controller::getImage

// reenable lazy resize
$GLOBALS['lazyResize'] = true;
?>
```

Known issues
------------

If a rendered file exists in system/html, the lazyResize does not work, because the getImage Hook is never triggered.
Buf if the file is deleted (clean up system/html), lazyResize get triggered.

ZF2 Route Printer
=================

Generates a pretty(ish) printed HTML file containing a list of all routes in a
given ZF2 configuration file. Works best when used with a pre-merged
configuration file.

This was a quick and dirty script. Sorry...

Usage
-----

If you have a `module-config-cache.php` (you can use the cached config from
Zend\ModuleManager)...

```php
<?php
return array (
  'router' => 
  array (
    'routes' => 
    array (
      'doctrine_orm_module_yuml' => 
      array (
// ... etc.
```

Then you can simply feed this file as parameter to `print.php`:

```
$ php print.php /path/to/my/pre-merged-config.php > output.html
```

This should generate `output.html` which is standalone and can be sent or served
up as static config.

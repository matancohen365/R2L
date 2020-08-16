
### Auto RTL

Simple class to rtl your themes

### 🍕 How to use?

##### *.css files

```php

<?php

require __DIR__ . '/vendor/autoload.php';  
  
$processor = new \AutoRTL\CSSProcessor();  
  
$contents = file_get_contents('path/to/theme.css');  
  
$RTLContents = $processor->process($contents);  
  
file_put_contents('path/to/theme.rtl.css', $RTLContents);

```
  
##### *.liquid.sass files (Shopify templates)

```php

<?php

require __DIR__ . '/vendor/autoload.php';  
  
$processor = new \AutoRTL\LiquidSassProcessor();  
  
$contents = file_get_contents('path/to/theme.liquid.sass');  
  
$RTLContents = $processor->process($contents);  
  
file_put_contents('path/to/theme.rtl.liquid.sass', $RTLContents); 

```

### 🙋️ Questions? Need some help? 
 - matan.cohen.365@gmail.com

### ☕  Buy me a coffee 

 - [Donate via PayPal](https://bit.ly/3171pMx)
 
🆓 License
----

MIT

**Free Software, Hell Yeah!**

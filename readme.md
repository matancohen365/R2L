
### R2L (RTL TO LTR)

right-to-left your left-to-right assets in a push of a button

### 🍕 How to use?

##### *.css files

```php

<?php

use R2L\CSSProcessor;

require __DIR__ . '/vendor/autoload.php';  
  
$processor = new CSSProcessor();  
  
$contents = file_get_contents('path/to/theme.css');  
  
$RTLContents = $processor->process($contents);  
  
file_put_contents('path/to/theme.rtl.css', $RTLContents);

```
  
##### *.liquid.sass files (Shopify templates)

```php

<?php

use R2L\LiquidProcessor;
use R2L\SassProcessor;

require __DIR__ . '/vendor/autoload.php';  
  
$processor = new LiquidProcessor(new SassProcessor());
  
$contents = file_get_contents('path/to/theme.liquid.sass');  
  
$RTLContents = $processor->process($contents);  
  
file_put_contents('path/to/theme.rtl.liquid.sass', $RTLContents); 

```

### TODO
 - Better Tests.
 
### 🙋️ Questions? Need some help? 
 - matancohen365@gmail.com
 
🆓 License
----

MIT

**Free Software, Hell Yeah!**


# Auto RTL

Allows you to take a frontend template designed for left-to-right usage and transform it into right-to-left design.

## Demo

[https://ltr2rtl.com/][4]

## Usage

### *.css files

```php

<?php

use R2L\CSSProcessor;

require __DIR__ . '/vendor/autoload.php';  
  
$processor = new CSSProcessor();  
  
$contents = file_get_contents('path/to/theme.css');  
  
$RTLContents = $processor->process($contents);  
  
file_put_contents('path/to/theme.rtl.css', $RTLContents);

```
  
### *.liquid.sass files (Shopify templates)

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

## Installation

### With Composer

```
$ composer require matancohen365/auto-rtl
```

## TODOs
 - Better Tests.

## Thanks
 * [Alexander Raskin][1] for [ltr2rtl][2]
 
## Questions
 - matancohen365@gmail.com
 
🆓 License
----

The Non-Profit Open Software License version 3.0 (NPOSL-3.0)

[https://opensource.org/licenses/NPOSL-3.0][3]

[1]: https://github.com/intval
[2]: https://github.com/intval/ltr2rtl
[3]: https://opensource.org/licenses/NPOSL-3.0
[4]: https://ltr2rtl.com/

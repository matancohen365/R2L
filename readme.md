
# R2L

LTR to RTL Converter

Allows you to take a frontend template designed for left-to-right usage and transform it into right-to-left design.

## Demo

[R2L - LTR to RTL Converter](https://ltr2rtl.com/)

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
 
## Questions
 - matancohen365@gmail.com
 
🆓 License
----

The R2L package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

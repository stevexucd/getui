GeTui
=====
GeTui extensions

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist stevexu/getui "*"
```

or add

```
"stevexu/yii2-getui": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

add to config file in component section:
```php
'getui'=>[
    		'class' => 'stevexu\getui\Getui',
//     		'appid' => 'a75fa85cfef87b0ae43d',	
//     		'appkey' => 'a75fa85cfef87b0ae43d',
//     		'mastersecret' => 'a75fa85cfef87b0ae43d',
    	],
```
```php
\Yii::$app->getui->run();
```

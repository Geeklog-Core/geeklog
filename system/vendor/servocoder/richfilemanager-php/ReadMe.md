PHP connector for Rich Filemanager
========================

This package is the part of [RichFilemanager](https://github.com/servocoder/RichFilemanager) project.

Requires PHP >= 5.6.4


Introduction
------------

PHP connector provides a flexible way to manage you files at different king of storages.
There are 2 storages supported out of the box:

- [Local filesystem storage](#local-filesystem-storage)
- [AWS S3 storage](#aws-s3-storage)

Configuration details for each are described below.
You create implementation for any other storage that you wish by implementing Api and Storage classes.


Installation
------------

```sh
composer require servocoder/richfilemanager-php
```

NOTE: Most likely you won't have to install PHP connector separately. It's sufficient to run composer of the main package.
Check out the [installation guide](https://github.com/servocoder/RichFilemanager/wiki/PHP-connector) of RichFilemanager main package for PHP connector.

**AWS PHP SDK**

If you are going to use AWS S3 storage make sure that AWS PHP SDK package version >= 3.18.0 is added to the "require" section of
RichFilemanager [composer.json](https://github.com/servocoder/RichFilemanager/blob/master/composer.json) file:

```json
{
  "require": {
    "servocoder/richfilemanager-php": "*",
    "aws/aws-sdk-php": "^3.18.0"
  }
}
```

FYI - Amazon PHP SDK installation guide:
https://docs.aws.amazon.com/aws-sdk-php/v3/guide/getting-started/installation.html


Entry point setup
-----------------

RichFilemanager provides [entry point script](https://github.com/servocoder/RichFilemanager/blob/master/connectors/php/filemanager.php) out of the box,
so you don't have to create it from scratch. In this section you can find explanations and examples to setup the entry script.

1. Initiate application.

```php
$app = new \RFM\Application();
```

2. Create and set storage class instance.
Usually you will use a single storage, but it's possible initiate instances for various storages to use both in API.
For example, AWS S3 API can use S3 storage instance to manage original files and Local storage to manage image thumbnails.
More details in the [Configuration](#configuration) section. 
   
```php
// local filesystem storage
$local = new \RFM\Repository\Local\Storage();
$app->setStorage($local);

// AWS S3 storage instance
$s3 = new \RFM\Repository\S3\Storage();
$app->setStorage($s3);
```

3. Create and set API class instance. You can set only one API instance unlike storage instances. 

```php
// local filesystem API
$app->api = new RFM\Api\LocalApi();
```

OR

```php
// AWS S3 API
$app->api = new RFM\Api\AwsS3Api();
```

4. Run application. 

```php
$app->run();
```


Documentation
-------------

The [Wiki pages](https://github.com/servocoder/RichFilemanager-PHP/wiki) provide articles that details the following subjects:

- [Configuration](https://github.com/servocoder/RichFilemanager-PHP/wiki/Configuration)
- [Security concerns](https://github.com/servocoder/RichFilemanager-PHP/wiki/Security)
- [User storage folder setup](https://github.com/servocoder/RichFilemanager-PHP/wiki/User-storage-folder)
- [Debug and Logging](https://github.com/servocoder/RichFilemanager-PHP/wiki/Debug-and-Logging)
- [Integrations](https://github.com/servocoder/RichFilemanager-PHP/wiki#integrations)
- etc.


MIT LICENSE
-----------

Released under the [MIT license](http://opensource.org/licenses/MIT).
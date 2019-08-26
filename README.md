# Laravel OpenCC

OpenCC for Laravel Application.

## Requirements

- [opencc4php](https://github.com/NauxLiu/opencc4php)

## Installation

Composer

```shell
$ composer require mvmx/l5-opencc
```

## Configuration

Publish Configuration

```php
$ php artisan vendor:publish --provider "Mvmx\OpenCC\ServiceProvider"
```

## Usage

```php
OpenCC::trans('四面垂杨十里荷，问云何处最花多。画楼南畔夕阳和。', 's2t'); // 四面垂楊十里荷，問云何處最花多。畫樓南畔夕陽和。
```

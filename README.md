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

```php

    /**
     * 默认转换配置
     */

    'default' => 's2t.json',

    /**
     * 转换配置别名
     */

    'aliases' => [
        's2t' => 's2t.json', // 简体到繁体
        't2s' => 't2s.json', // 繁体到简体
        's2tw' => 's2tw.json', // 简体到台湾正体
        'tw2s' => 'tw2s.json', // 台湾正体到简体
        's2hk' => 's2hk.json', // 简体到香港繁体（香港小学学习字词表标准）
        'hk2s' => 'hk2s.json', // 香港繁体（香港小学学习字词表标准）到简体
        's2twp' => 's2twp.json', // 简体到繁体（台湾正体标准）并转换为台湾常用词汇
        'tw2sp' => 'tw2sp.json', // 繁体（台湾正体标准）到简体并转换为中国大陆常用词汇
    ],

    /**
     * 转换替换
     */

    'replace' => [

        // 简体到繁体
        's2t.json' => [
            // '艳' => '艷',
        ],

        ...

```


## Usage

```php
OpenCC::trans('四面垂杨十里荷，问云何处最花多。画楼南畔夕阳和。', 's2t'); // 四面垂楊十里荷，問云何處最花多。畫樓南畔夕陽和。
```

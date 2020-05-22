### Should docker install
check docker version
```bash
docker --version
```
---
### Must docker compose
check docker compose version
```bash
docker-compose --version
```
---
### запуск проекта php-fpm + nginx
скопировать env-example to .env
```bash
cp env-example .env
```
---
run docker containers
```bash
docker-compose up --build
```
### инициализация проекта
```bash
docker-compose exec php php init.php
```
запуск миграцию
```bash
docker-compose exec php php yii migrate
```
### настройка Phpstorm
откройте Yii.php файл `./vendor/yiisoft/yii2/Yii.php` и отметит как текст (Mark as plain text)

чтобы включить debug panel открывает `web-local.php` и добавим 
```php
<?php

$config['bootstrap'][] = 'debug';
$config['modules']['debug'] = [
    'class'      => \yii\debug\Module::class,
    'allowedIPs' => ['*'],
];

$config['bootstrap'][] = 'gii';
$config['modules']['gii'] = [
    'class'      => \yii\gii\Module::class,
    'allowedIPs' => ['*'],
];

return $config;
```
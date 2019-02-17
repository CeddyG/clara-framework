Clara Famework
===============

Basic components for Clara.

## Installation

```php
composer require ceddyg/clara-framework
```

Add to your providers in 'config/app.php'
```php
CeddyG\Clara\ServiceProvider::class,
```

Then to publish the files.
```php
php artisan vendor:publish --provider="CeddyG\Clara\ClaraServiceProvider"
```

# Osaris UK - Log Viewer

## Usage

You can publish the config file with:

```bash
php artisan vendor:publish --provider="OsarisUk\LogViewer\LogViewerServiceProvider" --tag="config"
```

And the views with:

```bash
php artisan vendor:publish --provider="OsarisUk\LogViewer\LogViewerServiceProvider" --tag="views"
```


## Config

In the config you can define the default route paramaters:

```php
    'routes' => [
        'name' => 'log',
        'prefix' => 'log',
        'middleware' => [
            'web'
        ]
    ]
```


## Views

This package ships with a basic view, this can be published and editied to fit your application.
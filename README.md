# Auth plugin for CakePHP

**NOTE:** It's still in development mode, do not use in production yet!

## Requirements

It is developed for CakePHP min. 3.x.

## Installation

You can install plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:
```
composer require kicaj/auth dev-master
```

## Load the Plugin

Load the Plugin in your bootstrap.php:
```
$this->addPlugin('Auth');
```

## Load the Component

Load the Component in your AppController.php:

```
public function initialize()
{
    parent::initialize();

    // ...
    $this->loadComponent('Auth.Authentication');
    // ...
}
```

Nextly, you should set authorization action list for each controller by `auth` property, like below:

```
public $auth = [
    'admin' => [
        'add',
        'edit',
        'delete',
    ],
    '*' => [
        'view'
    ],
];
```

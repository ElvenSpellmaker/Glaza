#Глаза (Glaza)

Глаза is a *very* basic view handler and parser for PHP views.

## Installing
Installing can be done through Composer:

`composer require ElvenSpellmaker/Glaza`
When asked which version to use, for now please use `dev-master`.

If you don't want to use Composer, then clone the repo and include the provided AutoLoader:
```php`
<?php

require_once 'path/to/Autoloader.php';
```

Now all classes can be loaded as needed.

## Why Глаза?
Glaza means eyes in Russian, and views are things you see the application through.

I was tired of templating frameworks either being too large or depending on too many other packages and wanted something quick and dirty to parse PHP views to separate my logic from my presentation code.

## Basic Usage
The first step is to either install the package through Composer or to include the Autoloader to load the classes.

The next step is to create a view:
```php
use ElvenSpellmaker\Глаза\View;

$view = new View( 'ViewTestHtml' );
```

This will look for a file in current working directory called `ViewTestHtml.php`, if this doesn't exist an SPL `RuntimeException` will be thrown.

You may now assign data to the view to appear in the templates:
```php`
$view->set( 'foo', 'World!' );
```

Views can contain other views too:
```php`
$view->set('bar', new View( 'NestedView' ) );
```

###Rendering A View

In `ViewTestHtml.php` is the code:
```php
<html>
    <body>
        Hello <?=$foo?>
    </body>
</html>
```

Rendering Views is really easy. Either call their `render` method, or typecast them to a string, either by an explicit cast `(string)` or by trying to echo the view: `echo $view`.

> Note: Views are rendered from the inside-out, which while it makes sense is worth pointing out.

Using the above exmaple the output is shown below:
```php
<html>
    <body>
        Hello World!
    </body>
</html>
```

###Automatic Escaping (Sanitisation)
Consider the following code:
```php`
$view->set('foo', '<b>Not Bold</b>');
```
The above will render as `&lt;b&gt;Not Bold&lt;/b&gt;` --> <b>Not Bold</b> because by default `htmlspecialchars()` is used to sanitise input.
In order to override this, pass `false` as the third argument to `View::set`:
```php`
$view->set('foo', '<b>Bold</b>', false);
```
This will render as `<b>Bold/b>` --> **Bold** which might be what you wanted!

### Finding Views In Other Directories
It's very likely you want to find your views in other directories and this is possible in two ways:

 1. Specify the full path to the View as you create the View: `$view = new View( '/full/path/to/view' );`
 2. Use the `ViewManager` class and add paths to search through. (This will be ultimately slower especially with the more paths that are added)

An example of method 2 is shown below:
```php
use ElvenSpellmaker\Глаза\ViewManager;

ViewManager::addViewPath( __DIR__ ); // Adds the current script's path to the ViewManager.
```

Now when you create a new view it will first search the current working directory and *then* search the added directory.
The order the directories are searched in is the order in which they are added. It it possible to add the path to be added to the beginning of the path list, by passing `false` to `ViewManager::addViewPath` as a second parameter. This will `array_unshift` the path to the front of the list.

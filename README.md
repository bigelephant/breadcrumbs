# Breadcrumbs

This is designed for use within Laravel 4 which is all this readme will cover, however it could be used outside of it if you liked.

## Installation
Go into your applications composer.json file and add `"bigelephant/breadcrumbs": "1.0.*"` to your require list and run `composer update`.

After this is done you can use the breadcrumbs like you would any other composer package.

## Laravel Integration

So you can use a `Crumbs::` facade and have some crumbs automatically set you need to add `'BigElephant\Breadcrumbs\CrumbsServiceProvider',` to the providers array and `'Crumbs'   => 'BigElephant\Breadcrumbs\Facades\Crumbs',` to the `aliases` array in your `config/app.php` file.

There is also a custom routing class you can use which will add a crumb to your list depending on the route. With it if you add the optional `title => 'Title For Crumb'`, in the same manner as `as => 'home',`. If this title is set and you use the custom Router it will set that breadcrumb for you.

Instructions for using a custom router coming soon...
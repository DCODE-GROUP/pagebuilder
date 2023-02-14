# Page Builder

This package provides functionality for a CMS like page builder in Laravel. This includes managing pages and their content.

The package is extendable on per-project basis: new components, templates and page layouts can be defined.

## Installation

You can install the package via composer:

```bash
composer require dcodegroup/page-builder
```

Then run the install command.

```bash
php artisan vendor:publish --tag=page-builder-config
php artisan vendor:publish --tag=page-builder-migrations
```

This will publish the configuration file and the migrations.

Then run the migrations:

```bash
php artisan migrate
```


## Configuration

Most of configuration has been set the fair defaults. However you can review the configuration file at `config/page-builder.php` and adjust as needed.

The configuration values are mostly used for adding middleware, prefixes and groups for the routes used by the admin and the site functionality.

## Routes

The following routes are exposed by the package

Admin side:
```
/admin/pages - List all available pages
/admin/pages/{page} - Edit page
/admin/pages/{page}/preview - Ajax endpoint for generating previews for a page

/admin/templates - List all available layout templates
```

Frontend side:
```
/{slug} - Renders a page with the given slug. Returns 404 if not found.
```

## Extending

### Components

Components can be added or changed using the DI container in Laravel. These examples should be added to one of your `ServiceProvider` (`AppServiceProvider` will do).

New components can be registered with the following method:

```php
$this->app->tag([
    \App\MyCMSModules\Heading::class
], 'page-builder-modules');
```

Existing components can be overwritten with the following method:

```php
$this->app->bind(\Dcodegroup\PageBuilder\Modules\Heading::class, \App\MyCMSModules\Heading::class);
```

#### Component templates

The available templates for a component can be defined in the component's PHP class by overwriting the `availableTemplates()` method on the Module class. After this, the UI will show a select input where you can select which template do you want to use when rendering the page. The templates must be available as a view with the name of (e.g. for a Heading module): `page-builder::modules.heading.my-template`. For example, in a specific project, this is located at: `{$projectRoot}/resources/views/vendor/page-builder/modules/heading/my-template.blade.php`

### Layout templates

The layout templates are managed from the `/admin/templates` page. First you have to create a new record with each added template. The `key` field of the template will be used when searching for the Blade view. The templates must be available as a view with the name of `page-builder::templates.{$key}`. E.g. in a specific project this can be at `{$projectRoot}/resources/views/vendor/page-builder/templates/my-template.blade.php`. In this case the template key will be `my-template`.

# Configuration

You can find the config of oscer in `config/cms.php`.  
You can publish it with `php artisan cms:publish` if the file does not exist.

### `from_email`
This configuration value will be used for all E-Mails which are sent by oscer.

### `backend`
This key is for all Admin UI related things.

#### `domain`
This variable lets the authentication system know on which domain oscer will run.
I can be set via the environment variable `CMS_BACKEND_DOMAIN`.

#### `url`
This is the url prefix of the admin routes. You can change it if these routes clash with your 
current route configuration.

#### `middleware`
Here you can change the middleware which is used for the admin ui.

### `resources`
These are currently active resources. 
They hold the data for the CMS and are available via API and Forms.
Not all resources have forms or all API endpoints. 
You can read more about each resource in its section in the documentation.

### `options`
These is the configuration of the Options in the Admin ui. The first level defines the tab 
and every key inside of a tab declares an options field. You can declare any tabs 
you want except the `theme` key which is used by the options of the `Theme`.  
Currently there is only the `text` type.

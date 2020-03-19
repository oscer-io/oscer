# Configuration

You can find the config of laravel CMS in `config/cms.php`.  
You can publish it with `php artisan cms:publish` if the file does not exist.

### `from_email`
This configuration value will be used for all E-Mails which are sent by Laravel CMS.

### `database_connection`
Laravel CMS uses its own database connection and migrations. This way we can ensure to not conflict with your tables.
This configuration variable is to set the corresponding database_connection. 
If you have followed the installation instructions you are good to go with this value.

### `backend`
This key is for all Admin UI related things.

#### `url`
This is the url prefix of the admin routes. You can change it if these routes clash with your 
current route configuration.

#### `middleware`
Here you can change the middleware which is used for the admin ui.

### `options`
These is the configuration of the Options in the Admin ui. The first level defines the tab 
and every key inside of a tab declares an options field. You can declare any tabs 
you want except the `theme` key which is used by the options of the `Theme`.  
Currently there is only the `text` type.

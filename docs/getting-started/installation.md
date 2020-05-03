# Installation

### Install dependencies
You can install the package via composer:
```bash
composer require oscer-io/oscer
```

### Install Oscer

```bash
php artisan cms:install
```  
To skip the interactive part of the command you can append `--dev` which adds defaults for the first user.  
The `--fresh` option migrates the database fresh. These options in combination speed up the process in development.
Simply execute `php artisan cms:install --dev --fresh` to "reset" Oscer.  

### Add environment variable

Let the authentication system know on which domain Oscer will run:
```bash
# ...
CMS_BACKEND_DOMAIN=web.cms.test
```  


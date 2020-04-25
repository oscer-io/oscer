# Coding Style Guide

The key words “MUST”, “MUST NOT”, “REQUIRED”, “SHALL”, “SHALL NOT”, “SHOULD”, “SHOULD NOT”, “RECOMMENDED”, “MAY”, and “OPTIONAL” in this document are to be interpreted as described in [RFC 2119](http://www.ietf.org/rfc/rfc2119.txt).

## PHP
We follow the [Laravel Coding Style](https://laravel.com/docs/7.x/contributions#coding-style), which is yet based on [PSR-2](https://www.php-fig.org/psr/psr-2/) but will probably be [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standard and [PSR-4](https://www.php-fig.org/psr/psr-4/) autoloading standard.

----

## Vue JS
We follow the recommendations defined in the [Vue.js Style Guide (beta)](https://vuejs.org/v2/style-guide/).<br>
The following sections further define our conventions.

### Directorynames
- directories MUST be `lowercase`
- directories that group particular Models views (i.e. Pages, Posts, Menus) MUST be `PascalCase`

### Filenames
- JS class files MUST be `PascalCase`
- other JS files MUST be `lowercase`
- Vue files MUST be `PascalCase`

### Directory Structure
- components MUST be stored in `js/components/`
- components that group particular Models views MUST be stored in `js/views/`
- mixins MUST be stored in `js/mixins/`
- library JS files MUST be stored in `js/lib/`  (i.e. classes, modules etc.)
- files that handling the bootstrapping of Oscer must be stored in `js/bootstrap/`

**Example:**

```
js
|--	bootstrap
|	|-- components.js
|	`-- ...
|-- components
|	|-- base
|	|	|-- BaseButton.vue 
|	|	|-- ... 
|	`-- fields
|		|-- ListField.vue
|		|-- ListItemField.vue
|		`-- ...
|--	lib
|	|-- Router.js
|	`-- ...
|--	mixins
|	|-- route.js
|	`-- ...
|-- views
|	|-- Pages
|		`-- ... 
|	|-- Posts
|	|	|-- Index.vue
|	|	|-- Create.vue 
|	|	`-- ... 
|	`-- ... 
`-- ... 


```

### Components

#### Component Tags
- Components with no content MUST be self-closing in single-file components, string templates, and JSX - but MUST NEVER in DOM templates. ([detailed info](https://vuejs.org/v2/style-guide/#Self-closing-components-strongly-recommended))
- Component Tags MUST be in the `PascalCase` and MUST NOT be `kebab-case` ([detailed info](https://vuejs.org/v2/style-guide/#Single-file-component-filename-casing-strongly-recommended))

#### Single instance components
Single instance components are should only ever have one single active instance. This does not mean the component is only used in one single page, but it will only be used once per page. 
- Single instance components MUST begin with `The` (i.e. TheHeading.vue) ([detailed info](https://vuejs.orgv2/style-guide/#Single-instance-component-names-strongly-recommended))
- single instance components MUST never accept anyprops (since they are specific to the app, not their context within the app)([detailed info](https://vuejs.org/v2/style-guide/#Single-instance-component-names-strongly-recommended))

#### Base components
Base components (a.k.a. presentational, dumb, or pure components) apply app-specific styling, don't apply complex logic and are used frequently. Such components will become loaded automatically. [detailed info](https://vuejs.org/v2/style-guide/#Base-component-names-strongly-recommended)

- component file names MUST start with `Base` (i.e. BaseButton.vue)
- component tag names MUST start with `Base` (i.e. `<BaseButton>Foo Bar Baz</BaseButton>`)

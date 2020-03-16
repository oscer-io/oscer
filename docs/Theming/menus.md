# Menus

In Laravel CMS menus are defined by code and the menu items are in the database. 
This way we can ensure that the editor does not delete a menu accidentally.
 
## Declaration

To declare a new menu, simply extend the array in the `getMenus()` . 
Currently it only contains a single key which sets the template that will be used to render the menu.

## Rendering

The Rendering of a menu is done by `<x-menu/>` Blade component. 
It accepts the attribute name to specify which menu should be rendered.
```
<x-menu name=“main“/>
```

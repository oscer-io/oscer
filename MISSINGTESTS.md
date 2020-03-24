# This is a list with all the test cases which are missing

## Feature
* Login
    * Wrong password gives error
    * Not existent email gives error
* Forgot password
    * The password can be reset
* Create user
    * a user can be created
    * the data needs to be valid (all cases)
* Delete user
    * a user can be deleted
* Update profile
    * the profile can be updated
    * the password can be changed
* Create menu item
    * a menu item can be created
    * the data needs to be valid (all cases)
* Update menu item
    * a menu item can be updated
    * the data needs to be valid (all cases)
* Delete menu item
    * a menu item can be deleted
* Reorder menu items
    * the menu items can be reordered
* Create Posts
    * a post can be created
    * the data must be valid
* Update Posts
    * a post can be updated
    * the data must be valid

* Api
    * all options stuff
    * Create menu item
        * a menu item can be created
        * the data needs to be valid (all cases)
    * Update menu item
        * a menu item can be updated
        * the data needs to be valid (all cases)
    * Delete menu item
        * a menu item can be deleted
    * Reorder menu items
        * the menu items can be reordered

Frontend:
* Theme will be passed to any Frontend view.
 
 ## Unit
* Menu
    * it can resolve its children in the correct order
* SetLocale
    * the locale will be set on user language
* Post
    * it syncs the tags automatically
* CmsRouter
    * blog routes will be registered
    * blog prefix will be set
    * blog middleware will be set
    * page slugs will be cached
    * page routes will be registered
    * page prefix will be set
    * page middleware will be set

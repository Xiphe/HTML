HTML - The clean code approach
==============================

Author: Xiphe  
URL: http://xiphe.net  
Plugin Info: http://xiphe.net/html/  
Plugin Code: https://github.com/XIPHE/HTML  
Version:2.0.0  
Date: 2013-01-02 13:00:00 +01:00  
Requires: 3.0  
Tested: 3.5  




Description
-----------

### This is a PHP-based HTML Markup generator.

The main benefits are:

* no switching between php and html or echoing of html strings needed when you are inside your php stuff.
* Minimalistic usage attempt and helper functions. You should be able to generate more html markup with less php instructions while keeping full flexibility.
* Auto-indention. Unless you turn it of to save whitespace you will receive beautifully indented and super-readable markup for your web-projects.

The main downfalls are:

* Page generation takes longer, because every html-tag will run through a lot of php functions while being generated.  
(I use it along with wordpress and can not make a humanly noticeable difference in page loading speed when changing from a default wp-theme to one that uses the generator.)
* It may be difficult to learn how to use this, compared to writing pure html.

This project is inspired by the [CakePHP HtmlHelper](http://api.cakephp.org/class/html-helper).

[Demo-/Testpage](http://html.xiphe.net/demo/)  
[Documentation(phpDocumentor)](http://html.xiphe.net/doc/)




3rd Party
---------

* **[PHP Diff Class](https://github.com/chrisboulton/php-diff)** by Chris Boulton (Used for the Demos/Tests. Will not be loaded in productive usage).
* **[PHP Markdown](http://michelf.ca/projects/php-markdown/)** by Michel Fortin
* **[phpDocumentor](http://www.phpdoc.org/)** was used to generate the documentation under /doc



Installation
------------

### Wordpress

1. Upload the plugin directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

### Standalone

1. Include `_html.php`.



Changelog
---------

### 2.0.0
+   COMPLETE REMAKE. Most functionality should still work the same way as in 1.x but most likely not everything.
	+   Introducing the Xiphe\HTML namespace
	+   Better modular OOP Structure
	+   Minimalistic Instances + most logic is now static.
	+   Tag Instances
	+   Test Cases
	+   much more...

### pre 2.0
+   see changelog.txt




Todo
----

* radio and checkbox group generation
* Functionality to add own modules and manipulate the TagInfo Class.
* More Test Cases
* Still better documentation
* Checking the Clean-Settings
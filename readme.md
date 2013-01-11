HTML - a PHP-based HTML Markup generator
========================================

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

* **[PHP Diff](https://packagist.org/packages/phpspec/php-diff)** by Chris Boulton (Used for the Demos/Tests. Will not be loaded in productive usage).
* **[Markdown](https://packagist.org/packages/dflydev/markdown)** by Dragonfly Development Inc, Beau Simensen, Michel Fortin and John Gruber
* **[phpDocumentor](http://www.phpdoc.org/)** was used to generate the documentation under /doc



Installation
------------

### Wordpress

1. Download the [latest "alldeps" branch](https://github.com/Xiphe/HTML/archive/alldeps.zip)
1. Extract the archive and upload the plugin into the `/wp-content/plugins/` directory of your wordpress project.
2. Activate the plugin through the 'Plugins' menu in WordPress

### Standalone

Use composer and require `"xiphe/html": "2.0.*"`

or download the [latest "alldeps" branch](https://github.com/Xiphe/HTML/archive/alldeps.zip),
extract it and put it anywhere in your php project.
Then include `[path to]/bootstrap.php` or `[path to]/vendor/autoload.php`.



Changelog
---------

### 2.0.6
+ fixed bugs related to Store::get()
+ desktop/mobile classes on html tag if THETOOLS are available.

### 2.0.5
+ callbacks for tags
+ configuration modes
+ bugfixes

### 2.0.4
+ fixed wp textdomain error 

### 2.0.3
+ if() and endif() pseudotags
+ BasicModule::generate() generates a default tag using the module parameters.
+ When Generator::call is called directly, tag options can now be passed as a third argument
	in addition to prefix them to the Tag

### 2.0.2
+ composer update test.

### 2.0.1
+ composer compatible.
+ now uses composer versions off php-diff and markdown.

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





Bugs
----

* The fist line of a multi-lined &lt;li&gt; has a false indention when cleaned with strong mode. 




Todo
----

* radio and checkbox group generation
* Functionality to add own modules and manipulate the TagInfo Class.
* More Test Cases
* Still better documentation
* Array-style attribute maipulation on Tags would be nice. $Tag[id] = 'myID';

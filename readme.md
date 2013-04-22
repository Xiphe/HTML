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


Installation
------------

### Wordpress

1. Download the [latest "alldeps" branch](https://github.com/Xiphe/HTML/archive/alldeps.zip)
1. Extract the archive and upload the plugin into the `/wp-content/plugins/` directory of your wordpress project.
2. Activate the plugin through the 'Plugins' menu in WordPress

### Standalone

Use [composer](http://getcomposer.org/) and require `"xiphe/html": "2.0.*"`

or download the [latest "alldeps" branch](https://github.com/Xiphe/HTML/archive/alldeps.zip),
extract it and put it anywhere in your php project.
Then include `[path to]/bootstrap.php` or `[path to]/vendor/autoload.php`.


Basic Usage
-----------

Follow the [Installation](https://github.com/Xiphe/HTML#installation) steps to initiate the global $HTML variable.

```php
<?php
/* Get access to an instance of Xiphe\HTML */
global $HTML

/* Opens a std HTML5 header - leaves you inside the <head> */
$HTML->HTML5()
	/* print a <title> */
	->title('HTML Example')
/* close the <head> tag */
->close('head')
/* open a <body> tag (s_[tag] will just open a [tag] - no </tag> will be echoed) */
->s_body()
	/* open a <div> tag with the class attribute "wrap" */
	->s_div('.wrap')
		/* open an <article> tag with an id */
		->s_article('#article1')
			/* print a <h1> with multiple attributes */
			->h1('Hello Stranger', array('style' => 'color: red;', 'rel' => 'title'))
			/* <3 */
			->p('Thank you for checking out Xiphe\HTML - that\'s very kind of you')
			/* Another way to pass multiple attributes to a tag */
			->img('src=http://upload.wikimedia.org/wikipedia/commons/c/ce/Example_image.png|alt=example')
/* close all Tags that have been opened previously */
->close('all');
```

Output:

```html
<!DOCTYPE HTML>
<html class="no-js">
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
		<title>HTML Example</title>
	</head>
	<body>
		<div class="wrap">
			<article id="article1">
				<h1 rel="title" style="color: red;">Hello Stranger</h1>
				<p>Thank you for checking out Xiphe\HTML - that's very kind of you</p>
				<img alt="example" src="http://upload.wikimedia.org/wikipedia/commons/c/ce/Example_image.png" />
			</article><!-- #article1 -->
		</div><!-- .wrap -->
	</body>
</html><!-- .no-js -->

```

Want to dig deeper?
[poke](https://github.com/Xiphe/HTML/issues) me to write a better documentation.
Or check out the [Test/Examples Hybrid on html.xiphe.net](http://html.xiphe.net/demo/).


3rd Party
---------

* Js/Css Minifiying from **[Fat-Free Framework](https://github.com/bcosca/fatfree)**  
	Distributed under the GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007  
	Copyright (c) 2009-2012 F3::Factory/Bong Cosca
* **[PHP Diff](https://packagist.org/packages/phpspec/php-diff)** by Chris Boulton (Used for the Demos/Tests. Will not be loaded in productive usage).  
	BSD License  
	Copyright (c) 2009 Chris Boulton <chris.boulton@interspire.com>  
	All rights reserved.
* **[Markdown](https://packagist.org/packages/dflydev/markdown)**  
	PHP Markdown & Extra  
	Copyright (c) 2011, Dragonfly Development Inc  
	All rights reserved.  

	Based on PHP Markdown & Extra  
	Copyright (c) 2004-2009 Michel Fortin  
	<http://michelf.com/>  
	All rights reserved.  

	Based on Markdown  
	Copyright (c) 2003-2006 John Gruber  
	<http://daringfireball.net/>  
	All rights reserved.  
* **[phpDocumentor](http://www.phpdoc.org/)** was used to generate the documentation under /doc



Changelog
---------

### 2.0.10
+ mergeClasses method added to core\Generator

### 2.0.9
+ minor bugfixes and compatibility to THETOOLS v1.0.7

### 2.0.8
+ Select Module updated

### 2.0.7
+ [New Logic](https://github.com/bcosca/fatfree/blob/918eb1048742cf8780c6e3d61f3d1ea066d9fb73/lib/web.php#L464) for Content::compress()
+ Googleanalytics Module allowes $HTML->googleanalytics('UA-0000000-0') for a simple, compressed ga tracker code
+ Added basic Sublime Text 2 snippet

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

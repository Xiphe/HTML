HTML - The clean code approach
==============================

Author: Hannes Diercks  
URL: http://www.red-thorn.de  
Plugin Info: http://plugins.red-thorn.de/libary/!html/  
Version: 1.4.8  
Date: 2012-02-24 11:00:00  
Requires: 3.0  
Tested: 3.3.1  




Description
-----------

This is a Wordpress Plugin that initializes the HTML and 
HTMLCleaner Class and generates a global variable called HTML.

This plugin is for other plugin-developers that want to use
the HTML Class and does nothing by itself besides initiating
the global and including the class files.

See [Demo Page](http://plugins.red-thorn.de/libary/!html/demo) for details




Installation
------------

1. Upload the plugin directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress




Changelog
---------

### 1.4.9
+	$HTML->select now accepts arrays for options attributes.
+	$HTML->ajaxMode( true||false ) added for disabeling comments, tabs and breaks.

### 1.4.8
+	$HTML->tag('fb', '.foo|#bar'); now available for <tag class="foo" id="bar">fb</tag>

### 1.4.7
+	added viewport() & appleIcon()
+	renamed readme.txt into readme.md
+	added functionality: end() function now accepts tagnames, ids and first class parameters to 
	end all tags until match.

### 1.4.6
+	github init
+	"labels" first attr is now "for"

### 1.4.5
+	Added checkbox($attrs, $label, $checked) && checkgroup() method
+	Fixed _add_label() bug, Strings are now ok for labels.
+	Added css() as alias to link & js() as alias to script
+	Added private _selfContainingTags property

### 1.4.42
+	Bugfix for HTMLCleaner, now correctly accepts slashes in opening <a href="http://"[...] Tags

### 1.4.41
+	Updates are now via THEMASTER

### 1.4.4
+   Changed defining of the constant "HTMLCLASSAVAILABE" into class file.

### 1.4
+   **First public version**

### 1.0
+   Intern version *no details*




Upgrade Notice
--------------

### 1.4.7
+	github test

### 1.4
+   First stable & public version




Known Bugs
----------

+   None ;)




Todo
----

### 1.4.43
+	Add radio() & radiogroup()
### 1.4.42
+	Fix Closing Tabs in HTMLCleaner (see htmlcleaner.php Line 4)
### 1.0
+   Better Code Documentation
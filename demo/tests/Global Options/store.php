<?php
$name = 'store';
$order = 20;
$tags = 'global, settings, store, tags, new instance';

$description = <<<'EOD'
**This is a verry advanced setting - normaly you do not need to change it.**

Normaly started tags are stored globaly - every instance of HTML can use the end() method to close
tabs opened by another instance. If an instance stores its opened tags internaly other instances
can not close them with the end() method.
An Instance of HTML using the internal store is also unable to close globaly stored tags.
This is usefull for Demos like this one. (all examples use internal storage so they do not
distract the markup outside the &lt;pre\&gt; tags.)

*This is just a demonstration of the possibilities. Normally you want to end(\'all\') when returning from an internal store to global.*

**Type:** *string* ("global"/"internal")
**Default:** "global"
EOD;

$code = <<<'EOD'
$HTML->s_div('#foo');
$HTML->setOption('store', 'global'); // Reset to global because this demos use internal by default.
$HTML->s_p('#bar');
$HTML->setOption('store', 'internal');
$HTML->end(); // Ends #foo because it is the last opened tag from internal store.
$HTML->setOption('store', 'global');
$HTML->end(); // Ends #bar because it was the last opened tag from global store.

EOD;

$prediction = <<<'EOD'
<div id="foo">
	<p id="bar">
	</div><!-- #foo -->
</p><!-- #bar -->

EOD;

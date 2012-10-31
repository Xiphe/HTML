<?php
$name = 'Method Chaining';
$order = 30;
$tags = 'tag, basic, chains';

$description = <<<'EOD'
Most method calls are returing the **HTML-Instance**, so chaining is possible.
EOD;

$code = <<<'EOD'
$HTML->div('this')->span('is')->pre('a')->p('chain')->hr();
EOD;

$prediction = <<<'EOD'
<div>this</div>
<span>is</span>
<pre>a</pre>
<p>chain</p>
<hr />

EOD;
?>
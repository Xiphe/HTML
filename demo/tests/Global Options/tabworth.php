<?php
$name = 'tabWorth';
$order = 20;
$tags = 'global, settings, tab, clean';

$description = <<<'EOD'
**This is a verry advanced setting - normaly you do not need to change it.**  

The Worth of a [Tab](#globaloptions_tab) in spaces.
When [Clean Mode](#globaloptions_cleanmode) is set to "strong" a long string will be 
realigned so that a line is not longer than the [maximal line width](#globaloptions_maximallinewidth).  
This value will be multiplyed by the current indention count and substracted from the maximal line width.

**Type:** *integer*  
**Default:** 8
EOD;

$code = <<<'EOD'
$HTML->set_option('cleanMode', 'strong')
	->set_option('tab', '  ')
	->set_option('tabWorth', 2);

$lorem = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.';

$HTML->c_p($lorem);
$HTML->add_tabs(8);
$HTML->c_p($lorem);

EOD;

$prediction = <<<'EOD'
<p>
  Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean
  massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec
  quam felis, ultricies nec, pellentesque eu, pretium quis, sem.
</p>
                <p>
                  Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula
                  eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient
                  montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu,
                  pretium quis, sem.
                </p>

EOD;
?>
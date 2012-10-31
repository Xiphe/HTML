<?php
$name = 'minLineWidth';
$order = 20;
$tags = 'global, settings, line width, clean';

$description = <<<'EOD'
**This is a verry advanced setting - normaly you do not need to change it.**  

The minimal width of a line of code when [strong cleaning](#globaloptions_cleanmode) is activated.  
Has a higher status than [maxLineWidth](#globaloptions_maxlinewidth).

**Type:** *integer*  
**Default:** 50
EOD;

$code = <<<'EOD'
$HTML->set_option('cleanMode', 'strong');
$HTML->set_option('maxLineWidth', 100);

$lorem = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.';

$HTML->c_p($lorem); /* Content is max 92 symbols long 100(maxWidth)-8(Tabworth*1) */
$HTML->add_tabs(1);
$HTML->c_p($lorem); /* Content is max 84 symbols long 100(maxWidth)-16(Tabworth*2) */
$HTML->add_tabs(7);
$HTML->c_p($lorem); /* Content is max 50 symbols long (default) 
                     * (should be 100-8*(1+7)=36 long without this setting)
                     */
$HTML->set_option('minLineWidth', 70);
$HTML->c_p($lorem); /* Content is max 70 symbols long (default) */
EOD;

$prediction = <<<'EOD'
<p>
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
	Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur
	ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.
</p>
	<p>
		Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
		dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
		nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
		quis, sem.
	</p>
								<p>
									Lorem ipsum dolor sit amet, consectetuer adipiscing
									elit. Aenean commodo ligula eget dolor. Aenean
									massa. Cum sociis natoque penatibus et magnis dis
									parturient montes, nascetur ridiculus mus. Donec
									quam felis, ultricies nec, pellentesque eu, pretium
									quis, sem.
								</p>
								<p>
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean
									commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus
									et magnis dis parturient montes, nascetur ridiculus mus. Donec quam
									felis, ultricies nec, pellentesque eu, pretium quis, sem.
								</p>

EOD;
?>

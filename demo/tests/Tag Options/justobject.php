<?php
$name = 't for tag object';
$order = 70;
$tags = 'tag options, options, tag, object';

$description = <<<'EOD'
Just creates a [Tag object](#tagobject) and returns it directly.
EOD;

$code = <<<'EOD'
$Div = $HTML->t_div('Content', 'foo=bar');
print_r($Div);
EOD;

$prediction = <<<'EOD'
Xiphe\HTML\core\Tag Object
(
    [ID] => 189
    [name] => div
    [realName] => div
    [options] => Array
        (
            [0] => justGetObject
        )

    [attributes] => Array
        (
            [foo] => bar
        )

    [content] => Content
    [brackets] => Array
        (
            [start] => <:name
            [end] => </:name
            [close_start] => >
            [close_short] =>  />
            [close_end] => >
        )

    [attributeString] =>  foo="bar"
    [classes] => Array
        (
        )

    [inlineInner] => 1
    [selfclosing] => 
    [_opened:Xiphe\HTML\core\Tag:private] => 
    [_closed:Xiphe\HTML\core\Tag:private] => 
    [_contentPrinted:Xiphe\HTML\core\Tag:private] => 
    [_configuration:protected] => 
    [_initArgs:protected] => Array
        (
        )

    [_callbacks:protected] => Array
        (
        )

)

EOD;

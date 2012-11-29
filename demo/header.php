<?php

$pageURL = 'http';
if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
    $pageURL .= "s";
}
$pageURL .= "://";
if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") {
    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
} else {
    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}
$HTML->setOption('baseUrl', $pageURL);
$HTML->XHTML()
        ->utf8()
        ->jquery()
         ->script('./res/highlight/sh_main.min.js')
         ->script('./res/highlight/sh_php.min.js')
         ->script('./res/highlight/sh_html.min.js')
         ->link('./res/highlight/sh_acid.css')
         ->title('Project Clean HTML » Examples')
         ->css('./res/css/style.css')
         ->js('./res/js/script.js')
     ->end();

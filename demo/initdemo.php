<?php
$s_mt = explode(" ",microtime());
require_once '../_html.php';

// INITIATION
global $HTML;
global $DemoHTML;
global $contents;
$contents = array();
$HTML = new Xiphe\HTML();
$DemoHTML = new Xiphe\HTML(array(
    'tabs' => 0,
    'baseUrl' => 'http://www.example.org',
    'maxLineWidth' => 100,
    'tabWorth' => 8,
    'store' => 'internal'
));

$sectionOrder = array(
    'Start',
    'Tags',
    'Attributes',
    'Global Options',
    'Special Tags',
    'Tag Options',
    'Misc'
);

$Tests = array();

foreach (glob(dirname(__FILE__).'/tests/*') as $folder) {
    $section = basename($folder);
    array_filter(glob($folder.'/*'), function($file) use (&$Tests, $section) {
        include($file);
        if (!isset($order)) {
            $order = 50;
        }
        if (!isset($tags)) {
            $tags = '';
        }
        $args = compact('name', 'section', 'tags', 'order', 'description', 'code', 'prediction');

        if (count($args) < 7) {
            return;
        }

        $Test = new Xiphe\HTML\demo\TestCase($args);
        $Tests[] = $Test;
    });
}

$sectionOrder = array_flip($sectionOrder);

usort($Tests, function($a, $b) use ($sectionOrder) {
    if ($a->section == $b->section) {
        return $a->order - $b->order;
    } else {
        return $sectionOrder[$a->section] - $sectionOrder[$b->section];
    }
});

foreach ($Tests as $k => $Test) {
    $Test->test();
    if (isset($_GET['status']) && $Test->success !== $_GET['status']) {
        unset($Tests[$k]);
    }
}

include 'header.php';

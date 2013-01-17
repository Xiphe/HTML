<?php
$name = 'googleanalytics';
$order = 30;
$tags = 'google, analytics, compressed, short';

$description = <<<'EOD'
Simply generates a tracking script with the user account you passed.
EOD;

$code = <<<'EOD'
$HTML->googleanalytics('UA-0000000-0');
EOD;

$prediction = <<<'EOD'
<script type="text/javascript">var _gaq=_gaq||[];_gaq.push(['_setAccount','UA-0000000-0']);_gaq.push(['_trackPageview']);(function(){var ga=document.createElement('script');ga.type='text/javascript';ga.async=true;ga.src=('https:'==document.location.protocol?'https://ssl':'http://www')+'.google-analytics.com/ga.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(ga,s);})();</script>

EOD;

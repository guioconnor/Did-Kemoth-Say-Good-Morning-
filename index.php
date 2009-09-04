<?php  
// ini_set('display_errors', '1');
// error_reporting(E_ALL);

// Set time and date conditions
date_default_timezone_set("America/Sao_Paulo");
$current_timestamp  = mktime();

// Retrieve tweets
$feed_url           = "http://search.twitter.com/search.atom?q=bom+dia+vermes+kemoth";
$response           = file_get_contents($feed_url);
$obj                = SimpleXML_Load_String($response);

$lastRetTweet       = $obj->entry[0];
$linkObj            = $lastRetTweet->link;
// $authorObj          = // $lastRetTweet->author->name;

$tweetTimestamp     = strtotime($lastRetTweet->updated);
$tweetDate          = date("d-m-Y", $tweetTimestamp);
$tweetDateLabel     = date("d-m-Y H:i:s", $tweetTimestamp);
$today              = date("d-m-Y");

$name               = $lastRetTweet->author->name;
$avatar             = $linkObj[1]['href'];
$url                = $linkObj[0]['href'];
$status             = "$lastRetTweet->title";


$javascript =<<<END_JS
    <script type="text/JavaScript">
    <!--
    setTimeout("location.reload(true);",60000);
    //   -->
    </script>
END_JS;

$css =<<<END_CSS
body {
    color:#333333;
    font-family:'Lucida Grande',sans-serif;
    font-size-adjust:none;
    font-style:normal;
    font-variant:normal;
    font-weight:normal;
    line-height:normal;
    text-align:center;
    padding-bottom: 100px;
}

a,
a:visited {
    color: #0084B4;
}

.entry-meta {
    font-size: 0.9em;
    text-align:right;
    display: block;
    margin-bottom: 50px;
}

#content {
    text-align: left;
    width: 400px;
    margin: auto;
}

#question {
    text-align: center;
    margin: 10px auto 0;
}

#answer {
    font-size: 12em;
    text-align: center;
    margin-bottom: 50px;
}

.thumb {
    float: left;
}

.screen-name,
.full-name {
    margin-left: 100px;
    font-size: 
}
END_CSS;


// Header
$html =<<<END_HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>O Kemoth Já disse Bom Dia Vermes hoje?</title>
    <style type="text/css">
    {$css}
    </style>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="en-us" http-equiv="Content-Language" />
</head>
<body>
<div id="content">
<div id="question">O Kemoth Já disse Bom Dia Vermes hoje?</div>
END_HTML;



if ($tweetDate == $today) {
    $html .=<<<END_HTML
    <div id="answer">Sim!</div>
    <div class="wide" id="content">
        <div class="wrapper">
            <div class="status" id="permalink">
                <div class="listable"/><span class="status-body"><span class="entry-content">$status</span><span class="meta entry-meta"><a rel="bookmark" class="entry-date" href="$url">$tweetDateLabel</span>
                    <div class="user-info clear">
                        <div class="thumb"><a hreflang="" class="tweet-url profile-pic" href="http://twitter.com/kemoth"><img width="73" height="73" border="0" style="vertical-align: middle;" src="http://a1.twimg.com/profile_images/331681796/dente_bigger.JPG" alt=""/></a></div>
                        <div class="screen-name"><a title="Daniel" hreflang="" href="http://twitter.com/kemoth">kemoth</a></div>
                        <div class="full-name">$name</div>
                    </div>
                </div>
            </div>
        </div>
END_HTML;
}
else {
    $html .=<<<END_HTML
    <div id="answer">Não</div>
END_HTML;
}

//footer

$html .=<<<END_HTML
</div>
{$javascript}
</body>
</html>
END_HTML;



echo $html;

// counter

$countfile='counter.txt';
$fh = fopen($countfile, 'r');
$dat = @fread($fh, filesize($countfile));
fclose($fh);
$fh = fopen($countfile, "w");
fwrite($fh, intval($dat)+1);
fclose($fh);


?> 

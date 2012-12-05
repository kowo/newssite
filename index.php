<?php
header('Content-Type: text/html; charset=utf-8');

$feed_ts  = 'http://www.tagesschau.de/xml/atom/';
$feed_mdr = 'http://www.mdr.de/mdr-info/news/nachrichten100-rss.xml';

$header =	"<!DOCTYPE html>\n".
			"<html>\n".
			"	<head>\n".
			"		<title>News Site</title>\n".
			"		<style type=\"text/css\">\n".
			"			@import url('./style.css');\n".
			"		</style>\n".
			"	</head>\n".
			"	<body>\n".
			"		<p><a href=\"./index.php\">Zurück</a></p>\n";

// XSLT Transform
if(isset($_GET['p']) && $_GET['p'] == 'xslt') {

	echo $header.
		 "		<div id=\"left\">\n";

	$dom    = new DomDocument();
	$xsl    = new DomDocument();

	//Tagesschau
	$dom->load($feed_ts);
	$xsl->load('./transformation_tagesschau.xslt');

	$xpr    = new XsltProcessor();
	$xpr->importStylesheet($xsl);

	$output = $xpr->transformToDoc($dom);
	echo $output->saveHTML();

	echo "		</div>\n".
		 "		<div id=\"right\">\n";

	//MDR
	$dom->load($feed_mdr);
	$xsl->load('./transformation_mdr.xslt');

	$xpr    = new XsltProcessor();
	$xpr->importStylesheet($xsl);

	$output = $xpr->transformToDoc($dom);
	echo $output->saveHTML();

	echo "		</div>\n".
		 "	</body>\n".
		 "</html>";


// DOM Parsing
} elseif(isset($_GET['p']) && $_GET['p'] == 'php') {
	
	echo $header;

	require('./NewsObject.php');

	$i = 0;
	echo "dom parsing:<br><pre>";
	$dom = new DomDocument();

	//tagesschau
	$dom->load($feed_ts);

	$r = $dom->documentElement;
	foreach($r->childNodes as $node) {
		if(isset($node->tagName) && $node->tagName == 'entry') {
			$ENTRIES[$i] = new NewsObject($node, 'ts');
			$i++;
		}
	}

	//mdr
	$dom->load($feed_mdr);

	$r = $dom->documentElement;
	foreach($r->childNodes as $node) {
		if(isset($node->tagName) && $node->tagName == 'channel') {
			foreach($node->childNodes as $node2) {
				if(isset($node2->tagName) && $node2->tagName == 'item') {
					$ENTRIES[$i] = new NewsObject($node2,'mdr');
					$i++;
				}
			}
		}
	}

	
	// Sort array by time (newest first)
	usort($ENTRIES, array("NewsObject", "cmp_time"));

	print_r($ENTRIES);
	echo "</pre>";

	echo "	</body>\n".
		 "</html>";

//Start
} else {
	include('./start.inc.php');
}
?>
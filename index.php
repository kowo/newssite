<?php
header('Content-Type: text/html; charset=utf-8');

$feed_ts  = 'http://www.tagesschau.de/xml/atom/';
$feed_mdr = 'http://www.mdr.de/mdr-info/news/nachrichten100-rss.xml';


if(isset($_GET['f'])) {
	switch($_GET['f']) {
		case 'ts':
			$feedsrc = $feed_ts;
			$xslsrc = './transformation_tagesschau.xslt';
			break;
		case 'mdr':
			$feedsrc = $feed_mdr;
			$xslsrc = './transformation_mdr.xslt';
			break;
		default:
			header('Location: ./index.php');
			exit;
	}

	$dom    = new DomDocument();
	$dom->load($feedsrc);

	$xsl    = new DomDocument();
	$xsl->load($xslsrc);

	$xpr    = new XsltProcessor();
	$xsl    = $xpr->importStylesheet($xsl);

	$output = $xpr->transformToDoc($dom);
	echo $output->saveXML();


} elseif(isset($_GET['p']) && $_GET['p'] == 'php') {
	
	//DOM parsing
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

} else {
	include('./start.inc.php');
}
?>
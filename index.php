<?php
header('Content-Type: text/html; charset=utf-8');


if(isset($_GET['f'])) {
	switch($_GET['f']) {
		case 'ts':
			$feedsrc = 'http://www.tagesschau.de/xml/atom/';
			$xslsrc = './transformation_tagesschau.xslt';
			break;
		case 'mdr':
			$feedsrc = 'http://www.mdr.de/mdr-info/news/nachrichten100-rss.xml';
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


} else {
	include('./start.inc.php');
}
?>
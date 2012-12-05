<?php
class NewsObject {
	
	private $title;
	private $link;
	public $date;
	private $text;
	private $src;

	function __construct($node,$src) {
		switch($src) {
			case 'ts':
				$this->parse_ts($node);
				break;
			case 'mdr':
				$this->parse_mdr($node);
				break;
			default:
				return null;
		}
	}

	private function parse_ts($node) {

		$dateformat = "Y-m-d\TH:i:s.uP";

		$this->src = 'Tagesschau';
		foreach($node->childNodes as $n) {
			if(isset($n->tagName)) {
				switch($n->tagName) {
					case 'title':
						$this->title = $n->nodeValue;
						break;
					case 'summary':
						$this->text = $n->nodeValue;
						break;
					case 'id':
						$this->link = $n->nodeValue;
						break;
					case 'updated';
						$this->date = DateTime::createFromFormat($dateformat, $n->nodeValue);
						break;
				}
			}
		}

	}

	private function parse_mdr($node) {

		$dateformat = 'D, d M Y H:i:s O';

		$this->src = 'MDR';
		foreach($node->childNodes as $n) {
			if(isset($n->tagName)) {
				switch($n->tagName) {
					case 'title':
						$this->title = $n->nodeValue;
						break;
					case 'description':
						$this->text = $n->nodeValue;
						break;
					case 'link':
						$this->link = $n->nodeValue;
						break;
					case 'pubDate';
						$this->date = DateTime::createFromFormat($dateformat, $n->nodeValue);
						break;
				}
			}
		}
	}

	public function getTimestamp() {
		return $this->date->getTimestamp();
	}
}

?>
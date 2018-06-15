<?php
	require_once('./phpQuery-onefile.php');
	
	class NumbersFour {
		private $url     = 'http://www.takarakujinet.co.jp/ajax/numbers4/pastResultPage.do';
		private $kaigou  = 0;
		private $howmany = 0;

		function __construct(){}

		function setKaigou($kaigou) {
			if (intval($kaigou < 1)){
				$this->kaigou = 0;
			}
			else {
				$this->kaigou = intval($kaigou);
			}
		}
		function setHowmany($howmany) {
			if (intval($howmany < 1)){
				$this->howmany = 0;
			}
			else {
				$this->howmany = intval($howmany);
			}
		}
		function getLotNum() {
			$url = $this->url;
			$kaigou  = $this->kaigou;
			$howmany = $this->howmany;
			$result  = [];

			if (($kaigou === 0) || ($howmany === 0)){
				$result = $this->getRecent10LotNum();
			}
			else {
				$url = $url . '?searchway=kaigou' . '&kaigou=' . $kaigou . '&howmany=' . $howmany;
				$page = $this->getPage($url);
				if ($page === NULL) {
					return NULL;
				}
				else {
					$docs = phpQuery::newDocument($page);
					
					foreach($docs['table.list tr'] as $row){
						$lotnum = pq($row)->find('td.lotnum')->text();
						if (strlen($lotnum)) {
							$result[] = $lotnum;
						}
					}
				}
			}
			
			return $result;
		}
		function getRecent10LotNum() {
			echo "直近 10 回号分の結果を出力します。", PHP_EOL;
			$url  = $this->url;
			$result = [];

			$page = $this->getPage($url);
			
			if ($page === NULL) {
				return NULL;
			}
			else {
				$docs = phpQuery::newDocument($page);

				foreach($docs['table.list tr'] as $row){
					$lotnum = pq($row)->find('td.lotnum')->text();
					if (strlen($lotnum)) {
						$result[] = $lotnum;
					}
				}
			}
			
			return $result;
		}
		function getFile() {
			$result = $this->getLotNum();

			$file = tmpfile();
			$filemeta = stream_get_meta_data($file);
			$filepath = $filemeta['uri'];

			foreach ($result as $row) {
				$row = $row . "\n";
				fwrite($file, $row);
			}
			rewind($file);

			$dlname = 'numbers4_' . $this->kaigou . '_' . $this->howmany . '.csv';
			header('Content-Type: application/octet-stream');
			header('Content-length: ' . filesize($filepath));
			header('Content-Disposition: attachment; filename="' . $dlname . '"');

			readfile($filepath);
			fclose($file);
		}
		private function getPage($url){
			$page = NULL;

			if (!($page = file_get_contents($url))) {
				return NULL;
			}
			else {
				return $page;
			}
		}
	}
	
	/*
	*/
?>

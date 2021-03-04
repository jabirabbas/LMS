<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function selected($a, $b)
	{
		return ($a == $b ? 'active' : '');
	}
	
	function limit_words($string, $word_limit = 35)
	{
		$words = explode(" ",$string);
		//echo count(array_keys($words));
		$result =  implode(" ",array_splice($words,0,$word_limit));
		if(count(array_keys($words)) > 1) $result .= ' ...';
		return $result;
	}
	
	
	function _createThumbnail($fileName, $source) {
		error_reporting(0);
		$file = explode(',', $fileName);
		for($i=0; $i<=count($file)-1; $i++){
			$CI =& get_instance();
			$config['image_library'] = 'gd2';
			$config['source_image'] = $source.$file[$i];
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 199;
			$config['height'] = 199;
			$CI->load->library('image_lib');
			$CI->image_lib->initialize($config);
			$CI->image_lib->resize();
			$CI->image_lib->clear();
		}
		return true;
	}
	
	function readExcel($filename){
		require_once 'Excel_Reader/reader.php';
    	$excel = new Spreadsheet_Excel_Reader();
		
		$excel->read($filename);
		
		$x=2;
		while($x<=$excel->sheets[0]['numRows']) {
			$imei_numbers[] = (isset($excel->sheets[0]['cells'][$x][1])) ? $excel->sheets[0]['cells'][$x][1] : '';
		  $x++;
		}
		
		return $imei_numbers;
		
	}
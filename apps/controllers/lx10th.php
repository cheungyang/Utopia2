<?php

class Lx10th extends Controller {

	static private $csv, $filename;
	
	function Lx10th()
	{
		parent::Controller();	
		
		self::$filename = DIR_WEB_ROOT. 'files/lxlearn-10th-content.txt';
		$csvstr = file_get_contents(self::$filename);
		$csvarr = explode("\n", $csvstr);
		$csv = array();
		$row = 1;
		foreach($csvarr as $c)
		{
			$csv[$row] = explode("\t", $c);
			$row++;
		}
		self::$csv = $csv;
//		print_r($csv); die();

				
//		self::$filename = DIR_WEB_ROOT. 'files/lxlearn-10th-content.csv';		
//		$row = 1;
//		$csv = array();		
//		$handle = fopen(self::$filename, "r");
//		while (($data = fgetcsv($handle)) !== FALSE) 
//		{
//    		$row++;
//			if ($row < 2)
//			{
//				continue;
//			}		
//			$num = count($data);
//			for ($c=0; $c < $num; $c++) 
//			{
//        		//$csv[$row] = iconv('', 'UTF-8', $data[$c]);
//        		$csv[$row] = mb_convert_encoding($data[$c], 'UTF-8');
//    		}
//			print_r($data);	
////			print_r($csv[$row]);
//		}
//		fclose($handle);		
	}
	
	function index($page=1)
	{
		$pageinfo = self::$csv[$page];
		$smarty = SmartyConnect::getInstance();
		$urlbase = "http://localhost/utopia/index.php/lx10th/index/%d";		
		if (isset(self::$csv[$page+1]))
		{	
			$smarty->assign('nextpage', sprintf($urlbase, $page+1));
		}
		if (isset(self::$csv[$page-1]))
		{
			$smarty->assign('prepage', sprintf($urlbase, $page-1));
		}		
    
	    $smarty->assign('curpage', sprintf($urlbase, $page));
	    
	    $allpages = array();
	    foreach(self::$csv as $num => $page)
	    {
	    	$allpages[] = array(
	    		'url' => sprintf($urlbase, $num),
	    		'title' => !empty($page[4])? $page[4]: $page[5],
	    		'thumb' => $page[3],
	    	);
	    }
	    //$allpages = array_map('sprintf', array_fill(0,count(self::$csv),$urlbase), array_keys(self::$csv) );    
	    $smarty->assign('allpages', $allpages);
	    
	    $smarty->assign('WEB_CSS_ROOT', WEB_CSS_ROOT);
	    $smarty->assign('WEB_JS_ROOT', WEB_JS_ROOT);
		$smarty->assign('WEB_FILES_ROOT', WEB_FILES_ROOT);		
		$smarty->assign('page', $pageinfo);
		$smarty->display($pageinfo[1].'.tpl');

//    [0] => P
//    [1] => Template
//    [2] => Category
//    [3] => Image_filename
//    [4] => Title
//    [5] => Capt
//    [6] => Text		
	}
	
}

/* End of file model.php */
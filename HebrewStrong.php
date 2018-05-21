<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////
/*
    .....                                         ...     ..         .          ..          ..            
 .H8888888h.  ~-.    .uef^"                    .=*8888x <"?88h.     @88>  . uW8"      x .d88"             
 888888888888x  `> :d88E                      X>  '8888H> '8888     %8P   `t888        5888R              
X~     `?888888hx~ `888E            .u       '88h. `8888   8888      .     8888   .    '888R        .u    
'      x8.^"*88*"   888E .z8k    ud8888.     '8888 '8888    "88>   .@88u   9888.z88N    888R     ud8888.  
 `-:- X8888x        888E~?888L :888'8888.     `888 '8888.xH888x.  ''888E`  9888  888E   888R   :888'8888. 
      488888>       888E  888E d888 '88%"       X" :88*~  `*8888>   888E   9888  888E   888R   d888 '88%" 
    .. `"88*        888E  888E 8888.+"        ~"   !"`      "888>   888E   9888  888E   888R   8888.+"    
  x88888nX"      .  888E  888E 8888L           .H8888h.      ?88    888E   9888  888E   888R   8888L      
 !"*8888888n..  :   888E  888E '8888c. .+     :"^"88888h.    '!     888&  .8888  888"  .888B . '8888c. .+ 
'    "*88888888*   m888N= 888>  "88888%       ^    "88888hx.+"      R888"  `%888*%"    ^*888%   "88888%   
        ^"***"`     `Y"   888     "YP'               ^"**""          ""       "`         "%       "YP'    
                         J88"                                                                             
                         @%                                                                               
                       :"                                                                                 

This page is written in PHP to read Hebrew Strong XML file and returns the search result 
in mobile friendly web page using HTML, jQuery, CSS and Bootstrap.
You can search by Hebrew word, Hebrew Strong's ID (with or without H) and definitions.

*Open Source Original Credits*
*Hebrew Strong XML Files : https://github.com/openscriptures/HebrewLexicon/blob/master/HebrewStrong.xml

Created by : Regina Hong
Updated by : Regina Hong
Updated on : September 26, 2017

*/
//////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php
//Get parameters from URL either word or id
$word = (isset($_GET['word'])) ? $_GET['word'] : '' ;
$id = (isset($_GET['id'])) ? $_GET['id'] : '' ;
$def = (isset($_GET['def'])) ? $_GET['def'] : '' ;

$search_pr = '';

if ($word <> '' || $id <> '' || $def <> '') {

	//Load HebrewStrong.xml and PartsOfSpeech.xml
	$xml_hebrew_strong = 'Analysis/dic/HebrewStrong.xml';

	$xml_hs = new DOMDocument();
	$xml_hs->load($xml_hebrew_strong);

	$xpath = new DOMXPath($xml_hs);

	if ($word <> '') {
		//Query HebrewStrong.xml with the word and get the parent node
		$elements = $xpath->query("//entry/w[text()='".$word."']/..");
		$no_result_link = "word=".$word;
	}
	elseif ($id <> '') {

		if (stripos($id, 'h') !== false) {
			$id_search = str_replace('h', 'H', $id);
		}
		elseif (stripos($id, 'H') == false) {
			$id_search = 'H'.$id;
		}
		else
			$id_search = $id;

		//Query HebrewStrong.xml with the id and get the node
		$elements = $xpath->query("//entry[@id='".$id_search."']");
	}
	elseif ($def <> '') {
		//Query HebrewStrong.xml with exact match of definition
		//$xml->xpath("//line[contains(translate(text(), 'ABCDEFGHJIKLMNOPQRSTUVWXYZ', 'abcdefghjiklmnopqrstuvwxyz'), '$search')]");
		$search = strtolower($def).'';

		//first - exact match of def
		$elements = $xpath->query("//entry/meaning/def[translate(., 'ABCDEFGHJIKLMNOPQRSTUVWXYZ', 'abcdefghjiklmnopqrstuvwxyz')='".$search."']/../..");

		if ($elements->length == 0) {

			$search = strtolower($def).' ';
			$elements = $xpath->query("//entry/usage[contains(translate(text(), 'ABCDEFGHJIKLMNOPQRSTUVWXYZ', 'abcdefghjiklmnopqrstuvwxyz'), '$search')]/..");

			if ($elements->length == 0) {

				$search = strtolower($def).', ';
				$elements = $xpath->query("//entry/usage[contains(translate(text(), 'ABCDEFGHJIKLMNOPQRSTUVWXYZ', 'abcdefghjiklmnopqrstuvwxyz'), '$search')]/..");

				if ($elements->length == 0) {

					$search = strtolower($def).'.';
					$elements = $xpath->query("//entry/usage[contains(translate(text(), 'ABCDEFGHJIKLMNOPQRSTUVWXYZ', 'abcdefghjiklmnopqrstuvwxyz'), '$search')]/..");
				}
			}
		}

		//$elements = $xpath->query("//entry/meaning/def[contains(translate(text(), 'ABCDEFGHJIKLMNOPQRSTUVWXYZ', 'abcdefghjiklmnopqrstuvwxyz'), '$search')]/../..");
		$no_result_link = "def=".$def;
	}
	
	if ($elements->length >0) {

		$search_pr .= "<div class='container-fluid' id='content'>";
		$search_pr .= "<table class='table table-striped table-bordered' id='result-table'>";

		//Prints all available items in the dictionary including some children and some attributes
	    foreach ($elements as $entry) {

	    	$iid = "<span id='iid'>".str_replace('H', '', $entry->getAttribute('id'))."</span>";
	        $nodes = $entry->childNodes;

	        foreach ($nodes as $node) {
	            if ($node->nodeName <> '#text') {

	            	if ($node->nodeName == 'source' && $node->getElementsByTagName('w')) {
						foreach ($node->getElementsByTagName('w') as $ww) {
            				if (is_numeric($ww->nodeValue)) {
            					$temp1 = $ww->nodeValue;
								$temp2 = '<a href="HebrewStrong.php?id='.$temp1.'"><span id="sw">'.$temp1.'</span></a>';
								$search_pr .= "<tr><td>".$node->nodeName."</td><td id='".$node->nodeName."'>".str_replace($temp1, $temp2, $node->nodeValue). "</td></tr>";
            				}
	            		}
	            	}
	            	elseif ($node->nodeName == 'meaning' && $node->getElementsByTagName('def')) {
            			foreach ($node->getElementsByTagName('def') as $ddef) {
            					$dtemp1[] = $ddef->nodeValue;
								$dtemp2[] = '<span id ="dt">'.$ddef->nodeValue.'</span>';	            				
            			}
						$search_pr .= "<tr><td>".$node->nodeName."</td><td id='".$node->nodeName."'>".str_replace($dtemp1, $dtemp2, $node->nodeValue). "</td></tr>";
	            	}
	            	else {
	            		if ($node->nodeName == 'w') {
							$search_pr .= "<tr><td>".$node->nodeName."</td><td id='".$node->nodeName."'>".$node->nodeValue." <button onclick=\"window.open('Analysis.php?id=".str_replace('H', '', $entry->getAttribute('id'))."','_blank');\" type='button' class='btn btn-basic'>Analyze</button></td></tr>";
	            		}
	            		else {
	            			$search_pr .= "<tr><td>".$node->nodeName."</td><td id='".$node->nodeName."'>".$node->nodeValue."</td></tr>";
	            		}
	            		
	            	}
					
					$attr_pr = '';

					if ($node->hasAttributes()) {
						foreach ($node->attributes as $attr) {
							if ($attr->nodeName == 'xlit') {
								$attr_pr .= $attr->nodeName.'=<span id="xlit">'.$attr->nodeValue.'</span>, ';
							}
							elseif ($attr->nodeName == 'pos') {
								$attr_pr .= $attr->nodeName.'=<span id="pos">'.$attr->nodeValue.'</span>, ';
							}
							else {
								$attr_pr .= $attr->nodeName.'='.$attr->nodeValue.', ';
							}
					  	}
					  	$search_pr .= "<tr><td>attributes</td><td>".$attr_pr."ID=".$iid."</td></tr>";
					}
	          	}
			}
		}
		$search_pr .= "</table>";
		$search_pr .= "</div>";
	}
	else {
		if ($word <>'' || $def <>'') {
				$search_pr .= "<div class='container-fluid' id='content'>";
				$search_pr .= "<p>No search result.</p>";
				$search_pr .= "</div>";
		}
		else {
				$search_pr .= "<div class='container-fluid' id='content'>";
				$search_pr .= "<p>No search result.</p>";
				$search_pr .= "</div>";
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Hebrew Strong Dictionary</title>
	<meta name="keywords" content="Hebrew Bible Analysis, Tanakh Old Testament, Biblical Hebrew, Search for the Truth, Reaching for Spiritual Depth">
	<meta name="description" content="The Hebrew Bible (Tanakh) Analysis, Biblical Hebrew Study Resources, Reaching for Spiritual Depth, Searching for The Truth, Analyzing Sacred Ancient Texts.">
	<?php require 'INC/Header.php'; ?>
	<link href="https://fonts.googleapis.com/css?family=Eagle+Lake" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="CSS/1-2/HebrewStrong.css"> <!-- my css -->	
	<script src="JS/1-2/TheBible.js"></script> <!-- my jQuery -->
</head>
<body>

<?php require 'INC/Nav.php'; ?>

<div class="container-fluid" id="index">
	<!-- Hebrew Word, Strong ID, Definition and Meaning selection form on the top menu-->
	<form class="form-inline">
        <div class="form-group">
	        <label for="dynamic_select_word">Hebrew Word</label>
	        <input name="word" class="form-control" id="dynamic_select_word" placeholder="with vowels..">
	        <label for="dynamic_select_id">Strong's ID</label>
	        <input name="id" class="form-control" id="dynamic_select_id" placeholder="1 - 8674">
	        <label for="dynamic_select_def">Definition</label>
	        <input name="def" class="form-control" id="dynamic_select_def" placeholder="">
        </div>
    </form> 
</div>

<div class="container-fluid" id="header">
	<h2 class="text-center">Hebrew Strong</h2>
</div>

<?php echo $search_pr; ?>

<?php require 'INC/Footer.php'; ?>

</body>
</html>
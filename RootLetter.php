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
You can look up Hebrew Strong's dictionary using root letters.

*Open Source Original Credits*
*Hebrew Strong XML Files : https://github.com/openscriptures/HebrewLexicon/blob/master/HebrewStrong.xml

Created by : Regina Hong
Updated by : Regina Hong
Updated on : December 19, 2018

*/
//////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php
//Get parameters from URL
$letter1 = (isset($_GET['letter1'])) ? $_GET['letter1'] : '' ;
$letter2 = (isset($_GET['letter2'])) ? $_GET['letter2'] : '' ;
$letter3 = (isset($_GET['letter3'])) ? $_GET['letter3'] : '' ;

$search_pr = '';

$letter_options1 = "<option value=''></option>";
$letter_options2 = "<option value=''></option>";
$letter_options3 = "<option value=''></option>";
$letters_heb = array('א','ב','ג', 'ד','ה', 'ו', 'ז','ח','ט', 'י','כ','ל','מ','נ','ס', 'ע','פ','צ','ק', 'ר','ש','ת','ך','ם','ף','ן','ץ');
$letters_eng = array('Ah','Bt','Gl','Td','Hh','Vv','Zn','Ht','Tt','Yd','Cf','Ld','Mm','Nn','Sd','An','Ph','Zk','Kf','Rh','Sn','Tv','Cf','Mm','Ph','Nn','Zk');

for ($i=0; $i < count($letters_heb); $i++) {

	if ($letter1 == $letters_heb[$i]) {
		$letter_options1 .= "<option value='".$letters_heb[$i]."' selected>".$letters_heb[$i]."</option>";
	} else {
		$letter_options1 .= "<option value='".$letters_heb[$i]."'>".$letters_heb[$i]."</option>";
	}

	if ($letter2 == $letters_heb[$i]) {
		$letter_options2 .= "<option value='".$letters_heb[$i]."' selected>".$letters_heb[$i]."</option>";
	} else {
		$letter_options2 .= "<option value='".$letters_heb[$i]."'>".$letters_heb[$i]."</option>";
	}

	if ($letter3 == $letters_heb[$i]) {
		$letter_options3 .= "<option value='".$letters_heb[$i]."' selected>".$letters_heb[$i]."</option>";
	} else {
		$letter_options3 .= "<option value='".$letters_heb[$i]."'>".$letters_heb[$i]."</option>";
	}

}

if ($letter1 <> '') {

	//Load HebrewStrong.xml and PartsOfSpeech.xml
	$xml_hebrew_strong = 'Analysis/dic/HebrewStrong.xml';

	$xml_hs = new DOMDocument();
	$xml_hs->load($xml_hebrew_strong);

	$xpath = new DOMXPath($xml_hs);

	if ($letter1 <> '' && $letter2 <> '' && $letter3 <> '') {
		$elements = $xpath->query("//entry/w[contains(translate(text(),'ְֱֲֳִֵֶַָׇֹֺֻּֽֿׁׂ֑֖֛֢֣֤֥֦֧֪ׅ֚֭֮֒֓֔֕֗֘֙֜֝֞֟֠֡֨֩֫֬֯ׄ', ''),'".$letter1.$letter2.$letter3."')]/..");
	} elseif ($letter1 <> '' && $letter2 <> '') {
		$elements = $xpath->query("//entry/w[contains(translate(text(),'ְֱֲֳִֵֶַָׇֹֺֻּֽֿׁׂ֑֖֛֢֣֤֥֦֧֪ׅ֚֭֮֒֓֔֕֗֘֙֜֝֞֟֠֡֨֩֫֬֯ׄ', ''),'".$letter1.$letter2."')]/..");
	} elseif ($letter1 <> '') {
		$elements = $xpath->query("//entry/w[contains(translate(text(),'ְֱֲֳִֵֶַָׇֹֺֻּֽֿׁׂ֑֖֛֢֣֤֥֦֧֪ׅ֚֭֮֒֓֔֕֗֘֙֜֝֞֟֠֡֨֩֫֬֯ׄ', ''),'".$letter1."')]/..");
	}
	
	if ($elements->length >0) {

		$search_pr .= "<div class='container-fluid' id='content'>";
		$search_pr .= "<table class='table table-striped table-bordered' id='result-table'><thead><th>Word</th><th>ID</th><th>Analyze</th><th>PoS</th><th>xlit</th><th>Meaning</th></thead>";

		//Prints all available items in the dictionary including some children and some attributes
	    foreach ($elements as $entry) {
	        
	        $search_pr .='<tr>';
	        $nodes = $entry->childNodes;

	        foreach ($nodes as $node) {

	            if ($node->nodeName <> '#text') {

	            	if ($node->nodeName == 'meaning' && $node->getElementsByTagName('def')) {
						$search_pr .= "<td>".$node->nodeValue."</td>";
	            	}

	            	if ($node->nodeName == 'w') {
							$search_pr .= "<td>".$node->nodeValue."</td><td><a href='HebrewStrong.php?id=".str_replace('H', '', $entry->getAttribute('id'))."'>".str_replace('H', '', $entry->getAttribute('id'))."</a></td><td><button onclick=\"window.open('Analysis.php?id=".str_replace('H', '', $entry->getAttribute('id'))."','_blank');\" type='button' class='btn btn-basic'>Analyze</button></td>";           		
	            	}

					if ($node->hasAttributes()) {
						foreach ($node->attributes as $attr) {
							if ($attr->nodeName == 'xlit') {
								$search_pr .= '<td>'.$attr->nodeValue.'</td>';
							}
							elseif ($attr->nodeName == 'pos') {
								$search_pr .= '<td>'.$attr->nodeValue.'</td>';
							}
					  	}
					}
	          	}
			}
	            $search_pr .='</tr>';
		}

		$search_pr .= "</table>";
		$search_pr .= "</div>";
	}
	else {

		$search_pr .= "<div class='container-fluid' id='content'>";
		$search_pr .= "<p>No search result.</p>";
		$search_pr .= "</div>";
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
	<link rel="stylesheet" type="text/css" href="CSS/1-3/HebrewStrong.css"> <!-- my css -->
	<script>
		function RootLookup() {
			url = "RootLetter.php";
		    window.location.replace = (url);
		}
		function Reset() {
			$("select").each(function() { this.selectedIndex = 0 });
		}
	</script>
</head>
<body>

<?php require 'INC/Nav.php'; ?>

<div class="container-fluid" id="index">
	<!-- Hebrew Word, Strong ID, Definition and Meaning selection form on the top menu-->
	<form class="form-inline">
        <div class="form-group">
	        <label for="letter3">Root Letter 3</label>
			<select name="letter3" class="form-control" id="letter3"><?php echo $letter_options3; ?></select>
	        <label for="letter2">Root Letter 2</label>
	        <select name="letter2" class="form-control" id="letter2"><?php echo $letter_options2; ?></select>
	        <label for="letter1">Root Letter 1</label>
	        <select name="letter1" class="form-control" id="letter1"><?php echo $letter_options1; ?></select>
	        <button onclick="RootLookup()" class="btn btn-primary">Search</button>
	        <button onclick="Reset()" class="btn btn-default">Reset</button>
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
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
This page is written in PHP and uses HMTL, jQUERY, CSS and Bootstrap to present it in mobile-friendly web pages.
It presents Biblical Hebrew Vocabularies by reading it from the database I developed 
by using Hebrew Tanach XML Files with lemma and Hebrew Strong XML file.

The purpose is to make it easy to learn Biblical Hebrew Verb System and to enable root word search analysis.

*Open Source Original Credits*
*Hebrew Tanach XML Files : https://github.com/ancientlanguage/xml-tanach
*Hebrew Strong XML Files : https://github.com/openscriptures/HebrewLexicon/blob/master/HebrewStrong.xml

Created by : Regina Hong
Updated by : Regina Hong
Updated on : December 19, 2018
*/
//////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php
include 'INC/ConvertNumberToHebrewLetters.php';
require_once 'INC/Database.php';

$bible_content = '';
$letter_options = "<option value=''>-</option>";
$letters_heb = array('א','ב','ג', 'ד','ה', 'ו', 'ז','ח','ט', 'י','כ','ל','מ','נ','ס', 'ע','פ','צ','ק', 'ר','ש','ת','ך','ם','ף','ן','ץ');
$letters_eng = array('Ah','Bt','Gl','Td','Hh','Vv','Zn','Ht','Tt','Yd','Cf','Ld','Mm','Nn','Sd','An','Ph','Zk','Kf','Rh','Sn','Tv','Cf','Mm','Ph','Nn','Zk');

for ($i=0; $i < count($letters_heb); $i++) {

	$letter_options .= "<option value='".$letters_eng[$i]."'>".$letters_heb[$i]."</option>";

}

//Get mosted used words from bible analysis database
$query = "SELECT * FROM u955934022_bible.strong AS a WHERE a.POS LIKE 'v%'";

$mysql = get_database_connection();
mysqli_set_charset($mysql,'utf8');
$result = mysqli_query($mysql, $query);

$words = array();
$defs = array();
$poss = array();
$xlits = array();
$ids = array();
$total_rows = 0;

while($row = mysqli_fetch_assoc($result)) {
	$words[] =$row['Word'];
	$defs[] =$row['Def'];
	if (strpos($row['POS'],' ') > 0 ) {
		$poss[] = substr($row['POS'], 0, strpos($row['POS'], ' '));
	}
	else {
		$poss[] = $row['POS'];
	}

	$xlits[] = $row['xlit'];
	$ids[] = $row['ID'];
	$total_rows++;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Biblical Hebrew Verb System</title>
	<meta name="keywords" content="Biblical Hebrew Study Resources, List of Vocabularies, Dynamic generation by book chapter and part of speech, Biblical Hebrew Study">
	<meta name="description" content="This is Biblical Hebrew Study Resources page written in PHP and in mobile friendly website to present the list of vocabularies by part of speech with dynamic selection by book and chapter.">
	<?php require 'INC/Header.php'; ?>
	<link href="https://fonts.googleapis.com/css?family=Eagle+Lake" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="CSS/1-3/StudyResources.css"> <!-- my css -->
	<script src="JS/1-2/StudyResources.js"></script> <!-- my jQuery -->
	<script src="JS/1-2/BiblicalHebrewVerbSystem.js"></script> <!-- my jQuery -->
</head>
<body>

<?php require 'INC/Nav.php'; ?>

<div class="container-fluid" id="index">
	<!-- Book, Chapter, Verse selection form on the right menu-->
	<form class="form-inline">
        <div class="form-group">
        	<label for="dynamic_select_root_3">&nbsp;Root Letter Search&nbsp;</label>
	        <select name="dynamic_select_root_3" class="form-control" id="dynamic_select_root_3"><?php echo $letter_options; ?></select>        
	        <label for="dynamic_select_root_3">&nbsp;3&nbsp;</label>
	        <select name="dynamic_select_root_2" class="form-control" id="dynamic_select_root_2"><?php echo $letter_options; ?></select>
	        <label for="dynamic_select_root_2">&nbsp;2&nbsp;</label>     
	        <select name="dynamic_select_root_1" class="form-control" id="dynamic_select_root_1"><?php echo $letter_options; ?></select>
	        <label for="dynamic_select_root_1">&nbsp;1&nbsp;</label>
        </div>
    </form> 
</div>

<div class="container-fluid" id="header">
	<h2 class="text-center">Biblical Hebrew Verb System</h2>
</div>

<div class="container-fluid" id="content">
	<div id="bible-text">
		<p>*Total 1,615 verbs from Hebrew Strong's dictionary</p>
		<p id="bible-content">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Definitions</th>
						<th>Type</th>
						<th>3</th>
						<th>2</th>
						<th>1</th>
						<th>xlit</th>
						<th>Root</th>
						<th>ID</th>
					</tr>
				</thead>
				<tbody>
					<?php 

						for ($t=0; $t < count($words) ; $t++) { 

							if ($poss[$t] == 'v') {
								$d = str_replace(',', ', ', $defs[$t]);

								//Replace Cantillation
								$verb_root = preg_replace('/[\x{0591}-\x{05C7}\x{05F0}-\x{05F5}]/u','',$words[$t]);

								$firstletter = mb_substr($verb_root,0,1);
								$secondletter = mb_substr($verb_root,1,1);
								$thirdletter= mb_substr($verb_root,2,3);

								$firstletter_eng = $letters_eng[array_search($firstletter, $letters_heb)];
								$secondletter_eng = $letters_eng[array_search($secondletter, $letters_heb)];
								$thirdletter_eng= $letters_eng[array_search($thirdletter, $letters_heb)];

								echo '<tr id="root'.$firstletter_eng.$secondletter_eng.$thirdletter_eng.'">';
								echo '<td><sup>'.rtrim($d,', ').'</sup></td>';

								if ($firstletter == 'א') {
									$verb_type = 'Weak<br>I-Aleph';	
								} elseif ($firstletter == 'נ') {
									$verb_type = 'Weak<br>I-Nun';										
								} elseif ($firstletter == 'נ') {
									$verb_type = 'Weak<br>I-Nun';										
								} elseif ($firstletter == 'י') {
									$verb_type = 'Weak<br>I-Yud';										
								} elseif ($thirdletter == 'ה') {
									$verb_type = 'Weak<br>III-He';										
								} elseif ($secondletter == $thirdletter) {
									$verb_type = 'Weak<br>Geminate';										
								} elseif ($firstletter == 'ר' || $firstletter == 'ה' || $firstletter == 'ע' || $firstletter == 'ח') {
									$verb_type = 'Weak<br>I-Guttural';
								} elseif ($secondletter == 'ו' || $secondletter == 'י') {
									$verb_type = 'Weak<br>Hollow';
								} else {
									$verb_type = 'strong';								
								}

								echo '<td><sup>'.$verb_type.'</sup></td>';
								echo '<td>'.$thirdletter.'</td>';
								echo '<td>'.$secondletter.'</td>';
								echo '<td>'.$firstletter.'</td>';
								echo '<td><sup>'.$xlits[$t].'</sup></td>';
								echo '<td>'.$verb_root.'</td>';
								echo '<td><a href="HebrewStrong.php?id='.$ids[$t].'" target="_blank">'.$ids[$t].'</a></td>';
								echo '</tr>';
							}

						}

					?>
				</tbody>
			</table>
		</p>
	</div>
</div>

<?php require 'INC/Footer.php'; ?>

</body>
</html>

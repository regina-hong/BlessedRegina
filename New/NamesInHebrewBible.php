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

The purpose is to make it easy to learn Biblical Hebrew Vocabularies by presenting words grouped by part of speech 
and order it by the occurence frequency within that chapter of the book.

*Open Source Original Credits*
*Hebrew Tanach XML Files : https://github.com/ancientlanguage/xml-tanach
*Hebrew Strong XML Files : https://github.com/openscriptures/HebrewLexicon/blob/master/HebrewStrong.xml

Created by : Regina Hong
Updated by : Regina Hong
Updated on : May 10, 2018
*/
//////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php
include 'INC/ConvertNumberToHebrewLetters.php';
require_once 'INC/Database.php';

$bible_content = '';

$query = "SELECT b.Word, b.xlit, b.Def, b.POS, b.ID FROM u955934022_bible.strong as b WHERE b.POS LIKE '%n-pr%' ORDER BY b.Word ASC";

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
	<title>Names in Hebrew Bible</title>
	<meta name="keywords" content="Biblical Hebrew Study Resources, List of Names in Hebrew Bible, Biblical Hebrew Study Plan, Learn Hebrew Alphabet through Biblical Names in Hebrew">
	<meta name="description" content="This is Biblical Hebrew Study Resources page written in PHP and in mobile friendly website to present the list of Biblical Names in Hebrew. This will help you in studying Biblical Hebrew Alphabets through recognizing letters in the names that you are already familiar with from English Bible.">
	<?php require 'INC/Header.php'; ?>
	<link href="https://fonts.googleapis.com/css?family=Eagle+Lake" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="CSS/1-2/StudyResources.css"> <!-- my css -->
	<script src="JS/1-2/StudyResources.js"></script> <!-- my jQuery -->
</head>
<body>

<?php require 'INC/Nav.php'; ?>

<div class="container-fluid" id="header">
	<h2 class="text-center">Biblical Names in Hebrew<br><button class="btn blue-h" type="button" data-toggle="collapse" data-target="#collapseMale" aria-expanded="false" aria-controls="collapseMale" align="text-center">Male</button> <button class="btn pink-h" type="button" data-toggle="collapse" data-target="#collapseFemale" aria-expanded="false" aria-controls="collapseFemale" align="text-center">Female</button> <button class="btn orange-h" type="button" data-toggle="collapse" data-target="#collapseUnknown" aria-expanded="false" aria-controls="collapseUnknown" align="text-center">Unknown</button></h2><br><p class="text-center">*These are toggle buttons. Click to show and click to hide.*</p>
</div>

<div class="container-fluid" id="content">
	<div id="bible-text">
		<p id="bible-content">

		<div class="collapse" id="collapseMale">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th colspan="3" scope="col" class="orange-h">Male</th>
					</tr>
					<tr>
						<th>Definitions</th>
						<th>xlit</th>
						<th>Word</th>
					</tr>
				</thead>
				<tbody>
					<?php 

						for ($t=0; $t < count($words) ; $t++) { 

							if ($poss[$t] == 'n-pr-m') {
								$d = str_replace(',', ', ', $defs[$t]);
								echo '<tr>';
								echo '<td><sup>'.rtrim($d,', ').'</sup></td>';
								echo '<td><sup>'.$xlits[$t].'</sup></td>';
								echo '<td><a href="HebrewStrong.php?id='.$ids[$t].'" target="_blank">'.$words[$t].'</a></td>';
								echo '</tr>';
							}

						}

					?>
				</tbody>
			</table>
		</div>

		<div class="collapse" id="collapseFemale">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th colspan="3" scope="col" class="orange-h">Female</th>
					</tr>
					<tr>
						<th>Definitions</th>
						<th>xlit</th>
						<th>Word</th>
					</tr>
				</thead>
				<tbody>
					<?php 

						for ($t=0; $t < count($words) ; $t++) { 

							if ($poss[$t] == 'n-pr-f') {
								$d = str_replace(',', ', ', $defs[$t]);
								echo '<tr>';
								echo '<td><sup>'.rtrim($d,', ').'</sup></td>';
								echo '<td><sup>'.$xlits[$t].'</sup></td>';
								echo '<td><a href="HebrewStrong.php?id='.$ids[$t].'" target="_blank">'.$words[$t].'</a></td>';
								echo '</tr>';
							}

						}

					?>
				</tbody>
			</table>
		</div>

		<div class="collapse" id="collapseUnknown">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th colspan="3" scope="col" class="orange-h">Unknown</th>
					</tr>
					<tr>
						<th>Definitions</th>
						<th>xlit</th>
						<th>Word</th>
					</tr>
				</thead>
				<tbody>
					<?php 

						for ($t=0; $t < count($words) ; $t++) { 

							if ($poss[$t] == 'n-pr') {
								$d = str_replace(',', ', ', $defs[$t]);
								echo '<tr>';
								echo '<td><sup>'.rtrim($d,', ').'</sup></td>';
								echo '<td><sup>'.$xlits[$t].'</sup></td>';
								echo '<td><a href="HebrewStrong.php?id='.$ids[$t].'" target="_blank">'.$words[$t].'</a></td>';
								echo '</tr>';
							}

						}

					?>
				</tbody>
			</table>
		</div>

		</p>
	</div>
</div>

<?php require 'INC/Footer.php'; ?>

</body>
</html>

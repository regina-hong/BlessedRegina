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
It presents Biblical Hebrew Vocabulary Analysis on consonantal and vowel form variations and reference verses 
by reading it from the database I converted from WLC Word List from  openscriptures.

The purpose is to make it easy to learn and recognize Biblical Hebrew Vocabularies by presenting words 
grouped by same Hebrew Strong's ID and to study patterns and deeper relations by its usage throughout different books.

*Open Source Original Credits*
*Hebrew Tanach XML Files : https://github.com/openscriptures/morphhb/blob/master/WlcWordList/WordList.xml

Created by : Regina Hong
Updated by : Regina Hong
Updated on : September 28, 2017
*/
//////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php

include 'INC/ConvertNumberToHebrewLetters.php';
require_once 'INC/Database.php';

//Get 3 parameters from URL. Genesis Chapter 1 is the default
$id = (isset($_GET['id'])) ? $_GET['id'] : '' ;
$vword = (isset($_GET['vword'])) ? $_GET['vword'] : '' ;
$cword = (isset($_GET['cword'])) ? $_GET['cword'] : '' ;

if ($id <> '' || $vword <> '' || $cword <> '') {

	//Get mosted used words from bible analysis database
	if ($id <> '') {
		$query = "SELECT DISTINCT C, V, Ref, Strong_ID FROM u955934022_bible.ref WHERE Strong_ID = '".$id."'";
	}
	elseif ($vword <> '') {
		$query = "SELECT DISTINCT C, V, Ref, Strong_ID FROM u955934022_bible.ref WHERE V = '".$vword."'";
	}
	elseif ($cword <> '') {
		$query = "SELECT DISTINCT C, V, Ref, Strong_ID FROM u955934022_bible.ref WHERE C = '".$cword."'";
	}

	$mysql = get_database_connection();
	mysqli_set_charset($mysql,'utf8');
	$result = mysqli_query($mysql, $query);

	function CountByBook($text) {

		$ref_list = explode(" ",$text);
		$final_list = array();

		$test = '';
		foreach ($ref_list as $key => $value) {

			$tp = strtok($value, '.');

			if (!isset( $final_list[$tp])) {
				$final_list[$tp] = 1;
			}
			else {
				$final_list[$tp]++;
			}
		}

		array_pop($final_list);

		$output_list = '';
		foreach ($final_list as $key => $value) {
			$output_list .= $key.' - '.$value.'<br>';
		}
		return $output_list;
	}

	function GetBibleLink($reference) {

		$ref_list = explode(" ",$reference);
		array_pop($ref_list);

		$book = array();
		$chapter = array();
		$verse = array();

		foreach ($ref_list as $key => $value) {
			$book[] = strtok($value, '.');
			$chapter[] = get_string_between($value,'.','.');
			$verse[] = substr(strrchr($value, "."), 1);
		}

		$output_list = '';
		for ($n=0; $n < count($book) ; $n++) { 
			$output_list .= "<a href='TheBible.php?book=".$book[$n]."&chapter=".$chapter[$n]."&verse=".$verse[$n]."' target='_blank'>".$ref_list[$n]."</a><br>";
		}

		return $output_list;
	}

	function get_string_between($string, $start, $end){
	    $string = ' ' . $string;
	    $ini = strpos($string, $start);
	    if ($ini == 0) return '';
	    $ini += strlen($start);
	    $len = strpos($string, $end, $ini) - $ini;
	    return substr($string, $ini, $len);
	}

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Biblical Hebrew Study Resources</title>
	<meta name="keywords" content="Hebrew Bible Analysis, Tanakh Old Testament, Biblical Hebrew, Search for the Truth, Reaching for Spiritual Depth">
	<meta name="description" content="The Hebrew Bible (Tanakh) Analysis, Biblical Hebrew Study Resources, Reaching for Spiritual Depth, Searching for The Truth, Analyzing Sacred Ancient Texts.">
	<?php require 'INC/Header.php'; ?>
	<link rel="stylesheet" type="text/css" href="CSS/1-2/TheBible.css"> <!-- my css -->
	<link rel="stylesheet" type="text/css" href="CSS/1-2/HebrewStrong.css"> <!-- my css -->
	<script src="JS/1-2/Analysis.js"></script> <!-- my jQuery -->
</head>
<body>

<?php require 'INC/Nav.php'; ?>

<div class="container-fluid" id="index">
	<!-- Hebrew Word, Strong ID, Definition and Meaning selection form on the top menu-->
	<form class="form-inline">
        <div class="form-group">
        	<label for="dynamic_select_id">Strong's ID</label>
	        <input name="id" class="form-control" id="dynamic_select_id" placeholder="1 - 8674">
	        <label for="dynamic_select_vword">V-Word</label>
	        <input name="word" class="form-control" id="dynamic_select_vword" placeholder="in vowel form..">
	        <label for="dynamic_select_cword">C-Word</label>
	        <input name="def" class="form-control" id="dynamic_select_cword" placeholder="in consonantal form..">
        </div>
    </form> 
</div>

<div class="container-fluid" id="content">
	<div id="bible-text">
	

			<?php 

				echo '<b>Biblical Hebrew Vocabulary Analysis</b><br>';

				if ($id <> '' || $vword <> '' || $cword <> '') {
					if ($id <> '') {

						echo 'Strong ID: <span id="iid">'.$id.'</span>';

					}
					elseif ($vword <> '') {

						echo 'on V-Word: <span id="w">'.$vword.'</span>';

					}
					elseif ($cword <> '') {

						echo 'on C-Word: <span id="w">'.$cword.'</span>';

					}
				}

			?>
			<br>
			<table class="table table-bordered table-stripe">
				<thead>
					<th>References<br><button onclick="ShowHideReference('reference')" class="btn btn-basic">Show/Hide</button></th>
					<th>Total # of verses by books<br><button onclick="ShowHideReference('countbybook')" class="btn btn-basic">Show/Hide</button></th>
					<th>Total # of verses in Tanakh</th>
					<th>V-Word</th>
					<th>C-Word</th>
					<th>Strong ID</th>
				</thead>
				<tbody>
					<?php 

						if ($id <> '' || $vword <> '' || $cword <> '') {
							$ref_id = 0;
							while($row = mysqli_fetch_assoc($result)) {

								echo '<tr>';
								//echo '<td><button onclick="ShowHideReference(\'ref'.$ref_id.'\')">Click here</button><div class="reference" id="ref'.$ref_id.'">'.$row['Ref'].'</div></td>';
								echo '<td><div class="reference" style="display:none">'.GetBibleLink($row['Ref']).'</div></td>';
								echo '<td><div class="countbybook" style="display:none">'.CountByBook($row['Ref']).'</div></td>';
								echo '<td>'.substr_count($row['Ref'], ' ').'</td>';
								echo '<td><div class="vcword">'.$row['V'].'</div></td>';
								echo '<td><div class="vcword">'.$row['C'].'</div></td>';
								echo '<td><div class="vcword"><a href="HebrewStrong.php?id='.$row['Strong_ID'].'" target="_blank">'.$row['Strong_ID'].'</a></div></td>';
								echo '</tr>';

								$ref_id ++;
							}
						}

					?>
				</tbody>
			</table>
	</div>
</div>

<?php require 'INC/Footer.php'; ?>

</body>
</html>
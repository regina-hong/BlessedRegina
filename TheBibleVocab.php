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
Updated on : September 26, 2017
*/
//////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php
include 'INC/ConvertNumberToHebrewLetters.php';
require_once 'INC/Database.php';

//Get 3 parameters from URL. Genesis Chapter 1 is the default
$book = (isset($_GET['book'])) ? $_GET['book'] : 'Gen' ;
$chapter = (isset($_GET['chapter'])) ? $_GET['chapter'] : '1' ;
$pos = (isset($_GET['pos'])) ? $_GET['pos'] : '' ;

$books = array();
$chapters = array();
$book_options = '';
$chapter_options = '';
$pos_options = '<option value="">All</option>';
$bible_content = '';

//Tanach Index file
$xml_tanach_index = 'Analysis/book/Book_Index.xml';
$xml_index = simplexml_load_file($xml_tanach_index) or die('Error: There was a problem loading XML Index file.');

for ($k=0; $k < 39; $k++) { 

	$book_name = $xml_index->tanach->book[$k]->names->name; //Name for each book
	$file_name = $xml_index->tanach->book[$k]->names->abbrev; //File Name for each book
	$books_name[] = $book_name;
	$books_file_name[] = $file_name;
	$chapters[] = $xml_index->tanach->book[$k]->cs; //Total number of chapters for each book

}

//Get the list of Books
for ($i=0; $i < Count($books_file_name); $i++) { 
	if ($books_file_name[$i] == $book) {
		$book_options .= "<option value='".$books_file_name[$i]."' selected>".$books_name[$i]."</option>";
	}
	else {
		$book_options .= "<option value='".$books_file_name[$i]."'>".$books_name[$i]."</option>";
	}
}

//Get the list of Chapters of the Book
$chapter_key = array_search($book, $books_file_name);

for ($i=0; $i < $chapters[$chapter_key]; $i++) { 

	$print = $i + 1;
	if ((string)$chapter == (string)$print) {
		$chapter_options .= "<option value='".$chapter."' selected>".$chapter."</option>";
	}
	else {
		$chapter_options .= "<option value='".$print."'>".$print."</option>";
	}

}

//Get mosted used words from bible analysis database
if ($pos == '') {
	$query = "SELECT a.Strong_ID, b.Word, b.xlit, Count(*) as Frequency, b.Def, b.POS FROM u955934022_bible.word AS a LEFT JOIN u955934022_bible.strong AS b ON (a.Strong_ID = b.ID) WHERE a.Book = '".$book."' AND a.Chapter ='".$chapter."' AND a.Strong_ID <> '' AND b.Word <> '' GROUP BY a.Strong_ID ORDER BY b.POS DESC, Frequency DESC";
}
else {
	$query = "SELECT a.Strong_ID, b.Word, b.xlit, Count(*) as Frequency, b.Def, b.POS FROM u955934022_bible.word AS a LEFT JOIN u955934022_bible.strong AS b ON (a.Strong_ID = b.ID) WHERE a.Book = '".$book."' AND a.Chapter ='".$chapter."' AND b.POS ='".$pos."'AND a.Strong_ID <> '' AND b.Word <> '' GROUP BY a.Strong_ID ORDER BY b.POS DESC, Frequency DESC";
}

//Get PoS data separately
$pos_query = "SELECT a.Strong_ID, b.Word, b.xlit, Count(*) as Frequency, b.Def, b.POS FROM u955934022_bible.word AS a LEFT JOIN u955934022_bible.strong AS b ON (a.Strong_ID = b.ID) WHERE a.Book = '".$book."' AND a.Chapter ='".$chapter."' AND a.Strong_ID <> '' AND b.Word <> '' GROUP BY a.Strong_ID ORDER BY b.POS DESC, Frequency DESC";


$mysql = get_database_connection();
mysqli_set_charset($mysql,'utf8');
$result = mysqli_query($mysql, $query);
$pos_result = mysqli_query($mysql, $pos_query);

$words = array();
$defs = array();
$poss = array();
$poss_options = array();
$xlits = array();
$ids = array();
$total_rows = 0;

while($row = mysqli_fetch_assoc($result)) {
	$words[] =$row['Word'];
	$defs[] =$row['Def'];
	$poss[] = $row['POS'];
	$xlits[] = $row['xlit'];
	$ids[] = $row['Strong_ID'];
	$total_rows++;
}

while($pos_row = mysqli_fetch_assoc($pos_result)) {
	$poss_options[] = $pos_row['POS'];
}

$prev_pos = '';
//Get the list of the Verses of the Chapter of the Book
for ($m=0; $m < count($poss_options); $m++) { 

	if ($poss_options[$m] <> $prev_pos) {

		if ($pos == $poss_options[$m]) {
			$pos_options .= "<option value='".$poss_options[$m]."' selected>".$poss_options[$m]."</option>";
		}
		else {
			$pos_options .= "<option value='".$poss_options[$m]."'>".$poss_options[$m]."</option>";
		}

		$prev_pos = $poss_options[$m];
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
	<link rel="stylesheet" type="text/css" href="CSS/TheBible.css"> <!-- my css -->
	<script src="JS/TheBibleVocab.js"></script> <!-- my jQuery -->
</head>
<body>

<?php require 'INC/Nav.php'; ?>

<div class="container-fluid" id="index">
	<!-- Book, Chapter, Verse selection form on the right menu-->
	<form class="form-inline">
        <div class="form-group">
	        <label for="dynamic_select_book">&nbsp;Book&nbsp;</label>
	        <select name="book" class="form-control" id="dynamic_select_book"><?php echo $book_options; ?></select>
	        <label for="dynamic_select_chapter">&nbsp;Chapter&nbsp;</label>             
	        <select name="chapter" class="form-control" id="dynamic_select_chapter"><?php echo $chapter_options; ?></select>
	       	<label for="dynamic_select_chapter">&nbsp;PoS&nbsp;</label>             
	        <select name="pos" class="form-control" id="dynamic_select_pos"><?php echo $pos_options; ?></select>
        </div>
    </form> 
</div>

<div class="container-fluid" id="content">
	<div id="bible-text">
		<p id="bible-content">
			<table class="table table-bordered table-striped">
				<thead>
					<th>Definitions</th>
					<th>xlit</th>
					<th>Word</th>
				</thead>
				<tbody>
					<?php 

						for ($t=0; $t < count($words) ; $t++) { 

							$d = str_replace(',', ', ', $defs[$t]);

							echo '<tr>';
							if ($pos == '') {
								echo '<td>'.rtrim($d,', ').' ('.$poss[$t].')</td>';
							}
							else {
								echo '<td>'.rtrim($d,', ').'</td>';
							}
							echo '<td>'.$xlits[$t].'</td>';
							echo '<td><a href="HebrewStrong.php?id='.$ids[$t].'" target="_blank">'.$words[$t].'</a></td>';
							echo '</tr>';

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

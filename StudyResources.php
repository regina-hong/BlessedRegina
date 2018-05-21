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
Updated on : April 15, 2018
*/
//////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php
include 'INC/ConvertNumberToHebrewLetters.php';
require_once 'INC/Database.php';

//Get 3 parameters from URL. Genesis Chapter 1 is the default
$book = (isset($_GET['book'])) ? $_GET['book'] : 'Gen' ;
$chapter = (isset($_GET['chapter'])) ? $_GET['chapter'] : '1' ;

$books = array();
$chapters = array();
$book_options = '';
$chapter_options = '';
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
		$bknum = $i;
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
$query = "SELECT a.Strong_ID, b.Word, b.xlit, Count(*) as Frequency, b.Def, b.POS FROM u955934022_bible.word AS a LEFT JOIN u955934022_bible.strong AS b ON (a.Strong_ID = b.ID) WHERE a.Book = '".$book."' AND a.Chapter ='".$chapter."' AND a.Strong_ID <> '' AND b.Word <> '' GROUP BY a.Strong_ID ORDER BY b.POS DESC, Frequency DESC";

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
	$ids[] = $row['Strong_ID'];
	$total_rows++;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Biblical Hebrew Study Resources</title>
	<meta name="keywords" content="Biblical Hebrew Study Resources, List of Vocabularies, Dynamic generation by book chapter and part of speech, Biblical Hebrew Study">
	<meta name="description" content="This is Biblical Hebrew Study Resources page written in PHP and in mobile friendly website to present the list of vocabularies by part of speech with dynamic selection by book and chapter.">
	<?php require 'INC/Header.php'; ?>
	<link href="https://fonts.googleapis.com/css?family=Eagle+Lake" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="CSS/1-2/StudyResources.css"> <!-- my css -->
	<script src="JS/1-2/StudyResources.js"></script> <!-- my jQuery -->
	<script>
		function GoToChapter() {
		    window.open("TheBible.php?book=<?php echo $book; ?>&chapter=<?php echo $chapter; ?>");
		}
	</script>
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
        </div>
    </form> 
</div>

<div id="bible-text">
		<p id="bible-content"> <button onclick="GoToChapter()" class="btn btn-success text-center">Open Bible For This Chapter</button> </p>
</div>

<div class="container-fluid" id="header">
	<h2 class="text-center">Study Resources for <?php echo $books_name[$bknum]; ?> Chapter <?php echo $chapter; ?></h2>
</div>

<div class="container-fluid" id="content">
	<div id="bible-text">
		<p id="bible-content">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th colspan="3" scope="col" class="orange-h">Name of People or Place</th>
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

							if ($poss[$t] == 'n-pr-m' || $poss[$t] == 'n-pr-f' || $poss[$t] == 'n-pr') {
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

			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th colspan="3" scope="col" class="purple-h">Name of Location</th>
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

							if ($poss[$t] == 'n-m-loc' || $poss[$t] == 'n-pr-loc' || $poss[$t] == 'n-pr-m n-pr-loc' || $poss[$t] == 'n-pr-loc n-pr-m') {
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

			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th colspan="3" scope="col" class="yellow-h">Noun</th>
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

							if ($poss[$t] == 'n' || $poss[$t] == 'n-m' || $poss[$t] == 'n-f') {
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

			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th colspan="3" scope="col" class="pink-h">Verb</th>
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

							if ($poss[$t] == 'v') {
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

			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th colspan="3" scope="col" class="darkyellow-h">Adjective</th>
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

							if ($poss[$t] == 'a' || $poss[$t] == 'a-m' || $poss[$t] == 'a-f' || $poss[$t] == 'a-gent') {
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

			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th colspan="3" scope="col" class="magenta-h">Adverb</th>
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

							if ($poss[$t] == 'adv') {
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

			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th colspan="3" scope="col" class="blue-h">Pronoun</th>
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

							if ($poss[$t] == 'p') {
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

			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th colspan="3" scope="col" class="green-h">The Rest</th>
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

							if ($poss[$t] <> 'p' && $poss[$t] <> 'adv' && $poss[$t] <> 'a' && $poss[$t] <> 'a-m' && $poss[$t] <> 'a-f' && $poss[$t] <> 'a-gent' && $poss[$t] <> 'v' && $poss[$t] <> 'n' && $poss[$t] <> 'n-m' && $poss[$t] <> 'n-f' && $poss[$t] <> 'n-m-loc' && $poss[$t] <> 'n-pr-loc' && $poss[$t] <> 'n-pr-m' && $poss[$t] <> 'n-pr-f' && $poss[$t] <> 'n-pr' && $poss[$t] <> 'n-pr-m n-pr-loc' && $poss[$t] <> 'n-pr-loc n-pr-m') {
								$d = str_replace(',', ', ', $defs[$t]);
								echo '<tr>';
								echo '<td><sup>'.rtrim($d,', ').' ('.$poss[$t].')</sup></td>';
								echo '<td><sup>'.$xlits[$t].'</sup></td>';
								echo '<td><a href="HebrewStrong.php?id='.$ids[$t].'" target="_blank">'.$words[$t].'</a></td>';
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

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
This page is written in PHP to read Hebrew Tanach XML files and English KJV XML file 
and uses HMTL, jQUERY, CSS and Bootstrap to present it in mobile-friendly web pages.

*Open Source Original Credits*
*Hebrew Tanach XML Files : https://github.com/ancientlanguage/xml-tanach
*KJV XML File : https://github.com/neoadventist/kjvsql

Created by : Regina Hong
Updated by : Regina Hong
Updated on : January 26, 2019
*/
//////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php
include 'INC/ConvertNumberToHebrewLetters.php';
include 'INC/BasicPrefixSuffix.php';
require_once 'INC/Database.php';

//Get 3 parameters from URL. Genesis Chapter 1 is the default
$book = (isset($_GET['book'])) ? $_GET['book'] : 'Gen' ;
$chapter = (isset($_GET['chapter'])) ? $_GET['chapter'] : '1' ;
$verse = (isset($_GET['verse'])) ? $_GET['verse'] : '' ;

include 'YouTube/getyoutube.php';

$books = array();
$chapters = array();
$book_options = '';
$chapter_options = '';
$verse_options = '<option value="">All</option>';
$bible_content = '';

//Tanach Index file
$xml_tanach_index = 'Analysis/book/Book_Index.xml';
$xml_index = simplexml_load_file($xml_tanach_index) or die('Error: There was a problem loading XML Index file.');

//Get Tanach Book file based on parameter of the URL
$xml_tanach_book = 'Analysis/book/'.$book.'.xml';
$xml_book = simplexml_load_file($xml_tanach_book) or die('Error: There was a problem loading XML Book file.');

//Get KJV Book file based on parameter of the URL
$xml_kjv_book = 'Analysis/eng/kjv_osis.xml';
$xml_eng_book = simplexml_load_file($xml_kjv_book) or die('Error: There was a problem loading XML Book file.');

$xml_he = new DOMDocument();
$xml_he->load($xml_tanach_book);

$xml_en = new DOMDocument();
$xml_en->load($xml_kjv_book);


for ($k=0; $k < 39; $k++) { 

	$book_name = $xml_index->tanach->book[$k]->names->name; //Name for each book
	$file_name = $xml_index->tanach->book[$k]->names->abbrev; //File Name for each book
	$books_name[] = $book_name;
	$books_file_name[] = $file_name;
	$chapters[] = $xml_index->tanach->book[$k]->cs; //Total number of chapters for each book

}


//Get mosted used words from bible analysis database
$query = "SELECT a.Strong_ID, b.POS FROM u955934022_bible.word AS a LEFT JOIN u955934022_bible.strong AS b ON (a.Strong_ID = b.ID) WHERE a.Book = '".$book."' AND a.Chapter ='".$chapter."' AND a.Strong_ID <> '' AND b.Word <> '' GROUP BY a.Strong_ID ORDER BY b.POS ASC";

$mysql = get_database_connection();
mysqli_set_charset($mysql,'utf8');
$result = mysqli_query($mysql, $query);

$poss = array();
$ids = array();
$total_rows = 0;

while($row = mysqli_fetch_assoc($result)) {
	$poss[] = $row['POS'];
	$ids[] = $row['Strong_ID'];
	$total_rows++;
}

//Get the list of Books
for ($i=0; $i < Count($books_file_name); $i++) { 
	if ($books_file_name[$i] == $book) {
		$book_options .= "<option value='".$books_file_name[$i]."' selected>".$books_name[$i]."</option>";
		$mybook = $books_name[$i];
	}
	else {
		$book_options .= "<option value='".$books_file_name[$i]."'>".$books_name[$i]."</option>";
	}
}

//Get the list of Chapters of the Book
$chapter_key = array_search($book, $books_file_name);
$total_verses = $xml_index->tanach->book[$chapter_key]->c[$chapter-1]->vs; //Total number of verses for each chapter

for ($i=0; $i < $chapters[$chapter_key]; $i++) { 

	$print = $i + 1;
	if ((string)$chapter == (string)$print) {
		$chapter_options .= "<option value='".$chapter."' selected>".$chapter."</option>";
	}
	else {
		$chapter_options .= "<option value='".$print."'>".$print."</option>";
	}

}

//Get the list of the Verses of the Chapter of the Book
for ($m=0; $m < $total_verses; $m++) { 

	$print_v = $m + 1;
	if ((string)$verse == (string)$print_v) {
		$verse_options .= "<option value='".$print_v."' selected>".$print_v."</option>";
	}
	else {
		$verse_options .= "<option value='".$print_v."'>".$print_v."</option>";
	}

//All verses in a chapter printout as default
	if ($verse == '') {

		$xpath_he = new DOMXPath($xml_he);
		$words = $xpath_he->query("//div/chapter/verse[@osisID='".$book.".".$chapter.".".$print_v."']/w");

		if ($url <> '') {
			//youtube video link
			$vsearch = $mybook.' '.$chapter.':'.($m+1).' in Ancient Hebrew';
			$vkey = array_search($vsearch, $vtitle);

			if (!$vid[$vkey]=='') {
				$bible_content .='<object type="application/x-shockwave-flash" width="30" height="25" data="https://www.youtube.com/v/'.$vid[$vkey].'?version=2&enablejsapi=1&theme=dark"><param name="movie" value="https://www.youtube.com/v/'.$vid[$vkey].'?version=2&enablejsapi=1&theme=dark" /><param name="wmode" value="transparent" /></object>';
			}
		}

		//verse number
		//$words = $xml_book->div->chapter->verse[1]->w;
		$bible_content .= '<sup>'.ConvertNtoHL($m+1).'.</sup> ';


		//Loop through each word of the Verse
		foreach ($words as $entry) {
	
			$lid = $entry->getAttribute('lemma');
			$hword = $entry->nodeValue;
			$sid = preg_replace("/[^0-9,.]/", "", $lid);
			$key = array_search($sid, $ids);

			if (strpos($poss[$key], ' ') > 0) {
				$poscname = substr($poss[$key], 0, strpos($poss[$key], ' '));
			}
			else {
				$poscname = $poss[$key];
			}

			if ($poscname <> 'p' && $poscname <> 'adv' && $poscname <> 'a' && $poscname <> 'a-m' && $poscname <> 'a-f' && $poscname <> 'a-gent' && $poscname <> 'v' && $poscname <> 'n' && $poscname <> 'n-m' && $poscname <> 'n-f' && $poscname <> 'n-m-loc' && $poscname <> 'n-pr-loc' && $poscname <> 'n-pr-m' && $poscname <> 'n-pr-f' && $poscname <> 'n-pr') {
				$poscname = 'other';
			}

			if (strpos($hword, '/') >0) {
				$bible_content .= DeterminePrefixSufix($hword, $poscname, $sid);
			}
			else {
				$bible_content .= '<span class="'.$poscname.'"><a href="HebrewStrong.php?id='.$sid.'">'.$hword.'</a></span> ';
			}

		}

		$bible_content .= '<br>';

		include 'INC/KJVMatchCleanupChapter.php';

		//Loop through each word of the Verse
		foreach ($words as $entry) {
			$nodes = $entry->childNodes;		
			foreach ($nodes as $node) {

					$vword = $node->nodeValue;
			}

			$bible_content .= '<span class="kjv" style="color:grey;"><sup>'.$node->nodeValue.($m+1).'</sup></span><br>';

		}
	}
}

//Individual verse printout
if ($verse <> '') {

		$xpath_he = new DOMXPath($xml_he);
		$words = $xpath_he->query("//div/chapter/verse[@osisID='".$book.".".$chapter.".".$verse."']/w");

		if ($url <> '') {
			//youtube video link
			$vsearch = $mybook.' '.$chapter.':'.$verse.' in Ancient Hebrew';
			$vkey = array_search($vsearch, $vtitle);

			if (!$vid[$vkey]=='') {
				$bible_content .='<object type="application/x-shockwave-flash" width="30" height="25" data="https://www.youtube.com/v/'.$vid[$vkey].'?version=2&enablejsapi=1&theme=dark"><param name="movie" value="https://www.youtube.com/v/'.$vid[$vkey].'?version=2&enablejsapi=1&theme=dark" /><param name="wmode" value="transparent" /></object>';
			}
		}

		//$words = $xml_book->div->chapter->verse[1]->w;
		$bible_content .= '<sup>'.ConvertNtoHL($verse).'.</sup> ';

		//Loop through each word of the Verse
		foreach ($words as $entry) {

			$lid = $entry->getAttribute('lemma');
			$hword = $entry->nodeValue;
			$sid = preg_replace("/[^0-9,.]/", "", $lid);
			$key = array_search($sid, $ids);

			if (strpos($poss[$key], ' ') > 0) {
				$poscname = substr($poss[$key], 0, strpos($poss[$key], ' '));
			}
			else {
				$poscname = $poss[$key];
			}

			if ($poscname <> 'p' && $poscname <> 'adv' && $poscname <> 'a' && $poscname <> 'a-m' && $poscname <> 'a-f' && $poscname <> 'a-gent' && $poscname <> 'v' && $poscname <> 'n' && $poscname <> 'n-m' && $poscname <> 'n-f' && $poscname <> 'n-m-loc' && $poscname <> 'n-pr-loc' && $poscname <> 'n-pr-m' && $poscname <> 'n-pr-f' && $poscname <> 'n-pr') {
				$poscname = 'other';
			}

			if (strpos($hword, '/') >0) {
				$bible_content .= DeterminePrefixSufix($hword, $poscname, $sid);
			}
			else {
				$bible_content .= '<span class="'.$poscname.'"><a href="HebrewStrong.php?id='.$sid.'">'.$hword.'</a></span> ';
			}

		}

		include 'INC/KJVMatchCleanupVerse.php';

		//Loop through each word of the Verse
		foreach ($words as $entry) {
			$nodes = $entry->childNodes;		
			foreach ($nodes as $node) {

					$vword = $node->nodeValue;
			}

			$bible_content .= '<br><span class="kjv" style="color:grey;"><sup>'.$node->nodeValue.($verse).'</sup></span><br>';

		}

}


//Replace Cantillation
$bible_content = preg_replace('/[\x{0591}-\x{05AF}\x{05BD}\x{05BE}\x{05BF}\x{05C0}]/u','',$bible_content);
//Replace (Niqqud with Cantillation) with (just Niqqud)
//$from = "\u{05B1}\u{05B2}\u{05B3}";
//$to = "\u{05B6}\u{05B0}\u{05B8}";
//$bible_content = strtr($bible_content, $from, $to);

function get_string_between($string, $start, $end){

    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Blessed Regina's Bible Project</title>
	<meta name="keywords" content="Hebrew Bible Analysis, Tanakh Old Testament, Biblical Hebrew, Search for the Truth, Reaching for Spiritual Depth">
	<meta name="description" content="The Hebrew Bible (Tanakh) Analysis, Biblical Hebrew Study Resources, Reaching for Spiritual Depth, Searching for The Truth, Analyzing Sacred Ancient Texts.">
	<?php require 'INC/Header.php'; ?>
	<link rel="stylesheet" type="text/css" href="CSS/1-3/TheBible.css"> <!-- my css -->
	<link rel="stylesheet" type="text/css" href="CSS/1-3/TheBibleColorCoded.css">
	<script src="JS/1-2/TheBibleColorCoded.js"></script> <!-- my jQuery -->
	<script>
		function StudyResources() {
		    window.open("StudyResources.php?book=<?php echo $book; ?>&chapter=<?php echo $chapter; ?>");
		}
		function NonColorCoded() {
		    window.open("TheBible.php?book=<?php echo $book; ?>&chapter=<?php echo $chapter; ?>&verse=<?php echo $verse; ?>");
		}
		function GrammarStudy() {
		    window.open("AncientBiblicalHebrewGrammarStudy.php?book=<?php echo $book; ?>&chapter=<?php echo $chapter; ?>&verse=<?php echo $verse; ?>");
		}
		function Lesson1() {
		    window.open("https://www.truthofbible.com/LearnGenesisChapter1InHebrewIn31DaysBeginner/Plan.php");
		}
		function Lesson2() {
		    window.open("https://truthofbible.com/LearnGenesisChapter2InHebrewIn25DaysIntermediate/Plan.php");
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
	        <label for="dynamic_select_verse">&nbsp;Verse&nbsp;</label>
	        <select name="verse" class="form-control" id="dynamic_select_verse"><?php echo $verse_options; ?></select>
        </div>
    </form> 
</div>

<div class="container-fluid" id="content">
	<div id="bible-text">
		<p id="bible-content"> <button onclick="GrammarStudy()" class="btn btn-success">Grammar Study</button> <button onclick="StudyResources()" class="btn btn-success">Study Resources</button> <button onclick="NonColorCoded()" class="btn v">No Color Code</button> <button onclick="ShowHideEnglish('kjv')" class="btn btn-info">Show/Hide English</button><br><?php require 'INC/Lesson.php'; ?><br><br><?php echo $bible_content; ?></p>
	</div>
</div>

<?php require 'INC/Footer.php'; ?>

</body>
</html>
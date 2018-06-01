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
Updated on : May 31, 2018
*/
//////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php
include 'INC/ConvertNumberToHebrewLetters.php';
include 'YouTube/genesis1.php';
require_once 'INC/Database.php';

//Get 3 parameters from URL. Genesis Chapter 1 is the default
$book = (isset($_GET['book'])) ? $_GET['book'] : 'Gen' ;
$chapter = (isset($_GET['chapter'])) ? $_GET['chapter'] : '1' ;
$verse = (isset($_GET['verse'])) ? $_GET['verse'] : '' ;

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

		//$words = $xml_book->div->chapter->verse[1]->w;

		//youtube video link
		$vsearch = $mybook.' '.$chapter.':'.($m+1).' in Ancient Hebrew';
		$vkey = array_search($vsearch, $vtitle);

		if (!$vkey===false) {
			$bible_content .='<object type="application/x-shockwave-flash" width="30" height="25" data="https://www.youtube.com/v/'.$vid[$vkey].'?version=2&enablejsapi=1&theme=dark"><param name="movie" value="https://www.youtube.com/v/'.$vid[$vkey].'?version=2&enablejsapi=1&theme=dark" /><param name="wmode" value="transparent" /></object>';
		}


		//verse number
		$bible_content .= '<sup>'.ConvertNtoHL($m+1).'.</sup> ';

		//Loop through each word of the Verse
		foreach ($words as $entry) {
			$nodes = $entry->childNodes;		
			foreach ($nodes as $node) {

				if ((strpos($node->nodeValue, '/') !== false)) {
					$vword = DeterminePrefixSufix($node->nodeValue);
				}
				else {
					$vword = $node->nodeValue;
				}

				$bible_content .= '<a href="Analysis.php?vword='.$vword.'" target="_blank">'.$node->nodeValue.'</a> ';
			}
		}
		$bible_content .= '<br>';

		//English KJV translation
		$xpath_en = new DOMXPath($xml_en);
		//$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".$print_v."']");
		if (($book =='Gen' && $chapter == '32') || ($book =='Num' && $chapter == '30') || ($book =='Deut' && $chapter == '13') || ($book =='Deut' && $chapter == '23')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".($print_v-1)."']");
		} elseif (($book =='Exod' && $chapter == '22')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".($print_v+1)."']");
		} else {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".$print_v."']");
		}

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


		//youtube video link
		$vsearch = $mybook.' '.$chapter.':'.$verse.' in Ancient Hebrew';
		$vkey = array_search($vsearch, $vtitle);

		if (!$vkey===false) {
			$bible_content .='<object type="application/x-shockwave-flash" width="30" height="25" data="https://www.youtube.com/v/'.$vid[$vkey].'?version=2&enablejsapi=1&theme=dark"><param name="movie" value="https://www.youtube.com/v/'.$vid[$vkey].'?version=2&enablejsapi=1&theme=dark" /><param name="wmode" value="transparent" /></object>';
		}


		//$words = $xml_book->div->chapter->verse[1]->w;
		$bible_content .= '<sup>'.ConvertNtoHL($verse).'.</sup> ';

		//Loop through each word of the Verse
		foreach ($words as $entry) {
			$nodes = $entry->childNodes;		
			foreach ($nodes as $node) {
				if ((strpos($node->nodeValue, '/') !== false)) {
					$vword = DeterminePrefixSufix($node->nodeValue);
				}
				else {
					$vword = $node->nodeValue;
				}

				$bible_content .= '<a href="Analysis.php?vword='.$vword.'" target="_blank">'.$node->nodeValue.'</a> ';
			}
		}


		//English KJV translation
		$xpath_en = new DOMXPath($xml_en);
		if (($book =='Gen' && $chapter == '32') || ($book =='Num' && $chapter == '30') || ($book =='Deut' && $chapter == '13') || ($book =='Deut' && $chapter == '23')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".($verse-1)."']");
		} elseif (($book =='Exod' && $chapter == '22')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".($verse+1)."']");
		} else {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".$verse."']");
		}

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

function DeterminePrefixSufix ($word) {

	$output_word = '';
	//prefix and suffixes
	$ppp = array('ב', 'בְ', 'בְֽ', 'בִ', 'בִֽ', 'בֵ', 'בֵֽ', 'בֶ', 'בֶֽ', 'בַ', 'בַֽ', 'בָ', 'בָֽ', 'בּ', 'בְּ', 'בְּֽ', 'בִּ', 'בִּֽ', 'בֵּ', 'בֵּֽ', 'בֶּ', 'בֶּֽ', 'בַּ', 'בַּֽ', 'בָּ', 'בָּֽ', 'בּֽ', 'בַּֽ', 'בָּֽ', 'בֽ', 'בָֽ', 'ה', 'הְֽ', 'הֲ', 'הֳ', 'הֶ', 'הֶֽ', 'הַ', 'הַֽ', 'הַׄ', 'הָ', 'הָֽ', 'הֶֽ', 'הַֽ', 'הָֽ', 'הְֽ', 'הֲ', 'הֲֽ', 'הֶ', 'הֶֽ', 'הַ', 'הַֽ', 'הֲֽ', 'הַֽ', 'הָֽ', 'הֲ‍ֽ', 'ו', 'וְ', 'וְֽ', 'וְׄ', 'וֲ', 'וִ', 'וִֽ', 'וֵ', 'וֵֽ', 'וֶ', 'וֶֽ', 'וַ', 'וַֽ', 'וַׄ', 'וָ', 'וָֽ', 'וּ', 'וִּ', 'וּֽ', 'וּׄ', 'וְֽ', 'וִֽ', 'וֵֽ', 'וֶֽ', 'וַֽ', 'וָֽ', 'כ', 'כְ', 'כִ', 'כֶ', 'כַ', 'כַֽ', 'כָ', 'כְּ', 'כְּֽ', 'כִּ', 'כִּֽ', 'כֵּ', 'כֵּֽ', 'כֶּ', 'כֶּֽ', 'כַּ', 'כַּֽ', 'כָּ', 'כָּֽ', 'כַּֽ', 'כָּֽ', 'ל', 'לְ', 'לְֽ', 'לְׄ', 'לֲ', 'לִ', 'לִֽ', 'לֵ', 'לֵֽ', 'לֶ', 'לֶֽ', 'לַ', 'לַֽ', 'לָ', 'לָֽ', 'לָׄ', 'לּ', 'לְּ', 'לִּ', 'לִּֽ', 'לֵּ', 'לֶּ', 'לַּ', 'לָּ', 'לָּֽ', 'לּֽ', 'לֽ', 'לְֽ', 'לִֽ', 'לֵֽ', 'לֶֽ', 'לַֽ', 'לָֽ', 'לִֽֿ', 'מ', 'מְ', 'מִ', 'מִֽ', 'מֵ', 'מֵֽ', 'מֶ', 'מֶֽ', 'מַ', 'מִּ', 'מֵּ', 'מֵֽ', 'ש', 'שְׁ', 'שֶׁ', 'שֶֽׁ', 'שַׁ', 'שָׁ', 'שֶּׁ', 'שֶּֽׁ');

	$sss = array('א', 'אָה', 'דִי', 'ה', 'הָ', 'הּ', 'הָּ', 'הֿ', 'הָא', 'הא', 'הֽוּ', 'הׄוּׄ', 'הו', 'הוּ', 'הוא', 'הוֹם', 'הֽוֹן', 'הוֹן', 'הון', 'הִי', 'הֵין', 'הֶֽם', 'הֶם', 'הַם', 'הֹֽם', 'הֹם', 'הֶּם', 'הֶֽם', 'הם', 'הֵמָה', 'הֵן', 'הֶֽן', 'הֶן', 'הְנָה', 'הֶֽנָה', 'ו', 'וֹ', 'וּ', 'וׄ', 'וּהִי', 'וּךְ', 'י', 'יַ', 'ידע', 'יָהּ', 'יהָ', 'יהֶם', 'יו', 'יונים', 'יךְ', 'ינה', 'ך', 'ךְ', 'ךָ', 'ךָֽ', 'ךָּ', 'כֵה', 'כָה', 'כָּה', 'כוֹן', 'כִי', 'כי', 'כֶֽם', 'כֶם', 'כֹם', 'כם', 'כֶֽן', 'כֶן', 'כֶֽנָה', 'כֶנָה', 'ם', 'מו', 'מוֹ', 'מוּ', 'ן', 'נ', 'נְ', 'נֶ', 'נַ', 'נָא', 'נא', 'נָה', 'נָּֽה', 'נָּה', 'נה', 'נְהֽוּ', 'נְהוּ', 'נּֽוּ', 'נּוּ', 'נׄוּׄ', 'נו', 'נוֹ', 'נוּ', 'נִֽי', 'נִי', 'נִּי', 'ני', 'נְךָּ', 'נְנִי');

	if (substr_count($word, '/') == 1) {

		$prepre = strtok($word, '/');
		$sufsuf = substr(strrchr($word, '/'), 1);

		if (in_array($prepre, $ppp)) {
			$output_word = $sufsuf;
		}
		elseif (in_array($sufsuf, $sss)) {
			$output_word = $prepre;
		}
	}
	elseif (substr_count($word, '/') == 2) {

		$prepre = strtok($word, '/');

		if (in_array($prepre, $ppp)) {

			$trimmed_word = substr($word, strpos($word, "/") + 1);
			$output_word = DeterminePrefixSufix($trimmed_word);
		}
		else {
			$output_word = $prepre;
		}
	}
	elseif (substr_count($word, '/') > 2) {

		$trimmed_word = substr($word, strpos($word, "/") + 1);
		$output_word = DeterminePrefixSufix($trimmed_word);
	}
	else {
		$output_word = '';
	}

	return $output_word;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Blessed Regina's Bible Project</title>
	<meta name="keywords" content="Hebrew Bible Analysis, Tanakh Old Testament, Biblical Hebrew, Search for the Truth, Reaching for Spiritual Depth">
	<meta name="description" content="The Hebrew Bible (Tanakh) Analysis, Biblical Hebrew Study Resources, Reaching for Spiritual Depth, Searching for The Truth, Analyzing Sacred Ancient Texts.">
	<?php require 'INC/Header.php'; ?>
	<link rel="stylesheet" type="text/css" href="CSS/1-2/TheBible.css"> <!-- my css -->
	<script src="JS/1-2/TheBible.js"></script> <!-- my jQuery -->
	<script>
		function StudyResources() {
		    window.open("StudyResources.php?book=<?php echo $book; ?>&chapter=<?php echo $chapter; ?>");
		}
		function ColorCoded() {
		    window.open("TheBibleColorCoded.php?book=<?php echo $book; ?>&chapter=<?php echo $chapter; ?>&verse=<?php echo $verse; ?>");
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
		<p id="bible-content"> <button onclick="ColorCoded()" class="btn v">Color Code</button> <button onclick="StudyResources()" class="btn btn-success">Study Resources</button> <button onclick="ShowHideEnglish('kjv')" class="btn btn-info">Show/Hide English</button><br><br><?php echo $bible_content; ?></p>
	</div>
</div>

<?php require 'INC/Footer.php'; ?>

</body>
</html>
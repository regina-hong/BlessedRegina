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
Updated on : June 24, 2018
*/
//////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php
include 'INC/ConvertNumberToHebrewLetters.php';
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
$query = "SELECT a.Strong_ID, b.POS, b.Def FROM u955934022_bible.word AS a LEFT JOIN u955934022_bible.strong AS b ON (a.Strong_ID = b.ID) WHERE a.Book = '".$book."' AND a.Chapter ='".$chapter."' AND a.Strong_ID <> '' AND b.Word <> '' GROUP BY a.Strong_ID ORDER BY b.POS ASC";

$mysql = get_database_connection();
mysqli_set_charset($mysql,'utf8');
$result = mysqli_query($mysql, $query);

$poss = array();
$ids = array();
$defs = array();
$total_rows = 0;

while($row = mysqli_fetch_assoc($result)) {
	$poss[] = $row['POS'];
	$ids[] = $row['Strong_ID'];
	$defs[] = $row['Def'];
	$total_rows++;
}


//Get verb from strong id
$query2 = "SELECT * FROM u955934022_bible.strong AS a WHERE a.POS = 'v'";

$mysql2 = get_database_connection();
mysqli_set_charset($mysql2,'utf8');
$result2 = mysqli_query($mysql2, $query2);

$v_words = array();
$v_ids = array();
$total_rows2 = 0;

while($row2 = mysqli_fetch_assoc($result2)) {
	$v_words[] =$row2['Word'];
	$v_ids[] = $row2['ID'];
	$total_rows2++;
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

		$bible_content_a = array();
		$bible_content_b = array();
		$bible_content_c = array();

		//$words = $xml_book->div->chapter->verse[1]->w;
		$bible_content_a[] = '<td><div class="vcword"><sup>.'.ConvertNtoHL($m+1).'</sup></div></td> ';
		$bible_content_b[] = '<td><sup>.'.($m+1).'</sup></td> ';
		$bible_content_c[] = '<td></td> ';

		//Loop through each word of the Verse
		foreach ($words as $entry) {

			$lid = $entry->getAttribute('lemma');
			$hword = $entry->nodeValue;
			$sid = preg_replace("/[^0-9,.]/", "", $lid);
			$key = array_search($sid, $ids);
			$possorig = $poss[$key];
			$d = $defs[$key];
			$vw = $words[$key];
			$deffs = str_replace(',', '<br />', $d);
			$verb_addition = '';

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
				$bible_content_a[] = DeterminePrefixSufix($hword, $poscname, $sid);
				$bible_content_b[] = DeterminePrefixSufix2($hword, $poscname, $sid, $possorig);
				$bible_content_c[] = DeterminePrefixSufix3($hword, $poscname, $sid, $deffs);
			}
			else {
				//--------------------Verb---------------------------//	
				if ($poscname == 'v') {
					$vw_key = array_search($sid, $v_ids);
					$vw_word = $v_words[$vw_key];
					$verb_addition = DetermineVerbPGN($vw_word, $sid, $hword);
				}

				$bible_content_a[] = '<td><div class="vcword"><span class="'.$poscname.'"><a href="HebrewStrong.php?id='.$sid.'">'.$hword.'</a></span></div></td>';
				$bible_content_b[] = '<td><a href="HebrewStrong.php?id='.$sid.'">'.$sid.'</a><br><span class="'.$poscname.'">'.$possorig.$verb_addition.'</span></td>';
				$bible_content_c[] = '<td>'.$deffs.'</td>';
			}
		}

		//youtube video link
		$vsearch = $mybook.' '.$chapter.':'.($m+1).' in Ancient Hebrew';
		$vkey = array_search($vsearch, $vtitle);

		if (!$vkey===false) {
			$bible_content_a[] ='<td><object type="application/x-shockwave-flash" width="30" height="25" data="https://www.youtube.com/v/'.$vid[$vkey].'?version=2&enablejsapi=1&theme=dark"><param name="movie" value="https://www.youtube.com/v/'.$vid[$vkey].'?version=2&enablejsapi=1&theme=dark" /><param name="wmode" value="transparent" /></object></td>';
			$bible_content_b[] ='<td></td>';
			$bible_content_c[] ='<td></td>';
		}




////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//English KJV translation
		$xpath_en = new DOMXPath($xml_en);
		//$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".$print_v."']");
		if (($book =='Gen' && $chapter == '32' && $print_v == '1')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Gen.31.55"."']");
		} elseif (($book =='Num' && $chapter == '30' && $print_v == '1')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Num.29.40"."']");
		} elseif (($book =='Deut' && $chapter == '13' && $print_v == '1')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Deut.12.32"."']");
		} elseif (($book =='Deut' && $chapter == '23' && $print_v == '1')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Deut.22.30"."']");
		} elseif (($book =='Deut' && $chapter == '28' && $print_v == '69')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Deut.29.1"."']");
		} elseif (($book =='Exod' && $chapter == '7' && (((int)$print_v > 25) && ((int)$print_v < 30)))) {
			$temp_c = $print_v-25;	
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Exod.8.".$temp_c."']");		
		} elseif (($book =='Exod' && $chapter == '21' && $print_v == '37')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Exod.22.1"."']");
		} elseif (($book =='Lev' && $chapter == '5' && (((int)$print_v > 19) && ((int)$print_v < 27)))) {
			$temp_d = $print_v-19;	
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Lev.6.".$temp_d."']");
		} elseif (($book =='Num' && $chapter == '17' && (((int)$print_v > 0) && ((int)$print_v < 16)))) {
			$temp_a = $print_v+35;
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Num.16.".$temp_a."']");
		} elseif (($book =='Num' && $chapter == '17' && (((int)$print_v > 15)))) {
			$temp_b = $print_v-15;
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Num.17.".$temp_b."']");
		} elseif (($book =='Gen' && $chapter == '32') || ($book =='Num' && $chapter == '30') || ($book =='Deut' && $chapter == '13') || ($book =='Deut' && $chapter == '23')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".($print_v-1)."']");
		} elseif (($book =='Exod' && $chapter == '22') || ($book =='Deut' && $chapter == '29')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".($print_v+1)."']");
		} elseif (($book =='Lev' && $chapter == '6')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".($print_v+7)."']");
		} elseif (($book =='Exod' && $chapter == '8')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".($print_v+4)."']");			
		} else {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".$print_v."']");
		}
////////////////////////////////////////////////////////////////////////////////////////////////////////////

		//Loop through each word of the Verse
		foreach ($words as $entry) {
			$nodes = $entry->childNodes;		
			foreach ($nodes as $node) {

					$vword = $node->nodeValue;
			}

			$bible_content .= '<br><span class="kjv">'.$node->nodeValue.($m+1).'</span><br>';

		}


////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//Print grammar table for each verse
		$bible_content .= '<table class="table table-bordered table-stripe table-grammar"><tr>';

		foreach ( array_reverse($bible_content_a) as $a ) {
			$bible_content .= $a;
		}

		$bible_content .= '</tr><tr>';

		foreach ( array_reverse($bible_content_b) as $b ) {
			$bible_content .= $b;
		}		

		$bible_content .= '</tr><tr>';

		foreach ( array_reverse($bible_content_c) as $c ) {
			$bible_content .= $c;
		}		

		$bible_content .= '</tr></table>';

		$bible_content .= '<br>';

	}
}

//Individual verse printout
if ($verse <> '') {

		$xpath_he = new DOMXPath($xml_he);
		$words = $xpath_he->query("//div/chapter/verse[@osisID='".$book.".".$chapter.".".$verse."']/w");

		$bible_content_a = array();
		$bible_content_b = array();
		$bible_content_c = array();

		//$words = $xml_book->div->chapter->verse[1]->w;
		$bible_content_a[] = '<td><div class="vcword"><sup>.'.ConvertNtoHL($verse).'</sup></div></td> ';
		$bible_content_b[] = '<td><sup>.'.$verse.'</sup></td> ';
		$bible_content_c[] = '<td></td> ';

		//Loop through each word of the Verse
		foreach ($words as $entry) {

			$lid = $entry->getAttribute('lemma');
			$hword = $entry->nodeValue;
			$sid = preg_replace("/[^0-9,.]/", "", $lid);
			$key = array_search($sid, $ids);
			$possorig = $poss[$key];
			$d = $defs[$key];
			$deffs = str_replace(',', '<br />', $d);
			$verb_addition = '';

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
				$bible_content_a[] = DeterminePrefixSufix($hword, $poscname, $sid);
				$bible_content_b[] = DeterminePrefixSufix2($hword, $poscname, $sid, $possorig);
				$bible_content_c[] = DeterminePrefixSufix3($hword, $poscname, $sid, $deffs);
			}
			else {
				//--------------------Verb---------------------------//	
				if ($poscname == 'v') {
					$vw_key = array_search($sid, $v_ids);
					$vw_word = $v_words[$vw_key];
					$verb_addition = DetermineVerbPGN($vw_word, $sid, $hword);
				}

				$bible_content_a[] = '<td><div class="vcword"><span class="'.$poscname.'"><a href="HebrewStrong.php?id='.$sid.'">'.$hword.'</a></span></div></td>';
				$bible_content_b[] = '<td><a href="HebrewStrong.php?id='.$sid.'">'.$sid.'</a><br><span class="'.$poscname.'">'.$possorig.$verb_addition.'</span></td>';
				$bible_content_c[] = '<td>'.$deffs.'</td>';
				
			}
		}

		//youtube video link
		$vsearch = $mybook.' '.$chapter.':'.$verse.' in Ancient Hebrew';
		$vkey = array_search($vsearch, $vtitle);

		if (!$vkey===false) {
			$bible_content_a[] ='<td><object type="application/x-shockwave-flash" width="30" height="25" data="https://www.youtube.com/v/'.$vid[$vkey].'?version=2&enablejsapi=1&theme=dark"><param name="movie" value="https://www.youtube.com/v/'.$vid[$vkey].'?version=2&enablejsapi=1&theme=dark" /><param name="wmode" value="transparent" /></object></td>';
			$bible_content_b[] ='<td></td>';
			$bible_content_c[] ='<td></td>';
		}



////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//English KJV translation
		$xpath_en = new DOMXPath($xml_en);
		if (($book =='Gen' && $chapter == '32' && $verse == '1')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Gen.31.55"."']");
		} elseif (($book =='Num' && $chapter == '30' && $verse == '1')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Num.29.40"."']");
		} elseif (($book =='Deut' && $chapter == '13' && $verse == '1')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Deut.12.32"."']");
		} elseif (($book =='Deut' && $chapter == '23' && $verse == '1')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Deut.22.30"."']");
		} elseif (($book =='Deut' && $chapter == '28' && $verse == '69')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Deut.29.1"."']");
		} elseif (($book =='Exod' && $chapter == '7' && (((int)$verse > 25) && ((int)$verse < 30)))) {
			$temp_c = $verse-25;	
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Exod.8.".$temp_c."']");	
		} elseif (($book =='Exod' && $chapter == '21' && $verse == '37')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Exod.22.1"."']");
		} elseif (($book =='Lev' && $chapter == '5' && (((int)$verse > 19) && ((int)$verse < 27)))) {
			$temp_d = $verse-19;	
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Lev.6.".$temp_d."']");
		} elseif (($book =='Num' && $chapter == '17' && (((int)$verse > 0) && ((int)$verse < 16)))) {
			$temp_a = $verse+35;
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Num.16.".$temp_a."']");
		} elseif (($book =='Num' && $chapter == '17' && (((int)$verse > 15)))) {
			$temp_b = $verse-15;
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='Num.17.".$temp_b."']");
		} elseif (($book =='Gen' && $chapter == '32') || ($book =='Num' && $chapter == '30') || ($book =='Deut' && $chapter == '13') || ($book =='Deut' && $chapter == '23')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".($verse-1)."']");
		} elseif (($book =='Exod' && $chapter == '22') || ($book =='Deut' && $chapter == '29')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".($verse+1)."']");
		} elseif (($book =='Lev' && $chapter == '6')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".($verse+7)."']");
		} elseif (($book =='Exod' && $chapter == '8')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".($verse+4)."']");			
		} else {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".$verse."']");
		}
////////////////////////////////////////////////////////////////////////////////////////////////////////////

		//Loop through each word of the Verse
		foreach ($words as $entry) {
			$nodes = $entry->childNodes;		
			foreach ($nodes as $node) {

					$vword = $node->nodeValue;
			}

			$bible_content .= '<br><span class="kjv">'.$node->nodeValue.($verse).'</span><br>';

		}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//Print grammar table for each verse

		$bible_content .= '<table class="table table-bordered table-stripe table-grammar"><tr>';

		foreach ( array_reverse($bible_content_a) as $a ) {
			$bible_content .= $a;
		}

		$bible_content .= '</tr><tr>';

		foreach ( array_reverse($bible_content_b) as $b ) {
			$bible_content .= $b;
		}		

		$bible_content .= '</tr><tr>';

		foreach ( array_reverse($bible_content_c) as $c ) {
			$bible_content .= $c;
		}		

		$bible_content .= '</tr></table>';

}


//Replace Cantillation
$bible_content = preg_replace('/[\x{0591}-\x{05AF}\x{05BD}\x{05BE}\x{05BF}\x{05C0}]/u','',$bible_content);
//Replace (Niqqud with Cantillation) with (just Niqqud)
//$from = "\u{05B1}\u{05B2}\u{05B3}";
//$to = "\u{05B6}\u{05B0}\u{05B8}";
//$bible_content = strtr($bible_content, $from, $to);

////////////////////////////////////////////////////////////////////////////////////////////////////////////

function get_string_between($string, $start, $end){

    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////

function DetermineVerbPGN($verb, $strong, $verb_actual) {

	$output_verb = '';
	$verb_type = '';
	$verb_tense = '';
	$verb_root = '';
	$verb_pre = '';
	$verb_suf = '';
	$verb_pgn = '';
	$firstletter = '';
	$secondletter = '';
	$thirdletter = '';	

	//find verb root
	$verb_root = preg_replace('/[\x{0591}-\x{05C7}\x{05F0}-\x{05F5}]/u','',$verb);
	$firstletter = mb_substr($verb_root,0,1);
	$secondletter = mb_substr($verb_root,1,1);
	$thirdletter= mb_substr($verb_root,2,3);

	//determine verb type
	if ($firstletter == 'ה' && $secondletter == 'י' && $thirdletter == 'ה') {
		$verb_type = 'Special<br>Haya';	
	} elseif ($firstletter == 'א') {
		$verb_type = 'Weak<br>I-Aleph';	
	} elseif ($firstletter == 'נ') {
		$verb_type = 'Weak<br>I-Nun';																			
	} elseif ($firstletter == 'י') {
		$verb_type = 'Weak<br>I-Yud';										
	} elseif ($thirdletter == 'ה') {
		$verb_type = 'Weak<br>III-He';		
	} elseif ($firstletter == 'ר' || $firstletter == 'ה' || $firstletter == 'ע' || $firstletter == 'ח') {
		$verb_type = 'Weak<br>I-Guttural';
	} elseif ($secondletter == 'ר' || $secondletter == 'ה' || $secondletter == 'ע' || $secondletter == 'ח') {
		$verb_type = 'Weak<br>II-Guttural';									
	} elseif ($secondletter == $thirdletter) {
		$verb_type = 'Weak<br>Geminate';										
	} elseif ($secondletter == 'ו' || $secondletter == 'י') {
		$verb_type = 'Weak<br>Hollow';
	} else {
		$verb_type = 'Strong';								
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$ppp = array('ב', 'בְ', 'בְֽ', 'בִ', 'בִֽ', 'בֵ', 'בֵֽ', 'בֶ', 'בֶֽ', 'בַ', 'בַֽ', 'בָ', 'בָֽ', 'בּ', 'בְּ', 'בְּֽ', 'בִּ', 'בִּֽ', 'בֵּ', 'בֵּֽ', 'בֶּ', 'בֶּֽ', 'בַּ', 'בַּֽ', 'בָּ', 'בָּֽ', 'בּֽ', 'בַּֽ', 'בָּֽ', 'בֽ', 'בָֽ', 'ה', 'הְֽ', 'הֲ', 'הֳ', 'הֶ', 'הֶֽ', 'הַ', 'הַֽ', 'הַׄ', 'הָ', 'הָֽ', 'הֶֽ', 'הַֽ', 'הָֽ', 'הְֽ', 'הֲ', 'הֲֽ', 'הֶ', 'הֶֽ', 'הַ', 'הַֽ', 'הֲֽ', 'הַֽ', 'הָֽ', 'הֲ‍ֽ', 'ו', 'וְ', 'וְֽ', 'וְׄ', 'וֲ', 'וִ', 'וִֽ', 'וֵ', 'וֵֽ', 'וֶ', 'וֶֽ', 'וַ', 'וַֽ', 'וַׄ', 'וָ', 'וָֽ', 'וּ', 'וִּ', 'וּֽ', 'וּׄ', 'וְֽ', 'וִֽ', 'וֵֽ', 'וֶֽ', 'וַֽ', 'וָֽ', 'כ', 'כְ', 'כִ', 'כֶ', 'כַ', 'כַֽ', 'כָ', 'כְּ', 'כְּֽ', 'כִּ', 'כִּֽ', 'כֵּ', 'כֵּֽ', 'כֶּ', 'כֶּֽ', 'כַּ', 'כַּֽ', 'כָּ', 'כָּֽ', 'כַּֽ', 'כָּֽ', 'ל', 'לְ', 'לְֽ', 'לְׄ', 'לֲ', 'לִ', 'לִֽ', 'לֵ', 'לֵֽ', 'לֶ', 'לֶֽ', 'לַ', 'לַֽ', 'לָ', 'לָֽ', 'לָׄ', 'לּ', 'לְּ', 'לִּ', 'לִּֽ', 'לֵּ', 'לֶּ', 'לַּ', 'לָּ', 'לָּֽ', 'לּֽ', 'לֽ', 'לְֽ', 'לִֽ', 'לֵֽ', 'לֶֽ', 'לַֽ', 'לָֽ', 'לִֽֿ', 'מ', 'מְ', 'מִ', 'מִֽ', 'מֵ', 'מֵֽ', 'מֶ', 'מֶֽ', 'מַ', 'מִּ', 'מֵּ', 'מֵֽ', 'ש', 'שְׁ', 'שֶׁ', 'שֶֽׁ', 'שַׁ', 'שָׁ', 'שֶּׁ', 'שֶּֽׁ');

	$sss = array('א', 'אָה', 'דִי', 'ה', 'הָ', 'הּ', 'הָּ', 'הֿ', 'הָא', 'הא', 'הֽוּ', 'הׄוּׄ', 'הו', 'הוּ', 'הוא', 'הוֹם', 'הֽוֹן', 'הוֹן', 'הון', 'הִי', 'הֵין', 'הֶֽם', 'הֶם', 'הַם', 'הֹֽם', 'הֹם', 'הֶּם', 'הֶֽם', 'הם', 'הֵמָה', 'הֵן', 'הֶֽן', 'הֶן', 'הְנָה', 'הֶֽנָה', 'ו', 'וֹ', 'וּ', 'וׄ', 'וּהִי', 'וּךְ', 'י', 'יַ', 'ידע', 'יָהּ', 'יהָ', 'יהֶם', 'יו', 'יונים', 'יךְ', 'ינה', 'ך', 'ךְ', 'ךָ', 'ךָֽ', 'ךָּ', 'כֵה', 'כָה', 'כָּה', 'כוֹן', 'כִי', 'כי', 'כֶֽם', 'כֶם', 'כֹם', 'כם', 'כֶֽן', 'כֶן', 'כֶֽנָה', 'כֶנָה', 'ם', 'מו', 'מוֹ', 'מוּ', 'ן', 'נ', 'נְ', 'נֶ', 'נַ', 'נָא', 'נא', 'נָה', 'נָּֽה', 'נָּה', 'נה', 'נְהֽוּ', 'נְהוּ', 'נּֽוּ', 'נּוּ', 'נׄוּׄ', 'נו', 'נוֹ', 'נוּ', 'נִֽי', 'נִי', 'נִּי', 'ני', 'נְךָּ', 'נְנִי');


	//only 1 prefix or suffix
	if (substr_count($verb_actual, '/') == 1) {

		$prepre = strtok($verb_actual, '/');
		$sufsuf = substr(strrchr($verb_actual, '/'), 1);

		if (in_array($prepre, $ppp)) {
			$verb_pre = strtok($verb_actual, '/');
			$verb_actual_word = substr(strrchr($verb_actual, '/'), 1);
		}
		else {
			$verb_actual_word = strtok($verb_actual, '/');
			$verb_suf = substr(strrchr($verb_actual, '/'), 1);
		}
	}

	//2 prefix or suffix, that means there's a prefix / verb / suffix
	elseif (substr_count($verb_actual, '/') == 2) {

		$prepre = strtok($verb_actual, '/');

		if (in_array($prepre, $ppp)) {
			$verb_pre = strtok($verb_actual, '/');
			$trimmed_word = substr($verb_actual, strpos($verb_actual, "/") + 1);

			$prepre2 = strtok($trimmed_word, '/');
			$sufsuf2 = substr(strrchr($trimmed_word, '/'), 1);

				if (in_array($prepre2, $ppp)) {
					$verb_pre = strtok($trimmed_word, '/');
					$verb_actual_word = substr(strrchr($trimmed_word, '/'), 1);
				}
				else {
					$verb_actual_word = strtok($trimmed_word, '/');
					$verb_suf = substr(strrchr($trimmed_word, '/'), 1);
				}
		}
	}
	else {
		$verb_actual_word = $verb_actual;
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//replace cantillation, punctuations, shin dot, sin dots
	$verb_actual_word = preg_replace('/[\x{0591}-\x{05AF}\x{05C0}-\x{05C3}\x{05BD}\x{05BE}\x{05BF}]/u','',$verb_actual_word);
	$firstletter_a = mb_substr($verb_actual_word,0,1);

	$firstvowel_a = mb_substr($verb_actual_word,1,1,'UTF-8');
	$secondvowel_a = mb_substr($verb_actual_word,2,1,'UTF-8');
	$thirdvowel_a = mb_substr($verb_actual_word,3,1,'UTF-8');
	$fourthvowel_a = mb_substr($verb_actual_word,4,1,'UTF-8');
	$fifthvowel_a = mb_substr($verb_actual_word,5,1,'UTF-8');

	//determine verb tense
	//For Strong Verb Types
	if ($verb_pre == 'לְ' || $verb_pre == 'לִ' || $verb_pre == 'לֲ') {
		if ($firstletter_a == 'ה' && $firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ') {
			$verb_tense = 'Niphal/Inf Cs';
		} elseif ($firstletter_a == 'ה') {
			$verb_tense = 'Hiphil/Inf Cs';
		} elseif ($firstvowel_a == 'ַ' && $thirdvowel_a == 'ּ') {
			$verb_tense = 'Piel/Inf Cs';
		} else {
			$verb_tense = 'Qal/Inf Cs';
		}
	} elseif ($verb_pre == 'לֵ') {
			$verb_tense = 'Qal/Inf Abs';
	}

	//-----------------------------------------------Strong verbs------------------------------------------------------
	elseif ($verb_type == 'Strong') {
		//verb has no prefix
		if (($firstletter == $firstletter_a) && ($firstletter_a <> $thirdvowel_a)) {
			if ($firstvowel_a == 'ָ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ָ') || $firstvowel_a == 'ֲ') {
				if ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ּ') {
					$verb_tense = 'Qal/Pass Part';
				} elseif (($thirdvowel_a == 'ֹ') || ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ֹ')) {
					$verb_tense = 'Qal/Inf Abs';
				} else {
					$verb_tense = 'Qal/Perfect';
				}
			} elseif ($firstvowel_a == 'ַ') {
				$verb_tense = 'Piel/Imperative';
			} elseif ($firstvowel_a == 'ִ') {
				if ($thirdvowel_a == 'ּ') {
					$verb_tense = 'Piel/Perfect';
				} else {
					$verb_tense = 'Qal/Imperative';
				}
			} elseif ($firstvowel_a == 'ְ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ְ')) {
				$verb_tense = 'Qal/Imperative';
			} elseif (($firstvowel_a == 'ֹ') || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ֹ') || ($firstvowel_a == 'ו'  && $secondvowel_a == 'ֹ') || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ו'  && $thirdvowel_a == 'ֹ')) {
				$verb_tense = 'Qal/Act Part';
			} elseif ($firstvowel_a == 'ֻ') {
				if ($thirdvowel_a == 'ּ' && $fourthvowel_a == 'ֹ') {
					$verb_tense = 'Pual/Inf Abs';
				} else {
					$verb_tense = 'Pual/Perfect';
				}
			} elseif ($secondvowel_a == 'ֹ') {
				$verb_tense = 'Qal/Inf Abs';
			} else {
				$verb_tense = '';
			}

		//verb has prefix
		} elseif ($firstletter_a == 'ת' || $firstletter_a == 'י' || $firstletter_a == 'א' || $firstletter_a == 'נ') {
			if ($firstvowel_a == 'ַ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ַ')) {
				$verb_tense = 'Hiphil/Imperfect';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Imperfect';
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperfect';
			} elseif ($firstletter_a == 'נ' && ($fifthvowel_a == 'ַ' || $fifthvowel_a == 'ְ')) {
				$verb_tense = 'Niphal/Perfect';
			} elseif ($firstletter_a == 'נ' && $fifthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Part';
			} elseif ($firstletter_a == 'נ' && ($fifthvowel_a == 'ֹ' || ($fifthvowel_a == 'ו'))) {
				$verb_tense = 'Niphal/Inf';
			} else {
				$verb_tense = 'Qal/Imperfect';
			}
		} elseif ($firstletter_a == 'מ') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Part';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Part';
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Part';
			} else {
				$verb_tense = 'Participle';
			}
		} elseif ($firstletter_a == 'ה') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Imperative';
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperative';				
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hiphil/Perf';				
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Perf/Inf';				
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Perf/Imperative/Inf';				
			} else {
				$verb_tense = 'Perf/Imperative/Inf';
			}
		}
	}
	
	//--------------------------------------I-Guttural verbs-----------------------------------------------------

	elseif ($verb_type == 'Weak<br>I-Guttural') {
		//verb has no prefix
		if (($firstletter == $firstletter_a) && ($firstletter_a <> $thirdvowel_a)) {
			if ($firstvowel_a == 'ָ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ָ') || $firstvowel_a == 'ֲ') {
				if ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ּ') {
					$verb_tense = 'Qal/Pass Part';
				} elseif ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ֹ') {
					$verb_tense = 'Qal/Inf Abs';
				} elseif ($thirdvowel_a == 'ֹ') {
					$verb_tense = 'Qal/Imperative';
				} else {
					$verb_tense = 'Qal/Perfect';
				}
			} elseif ($firstvowel_a == 'ִ') {
				$verb_tense = 'Qal/Imperative';
			} elseif ($firstvowel_a == 'ֹ' && ($thirdvowel_a == 'ֵ' || $thirdvowel_a == 'ֶ')) {
				$verb_tense = 'Qal/Act Part';
			} else {
				$verb_tense = '';
			}

		//verb has prefix
		} elseif ($firstletter_a == 'ת' || $firstletter_a == 'י' || $firstletter_a == 'א' || $firstletter_a == 'נ') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Imperfect';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Imperfect';
			} elseif ($firstvowel_a == 'ֵ') {
				$verb_tense = 'Niphal/Imperfect';
			} elseif ($firstletter_a == 'נ' && $firstvowel_a == 'ֶ') {
				$verb_tense = 'Niphal/Perfect';
			} else {
				$verb_tense = 'Qal/Imperfect';
			}
		} elseif ($firstletter_a == 'מ') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Part';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Part';
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Part';
			} else {
				$verb_tense = 'Participle';
			}
		} elseif ($firstletter_a == 'ה') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Imperative';
			} elseif ($firstvowel_a == 'ֵ') {
				$verb_tense = 'Niphal/Imperative';				
			} elseif ($firstvowel_a == 'ֶ') {
				$verb_tense = 'Hiphil/Perf';				
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Perf/Inf';				
		}
	}
}

	//--------------------------------------II-Guttural verbs-----------------------------------------------------

	elseif ($verb_type == 'Weak<br>II-Guttural') {
		//verb has no prefix
		if (($firstletter == $firstletter_a) && ($firstletter_a <> $thirdvowel_a)) {
			if ($firstvowel_a == 'ָ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ָ') || $firstvowel_a == 'ֲ') {
				if ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ּ') {
					$verb_tense = 'Qal/Pass Part';
				} elseif (($thirdvowel_a == 'ֹ') || ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ֹ')) {
					$verb_tense = 'Qal/Inf Abs';
				} else {
					$verb_tense = 'Qal/Perfect';
				}
			} elseif ($firstvowel_a == 'ַ') {
				$verb_tense = 'Qal/Imperative';
			} elseif ($firstvowel_a == 'ֵ') {
					$verb_tense = 'Piel/Perfect';
			} elseif ($firstvowel_a == 'ּ' && $secondvowel_a == 'ֹ') {
				if ($fourthvowel_a == 'ַ' || $fourthvowel_a == 'ְ') {
					$verb_tense = 'Pual/Perfect';
				} else {
					$verb_tense = 'Qal/Act Part';
				}
			} elseif ($firstvowel_a == 'ֹ' || $secondvowel_a == 'ֹ') {
				$verb_tense = 'Qal/Inf Abs';
			} else {
				$verb_tense = '';
			}

		//verb has prefix
		} elseif ($firstletter_a == 'ת' || $firstletter_a == 'י' || $firstletter_a == 'א' || $firstletter_a == 'נ') {
			if ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ָ') {
				$verb_tense = 'Piel/Imperfect';
			} elseif (($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֹ') || ($secondvowel_a == 'ְ' && $fourthvowel_a == 'ֹ') || ($firstletter == 'א' && $firstvowel_a = 'ֶ' && $thirdvowel_a == 'ֲ')) {
				$verb_tense = 'Pual/Imperfect';
			} elseif ($firstletter_a == 'נ') {
				$verb_tense = 'Niphal/Perfect';
			} elseif ($firstletter_a == 'נ' && $fifthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Part';
			} elseif ($firstletter_a == 'נ' && ($fifthvowel_a == 'ֹ' || ($fifthvowel_a == 'ו'))) {
				$verb_tense = 'Niphal/Inf';
			} elseif (($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') || ($firstletter == 'א' && $firstvowel_a = 'ֶ')) {
				$verb_tense = 'Niphal/Imperfect';
			} else {
				$verb_tense = 'Qal/Imperfect';
			}
		} elseif ($firstletter_a == 'מ') {
			if ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ָ') {
				$verb_tense = 'Piel/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֹ') {
				$verb_tense = 'Pual/Part';
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Part';
			} else {
				$verb_tense = 'Participle';
			}
		} elseif ($firstletter_a == 'ה') {
			if ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperative';								
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Perf/Imperative/Inf';				
			} else {
				$verb_tense = 'Perf/Imperative/Inf';
			}
		}
	}

	//--------------------------------------I-Aleph verbs-----------------------------------------------------
	elseif ($verb_type == 'Weak<br>I-Aleph') {
		//verb has no prefix
		if (($firstletter == $firstletter_a) && ($firstletter_a <> $thirdvowel_a)) {
			if ($firstvowel_a == 'ָ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ָ') || $firstvowel_a == 'ֲ') {
				if ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ּ') {
					$verb_tense = 'Qal/Pass Part';
				} elseif (($thirdvowel_a == 'ֹ') || ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ֹ')) {
					$verb_tense = 'Qal/Inf Abs';
				} else {
					$verb_tense = 'Qal/Perfect';
				}
			} elseif ($firstvowel_a == 'ַ') {
				$verb_tense = 'Piel/Imperative';
			} elseif ($firstvowel_a == 'ִ' || $firstvowel_a == 'ֱ') {
					$verb_tense = 'Qal/Imperative';
			} elseif ($firstvowel_a == 'ְ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ְ')) {
				$verb_tense = 'Qal/Imperative';
			} elseif (($firstvowel_a == 'ֹ') || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ֹ') || ($firstvowel_a == 'ו'  && $secondvowel_a == 'ֹ') || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ו'  && $thirdvowel_a == 'ֹ')) {
				$verb_tense = 'Qal/Act/Part';
			} elseif ($firstvowel_a == 'ֻ') {
				if ($thirdvowel_a == 'ּ' && $fourthvowel_a == 'ֹ') {
					$verb_tense = 'Pual/Inf Abs';
				} else {
					$verb_tense = 'Pual/Perfect';
				}
			} elseif ($secondvowel_a == 'ֹ') {
				$verb_tense = 'Qal/Inf Abs';
			} else {
				$verb_tense = '';
			}

		//verb has prefix
		} elseif ($firstletter_a == 'ת' || $firstletter_a == 'י' || $firstletter_a == 'א' || $firstletter_a == 'נ') {
			if ($firstvowel_a == 'ַ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ַ')) {
				$verb_tense = 'Hiphil/Imperfect';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Imperfect';
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperfect';
			} elseif ($firstletter_a == 'נ' && ($fifthvowel_a == 'ַ' || $fifthvowel_a == 'ְ')) {
				$verb_tense = 'Niphal/Perfect';
			} elseif ($firstletter_a == 'נ' && $fifthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Part';
			} elseif ($firstletter_a == 'נ' && ($fifthvowel_a == 'ֹ' || ($fifthvowel_a == 'ו'))) {
				$verb_tense = 'Niphal/Inf';
			} else {
				$verb_tense = 'Qal/Imperfect';
			}
		} elseif ($firstletter_a == 'מ') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Part';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Part';
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Part';
			} else {
				$verb_tense = 'Participle';
			}
		} elseif ($firstletter_a == 'ה') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Imperative';
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperative';				
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hiphil/Perf';				
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Perf/Inf';				
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Perf/Imperative/Inf';				
			} else {
				$verb_tense = 'Perf/Imperative/Inf';
			}
		}
	}

	//--------------------------------------I-Nun verbs-----------------------------------------------------
	elseif ($verb_type == 'Weak<br>I-Nun') {
		//verb has no prefix
		if (($firstletter == $firstletter_a) && ($firstletter_a <> $thirdvowel_a)) {
			if ($firstvowel_a == 'ָ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ָ') || ($firstvowel_a == 'ְ' && $secondvowel_a == 'ַ')) {
				if ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ּ') {
					$verb_tense = 'Qal/Pass Part';
				} elseif (($thirdvowel_a == 'ֹ') || ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ֹ')) {
					$verb_tense = 'Qal/Inf Abs';
				} else {
					$verb_tense = 'Qal/Perfect';
				}
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ַ') {
				$verb_tense = 'Niphan/Perfect';
			} elseif ($firstvowel_a == 'ִ') {
				$verb_tense = 'Qal/Imperative';
			} elseif ($firstvowel_a == 'ְ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ְ')) {
				$verb_tense = 'Qal/Imperative';
			} elseif (($firstvowel_a == 'ֹ') || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ֹ') || ($firstvowel_a == 'ו'  && $secondvowel_a == 'ֹ') || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ו'  && $thirdvowel_a == 'ֹ')) {
				$verb_tense = 'Qal/Act/Part';
			} elseif ($secondvowel_a == 'ֹ') {
				$verb_tense = 'Qal/Inf Abs';
			} else {
				$verb_tense = '';
			}

		//verb has prefix
		} elseif ($firstletter_a == 'ת' || $firstletter_a == 'י' || $firstletter_a == 'א' || $firstletter_a == 'נ') {
			if ($firstvowel_a == 'ַ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ַ')) {
				$verb_tense = 'Hiphil/Imperfect';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Imperfect';
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperfect';
			} elseif ($firstletter_a == 'נ' && ($fifthvowel_a == 'ַ' || $fifthvowel_a == 'ְ')) {
				$verb_tense = 'Niphal/Perfect';
			} elseif ($firstletter_a == 'נ' && $fifthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Part';
			} elseif ($firstletter_a == 'נ' && ($fifthvowel_a == 'ֹ' || ($fifthvowel_a == 'ו'))) {
				$verb_tense = 'Niphal/Inf';
			} else {
				$verb_tense = 'Qal/Imperfect';
			}
		} elseif ($firstletter_a == 'מ') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Part';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Part';
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Part';
			} else {
				$verb_tense = 'Participle';
			}
		} elseif ($firstletter_a == 'ה') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Imperative';
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperative';				
			} elseif ($firstvowel_a == 'ִ') {
				$verb_tense = 'Hiphil/Perf';				
			} elseif ($firstvowel_a == 'ֻ') {
				$verb_tense = 'Hophal/Perf/Inf';				
			}
		}
	}

	//------------------------------------------I-Waw / I-Yud verbs------------------------------------------------
	elseif ($verb_type == 'Weak<br>I-Yud') {

		//verb has no prefix
		if ($firstletter_a == 'י') {
			if ($firstvowel_a == 'ָ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ָ') || $firstvowel_a == 'ְ') {
				if ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ּ') {
					$verb_tense = 'Qal/Pass Part';
				} elseif (($thirdvowel_a == 'ֹ') || ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ֹ')) {
					$verb_tense = 'Qal/Inf Abs';
				} else {
					$verb_tense = 'Qal/Perfect';
				}
			} elseif (($firstvowel_a == 'ּ' && $secondvowel_a == 'ו' && $thirdvowel_a == 'ֹ') || ($firstvowel_a == 'ו' && $secondvowel_a == 'ֹ')) {
				$verb_tense = 'Hiphil/Imperfect';
				$verb_type = 'Weak<br>I-Waw';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Perfect';
				$verb_type = 'Weak<br>I-Waw';
			} elseif (($firstvowel_a == 'ּ' && $secondvowel_a == 'ִ' && $thirdvowel_a == 'ו' && $fourthvowel_a == 'ּ') || ($firstvowel_a == 'ִ' && $secondvowel_a == 'ו' && $thirdvowel_a == 'ּ') || ($firstvowel_a == 'ו' && $secondvowel_a == 'ּ')) {
				$verb_tense = 'Niphal/Imperfect';
				$verb_type = 'Weak<br>I-Waw';
			} else {
				$verb_tense = 'Qal/Perfect';
			}

		//verb has prefix
		} elseif ($firstletter_a == 'ת' || $firstletter_a == 'א' || $firstletter_a == 'נ') {
			if (($firstvowel_a == 'ּ' && $secondvowel_a == 'ו' && $thirdvowel_a == 'ֹ') || ($firstvowel_a == 'ו' && $secondvowel_a == 'ֹ')) {
				$verb_tense = 'Hiphil/Imperfect';
				$verb_type = 'Weak<br>I-Waw';
			} elseif (($firstvowel_a == 'ו' && $secondvowel_a == 'ּ') || (($secondvowel_a == 'ו' && $thirdvowel_a == 'ּ'))) {
				$verb_tense = 'Hophal/Imperfect';
				$verb_type = 'Weak<br>I-Waw';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Perfect';
				$verb_type = 'Weak<br>I-Waw';
			} elseif (($firstvowel_a == 'ּ' && $secondvowel_a == 'ִ' && $thirdvowel_a == 'ו' && $fourthvowel_a == 'ּ') || ($firstvowel_a == 'ִ' && $secondvowel_a == 'ו' && $thirdvowel_a == 'ּ') || ($firstvowel_a == 'ו' && $secondvowel_a == 'ּ')) {
				$verb_tense = 'Niphal/Imperfect';
				$verb_type = 'Weak<br>I-Waw';
			} elseif ($firstletter_a == 'נ' && $secondvowel_a == 'ו' && $thirdvowel_a == 'ֹ' && $fifthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Part';
				$verb_type = 'Weak<br>I-Waw';
			} elseif ($firstletter_a == 'נ' && $secondvowel_a == 'ו' && $thirdvowel_a == 'ֹ') {
				$verb_tense = 'Niphal/Perfect';
				$verb_type = 'Weak<br>I-Waw';
			} elseif ($firstvowel_a == 'ֵ' || $secondvowel_a == 'ֵ') {
				$verb_tense = 'Qal/Imperfect';
			}
		} elseif ($firstletter_a == 'מ') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Part';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Part';
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Part';
			} else {
				$verb_tense = 'Participle';
			}
		} elseif ($firstletter_a == 'ה' && $firstvowel_a == 'ו') {
			if ($secondvowel_a == 'ֹ' && $fourthvowel_a == 'ַ' || $fourthvowel_a == 'ִ') {
				$verb_tense = 'Hiphil/Imperative/Perfect';
				$verb_type = 'Weak<br>I-Waw';
			} elseif ($secondvowel_a == 'ּ' && $fourthvowel_a == 'ַ' || $fourthvowel_a == 'ְ') {
				$verb_tense = 'Hophal/Perfect';	
				$verb_type = 'Weak<br>I-Waw';			
			} elseif ($secondvowel_a == 'ּ' && $fourthvowel_a == 'ֵ') {
				$verb_tense = 'Hophal/Inf';
				$verb_type = 'Weak<br>I-Waw';			
			}
		}
	}

	//---------------------------------------------------III-He verbs------------------------------------------------
	elseif ($verb_type == 'Weak<br>III-He') {
		//verb has no prefix
		if (($firstletter == $firstletter_a) && ($firstletter_a <> $thirdvowel_a)) {
			if ($firstvowel_a == 'ָ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ָ') || $firstvowel_a == 'ֲ') {
				if ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ּ') {
					$verb_tense = 'Qal/Pass Part';
				} elseif (($thirdvowel_a == 'ֹ') || ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ֹ')) {
					$verb_tense = 'Qal/Inf Abs';
				} else {
					$verb_tense = 'Qal/Perfect';
				}
			} elseif ($firstvowel_a == 'ַ') {
				$verb_tense = 'Piel/Imperative';
			} elseif ($firstvowel_a == 'ִ') {
				if ($thirdvowel_a == 'ּ') {
					$verb_tense = 'Qal/Imperative';
				} else {
					$verb_tense = 'Piel/Perfect';
				}
			} elseif ($firstvowel_a == 'ְ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ְ')) {
				$verb_tense = 'Qal/Imperative';
			} elseif (($firstvowel_a == 'ֹ') || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ֹ') || ($firstvowel_a == 'ו'  && $secondvowel_a == 'ֹ') || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ו'  && $thirdvowel_a == 'ֹ')) {
				$verb_tense = 'Qal/Act Part';
			} elseif ($firstvowel_a == 'ֻ') {
				if ($thirdvowel_a == 'ּ' && $fourthvowel_a == 'ֹ') {
					$verb_tense = 'Pual/Inf Abs';
				} else {
					$verb_tense = 'Pual/Perfect';
				}
			} elseif ($secondvowel_a == 'ֹ') {
				$verb_tense = 'Qal/Inf Abs';
			} else {
				$verb_tense = '';
			}

		//verb has prefix
		} elseif ($firstletter_a == 'ת' || $firstletter_a == 'י' || $firstletter_a == 'א' || $firstletter_a == 'נ') {
			if ($firstvowel_a == 'ַ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ַ')) {
				$verb_tense = 'Hiphil/Imperfect';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Imperfect';
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperfect';
			} elseif ($firstletter_a == 'נ' && ($fifthvowel_a == 'ַ' || $fifthvowel_a == 'ְ')) {
				$verb_tense = 'Niphal/Perfect';
			} elseif ($firstletter_a == 'נ' && $fifthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Part';
			} elseif ($firstletter_a == 'נ' && ($fifthvowel_a == 'ֹ' || ($fifthvowel_a == 'ו'))) {
				$verb_tense = 'Niphal/Inf';
			} else {
				$verb_tense = 'Qal/Imperfect';
			}
		} elseif ($firstletter_a == 'מ') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Part';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Part';
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Part';
			} else {
				$verb_tense = 'Participle';
			}
		} elseif ($firstletter_a == 'ה') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Imperative';
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperative';				
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hiphil/Perf';				
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Perf/Inf';				
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Perf/Imperative/Inf';				
			} else {
				$verb_tense = 'Perf/Imperative/Inf';
			}
		}
	}

//----------------------------------------------Special Haya verb----------------------------------------------------
	elseif ($verb_type == 'Special<br>Haya') {
		//verb has no prefix
		if (($firstletter == $firstletter_a) && ($firstletter_a <> $thirdvowel_a)) {
			if ($firstvowel_a == 'ָ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ָ') || $firstvowel_a == 'ֲ') {
				if ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ּ') {
					$verb_tense = 'Qal/Pass Part';
				} elseif (($thirdvowel_a == 'ֹ') || ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ֹ')) {
					$verb_tense = 'Qal/Inf Abs';
				} else {
					$verb_tense = 'Qal/Perfect';
				}
			} elseif ($firstvowel_a == 'ַ') {
				$verb_tense = 'Piel/Imperative';
			} elseif ($firstvowel_a == 'ִ') {
				if ($thirdvowel_a == 'ּ') {
					$verb_tense = 'Qal/Imperative';
				} else {
					$verb_tense = 'Piel/Perfect';
				}
			} elseif ($firstvowel_a == 'ְ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ְ')) {
				$verb_tense = 'Qal/Imperative';
			} elseif (($firstvowel_a == 'ֹ') || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ֹ') || ($firstvowel_a == 'ו'  && $secondvowel_a == 'ֹ') || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ו'  && $thirdvowel_a == 'ֹ')) {
				$verb_tense = 'Qal/Act Part';
			} elseif ($firstvowel_a == 'ֻ') {
				if ($thirdvowel_a == 'ּ' && $fourthvowel_a == 'ֹ') {
					$verb_tense = 'Pual/Inf Abs';
				} else {
					$verb_tense = 'Pual/Perfect';
				}
			} elseif ($secondvowel_a == 'ֹ') {
				$verb_tense = 'Qal/Inf Abs';
			} else {
				$verb_tense = '';
			}

		//verb has prefix
		} elseif ($firstletter_a == 'ת' || $firstletter_a == 'י' || $firstletter_a == 'א' || $firstletter_a == 'נ') {
			if ($firstvowel_a == 'ַ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ַ')) {
				$verb_tense = 'Hiphil/Imperfect';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Imperfect';
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperfect';
			} elseif ($firstletter_a == 'נ' && ($fifthvowel_a == 'ַ' || $fifthvowel_a == 'ְ')) {
				$verb_tense = 'Niphal/Perfect';
			} elseif ($firstletter_a == 'נ' && $fifthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Part';
			} elseif ($firstletter_a == 'נ' && ($fifthvowel_a == 'ֹ' || ($fifthvowel_a == 'ו'))) {
				$verb_tense = 'Niphal/Inf';
			} else {
				$verb_tense = 'Qal/Imperfect';
			}
		} elseif ($firstletter_a == 'מ') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Part';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Part';
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Part';
			} else {
				$verb_tense = 'Participle';
			}
		} elseif ($firstletter_a == 'ה') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Imperative';
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperative';				
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hiphil/Perf';				
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Perf/Inf';				
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Perf/Imperative/Inf';				
			} else {
				$verb_tense = 'Perf/Imperative/Inf';
			}
		}
	}

	//-------------------------------------------Hollow verbs------------------------------------------------
	elseif ($verb_type == 'Weak<br>Hollow') {
		//verb has no prefix
		if (($firstletter == $firstletter_a) && ($firstletter_a <> $thirdvowel_a)) {
			if ($firstvowel_a == 'ָ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ָ') || $firstvowel_a == 'ֲ') {
				if ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ּ') {
					$verb_tense = 'Qal/Pass Part';
				} elseif (($thirdvowel_a == 'ֹ') || ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ֹ')) {
					$verb_tense = 'Qal/Inf Abs';
				} else {
					$verb_tense = 'Qal/Perfect';
				}
			} elseif ($firstvowel_a == 'ַ') {
				$verb_tense = 'Piel/Imperative';
			} elseif ($firstvowel_a == 'ִ') {
				if ($thirdvowel_a == 'ּ') {
					$verb_tense = 'Qal/Imperative';
				} else {
					$verb_tense = 'Piel/Perfect';
				}
			} elseif ($firstvowel_a == 'ְ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ְ')) {
				$verb_tense = 'Qal/Imperative';
			} elseif (($firstvowel_a == 'ֹ') || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ֹ') || ($firstvowel_a == 'ו'  && $secondvowel_a == 'ֹ') || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ו'  && $thirdvowel_a == 'ֹ')) {
				$verb_tense = 'Qal/Act/Part';
			} elseif ($firstvowel_a == 'ֻ') {
				if ($thirdvowel_a == 'ּ' && $fourthvowel_a == 'ֹ') {
					$verb_tense = 'Pual/Inf Abs';
				} else {
					$verb_tense = 'Pual/Perfect';
				}
			} elseif ($secondvowel_a == 'ֹ') {
				$verb_tense = 'Qal/Inf Abs';
			} else {
				$verb_tense = '';
			}

		//verb has prefix
		} elseif ($firstletter_a == 'ת' || $firstletter_a == 'י' || $firstletter_a == 'א' || $firstletter_a == 'נ') {
			if ($firstvowel_a == 'ַ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ַ')) {
				$verb_tense = 'Hiphil/Imperfect';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Imperfect';
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperfect';
			} elseif ($firstletter_a == 'נ' && ($fifthvowel_a == 'ַ' || $fifthvowel_a == 'ְ')) {
				$verb_tense = 'Niphal/Perfect';
			} elseif ($firstletter_a == 'נ' && $fifthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Part';
			} elseif ($firstletter_a == 'נ' && ($fifthvowel_a == 'ֹ' || ($fifthvowel_a == 'ו'))) {
				$verb_tense = 'Niphal/Inf';
			} else {
				$verb_tense = 'Qal/Imperfect';
			}
		} elseif ($firstletter_a == 'מ') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Part';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Part';
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Part';
			} else {
				$verb_tense = 'Participle';
			}
		} elseif ($firstletter_a == 'ה') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Imperative';
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperative';				
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hiphil/Perf';				
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Perf/Inf';				
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Perf/Imperative/Inf';				
			} else {
				$verb_tense = 'Perf/Imperative/Inf';
			}
		}
	}

	//---------------------------------------------Geminate verbs----------------------------------------------
	elseif ($verb_type == 'Weak<br>Geminate') {
		//verb has no prefix
		if (($firstletter == $firstletter_a) && ($firstletter_a <> $thirdvowel_a)) {
			if ($firstvowel_a == 'ָ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ָ') || $firstvowel_a == 'ֲ') {
				if ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ּ') {
					$verb_tense = 'Qal/Pass Part';
				} elseif (($thirdvowel_a == 'ֹ') || ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ֹ')) {
					$verb_tense = 'Qal/Inf Abs';
				} else {
					$verb_tense = 'Qal/Perfect';
				}
			} elseif ($firstvowel_a == 'ַ') {
				$verb_tense = 'Piel/Imperative';
			} elseif ($firstvowel_a == 'ִ') {
				if ($thirdvowel_a == 'ּ') {
					$verb_tense = 'Qal/Imperative';
				} else {
					$verb_tense = 'Piel/Perfect';
				}
			} elseif ($firstvowel_a == 'ְ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ְ')) {
				$verb_tense = 'Qal/Imperative';
			} elseif (($firstvowel_a == 'ֹ') || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ֹ') || ($firstvowel_a == 'ו'  && $secondvowel_a == 'ֹ') || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ו'  && $thirdvowel_a == 'ֹ')) {
				$verb_tense = 'Qal/Act/Part';
			} elseif ($firstvowel_a == 'ֻ') {
				if ($thirdvowel_a == 'ּ' && $fourthvowel_a == 'ֹ') {
					$verb_tense = 'Pual/Inf Abs';
				} else {
					$verb_tense = 'Pual/Perfect';
				}
			} elseif ($secondvowel_a == 'ֹ') {
				$verb_tense = 'Qal/Inf Abs';
			} else {
				$verb_tense = '';
			}

		//verb has prefix
		} elseif ($firstletter_a == 'ת' || $firstletter_a == 'י' || $firstletter_a == 'א' || $firstletter_a == 'נ') {
			if ($firstvowel_a == 'ַ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ַ')) {
				$verb_tense = 'Hiphil/Imperfect';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Imperfect';
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperfect';
			} elseif ($firstletter_a == 'נ' && ($fifthvowel_a == 'ַ' || $fifthvowel_a == 'ְ')) {
				$verb_tense = 'Niphal/Perfect';
			} elseif ($firstletter_a == 'נ' && $fifthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Part';
			} elseif ($firstletter_a == 'נ' && ($fifthvowel_a == 'ֹ' || ($fifthvowel_a == 'ו'))) {
				$verb_tense = 'Niphal/Inf';
			} else {
				$verb_tense = 'Qal/Imperfect';
			}
		} elseif ($firstletter_a == 'מ') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Part';
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Part';
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Part';
			} else {
				$verb_tense = 'Participle';
			}
		} elseif ($firstletter_a == 'ה') {
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Imperative';
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperative';				
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hiphil/Perf';				
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Perf/Inf';				
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Perf/Imperative/Inf';				
			} else {
				$verb_tense = 'Perf/Imperative/Inf';
			}
		}
	}

	$firstvowel_l = mb_substr($verb_actual_word,-1,1,'UTF-8');
	$secondvowel_l = mb_substr($verb_actual_word,-2,1,'UTF-8');
	$thirdvowel_l = mb_substr($verb_actual_word,-3,1,'UTF-8');
	$fourthvowel_l = mb_substr($verb_actual_word,-4,1,'UTF-8');
	$fifthvowel_l = mb_substr($verb_actual_word,-5,1,'UTF-8');

	//-------------------------------------determine Person/Gender/Number--------------------------------------------
	if (substr_count($verb_tense, 'Part') > 0) {

		if ($firstvowel_l == 'ם' && $secondvowel_l == 'י') {
			$verb_pgn = 'm.p';
		} elseif ($firstvowel_l == 'ת' && $secondvowel_l == 'ֹ' && $thirdvowel_l == 'ו') {
			$verb_pgn = 'f.p';
		} elseif ($firstvowel_l == 'ת' && $secondvowel_l == 'ֹ') {
			$verb_pgn = 'f.p';
		} elseif ($firstvowel_l == 'ת') {
			$verb_pgn = 'f.s';
		} else {
			$verb_pgn = 'm.s';
		}

	} elseif (substr_count($verb_tense, 'Perfect') > 0 || substr_count($verb_tense, 'Perf') > 0) {

		if ($firstvowel_l == 'ם' && $secondvowel_l == 'ֶ' && $thirdvowel_l == 'ּ' && $fourthvowel_l == 'ת') {
			$verb_pgn = '2.m.p';
		} elseif ($firstvowel_l == 'ן' && $secondvowel_l == 'ֶ' && $thirdvowel_l == 'ּ' && $fourthvowel_l == 'ת') {
			$verb_pgn = '2.f.p';
		} elseif ($firstvowel_l == 'ה') {
			$verb_pgn = '3.f.s';			
		} elseif ($firstvowel_l == 'ּ' && $secondvowel_l == 'ו' && $thirdvowel_l == 'נ') {
			$verb_pgn = '1.c.p';	
		} elseif ($firstvowel_l == 'ּ' && $secondvowel_l == 'ו') {
			$verb_pgn = '3.c.p';	
		} elseif ($firstvowel_l == 'י') {
			$verb_pgn = '1.c.s';	
		} elseif ($firstvowel_l == 'ָ' && $secondvowel_l == 'ּ' && $thirdvowel_l == 'ת') {
			$verb_pgn = '2.m.s';	
		} elseif ($firstvowel_l == 'ְ' && $secondvowel_l == 'ּ' && $thirdvowel_l == 'ת') {
			$verb_pgn = '2.f.s';	
		} else {
			$verb_pgn = '3.m.s';
		}

	} elseif (substr_count($verb_tense, 'Imperfect') > 0) {

		if ($firstvowel_l == 'ה' && $firstletter_a == 'ת' && $thirdletter <> 'ה') {
			$verb_pgn = '2.f.p/3.f.p';			
		} elseif ($firstvowel_l == 'ּ' && $secondvowel_l == 'ו' && $firstletter_a == 'ת') {
			$verb_pgn = '2.m.p';	
		} elseif ($firstvowel_l == 'ּ' && $secondvowel_l == 'ו' && $firstletter_a == 'י') {
			$verb_pgn = '3.m.p';	
		} elseif ($firstletter_a == 'י') {
			$verb_pgn = '3.m.s';	
		} elseif (($secondvowel_a == 'ִ' && $firstvowel_a == 'ּ' && $firstletter_a == 'ת') || $firstletter_a == 'ת' )  {
			$verb_pgn = '2.m.s/3.f.s';	
		} elseif ($firstvowel_l == 'י' && $firstletter_a == 'ת') {
			$verb_pgn = '2.f.s';	
		} elseif ($firstletter_a == 'נ') {
			$verb_pgn = '1.c.p';
		} elseif ($firstletter_a == 'א') {
			$verb_pgn = '1.c.s';
		}

	} elseif (substr_count($verb_tense, 'Imperative') > 0) {

		if ($firstvowel_l == 'י') {
			$verb_pgn = '2.f.s';
		} elseif ($firstvowel_l == 'ּ' && $secondvowel_l == 'ו') {
			$verb_pgn = '2.m.p';
		} elseif ($firstvowel_l == 'ה' && $secondvowel_l == 'ָ' && $thirdvowel_l == 'נ') {
			$verb_pgn = '2.f.p';
		} else {
			$verb_pgn = '2.m.s';
		}

	} else {
		$verb_pgn = '';
	}

	//final output
	$output_verb = '<br>'.$verb_type.'<br>root '.$verb_root.'<br>'.$verb_tense.'<br>'.$verb_pgn;

	return $output_verb;

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////

function DeterminePrefixSufix ($word, $pos, $strong) {

	$output_word = '';
	//prefix and suffixes
	$ppp = array('ב', 'בְ', 'בְֽ', 'בִ', 'בִֽ', 'בֵ', 'בֵֽ', 'בֶ', 'בֶֽ', 'בַ', 'בַֽ', 'בָ', 'בָֽ', 'בּ', 'בְּ', 'בְּֽ', 'בִּ', 'בִּֽ', 'בֵּ', 'בֵּֽ', 'בֶּ', 'בֶּֽ', 'בַּ', 'בַּֽ', 'בָּ', 'בָּֽ', 'בּֽ', 'בַּֽ', 'בָּֽ', 'בֽ', 'בָֽ', 'ה', 'הְֽ', 'הֲ', 'הֳ', 'הֶ', 'הֶֽ', 'הַ', 'הַֽ', 'הַׄ', 'הָ', 'הָֽ', 'הֶֽ', 'הַֽ', 'הָֽ', 'הְֽ', 'הֲ', 'הֲֽ', 'הֶ', 'הֶֽ', 'הַ', 'הַֽ', 'הֲֽ', 'הַֽ', 'הָֽ', 'הֲ‍ֽ', 'ו', 'וְ', 'וְֽ', 'וְׄ', 'וֲ', 'וִ', 'וִֽ', 'וֵ', 'וֵֽ', 'וֶ', 'וֶֽ', 'וַ', 'וַֽ', 'וַׄ', 'וָ', 'וָֽ', 'וּ', 'וִּ', 'וּֽ', 'וּׄ', 'וְֽ', 'וִֽ', 'וֵֽ', 'וֶֽ', 'וַֽ', 'וָֽ', 'כ', 'כְ', 'כִ', 'כֶ', 'כַ', 'כַֽ', 'כָ', 'כְּ', 'כְּֽ', 'כִּ', 'כִּֽ', 'כֵּ', 'כֵּֽ', 'כֶּ', 'כֶּֽ', 'כַּ', 'כַּֽ', 'כָּ', 'כָּֽ', 'כַּֽ', 'כָּֽ', 'ל', 'לְ', 'לְֽ', 'לְׄ', 'לֲ', 'לִ', 'לִֽ', 'לֵ', 'לֵֽ', 'לֶ', 'לֶֽ', 'לַ', 'לַֽ', 'לָ', 'לָֽ', 'לָׄ', 'לּ', 'לְּ', 'לִּ', 'לִּֽ', 'לֵּ', 'לֶּ', 'לַּ', 'לָּ', 'לָּֽ', 'לּֽ', 'לֽ', 'לְֽ', 'לִֽ', 'לֵֽ', 'לֶֽ', 'לַֽ', 'לָֽ', 'לִֽֿ', 'מ', 'מְ', 'מִ', 'מִֽ', 'מֵ', 'מֵֽ', 'מֶ', 'מֶֽ', 'מַ', 'מִּ', 'מֵּ', 'מֵֽ', 'ש', 'שְׁ', 'שֶׁ', 'שֶֽׁ', 'שַׁ', 'שָׁ', 'שֶּׁ', 'שֶּֽׁ');

	$sss = array('א', 'אָה', 'דִי', 'ה', 'הָ', 'הּ', 'הָּ', 'הֿ', 'הָא', 'הא', 'הֽוּ', 'הׄוּׄ', 'הו', 'הוּ', 'הוא', 'הוֹם', 'הֽוֹן', 'הוֹן', 'הון', 'הִי', 'הֵין', 'הֶֽם', 'הֶם', 'הַם', 'הֹֽם', 'הֹם', 'הֶּם', 'הֶֽם', 'הם', 'הֵמָה', 'הֵן', 'הֶֽן', 'הֶן', 'הְנָה', 'הֶֽנָה', 'ו', 'וֹ', 'וּ', 'וׄ', 'וּהִי', 'וּךְ', 'י', 'יַ', 'ידע', 'יָהּ', 'יהָ', 'יהֶם', 'יו', 'יונים', 'יךְ', 'ינה', 'ך', 'ךְ', 'ךָ', 'ךָֽ', 'ךָּ', 'כֵה', 'כָה', 'כָּה', 'כוֹן', 'כִי', 'כי', 'כֶֽם', 'כֶם', 'כֹם', 'כם', 'כֶֽן', 'כֶן', 'כֶֽנָה', 'כֶנָה', 'ם', 'מו', 'מוֹ', 'מוּ', 'ן', 'נ', 'נְ', 'נֶ', 'נַ', 'נָא', 'נא', 'נָה', 'נָּֽה', 'נָּה', 'נה', 'נְהֽוּ', 'נְהוּ', 'נּֽוּ', 'נּוּ', 'נׄוּׄ', 'נו', 'נוֹ', 'נוּ', 'נִֽי', 'נִי', 'נִּי', 'ני', 'נְךָּ', 'נְנִי');


	//if there's only 1 prefix or suffix, determine if it's prefix or suffix then print out the verse
	if (substr_count($word, '/') == 1) {

		$prepre = strtok($word, '/');
		$sufsuf = substr(strrchr($word, '/'), 1);

		if (in_array($prepre, $ppp)) {
			$output_word = '<td><div class="vcword"><span class="'.$pos.'"><a href="HebrewStrong.php?id='.$strong.'">'.$sufsuf.'</a></span></div></td><td><div class="vcword">'.$prepre.'</div></td>';
		}
		else {
			$output_word = '<td><div class="vcword">'.$sufsuf.'</div></td><td><div class="vcword"><span class="'.$pos.'"><a href="HebrewStrong.php?id='.$strong.'">'.$prepre.'</a></span></div></td>';
		}
	}

	//if there are 2 prefix or suffix, that means there's a prefix / word / suffix, print out accordingly in order
	elseif (substr_count($word, '/') == 2) {

		$prepre = strtok($word, '/');

		if (in_array($prepre, $ppp)) {
			
			$trimmed_word = substr($word, strpos($word, "/") + 1);
			$sufsuf = DeterminePrefixSufix($trimmed_word, $pos, $strong);
			$output_word = $sufsuf.'<td><div class="vcword">'.$prepre.'</div></td>';

		}
		else {

			$firstpart = DeterminePrefixSufix($prepre, $pos, $strong);
			$trimmed_word = substr($word, strpos($word, "/") + 1);
			$sufsuf = DeterminePrefixSufix($prepre, $pos, $strong);
			$output_word = '<td><div class="vcword">'.$sufsuf.'</div></td>'.$firstpart;		

		}
	}

	//if there are more than 2 prefix or suffix, then repeat this function
	elseif (substr_count($word, '/') > 2) {

		$prepre = strtok($word, '/');
		$trimmed_word = substr($word, strpos($word, "/") + 1);
		$sufsuf = DeterminePrefixSufix($trimmed_word, $pos, $strong);
		$output_word = '<td><div class="vcword">'.$sufsuf.'</div></td><td><div class="vcword">'.$prepre.'</div></td>';

	}

	//return the bible verse print out
	return $output_word;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////

function DeterminePrefixSufix2 ($word, $pos, $strong, $possorig) {

	global $v_ids;
	global $v_words;

	$output_word = '';

	//prefix and suffixes
	$ppp = array('ב', 'בְ', 'בְֽ', 'בִ', 'בִֽ', 'בֵ', 'בֵֽ', 'בֶ', 'בֶֽ', 'בַ', 'בַֽ', 'בָ', 'בָֽ', 'בּ', 'בְּ', 'בְּֽ', 'בִּ', 'בִּֽ', 'בֵּ', 'בֵּֽ', 'בֶּ', 'בֶּֽ', 'בַּ', 'בַּֽ', 'בָּ', 'בָּֽ', 'בּֽ', 'בַּֽ', 'בָּֽ', 'בֽ', 'בָֽ', 'ה', 'הְֽ', 'הֲ', 'הֳ', 'הֶ', 'הֶֽ', 'הַ', 'הַֽ', 'הַׄ', 'הָ', 'הָֽ', 'הֶֽ', 'הַֽ', 'הָֽ', 'הְֽ', 'הֲ', 'הֲֽ', 'הֶ', 'הֶֽ', 'הַ', 'הַֽ', 'הֲֽ', 'הַֽ', 'הָֽ', 'הֲ‍ֽ', 'ו', 'וְ', 'וְֽ', 'וְׄ', 'וֲ', 'וִ', 'וִֽ', 'וֵ', 'וֵֽ', 'וֶ', 'וֶֽ', 'וַ', 'וַֽ', 'וַׄ', 'וָ', 'וָֽ', 'וּ', 'וִּ', 'וּֽ', 'וּׄ', 'וְֽ', 'וִֽ', 'וֵֽ', 'וֶֽ', 'וַֽ', 'וָֽ', 'כ', 'כְ', 'כִ', 'כֶ', 'כַ', 'כַֽ', 'כָ', 'כְּ', 'כְּֽ', 'כִּ', 'כִּֽ', 'כֵּ', 'כֵּֽ', 'כֶּ', 'כֶּֽ', 'כַּ', 'כַּֽ', 'כָּ', 'כָּֽ', 'כַּֽ', 'כָּֽ', 'ל', 'לְ', 'לְֽ', 'לְׄ', 'לֲ', 'לִ', 'לִֽ', 'לֵ', 'לֵֽ', 'לֶ', 'לֶֽ', 'לַ', 'לַֽ', 'לָ', 'לָֽ', 'לָׄ', 'לּ', 'לְּ', 'לִּ', 'לִּֽ', 'לֵּ', 'לֶּ', 'לַּ', 'לָּ', 'לָּֽ', 'לּֽ', 'לֽ', 'לְֽ', 'לִֽ', 'לֵֽ', 'לֶֽ', 'לַֽ', 'לָֽ', 'לִֽֿ', 'מ', 'מְ', 'מִ', 'מִֽ', 'מֵ', 'מֵֽ', 'מֶ', 'מֶֽ', 'מַ', 'מִּ', 'מֵּ', 'מֵֽ', 'ש', 'שְׁ', 'שֶׁ', 'שֶֽׁ', 'שַׁ', 'שָׁ', 'שֶּׁ', 'שֶּֽׁ');

	$sss = array('א', 'אָה', 'דִי', 'ה', 'הָ', 'הּ', 'הָּ', 'הֿ', 'הָא', 'הא', 'הֽוּ', 'הׄוּׄ', 'הו', 'הוּ', 'הוא', 'הוֹם', 'הֽוֹן', 'הוֹן', 'הון', 'הִי', 'הֵין', 'הֶֽם', 'הֶם', 'הַם', 'הֹֽם', 'הֹם', 'הֶּם', 'הֶֽם', 'הם', 'הֵמָה', 'הֵן', 'הֶֽן', 'הֶן', 'הְנָה', 'הֶֽנָה', 'ו', 'וֹ', 'וּ', 'וׄ', 'וּהִי', 'וּךְ', 'י', 'יַ', 'ידע', 'יָהּ', 'יהָ', 'יהֶם', 'יו', 'יונים', 'יךְ', 'ינה', 'ך', 'ךְ', 'ךָ', 'ךָֽ', 'ךָּ', 'כֵה', 'כָה', 'כָּה', 'כוֹן', 'כִי', 'כי', 'כֶֽם', 'כֶם', 'כֹם', 'כם', 'כֶֽן', 'כֶן', 'כֶֽנָה', 'כֶנָה', 'ם', 'מו', 'מוֹ', 'מוּ', 'ן', 'נ', 'נְ', 'נֶ', 'נַ', 'נָא', 'נא', 'נָה', 'נָּֽה', 'נָּה', 'נה', 'נְהֽוּ', 'נְהוּ', 'נּֽוּ', 'נּוּ', 'נׄוּׄ', 'נו', 'נוֹ', 'נוּ', 'נִֽי', 'נִי', 'נִּי', 'ני', 'נְךָּ', 'נְנִי');


	//if there's only 1 prefix or suffix, determine if it's prefix or suffix then print out the verse
	if (substr_count($word, '/') == 1) {

		$prepre = strtok($word, '/');
		$sufsuf = substr(strrchr($word, '/'), 1);
		$verb_addition = '';

		if (in_array($prepre, $ppp)) {

			//--------------------Verb---------------------------//	
			if ($pos == 'v') {
				$vw_key = array_search($strong, $v_ids);
				$vw_word = $v_words[$vw_key];
				$verb_addition = DetermineVerbPGN($vw_word, $strong, $word);
			}

			$output_word = '<td><a href="HebrewStrong.php?id='.$strong.'">'.$strong.'</a><br><span class="'.$pos.'">'.$possorig.$verb_addition.'</span></td><td><span class="pre"><br>pre</span></td>';
		}
		else {

			//--------------------Verb---------------------------//	
			if ($pos == 'v') {
				$vw_key = array_search($strong, $v_ids);
				$vw_word = $v_words[$vw_key];
				$verb_addition = DetermineVerbPGN($vw_word, $strong, $word);
			}

			$output_word = '<td><span class="suf"><br>suf</span></td><td><a href="HebrewStrong.php?id='.$strong.'">'.$strong.'</a><br><span class="'.$pos.'">'.$possorig.$verb_addition.'</span></td>';

		}
	}

	//if there are 2 prefix or suffix, that means there's a prefix / word / suffix, print out accordingly in order
	elseif (substr_count($word, '/') == 2) {

		$prepre = strtok($word, '/');

		if (in_array($prepre, $ppp)) {
			
			$trimmed_word = substr($word, strpos($word, "/") + 1);
			$sufsuf = DeterminePrefixSufix2($trimmed_word, $pos, $strong, $possorig);
			$output_word = $sufsuf.'<td><span class="pre"><br>pre</span></td>';

		}
		else {

			$firstpart = DeterminePrefixSufix2($prepre, $pos, $strong, $possorig);
			$trimmed_word = substr($word, strpos($word, "/") + 1);
			$sufsuf = DeterminePrefixSufix2($prepre, $pos, $strong, $possorig);
			$output_word = '<td>'.$sufsuf.'</td>'.$firstpart;		

		}
	}

	//if there are more than 2 prefix or suffix, then repeat this function
	elseif (substr_count($word, '/') > 2) {

		$prepre = strtok($word, '/');
		$trimmed_word = substr($word, strpos($word, "/") + 1);
		$sufsuf = DeterminePrefixSufix2($trimmed_word, $pos, $strong, $possorig);
		$output_word = '<td>'.$sufsuf.'</td><td><span class="pre"><br>pre</span></td>';

	}

	//return the bible verse print out
	return $output_word;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////

function DeterminePrefixSufix3 ($word, $pos, $strong, $deffs) {

	$output_word = '';
	//prefix and suffixes
	$ppp = array('ב', 'בְ', 'בְֽ', 'בִ', 'בִֽ', 'בֵ', 'בֵֽ', 'בֶ', 'בֶֽ', 'בַ', 'בַֽ', 'בָ', 'בָֽ', 'בּ', 'בְּ', 'בְּֽ', 'בִּ', 'בִּֽ', 'בֵּ', 'בֵּֽ', 'בֶּ', 'בֶּֽ', 'בַּ', 'בַּֽ', 'בָּ', 'בָּֽ', 'בּֽ', 'בַּֽ', 'בָּֽ', 'בֽ', 'בָֽ', 'ה', 'הְֽ', 'הֲ', 'הֳ', 'הֶ', 'הֶֽ', 'הַ', 'הַֽ', 'הַׄ', 'הָ', 'הָֽ', 'הֶֽ', 'הַֽ', 'הָֽ', 'הְֽ', 'הֲ', 'הֲֽ', 'הֶ', 'הֶֽ', 'הַ', 'הַֽ', 'הֲֽ', 'הַֽ', 'הָֽ', 'הֲ‍ֽ', 'ו', 'וְ', 'וְֽ', 'וְׄ', 'וֲ', 'וִ', 'וִֽ', 'וֵ', 'וֵֽ', 'וֶ', 'וֶֽ', 'וַ', 'וַֽ', 'וַׄ', 'וָ', 'וָֽ', 'וּ', 'וִּ', 'וּֽ', 'וּׄ', 'וְֽ', 'וִֽ', 'וֵֽ', 'וֶֽ', 'וַֽ', 'וָֽ', 'כ', 'כְ', 'כִ', 'כֶ', 'כַ', 'כַֽ', 'כָ', 'כְּ', 'כְּֽ', 'כִּ', 'כִּֽ', 'כֵּ', 'כֵּֽ', 'כֶּ', 'כֶּֽ', 'כַּ', 'כַּֽ', 'כָּ', 'כָּֽ', 'כַּֽ', 'כָּֽ', 'ל', 'לְ', 'לְֽ', 'לְׄ', 'לֲ', 'לִ', 'לִֽ', 'לֵ', 'לֵֽ', 'לֶ', 'לֶֽ', 'לַ', 'לַֽ', 'לָ', 'לָֽ', 'לָׄ', 'לּ', 'לְּ', 'לִּ', 'לִּֽ', 'לֵּ', 'לֶּ', 'לַּ', 'לָּ', 'לָּֽ', 'לּֽ', 'לֽ', 'לְֽ', 'לִֽ', 'לֵֽ', 'לֶֽ', 'לַֽ', 'לָֽ', 'לִֽֿ', 'מ', 'מְ', 'מִ', 'מִֽ', 'מֵ', 'מֵֽ', 'מֶ', 'מֶֽ', 'מַ', 'מִּ', 'מֵּ', 'מֵֽ', 'ש', 'שְׁ', 'שֶׁ', 'שֶֽׁ', 'שַׁ', 'שָׁ', 'שֶּׁ', 'שֶּֽׁ');

	$pppdef = array('in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'ש', 'שְׁ', 'שֶׁ', 'שֶֽׁ', 'שַׁ', 'שָׁ', 'שֶּׁ', 'שֶּֽׁ');

	$sss = array('א', 'אָה', 'דִי', 'ה', 'הָ', 'הּ', 'הָּ', 'הֿ', 'הָא', 'הא', 'הֽוּ', 'הׄוּׄ', 'הו', 'הוּ', 'הוא', 'הוֹם', 'הֽוֹן', 'הוֹן', 'הון', 'הִי', 'הֵין', 'הֶֽם', 'הֶם', 'הַם', 'הֹֽם', 'הֹם', 'הֶּם', 'הֶֽם', 'הם', 'הֵמָה', 'הֵן', 'הֶֽן', 'הֶן', 'הְנָה', 'הֶֽנָה', 'ו', 'וֹ', 'וּ', 'וׄ', 'וּהִי', 'וּךְ', 'י', 'יַ', 'ידע', 'יָהּ', 'יהָ', 'יהֶם', 'יו', 'יונים', 'יךְ', 'ינה', 'ך', 'ךְ', 'ךָ', 'ךָֽ', 'ךָּ', 'כֵה', 'כָה', 'כָּה', 'כוֹן', 'כִי', 'כי', 'כֶֽם', 'כֶם', 'כֹם', 'כם', 'כֶֽן', 'כֶן', 'כֶֽנָה', 'כֶנָה', 'ם', 'מו', 'מוֹ', 'מוּ', 'ן', 'נ', 'נְ', 'נֶ', 'נַ', 'נָא', 'נא', 'נָה', 'נָּֽה', 'נָּה', 'נה', 'נְהֽוּ', 'נְהוּ', 'נּֽוּ', 'נּוּ', 'נׄוּׄ', 'נו', 'נוֹ', 'נוּ', 'נִֽי', 'נִי', 'נִּי', 'ני', 'נְךָּ', 'נְנִי','הוּ');

	$sssdef = array('א', 'her;it', 'דִי', 'her;it', 'her;it', 'her;it', 'her;it', 'her;it', 'her;it', 'her;it', 'his;its', 'his;its', 'his;its', 'his;its', 'him;it', 'הוֹם', 'הֽוֹן', 'הוֹן', 'הון', 'הִי', 'הֵין', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'הְנָה', 'הֶֽנָה', 'him or it;his or its', 'him or it;his or its', 'him or it;his or its', 'him or it;his or its', 'וּהִי', 'you;your', 'me;my', 'יַ', 'ידע', 'her;it', 'her;it', 'them, their', 'יו', 'יונים', 'you;your', 'ינה', 'you;your', 'you;your', 'you;your', 'you;your', 'you;your', 'כֵה', 'כָה', 'כָּה', 'כוֹן', 'כִי', 'כי', 'you;your', 'you;your', 'you;your', 'you;your', 'you;your', 'you;your', 'כֶֽנָה', 'כֶנָה', 'them;their', 'מו', 'מוֹ', 'מוּ', 'them;their', 'נ', 'נְ', 'me;my', 'נַ', 'נָא', 'נא', 'נָה', 'נָּֽה', 'נָּה', 'נה', 'נְהֽוּ', 'נְהוּ', 'us;our', 'us;our', 'us;our', 'us;our', 'נוֹ', 'us;our', 'me;my', 'me;my', 'me;my', 'me;my', 'you;your', 'נְנִי','his;its');


	//if there's only 1 prefix or suffix, determine if it's prefix or suffix then print out the verse
	if (substr_count($word, '/') == 1) {

		$prepre = strtok($word, '/');
		$sufsuf = substr(strrchr($word, '/'), 1);

		if (in_array($prepre, $ppp)) {

			//find prefix in definition array
			$pdkey = array_search($prepre, $ppp);
			$pdef = str_replace(" or ","<br>",$pppdef[$pdkey]);	

			$output_word = '<td>'.$deffs.'</td><td>'.$pdef.'</td>';

		} else {

		//find suffix in definition array
		$sdkey = array_search($sufsuf, $sss);

		//if it's suffix after a verb, then it's objective
		if ($pos == 'v') {
			$sdef = strtok($sssdef[$sdkey], ';');		
		//if it's suffix after a noun, then it's possesive	
		} elseif (substr($pos, 0, 1) == 'n') {
			$sdef = substr(strrchr($sssdef[$sdkey], ';'), 1);
		//other things need to be studied further
		} else {
			$sdef = strtok($sssdef[$sdkey], ';');
		}

		$sdef = str_replace(" or ","<br>",$sdef);
		$output_word = '<td>'.$sdef.'</td><td>'.$deffs.'</td>';

		}
	}

	//if there are 2 prefix or suffix, that means there's a prefix / word / suffix, print out accordingly in order
	elseif (substr_count($word, '/') == 2) {

		$prepre = strtok($word, '/');

		if (in_array($prepre, $ppp)) {

			//find prefix in definition array
			$pdkey = array_search($prepre, $ppp);
			$pdef = str_replace(" or ","<br>",$pppdef[$pdkey]);	
			
			$trimmed_word = substr($word, strpos($word, "/") + 1);
			$sufsuf = DeterminePrefixSufix3($trimmed_word, $pos, $strong, $deffs);
			$output_word = $sufsuf.'<td>'.$pdef.'</td>';

		}
		else {

			$firstpart = DeterminePrefixSufix3($prepre, $pos, $strong, $deffs);
			$trimmed_word = substr($word, strpos($word, "/") + 1);
			$sufsuf = DeterminePrefixSufix3($trimmed_word, $pos, $strong, $deffs);
			$output_word = '<td>'.$sufsuf.'</td>'.$firstpart;		

		}
	}

	//if there are more than 2 prefix or suffix, then repeat this function
	elseif (substr_count($word, '/') > 2) {

		$prepre = strtok($word, '/');
		$trimmed_word = substr($word, strpos($word, "/") + 1);
		$sufsuf = DeterminePrefixSufix3($trimmed_word, $pos, $strong, $deffs);
		$output_word = '<td>'.$sufsuf.'</td><td>pre</td>';

	}

	//return the bible verse print out
	return $output_word;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>
<!DOCTYPE html>
<html>
<head>
	<title>Blessed Regina's Bible Project</title>
	<meta name="keywords" content="Hebrew Bible Analysis, Tanakh Old Testament, Biblical Hebrew, Search for the Truth, Reaching for Spiritual Depth">
	<meta name="description" content="The Hebrew Bible (Tanakh) Analysis, Biblical Hebrew Study Resources, Reaching for Spiritual Depth, Searching for The Truth, Analyzing Sacred Ancient Texts.">
	<?php require 'INC/Header.php'; ?>
	<link rel="stylesheet" type="text/css" href="CSS/1-2/TheBible.css"> <!-- my css -->
	<link rel="stylesheet" type="text/css" href="CSS/1-2/TheBibleColorCoded.css">
	<style type="text/css">
		#content {
			font-size: 12px;
		}
		#kjv {
			font-size: 16px;
		}
	</style>
	<script src="JS/1-2/AncientBiblicalHebrewGrammarStudy.js"></script> <!-- my jQuery -->
	<script>
		function StudyResources() {
		    window.open("StudyResources.php?book=<?php echo $book; ?>&chapter=<?php echo $chapter; ?>");
		}
		function NonColorCoded() {
		    window.open("TheBible.php?book=<?php echo $book; ?>&chapter=<?php echo $chapter; ?>&verse=<?php echo $verse; ?>");
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
		<?php echo $bible_content; ?>
	</div>
</div>

<?php require 'INC/Footer.php'; ?>

</body>
</html>
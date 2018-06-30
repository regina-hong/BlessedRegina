<?php
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
		} elseif ($book =='1Sam' && $chapter == '24' && $verse == '1') {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='1Sam.23.29']");
		} elseif ($book =='1Sam' && $chapter == '21' && $verse == '1') {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='1Sam.20.43']");
		} elseif (($book =='Gen' && $chapter == '32') || ($book =='Num' && $chapter == '30') || ($book =='Deut' && $chapter == '13') || ($book =='Deut' && $chapter == '23') || ($book =='1Sam' && $chapter == '21')  || ($book =='1Sam' && $chapter == '24')) {
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
?>
<?php 
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
		} elseif ($book =='1Sam' && $chapter == '24' && $print_v == '1') {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='1Sam.23.29']");
		} elseif ($book =='1Sam' && $chapter == '21' && $print_v == '1') {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='1Sam.20.43']");
		} elseif ($book =='2Sam' && $chapter == '19' && $print_v == '1') {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='2Sam.18.33']");
		} elseif (($book =='Gen' && $chapter == '32') || ($book =='Num' && $chapter == '30') || ($book =='Deut' && $chapter == '13') || ($book =='Deut' && $chapter == '23') || ($book =='1Sam' && $chapter == '21') || ($book =='1Sam' && $chapter == '24') || ($book =='2Sam' && $chapter == '19')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".($print_v-1)."']");
		} elseif (($book =='Exod' && $chapter == '22') || ($book =='Deut' && $chapter == '29') || ($book =='1Sam' && $chapter == '24')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".($print_v+1)."']");		
		} elseif (($book =='Lev' && $chapter == '6')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".($print_v+7)."']");
		} elseif (($book =='Exod' && $chapter == '8')) {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".($print_v+4)."']");			
		} else {
			$words = $xpath_en->query("//osisText/div/chapter/verse[@osisID='".$book.".".$chapter.".".$print_v."']");
		}
////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
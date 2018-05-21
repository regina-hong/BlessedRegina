<?php

function ConvertNtoHL($verse_number) {

	if ($verse_number == 15) {
		$final_num = 'ט״ו';
		return $final_num;
	}
	elseif ($verse_number == 16) {
		$final_num = 'ט״ז';
		return $final_num;
	}
	else {

		$hebrew_letters = array('א', 'ב', 'ג', 'ד', 'ה', 'ו', 'ז', 'ח', 'ט', 'י', 'כ', 'ל', 'מ', 'נ', 'ס', 'ע', 'פ', 'צ', 'ק');
		$hebrew_numbers = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100);
		$temp = str_split($verse_number);
		$final_num = '';
		
		for ($i=0; $i < count($temp) ; $i++) { 
			$mul_n = count($temp)-1-$i;
			$mul_ten = 1;
			for ($j=0; $j < $mul_n ; $j++) { 
				$mul_ten *= 10;
			}
			$t_n = (int)$temp[$i] * $mul_ten;
			if ($t_n <> 0) {
				$key[] = array_search($t_n, $hebrew_numbers) ;
			}
		}

		for ($k=count($key) -1 ; $k >= 0 ; $k--) { 
			$t = $key[$k];
			$hebrew_vn[] = $hebrew_letters[$t] ;
		}

		for ($l=count($hebrew_vn) -1 ; $l >= 0 ; $l--) { 
			$final_num .= $hebrew_vn[$l];
		}

		return $final_num;

	}
}

?>
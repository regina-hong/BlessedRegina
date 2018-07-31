<?php

//prefix and suffixes

$ppp = array('ב', 'בְ', 'בְֽ', 'בִ', 'בִֽ', 'בֵ', 'בֵֽ', 'בֶ', 'בֶֽ', 'בַ', 'בַֽ', 'בָ', 'בָֽ', 'בּ', 'בְּ', 'בְּֽ', 'בִּ', 'בִּֽ', 'בֵּ', 'בֵּֽ', 'בֶּ', 'בֶּֽ', 'בַּ', 'בַּֽ', 'בָּ', 'בָּֽ', 'בּֽ', 'בַּֽ', 'בָּֽ', 'בֽ', 'בָֽ', 'ה', 'הְֽ', 'הֲ', 'הֳ', 'הֶ', 'הֶֽ', 'הַ', 'הַֽ', 'הַׄ', 'הָ', 'הָֽ', 'הֶֽ', 'הַֽ', 'הָֽ', 'הְֽ', 'הֲ', 'הֲֽ', 'הֶ', 'הֶֽ', 'הַ', 'הַֽ', 'הֲֽ', 'הַֽ', 'הָֽ', 'הֲ‍ֽ', 'ו', 'וְ', 'וְֽ', 'וְׄ', 'וֲ', 'וִ', 'וִֽ', 'וֵ', 'וֵֽ', 'וֶ', 'וֶֽ', 'וַ', 'וַֽ', 'וַׄ', 'וָ', 'וָֽ', 'וּ', 'וִּ', 'וּֽ', 'וּׄ', 'וְֽ', 'וִֽ', 'וֵֽ', 'וֶֽ', 'וַֽ', 'וָֽ', 'כ', 'כְ', 'כִ', 'כֶ', 'כַ', 'כַֽ', 'כָ', 'כְּ', 'כְּֽ', 'כִּ', 'כִּֽ', 'כֵּ', 'כֵּֽ', 'כֶּ', 'כֶּֽ', 'כַּ', 'כַּֽ', 'כָּ', 'כָּֽ', 'כַּֽ', 'כָּֽ', 'ל', 'לְ', 'לְֽ', 'לְׄ', 'לֲ', 'לִ', 'לִֽ', 'לֵ', 'לֵֽ', 'לֶ', 'לֶֽ', 'לַ', 'לַֽ', 'לָ', 'לָֽ', 'לָׄ', 'לּ', 'לְּ', 'לִּ', 'לִּֽ', 'לֵּ', 'לֶּ', 'לַּ', 'לָּ', 'לָּֽ', 'לּֽ', 'לֽ', 'לְֽ', 'לִֽ', 'לֵֽ', 'לֶֽ', 'לַֽ', 'לָֽ', 'לִֽֿ', 'מ', 'מְ', 'מִ', 'מִֽ', 'מֵ', 'מֵֽ', 'מֶ', 'מֶֽ', 'מַ', 'מִּ', 'מֵּ', 'מֵֽ', 'ש', 'שְׁ', 'שֶׁ', 'שֶֽׁ', 'שַׁ', 'שָׁ', 'שֶּׁ', 'שֶּֽׁ', 'ב֖', 'בּ֥', 'לּ֥', 'הָ֠', 'הָֽ', 'הָ֣', 'בּ֑', 'ל֖', 'לִּ֥', 'לָ֑', 'לָ֚', 'לָ֔', 'לָ֖', 'וּ֠', 'הַ֨', 'בּ֖', 'בַ֣', 'וְ֠', 'מֵ֠', 'הַ֣', 'לָּ֣','לָּ֖', 'לִ֣', 'ל֤', 'לִּ֑', 'לִּ֔', 'לִ֖', 'ל֛', 'ל֣', 'וַ֠','ל֥', 'לִ֔', 'ל֔', 'לּ֖','לָ֧', 'ל֑','לָ֛', 'לְ֠', 'לָּ֔','ב֔', 'לִּ֣', 'לָ֣', 'בָּ֣', 'לִ֜', 'ל֗', 'לִ֑', 'ל֜', 'לָּ֨', 'לָ֜', 'לִּ֗', 'לִּ֤', 'בִּ֥','לִ֤', 'לִ֛');

$pppdef = array('in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'who or which or what or that or when or where or how or because or in order that', 'who or which or what or that or when or where or how or because or in order that', 'who or which or what or that or when or where or how or because or in order that', 'who or which or what or that or when or where or how or because or in order that', 'who or which or what or that or when or where or how or because or in order that', 'who or which or what or that or when or where or how or because or in order that', 'who or which or what or that or when or where or how or because or in order that', 'who or which or what or that or when or where or how or because or in order that','in or on', 'in or on', 'to or for', 'the', 'the', 'the', 'in or on', 'to or for','to or for','to or for', 'to or for','to or for','to or for', 'and','the', 'in or on', 'in or on', 'and', 'from','the','to or for','to or for','to or for','to or for','to or for','to or for','to or for','to or for','to or for', 'and', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'in or on', 'to or for', 'to or for', 'in or on', 'to or for', 'to or for', 'to or for','to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'in or on', 'to or for', 'to or for');

$sss = array('א', 'אָה', 'דִי', 'ה', 'הָ', 'הּ', 'הָּ', 'הֿ', 'הָא', 'הא', 'הֽוּ', 'הׄוּׄ', 'הו', 'הוּ', 'הוא', 'הוֹם', 'הֽוֹן', 'הוֹן', 'הון', 'הִי', 'הֵין', 'הֶֽם', 'הֶם', 'הַם', 'הֹֽם', 'הֹם', 'הֶּם', 'הֶֽם', 'הם', 'הֵמָה', 'הֵן', 'הֶֽן', 'הֶן', 'הְנָה', 'הֶֽנָה', 'ו', 'וֹ', 'וּ', 'וׄ', 'וּהִי', 'וּךְ', 'י', 'יַ', 'ידע', 'יָהּ', 'יהָ', 'יהֶם', 'יו', 'יונים', 'יךְ', 'ינה', 'ך', 'ךְ', 'ךָ', 'ךָֽ', 'ךָּ', 'כֵה', 'כָה', 'כָּה', 'כוֹן', 'כִי', 'כי', 'כֶֽם', 'כֶם', 'כֹם', 'כם', 'כֶֽן', 'כֶן', 'כֶֽנָה', 'כֶנָה', 'ם', 'מו', 'מוֹ', 'מוּ', 'ן', 'נ', 'נְ', 'נֶ', 'נַ', 'נָא', 'נא', 'נָה', 'נָּֽה', 'נָּה', 'נה', 'נְהֽוּ', 'נְהוּ', 'נּֽוּ', 'נּוּ', 'נׄוּׄ', 'נו', 'נוֹ', 'נוּ', 'נִֽי', 'נִי', 'נִּי', 'ני', 'נְךָּ', 'נְנִי','הוּ', 'הֶ֗ם', 'כֶ֥ם','כֶ֜ם', 'ךָ֥', 'הֶם֙', 'כֶ֣ם', 'כֶ֑ם', 'הֶ֔ם', 'הֶ֖ם', 'ךָ֔', 'ךָ֣', 'ךָ֙', 'ךָ֖', 'ךְ֙', 'ךָ֒', 'הֶ֑ן', 'ם֙', 'נוּ֙', 'הֶ֑ם', 'נִ֥י', 'נִי֩', 'וֹ֙', 'ךָ֗', 'ךָ֛', 'הֶ֛ם', 'כֶ֤ם', 'כֶם֙', 'כֶ֖ם', 'י֙', 'כֶ֔ם', 'כָ֥ה', 'כָ֞ה', 'ו֙', 'הֶ֤ם', 'וְ', 'הּ֙', 'כָ֖ה', 'הֶ֧ם','וֹ֒', 'ךָ֨', 'כֶ֛ם', 'הָ֙','ךָ֤', 'ךָ֜', 'ה֙', 'הֶ֔ן', 'הֶ֛ן', 'הֶ֖ן', 'כֶ֗ם');

$sssdef = array('א', 'her or it;her or its', 'דִי', 'her or it;her or its', 'her or it;her or its', 'her or it;her or its', 'her or it;her or its', 'her or it;her or its', 'her or it;her or its', 'her or it;her or its', 'him or it;his or its', 'him or it;his or its', 'him or it;his or its', 'him or it;his or its', 'him;it', 'הוֹם', 'הֽוֹן', 'הוֹן', 'הון', 'הִי', 'הֵין', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'הְנָה', 'הֶֽנָה', 'him or it;his or its', 'him or it;his or its', 'him or it;his or its', 'him or it;his or its', 'וּהִי', 'you;your', 'me;my', 'יַ', 'ידע', 'her or it;her or its', 'her or it;her or its', 'them;their', 'יו', 'יונים', 'you;your', 'them;their', 'you;your', 'you;your', 'you;your', 'you;your', 'you;your', 'you;your', 'you;your', 'כוֹן', 'כִי', 'כי', 'you;your', 'you;your', 'you;your', 'you;your', 'you;your', 'you;your', 'כֶֽנָה', 'כֶנָה', 'them;their', 'them;their', 'him or it;his or its', 'him or it;his or its', 'them;their', 'נ', 'נְ', 'me;my', 'נַ', 'נָא', 'נא', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'us;our', 'him or it;his or its', 'us;our', 'you','him or it;his or its','him or it;his or its', 'us;our', 'me;my', 'me;my', 'me;my', 'me;my', 'you;your', 'נְנִי','him or it;his or its', 'them;their', 'you;your','you;your','you;your', 'them;their', 'you;your', 'you;your', 'them;their', 'them;their', 'you;your', 'you;your', 'you;your', 'you;your', 'you;your', 'you;your', 'them;their', 'them;their', 'us;our', 'them;their', 'me;my', 'me;my', 'him or it;his or its', 'you;your', 'you;your', 'them;their', 'you;your', 'you;your', 'you;your', 'me;my', 'you;your', 'you','you','him or it;his or its', 'them;their','him or it;his or its','her or it;her or its', 'you;your', 'them;their','him or it;his or its', 'you;your', 'you;your', 'her or it;her or its', 'you;your', 'you;your','her or it;her or its', 'them;their', 'them;their', 'them;their', 'you;your');

/*
    $combine = array_combine($sss, $sssdef);

    $html = "<table>";
    $html .= "<tr><td>Sl.No</td><td>sss</td><td>sssdef</td></tr>";
    $i = 1;
    foreach ($combine as $sss =>  $sssdef):

        $html .= "<tr>";
        $html .= "<td>".$i."</td>";
        $html .= "<td>".$sss."</td>";
        $html .= "<td>".$sssdef."</td>";
        $html .= "</tr>";

        $i++;
    endforeach;
    $html .= "</table>";

    echo $html;
*/

////////////////////////////////////////////////////////////////////////////////////////////////////////////

function DeterminePrefixSufix ($word, $pos, $strong) {

	$output_word = '';
	global $ppp;
	global $sss;

	//if there's only 1 prefix or suffix, determine if it's prefix or suffix then print out the verse
	if (substr_count($word, '/') == 1) {

		$prepre = strtok($word, '/');
		$sufsuf = substr(strrchr($word, '/'), 1);

		if (in_array($prepre, $ppp) && in_array($sufsuf, $sss)) {
			$output_word = '<td><div class="vcword">'.$sufsuf.'</div></td><td><div class="vcword">'.$prepre.'</div></td>';
		}
		elseif (in_array($prepre, $ppp)) {
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
	global $ppp;
	global $sss;
	
	$output_word = '';

	//if there's only 1 prefix or suffix, determine if it's prefix or suffix then print out the verse
	if (substr_count($word, '/') == 1) {

		$prepre = strtok($word, '/');
		$sufsuf = substr(strrchr($word, '/'), 1);
		$verb_addition = '';

//echo $prepre.'<br>';
//echo $sufsuf.'<br>';

		if (in_array($prepre, $ppp) && in_array($sufsuf, $sss)) {
			$output_word = '<td><span class="suf"><br>suf</span></td><td><span class="pre"><br>pre</span></td>';
		}
		elseif (in_array($prepre, $ppp)) {

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
			$sufsuf = DeterminePrefixSufix2($trimmed_word, $pos, $strong, $possorig);
			$output_word = '<td>'.$sufsuf.'</td>'.$firstpart;		
		}
//echo $prepre.'<br>'.$sufsuf.'<br>';
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

	global $ppp;
	global $sss;
	global $pppdef;
	global $sssdef;
	$output_word = '';

	//if there's only 1 prefix or suffix, determine if it's prefix or suffix then print out the verse
	if (substr_count($word, '/') == 1) {

		$prepre = strtok($word, '/');
		$sufsuf = substr(strrchr($word, '/'), 1);
		$sdkey = array_search($sufsuf, $sss);
		$pdkey = array_search($prepre, $ppp);
		$pdef = str_replace(" or ","<br>",$pppdef[$pdkey]);
		$sdef = str_replace(" or ","<br>",$sssdef[$sdkey]);

		if (in_array($prepre, $ppp) && in_array($sufsuf, $sss)) {
			$sdef = strtok($sssdef[$sdkey], ';');
			$output_word = '<td>'.$sdef.'</td><td>'.$pdef.'</td>';

		} elseif (in_array($prepre, $ppp)) {

			$output_word = '<td>'.$deffs.'</td><td>'.$pdef.'</td>';

		} else {

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
		$pdkey = array_search($prepre, $ppp);
		$pdef = str_replace(" or ","<br>",$pppdef[$pdkey]);	
		$trimmed_word = substr($word, strpos($word, "/") + 1);
		$sufsuf = DeterminePrefixSufix3($trimmed_word, $pos, $strong, $deffs);
		$output_word = '<td>'.$sufsuf.'</td><td>'.$pdef.'</td>';

	}

	//return the bible verse print out
	return $output_word;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>
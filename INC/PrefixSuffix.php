<?php

//prefix and suffixes

$ppp = array('בּ֡','בַּֽ֠','מִ֥','ב֞','לִ֞','ל֡','בָ֨','ל֕','לִּ֕','בָּ֜','מֵ֣','לִּ֨','ב֤','בַּ֣','וִ֣','לִ֗','בָ֤','וִ֠','לּ֜','לּ֧','וַ֥','בִּ֛','לִ֕','הֲ֠','לָּ֧','וָ֠','הֶ֨','בִ֣','בְ֠','כַ֣','בִ֨','וּ','וַֽ֠','מִ֨','בָּ֤','בָ֥','בִּ֗','ב֣','לָּ֤','לָ֤ׄ','בָּ֠','בְּ֠','הֶ֣','בָ֗','ב֗','בּ֤','ב֜','בָּ֛','ב֥','לִ֠','לָ֠','בִּ֖','וְֽ֠','לָ֦','וַ֣','לַ֠','לִּ֜','בִּ֑','בִ֔','בָּ֥','בּ֗','לָּ֥','בָ֜','בָ֛','כְּ֠','בִ֑','הָ֨','כַּ֠','בִּ֠','בַּ֠','בּ֛','לַ֨','ל֧','לּ֑','בָּ֗','ב֛','לּ֣','הַ֠','לּ֛','בָ֖','לּ֛','לּ֗','בַ֨','בָּ֔','מִ֠','בּ֜','בָ֑','בָּ֖','ב', 'בְ', 'בְֽ', 'בִ', 'בִֽ', 'בֵ', 'בֵֽ', 'בֶ', 'בֶֽ', 'בַ', 'בַֽ', 'בָ', 'בָֽ', 'בּ', 'בְּ', 'בְּֽ', 'בִּ', 'בִּֽ', 'בֵּ', 'בֵּֽ', 'בֶּ', 'בֶּֽ', 'בַּ', 'בַּֽ', 'בָּ', 'בָּֽ', 'בּֽ', 'בַּֽ', 'בָּֽ', 'בֽ', 'בָֽ', 'ה', 'הְֽ', 'הֲ', 'הֳ', 'הֶ', 'הֶֽ', 'הַ', 'הַֽ', 'הַׄ', 'הָ', 'הָֽ', 'הֶֽ', 'הַֽ', 'הָֽ', 'הְֽ', 'הֲ', 'הֲֽ', 'הֶ', 'הֶֽ', 'הַ', 'הַֽ', 'הֲֽ', 'הַֽ', 'הָֽ', 'הֲ‍ֽ', 'ו', 'וְ', 'וְֽ', 'וְׄ', 'וֲ', 'וִ', 'וִֽ', 'וֵ', 'וֵֽ', 'וֶ', 'וֶֽ', 'וַ', 'וַֽ', 'וַׄ', 'וָ', 'וָֽ', 'וּ', 'וִּ', 'וּֽ', 'וּׄ', 'וְֽ', 'וִֽ', 'וֵֽ', 'וֶֽ', 'וַֽ', 'וָֽ', 'כ', 'כְ', 'כִ', 'כֶ', 'כַ', 'כַֽ', 'כָ', 'כְּ', 'כְּֽ', 'כִּ', 'כִּֽ', 'כֵּ', 'כֵּֽ', 'כֶּ', 'כֶּֽ', 'כַּ', 'כַּֽ', 'כָּ', 'כָּֽ', 'כַּֽ', 'כָּֽ', 'ל', 'לְ', 'לְֽ', 'לְׄ', 'לֲ', 'לִ', 'לִֽ', 'לֵ', 'לֵֽ', 'לֶ', 'לֶֽ', 'לַ', 'לַֽ', 'לָ', 'לָֽ', 'לָׄ', 'לּ', 'לְּ', 'לִּ', 'לִּֽ', 'לֵּ', 'לֶּ', 'לַּ', 'לָּ', 'לָּֽ', 'לּֽ', 'לֽ', 'לְֽ', 'לִֽ', 'לֵֽ', 'לֶֽ', 'לַֽ', 'לָֽ', 'לִֽֿ', 'מ', 'מְ', 'מִ', 'מִֽ', 'מֵ', 'מֵֽ', 'מֶ', 'מֶֽ', 'מַ', 'מִּ', 'מֵּ', 'מֵֽ', 'ש', 'שְׁ', 'שֶׁ', 'שֶֽׁ', 'שַׁ', 'שָׁ', 'שֶּׁ', 'שֶּֽׁ', 'ב֖', 'בּ֥', 'לּ֥', 'הָ֠', 'הָֽ', 'הָ֣', 'בּ֑', 'ל֖', 'לִּ֥', 'לָ֑', 'לָ֚', 'לָ֔', 'לָ֖', 'וּ֠', 'הַ֨', 'בּ֖', 'בַ֣', 'וְ֠', 'מֵ֠', 'הַ֣', 'לָּ֣','לָּ֖', 'לִ֣', 'ל֤', 'לִּ֑', 'לִּ֔', 'לִ֖', 'ל֛', 'ל֣', 'וַ֠','ל֥', 'לִ֔', 'ל֔', 'לּ֖','לָ֧', 'ל֑','לָ֛', 'לְ֠', 'לָּ֔','ב֔', 'לִּ֣', 'לָ֣', 'בָּ֣', 'לִ֜', 'ל֗', 'לִ֑', 'ל֜', 'לָּ֨', 'לָ֜', 'לִּ֗', 'לִּ֤', 'בִּ֥','לִ֤', 'לִ֛', 'בָ֣', 'לָ֤','ל֞','לָ֥','לָ֗', 'לָּ֑', 'כִּ֠','לָ','וְ֭','בַּ֝','בְּ֭','בְּ֝','מִֽ֝','וְ֝','וּ֝','לְ֝','וּ֭','לִּ֖','לּ֔','לִ֨','לִ֥','ל֦','בִּ֤','בִּ֔','לִּ֛','לִּ֞','מִ֝','בְ֭','וַֽ֝','בִּ֭','וְֽ֭','וַ֝','וִֽ֭','וַ֭','לִֽ֝','מֵ֝','לָ֨','ל֨','בּ֣','ב֑','לָּ֛','בָּ֑','בָּ֨','בָ֔','בּ֔','וִ֥','הַֽ֠');

$pppdef = array('in or on','in or on','from', 'in or on','to or for','to or for','in or on','to or for','to or for','in or on','from','to or for','in or on','in or on','and','to or for','in or on','and','to or for','to or for','and','in or on','to or for','the','to or for','and','the','in or on','in or on','as or like or because','in or on','and','and','from','in or on','in or on','in or on','in or on','to or for','to or for','in or on','in or on','the','in or on','in or on','in or on','in or on','in or on','in or on','to or for','to or for','in or on','and','to or for','and','to or for','to or for','in or on','in or on','in or on','in or on','to or for','in or on','in or on','as or like or because','in or on','the','as or like or because','in or on','in or on','in or on','to or for','to or for','to or for','in or on','in or on','to or for','the','to or for','in or on','to or for','to or for','in or on','in or on','from','in or on','in or on','in or on','in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'in or on', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'the', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'and', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'as or like or because', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'from', 'who or which or what or that or when or where or how or because or in order that', 'who or which or what or that or when or where or how or because or in order that', 'who or which or what or that or when or where or how or because or in order that', 'who or which or what or that or when or where or how or because or in order that', 'who or which or what or that or when or where or how or because or in order that', 'who or which or what or that or when or where or how or because or in order that', 'who or which or what or that or when or where or how or because or in order that', 'who or which or what or that or when or where or how or because or in order that','in or on', 'in or on', 'to or for', 'the', 'the', 'the', 'in or on', 'to or for','to or for','to or for', 'to or for','to or for','to or for', 'and','the', 'in or on', 'in or on', 'and', 'from','the','to or for','to or for','to or for','to or for','to or for','to or for','to or for','to or for','to or for', 'and', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'in or on', 'to or for', 'to or for', 'in or on', 'to or for', 'to or for', 'to or for','to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'in or on', 'to or for', 'to or for', 'in or on', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'as or like or because', 'to or for', 'and', 'in or on', 'in or on', 'in or on', 'from', 'and', 'and', 'to or for', 'and', 'to or for', 'to or for', 'to or for', 'to or for', 'to or for', 'in or on', 'in or on', 'to or for', 'to or for', 'from', 'in or on', 'and', 'in or on', 'and', 'and', 'and', 'and','to or for', 'from','to or for','to or for', 'in or on', 'in or on', 'to or for', 'in or on', 'in or on', 'in or on', 'in or on', 'and', 'the');

$sss = array('כָ֖ה','כָּה','נוּ֩','הְנָה','נָּה֙','נִ֕י','הֶ֡ם','י֩','הֶ֞ם','הּ֮','הֶם֮','הָ֒','הֶ֨ם','ה֮','ן','הּ֩','נ֣וּ','מוֹ֙','דִ֑י','נְהוּ֙','נׄוּׄ֙','נׄוּׄ','הֵ֖ן','ךָ֡','כֶּ֔ם','ךָ֧','ן֮','כֶ֕ם','כֶ֧ם','ו֒','נוּ֮','ךָ֞','הֵ֑ן','כֶם֮','כֶ֞ם','הּ֒','כֶם֒','וֹ֩','ן֙','ן','ם֒','ם֮','נִ֧י','נָּה֮','הֶם֒','יַ','נִ֣י','נִ֨י','מוֹ','נְהוּ','הֶ֜ם','כָ֔ה','נּוּ','ן֙','כֶן֙','נּוּ','נּֽוּ','נִ֤י','הֶם֩','הֶ֥ם','כֶם֩','נּוּ֙', 'ן', 'הֶ֣ם','ן','נּוּ֩','כֶ֔ן','נָּה','א', 'אָה', 'דִי', 'ה', 'הָ', 'הּ', 'הָּ', 'הֿ', 'הָא', 'הא', 'הֽוּ', 'הׄוּׄ', 'הו', 'הוּ', 'הוא', 'הוֹם', 'הֽוֹן', 'הוֹן', 'הון', 'הִי', 'הֵין', 'הֶֽם', 'הֶם', 'הַם', 'הֹֽם', 'הֹם', 'הֶּם', 'הֶֽם', 'הם', 'הֵמָה', 'הֵן', 'הֶֽן', 'הֶן', 'הְנָה', 'הֶֽנָה', 'ו', 'וֹ', 'וּ', 'וׄ', 'וּהִי', 'וּךְ', 'י', 'יַ', 'ידע', 'יָהּ', 'יהָ', 'יהֶם', 'יו', 'יונים', 'יךְ', 'ינה', 'ך', 'ךְ', 'ךָ', 'ךָֽ', 'ךָּ', 'כֵה', 'כָה', 'כָּה', 'כוֹן', 'כִי', 'כי', 'כֶֽם', 'כֶם', 'כֹם', 'כם', 'כֶֽן', 'כֶן', 'כֶֽנָה', 'כֶנָה', 'ם', 'מו', 'מוֹ', 'מוּ', 'ן', 'נ', 'נְ', 'נֶ', 'נַ', 'נָא', 'נא', 'נָה', 'נָּֽה', 'נָּה', 'נה', 'נְהֽוּ', 'נְהוּ', 'נּֽוּ', 'נּוּ', 'נׄוּׄ', 'נו', 'נוֹ', 'נוּ', 'נִֽי', 'נִי', 'נִּי', 'ני', 'נְךָּ', 'נְנִי','הוּ', 'הֶ֗ם', 'כֶ֥ם','כֶ֜ם', 'ךָ֥', 'הֶם֙', 'כֶ֣ם', 'כֶ֑ם', 'הֶ֔ם', 'הֶ֖ם', 'ךָ֔', 'ךָ֣', 'ךָ֙', 'ךָ֖', 'ךְ֙', 'ךָ֒', 'הֶ֑ן', 'ם֙', 'נוּ֙', 'הֶ֑ם', 'נִ֥י', 'נִי֩', 'וֹ֙', 'ךָ֗', 'ךָ֛', 'הֶ֛ם', 'כֶ֤ם', 'כֶם֙', 'כֶ֖ם', 'י֙', 'כֶ֔ם', 'כָ֥ה', 'כָ֞ה', 'ו֙', 'הֶ֤ם', 'וְ', 'הּ֙', 'כָ֖ה', 'הֶ֧ם','וֹ֒', 'ךָ֨', 'כֶ֛ם', 'הָ֙','ךָ֤', 'ךָ֜', 'ה֙', 'הֶ֔ן', 'הֶ֛ן', 'הֶ֖ן', 'כֶ֗ם','י֮','י֒','כֶ֨ם','הֶן֙','ךְ֒','נִי֙','כָ֛ה','כָ֣ה','הוּ֙','ו֮','הֶ֗ן','וֹ֮','ךָ֮','ךָ֩');

$sssdef = array('it','it','us;our','them;their','her or it;her or its','me;my','them;their','me;my','them;their','her or it;her or its','them;their','her or it;her or its','them;their','her or it;her or its','them or you or there;their or your or there','her or it;her or its','us;our','them;their','me;my','him or it;his or its','us;our','us;our','them;their','you;your','you;your','you;your','them or you or there;their or your or there','you;your','you;your','him or it;his or its','us;our','you;your','them;their','you;your','you;your','her or it;her or its','you;your','him or it;his or its','them or you or there;their or your or there','them or you or there;their or your or there','them;their','them;their','me;my','her or it;her or its','them;their','me;my','me;my','me;my','them;their','him or it;his or its','them;their','you;your','him or it;his or its','them;their','you;your','us;our','us;our','me;my','them;their','them;their','you;your','him or it;his or its','them;their','them;their','you;your','him or it;his or its','you;your','her or it;her or its','א', 'her or it;her or its', 'דִי', 'her or it;her or its', 'her or it;her or its', 'her or it;her or its', 'her or it;her or its', 'her or it;her or its', 'her or it;her or its', 'her or it;her or its', 'him or it;his or its', 'him or it;his or its', 'him or it;his or its', 'him or it;his or its', 'him;it', 'הוֹם', 'הֽוֹן', 'הוֹן', 'הון', 'הִי', 'הֵין', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'הְנָה', 'הֶֽנָה', 'him or it;his or its', 'him or it;his or its', 'him or it;his or its', 'him or it;his or its', 'וּהִי', 'you;your', 'me;my', 'יַ', 'ידע', 'her or it;her or its', 'her or it;her or its', 'them;their', 'יו', 'יונים', 'you;your', 'them;their', 'you;your', 'you;your', 'you;your', 'you;your', 'you;your', 'you;your', 'you;your', 'כוֹן', 'because', 'because', 'you;your', 'you;your', 'you;your', 'you;your', 'you;your', 'you;your', 'כֶֽנָה', 'כֶנָה', 'them;their', 'them;their', 'him or it;his or its', 'him or it;his or its', 'them;their', 'נ', 'נְ', 'me;my', 'נַ', 'נָא', 'נא', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'them;their', 'us;our', 'him or it;his or its', 'him or it;his or its', 'him or it;his or its','him or it;his or its','him or it;his or its', 'us;our', 'me;my', 'me;my', 'me;my', 'me;my', 'you;your', 'נְנִי','him or it;his or its', 'them;their', 'you;your','you;your','you;your', 'them;their', 'you;your', 'you;your', 'them;their', 'them;their', 'you;your', 'you;your', 'you;your', 'you;your', 'you;your', 'you;your', 'them;their', 'them;their', 'us;our', 'them;their', 'me;my', 'me;my', 'him or it;his or its', 'you;your', 'you;your', 'them;their', 'you;your', 'you;your', 'you;your', 'me;my', 'you;your', 'you','you','him or it;his or its', 'them;their','him or it;his or its','her or it;her or its', 'you;your', 'them;their','him or it;his or its', 'you;your', 'you;your', 'her or it;her or its', 'you;your', 'you;your','her or it;her or its', 'them;their', 'them;their', 'them;their', 'you;your', 'me;my', 'me;my', 'you;your', 'them;their', 'you;your', 'me;my', 'you;your', 'you;your', 'him or it;his or its', 'him or it;his or its', 'them;their', 'him or it;his or its', 'you;your', 'you;your');

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

function DeterminePrefixSufix2 ($word, $pos, $strong, $possorig, $pre_org) {

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
				$verb_addition = DetermineVerbPGN($vw_word, $strong, $word, $prepre);
			}

			$output_word = '<td><a href="HebrewStrong.php?id='.$strong.'">'.$strong.'</a><br><span class="'.$pos.'">'.$possorig.$verb_addition.'</span></td><td><span class="pre"><br>pre</span></td>';
		}
		else {

			//--------------------Verb---------------------------//	
			if ($pos == 'v') {
				$vw_key = array_search($strong, $v_ids);
				$vw_word = $v_words[$vw_key];
				$verb_addition = DetermineVerbPGN($vw_word, $strong, $word,$pre_org);
			}

			$output_word = '<td><span class="suf"><br>suf</span></td><td><a href="HebrewStrong.php?id='.$strong.'">'.$strong.'</a><br><span class="'.$pos.'">'.$possorig.$verb_addition.'</span></td>';

		}
	}

	//if there are 2 prefix or suffix, that means there's a prefix / word / suffix, print out accordingly in order
	elseif (substr_count($word, '/') == 2) {

		$prepre = strtok($word, '/');

		if (in_array($prepre, $ppp)) {
			$trimmed_word = substr($word, strpos($word, "/") + 1);
			$sufsuf = DeterminePrefixSufix2($trimmed_word, $pos, $strong, $possorig, $prepre);
			$output_word = $sufsuf.'<td><span class="pre"><br>pre</span></td>';
		}
		else {
			$firstpart = DeterminePrefixSufix2($prepre, $pos, $strong, $possorig,'NA');
			$trimmed_word = substr($word, strpos($word, "/") + 1);
			$sufsuf = DeterminePrefixSufix2($trimmed_word, $pos, $strong, $possorig,'NA');
			$output_word = '<td>'.$sufsuf.'</td>'.$firstpart;		
		}
//echo $prepre.'<br>'.$sufsuf.'<br>';
	}

	//if there are more than 2 prefix or suffix, then repeat this function
	elseif (substr_count($word, '/') > 2) {
		$prepre = strtok($word, '/');
		$trimmed_word = substr($word, strpos($word, "/") + 1);
		$sufsuf = DeterminePrefixSufix2($trimmed_word, $pos, $strong, $possorig,$prepre);
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
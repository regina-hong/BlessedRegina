<?php 
function DeterminePrefixSufix ($word, $pos, $strong) {

	$output_word = '';
	//prefix and suffixes
$ppp = array('ב', 'בְ', 'בְֽ', 'בִ', 'בִֽ', 'בֵ', 'בֵֽ', 'בֶ', 'בֶֽ', 'בַ', 'בַֽ', 'בָ', 'בָֽ', 'בּ', 'בְּ', 'בְּֽ', 'בִּ', 'בִּֽ', 'בֵּ', 'בֵּֽ', 'בֶּ', 'בֶּֽ', 'בַּ', 'בַּֽ', 'בָּ', 'בָּֽ', 'בּֽ', 'בַּֽ', 'בָּֽ', 'בֽ', 'בָֽ', 'ה', 'הְֽ', 'הֲ', 'הֳ', 'הֶ', 'הֶֽ', 'הַ', 'הַֽ', 'הַׄ', 'הָ', 'הָֽ', 'הֶֽ', 'הַֽ', 'הָֽ', 'הְֽ', 'הֲ', 'הֲֽ', 'הֶ', 'הֶֽ', 'הַ', 'הַֽ', 'הֲֽ', 'הַֽ', 'הָֽ', 'הֲ‍ֽ', 'ו', 'וְ', 'וְֽ', 'וְׄ', 'וֲ', 'וִ', 'וִֽ', 'וֵ', 'וֵֽ', 'וֶ', 'וֶֽ', 'וַ', 'וַֽ', 'וַׄ', 'וָ', 'וָֽ', 'וּ', 'וִּ', 'וּֽ', 'וּׄ', 'וְֽ', 'וִֽ', 'וֵֽ', 'וֶֽ', 'וַֽ', 'וָֽ', 'כ', 'כְ', 'כִ', 'כֶ', 'כַ', 'כַֽ', 'כָ', 'כְּ', 'כְּֽ', 'כִּ', 'כִּֽ', 'כֵּ', 'כֵּֽ', 'כֶּ', 'כֶּֽ', 'כַּ', 'כַּֽ', 'כָּ', 'כָּֽ', 'כַּֽ', 'כָּֽ', 'ל', 'לְ', 'לְֽ', 'לְׄ', 'לֲ', 'לִ', 'לִֽ', 'לֵ', 'לֵֽ', 'לֶ', 'לֶֽ', 'לַ', 'לַֽ', 'לָ', 'לָֽ', 'לָׄ', 'לּ', 'לְּ', 'לִּ', 'לִּֽ', 'לֵּ', 'לֶּ', 'לַּ', 'לָּ', 'לָּֽ', 'לּֽ', 'לֽ', 'לְֽ', 'לִֽ', 'לֵֽ', 'לֶֽ', 'לַֽ', 'לָֽ', 'לִֽֿ', 'מ', 'מְ', 'מִ', 'מִֽ', 'מֵ', 'מֵֽ', 'מֶ', 'מֶֽ', 'מַ', 'מִּ', 'מֵּ', 'מֵֽ', 'ש', 'שְׁ', 'שֶׁ', 'שֶֽׁ', 'שַׁ', 'שָׁ', 'שֶּׁ', 'שֶּֽׁ', 'ב֖', 'בּ֥', 'לּ֥', 'הָ֠', 'הָֽ', 'הָ֣', 'בּ֑', 'ל֖', 'לִּ֥', 'לָ֑', 'לָ֚', 'לָ֔', 'לָ֖', 'וּ֠', 'הַ֨', 'בּ֖', 'בַ֣', 'וְ֠');

$sss = array('א', 'אָה', 'דִי', 'ה', 'הָ', 'הּ', 'הָּ', 'הֿ', 'הָא', 'הא', 'הֽוּ', 'הׄוּׄ', 'הו', 'הוּ', 'הוא', 'הוֹם', 'הֽוֹן', 'הוֹן', 'הון', 'הִי', 'הֵין', 'הֶֽם', 'הֶם', 'הַם', 'הֹֽם', 'הֹם', 'הֶּם', 'הֶֽם', 'הם', 'הֵמָה', 'הֵן', 'הֶֽן', 'הֶן', 'הְנָה', 'הֶֽנָה', 'ו', 'וֹ', 'וּ', 'וׄ', 'וּהִי', 'וּךְ', 'י', 'יַ', 'ידע', 'יָהּ', 'יהָ', 'יהֶם', 'יו', 'יונים', 'יךְ', 'ינה', 'ך', 'ךְ', 'ךָ', 'ךָֽ', 'ךָּ', 'כֵה', 'כָה', 'כָּה', 'כוֹן', 'כִי', 'כי', 'כֶֽם', 'כֶם', 'כֹם', 'כם', 'כֶֽן', 'כֶן', 'כֶֽנָה', 'כֶנָה', 'ם', 'מו', 'מוֹ', 'מוּ', 'ן', 'נ', 'נְ', 'נֶ', 'נַ', 'נָא', 'נא', 'נָה', 'נָּֽה', 'נָּה', 'נה', 'נְהֽוּ', 'נְהוּ', 'נּֽוּ', 'נּוּ', 'נׄוּׄ', 'נו', 'נוֹ', 'נוּ', 'נִֽי', 'נִי', 'נִּי', 'ני', 'נְךָּ', 'נְנִי','הוּ', 'הֶ֗ם', 'כֶ֥ם','כֶ֜ם', 'ךָ֥', 'הֶם֙', 'כֶ֣ם', 'כֶ֑ם', 'הֶ֔ם', 'הֶ֖ם', 'ךָ֔', 'ךָ֣', 'ךָ֙', 'ךָ֖', 'ךְ֙', 'ךָ֒', 'הֶ֑ן', 'ם֙', 'נוּ֙', 'הֶ֑ם', 'נִ֥י', 'נִי֩', 'וֹ֙', 'ךָ֗', 'ךָ֛', 'הֶ֛ם', 'כֶ֤ם', 'כֶם֙', 'כֶ֖ם');


	//if there's only 1 prefix or suffix, determine if it's prefix or suffix then print out the verse
	if (substr_count($word, '/') == 1) {

		$prepre = strtok($word, '/');
		$sufsuf = substr(strrchr($word, '/'), 1);

		if (in_array($prepre, $ppp)) {
			$output_word = $prepre.'<span class="'.$pos.'"><a href="HebrewStrong.php?id='.$strong.'">'.$sufsuf.'</a></span> ';
		}
		else {
			$output_word = '<span class="'.$pos.'"><a href="HebrewStrong.php?id='.$strong.'">'.$prepre.'</a></span>'.$sufsuf.' ';
		}
	}

	//if there are 2 prefix or suffix, that means there's a prefix / word / suffix, print out accordingly in order
	elseif (substr_count($word, '/') == 2) {

		$prepre = strtok($word, '/');

		if (in_array($prepre, $ppp)) {
			
			$trimmed_word = substr($word, strpos($word, "/") + 1);
			$sufsuf = DeterminePrefixSufix($trimmed_word, $pos, $strong);
			$output_word = $prepre.$sufsuf;

		}
		else {

			$firstpart = DeterminePrefixSufix($prepre, $pos, $strong);
			$trimmed_word = substr($word, strpos($word, "/") + 1);
			$sufsuf = DeterminePrefixSufix($prepre, $pos, $strong);
			$output_word = $firstpart.$sufsuf;		

		}
	}

	//if there are more than 2 prefix or suffix, then repeat this function
	elseif (substr_count($word, '/') > 2) {

		$prepre = strtok($word, '/');
		$trimmed_word = substr($word, strpos($word, "/") + 1);
		$sufsuf = DeterminePrefixSufix($trimmed_word, $pos, $strong);
		$output_word = $prepre.$sufsuf;

	}

	//return the bible verse print out
	return $output_word;
}
?>
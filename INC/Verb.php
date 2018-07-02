<?php

function DetermineVerbPGN($verb, $strong, $verb_actual) {

	global $ppp;
	global $sss;
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

//echo $verb.'<br>'.$verb_root.'<br>'.$strong.'<br>';

	//determine verb type
	if (($firstletter == 'ה' || $firstletter == 'ח') && $secondletter == 'י' && $thirdletter == 'ה') {
		$verb_type = 'Special<br>Haya';	
	} elseif ($secondletter == $thirdletter) {
		$verb_type = 'Weak<br>Geminate';	
	} elseif ($firstletter == 'א') {
		$verb_type = 'Weak<br>I-Aleph';	
	} elseif ($firstletter == 'נ' || $verb_root == 'לקח') {
		$verb_type = 'Weak<br>I-Nun';																			
	} elseif ($firstletter == 'י') {
		$verb_type = 'Weak<br>I-Yud';										
	} elseif ($thirdletter == 'ה') {
		$verb_type = 'Weak<br>III-He';		
	} elseif ($firstletter == 'ר' || $firstletter == 'ה' || $firstletter == 'ע' || $firstletter == 'ח') {
		$verb_type = 'Weak<br>I-Guttural';
	} elseif ($secondletter == 'ר' || $secondletter == 'ה' || $secondletter == 'ע' || $secondletter == 'ח') {
		$verb_type = 'Weak<br>II-Guttural';																		
	} elseif ($secondletter == 'ו' || $secondletter == 'י') {
		$verb_type = 'Weak<br>Hollow';
	} else {
		$verb_type = 'Strong';								
	}

//echo 'verb actual  -  '.$verb_actual.'  prepre  -  '.$prepre.'<br>';

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
			$verb_pre = $prepre;
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

	$firstvowel_l = mb_substr($verb_actual_word,-1,1,'UTF-8');
	$secondvowel_l = mb_substr($verb_actual_word,-2,1,'UTF-8');
	$thirdvowel_l = mb_substr($verb_actual_word,-3,1,'UTF-8');
	$fourthvowel_l = mb_substr($verb_actual_word,-4,1,'UTF-8');
	$fifthvowel_l = mb_substr($verb_actual_word,-5,1,'UTF-8');

//echo $verb_actual_word.'<br>'.$verb_pre.'<br>';

	//determine verb tense

	if ($verb_pre == 'לְ' || $verb_pre == 'לִ' || $verb_pre == 'לֲ' || $verb_pre == 'לַֽ' || $verb_pre == 'לָ') {
		if ($firstletter_a == 'ה' && $firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ') {
			$verb_tense = 'Niphal/Inf Cs';
		} elseif ($firstletter_a == 'ה') {
			$verb_tense = 'Hiphil/Inf Cs';
		} elseif ($firstvowel_a == 'ַ' && $thirdvowel_a == 'ּ') {
			$verb_tense = 'Piel/Inf Cs';
		} else {
			$verb_tense = 'Qal/Inf Cs';
		}
	} elseif ($verb_pre == 'לֵ' || $verb_pre == 'לְ') {
		$verb_tense = 'Qal/Inf Abs';
	} elseif ($verb_pre == 'הָ') {
		$verb_tense = 'Qal/Act Part';
	}

	//-----------------------------------------------Strong verbs------------------------------------------------------
	elseif ($verb_type == 'Strong') {
		//verb has no prefix
		if (($firstletter == $firstletter_a) && ($firstletter_a <> $thirdvowel_a) && ($firstletter_a <> $secondvowel_a)) {
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
			} elseif ($firstletter_a == 'נ' && $firstvowel_a == 'ִ' && $thirdvowel_a == 'ְ' && ($fifthvowel_a == 'ְ' || $fourthvowel_l == 'ְ')) {
				$verb_tense = 'Qal/Cohortative';
				$verb_pgn = 'p';				
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Imperfect';
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperfect';
			} elseif ($firstvowel_a == 'ּ' && $secondvowel_a == 'ִ' && $fourthvowel_a == 'ּ' && $fifthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperfect';
			} elseif ($firstletter_a == 'נ' && $firstvowel_a == 'ִ') {
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
		if (($firstletter == $firstletter_a) && ($firstletter_a <> $thirdvowel_a) && ($firstletter_a <> $fourthvowel_a)) {
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
			} elseif ($firstvowel_a == 'ו' && $secondvowel_a == 'ֹ' && $fourthvowel_a == 'ֵ' ) {
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
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Perf/Imperative/Inf';
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
			} elseif ($firstvowel_a == 'ֵ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ֵ')) {
					$verb_tense = 'Piel/Perfect';
			} elseif ($firstvowel_a == 'ּ' && $secondvowel_a == 'ֹ') {
				if ($fourthvowel_a == 'ַ' || $fourthvowel_a == 'ְ') {
					$verb_tense = 'Pual/Perfect';
				} else {
					$verb_tense = 'Qal/Act Part';
				}
			} elseif ($firstvowel_a == 'ֹ' || $secondvowel_a == 'ֹ') {
				$verb_tense = 'Qal/Inf Abs';
			} elseif (($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֹ') || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ְ' && $fourthvowel_a == 'ֹ')) {
				$verb_tense = 'Qal/Inf Cs';
			} elseif ($firstvowel_a == 'ִ') {
				$verb_tense = 'Qal/Imperative';
			} else {
				$verb_tense = '';
			}

		//verb has prefix
		} elseif ($firstletter_a == 'ת' || $firstletter_a == 'י' || $firstletter_a == 'א' || $firstletter_a == 'נ') {
			if ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ָ') {
				$verb_tense = 'Piel/Imperfect';
			} elseif ($firstletter_a == 'נ' && $firstvowel_a == 'ִ' && $thirdvowel_a == 'ְ' && ($fifthvowel_a == 'ְ' || $fourthvowel_l == 'ְ')) {
				$verb_tense = 'Qal/Cohortative';
				$verb_pgn = 'p';	
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
			if ($firstvowel_a == 'ַ') {
				$verb_tense = 'Hiphil/Part';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ָ') {
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
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hiphil/Perfect';			
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
				$verb_tense = 'Qal/Imperative/Inf Cs';
			} elseif (($firstvowel_a == 'ֹ') || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ֹ') || ($firstvowel_a == 'ו'  && $secondvowel_a == 'ֹ') || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ו'  && $thirdvowel_a == 'ֹ')) {
				$verb_tense = 'Qal/Act Part';
			} elseif ($secondvowel_a == 'ֹ') {
				$verb_tense = 'Qal/Inf Abs';
			} else {
				$verb_tense = '';
			}

		//Imperative drops first letter
		} elseif ($firstletter_a == $secondletter && ($secondvowel_a == $thirdletter || $thirdvowel_a == $thirdletter)) {
			$verb_tense = 'Qal/Imperative';

		//verb has prefix
		} elseif ($firstletter_a == 'ת' || $firstletter_a == 'י' || $firstletter_a == 'א' || $firstletter_a == 'נ') {
			if ($firstvowel_a == 'ַ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ַ')) {
				$verb_tense = 'Hiphil/Imperfect';
			} elseif ($firstvowel_a == 'ֻ') {
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
		if ($firstletter_a == 'י' && ($secondvowel_a <> 'י' && $thirdvowel_a <> 'י')) {
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
			} elseif ($firstvowel_a == 'ִ' || $secondvowel_a == 'ִ') {
				$verb_tense = 'Qal/Imperfect';
			} elseif (($firstvowel_a == 'ֵ' || $thirdvowel_a == 'ֵ') || ($secondvowel_a == 'ֵ' || $fourthvowel_a == 'ֵ')) {
				$verb_tense = 'Qal/Imperfect';
				$verb_type = 'Weak<br>I-Waw';
			} else {
				$verb_tense = 'Qal/Perfect';
			}

		//I-Yud verb has yud as prefix
		} elseif ($firstletter_a == 'י' && ($secondvowel_a == 'י' || $thirdvowel_a == 'י')) {
			if ($firstvowel_a == 'ִ' || $secondvowel_a == 'ִ') {
				$verb_tense = 'Qal/Imperfect';
			} else {
				$verb_tense = 'Hiphil/Imperfect';
			}

		//I-Yud verb has dropped yud
		} elseif ($firstletter_a == $secondletter) {
				$verb_tense = 'Qal/Imperative';

		//verb has prefix			
		} elseif ($firstletter_a == 'ת' || $firstletter_a == 'א' || $firstletter_a == 'נ') {
			if ($firstletter_a == 'א' && $firstvowel_a == 'ִ' && $secondvowel_a == 'י') {
				$verb_tense = 'Qal/Imperfect';
			} elseif (($firstvowel_a == 'ּ' && $secondvowel_a == 'ו' && $thirdvowel_a == 'ֹ') || ($firstvowel_a == 'ו' && $secondvowel_a == 'ֹ')) {
				$verb_tense = 'Hiphil/Imperfect';
				$verb_type = 'Weak<br>I-Waw';
			} elseif (($firstvowel_a == 'ּ' && $secondvowel_a == 'ֵ') || ($firstvowel_a == 'ֵ')) {
				$verb_tense = 'Hiphil/Imperfect';
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
			} elseif ($firstletter_a == 'א') {
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
			} else {
				$verb_tense = 'Hiphil/Imperative';
				$verb_type = 'Weak<br>I-Waw';					
			}
		}
	}

//----------------------------------------------Special Haya verb----------------------------------------------------
	elseif ($verb_type == 'Special<br>Haya') {

		if ($verb_actual_word == 'יְהִי') {
			$verb_tense = 'Jussive/Qal/Imperfect';
		}

		//verb has no prefix
		elseif (($firstletter == $firstletter_a) && ($firstletter_a <> $thirdvowel_a)) {
			$verb_tense = 'Qal/Perfect';

		//verb has prefix
		} elseif ($firstletter_a == 'ת' || $firstletter_a == 'י' || $firstletter_a == 'א' || $firstletter_a == 'נ') {
				$verb_tense = 'Qal/Imperfect';
			}
	}


	//---------------------------------------------------III-He verbs------------------------------------------------
	elseif ($verb_type == 'Weak<br>III-He') {
		//verb has no prefix
		if (($firstletter == $firstletter_a) && ($firstletter_a <> $thirdvowel_a)) {
			if ($firstvowel_a == 'ָ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ָ') || $firstvowel_a == 'ֲ') {
				if ($thirdvowel_a == 'ֹ') {
					$verb_tense = 'Qal/Inf Abs';
				} elseif ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ֹ') {
					$verb_tense = 'Qal/Inf Cs';		
				} elseif ($thirdvowel_a == 'ֵ') {
					$verb_tense = 'Piel/Imperative';				
				} else {
					$verb_tense = 'Qal/Perfect';
				}
			} elseif ($firstvowel_a == 'ַ') {
				$verb_tense = 'Piel/Imperative';
			} elseif ($firstvowel_a == 'ִ') {
				if ($thirdvowel_a == 'ּ') {
					$verb_tense = 'Piel/Perfect';
				}
			} elseif (($firstvowel_a == 'ְ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ְ')) && ($thirdvowel_l <> 'ת' && $firstvowel_l <> 'י')) {
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
				$verb_tense = 'Qal/Perfect';
			}

		//verb has prefix
		} elseif ($firstletter_a == 'ת' || $firstletter_a == 'י' || $firstletter_a == 'א' || $firstletter_a == 'נ') {
			if ($firstvowel_a == 'ַ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ַ')) {
				$verb_tense = 'Hiphil/Imperfect';
			} elseif ($firstletter_a == 'נ' && $firstvowel_a == 'ִ' && $thirdvowel_a == 'ְ' & $fifthvowel_a == 'ֶ') {
				$verb_tense = 'Qal/Imperfect';				
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Imperfect';
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperfect';
			} elseif ($firstletter_a == 'נ' && ($thirdvowel_a == 'ְ' || $fourthvowel_a == 'ְ')) {
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
				$verb_tense = 'Hiphil/Perfect';				
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
		
//echo $verb_actual_word.'    '.$verb_root.'    '.$firstletter.'    '.$secondletter.'    '.$thirdletter.'<br>';
//echo $verb_actual_word.'    '.$verb_root.'    '.$firstvowel_a.'    '.$secondvowel_a.'    '.$thirdvowel_a.'<br>';

		if ($firstletter == $firstletter_a && $firstvowel_a == 'ו'  && $secondvowel_a == 'ֹ' && $thirdletter == $thirdvowel_a) {
			$verb_tense = 'Qal/Inf Abs';
		}

		//verb has no prefix
		elseif (($firstletter == $firstletter_a) && ($firstletter_a <> $thirdvowel_a)) {
			if ($firstvowel_a == 'ָ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ָ') || $firstvowel_a == 'ֲ' || $firstvowel_a == 'ֵ' || $firstvowel_a == 'ַ') {
				if ($firstvowel_a == 'ו'  && $secondvowel_a == 'ּ') {
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
				$verb_tense = 'Qal/Imperative/Act Part';
			} elseif ($firstvowel_a == 'ֻ') {
				if ($thirdvowel_a == 'ּ' && $fourthvowel_a == 'ֹ') {
					$verb_tense = 'Pual/Inf Abs';
				} else {
					$verb_tense = 'Pual/Perfect';
				}
			} elseif ($secondvowel_a == 'ֹ') {
				$verb_tense = 'Qal/Inf Abs';
			} elseif ($firstvowel_a == 'ו'  && ($secondvowel_a == 'ּ' || $secondvowel_a == 'ֹ')) {
				$verb_tense = 'Qal/Inf';
			} else {
				$verb_tense = '';
			}

		//verb has prefix
		} elseif ($firstletter_a == 'ת' || $firstletter_a == 'י' || $firstletter_a == 'א' || $firstletter_a == 'נ') {
			if ($firstvowel_a == 'ַ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ַ')) {
				$verb_tense = 'Hiphil/Imperfect';
			} elseif ($firstletter_a == 'נ' && $firstvowel_a == 'ָ' && $thirdvowel_a == 'ו' && $fourthvowel_a == 'ּ') {
				$verb_tense = 'Qal/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ַ') {
				$verb_tense = 'Piel/Imperfect';
			} elseif ($firstvowel_a == 'ְ' && $thirdvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Imperfect';
			} elseif ($firstvowel_a == 'ִ' && $thirdvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Imperfect';
			} elseif ($firstletter_a == 'נ' && ($firstvowel_a == 'ָ' || $firstvowel_a == 'ְ')) {
				$verb_tense = 'Niphal/Perfect';
			} elseif ($firstletter_a == 'נ' && $fifthvowel_a == 'ָ') {
				$verb_tense = 'Niphal/Part';
			} elseif ($firstletter_a == 'נ' && ($fifthvowel_a == 'ֹ' || ($fifthvowel_a == 'ו'))) {
				$verb_tense = 'Niphal/Inf';
			} elseif ($thirdvowel_a == 'ֻ' || $fourthvowel_a == 'ֻ') {
				$verb_tense = 'Pual/Imperfect';
			} else {
				$verb_tense = 'Qal/Imperfect';
			}
		} elseif ($firstletter_a == 'מ') {
			if ($firstvowel_a == 'ֵ') {
				$verb_tense = 'Hiphil/Act Part';
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
			} elseif ($firstvowel_a == 'ֵ' || $firstvowel_a == 'ֲ') {
				$verb_tense = 'Hiphil/Perfect';				
			} elseif ($firstvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Perf/Inf';				
			} elseif ($firstvowel_a == 'ִ' && $secondvowel_a == 'ת' && $thirdvowel_a == 'ְ') {
				$verb_tense = 'Hithpael/Perf/Imperative/Inf';
			}	
		}
	}

	//---------------------------------------------Geminate verbs----------------------------------------------
	elseif ($verb_type == 'Weak<br>Geminate') {
		//verb has no prefix
		if (($firstletter == $firstletter_a) && ($firstletter_a <> $thirdvowel_a)) {
			if ($firstvowel_a == 'ָ' || ($firstvowel_a == 'ּ' && $secondvowel_a == 'ָ') || $firstvowel_a == 'ֲ' || $firstvowel_a == 'ַ') {
				if ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ּ') {
					$verb_tense = 'Qal/Pass Part';
				} elseif (($thirdvowel_a == 'ֹ') || ($thirdvowel_a == 'ו'  && $fourthvowel_a == 'ֹ')) {
					$verb_tense = 'Qal/Inf Abs';
				} else {
					$verb_tense = 'Qal/Perfect';
				}
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
			if ($firstvowel_a == 'ו' && $secondvowel_a == 'ּ' && $fourthvowel_a == 'ַ') {
				$verb_tense = 'Hophal/Perfect/Inf Cs';
			} elseif ($firstvowel_a == 'ו' && $secondvowel_a == 'ּ' && $fourthvowel_a == 'ָ') {
				$verb_tense = 'Hophal/Pass Part';
			} elseif ($firstvowel_a == 'ַ') {
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

		if ($verb_type == 'Weak<br>III-He') {
			if ($firstvowel_l == 'ם' && $secondvowel_l == 'ֶ' && $thirdvowel_l == 'ת') {
				$verb_pgn = '2.m.p';
			} elseif ($firstvowel_l == 'ן' && $secondvowel_l == 'ֶ' && $thirdvowel_l == 'ת') {
				$verb_pgn = '2.f.p';
			} elseif ($firstvowel_l == 'ה' && $secondvowel_l == 'ָ' && $thirdvowel_l == 'ת') {
				$verb_pgn = '3.f.s';			
			} elseif ($firstvowel_l == 'ּ' && $secondvowel_l == 'ו' && $thirdvowel_l == 'נ') {
				$verb_pgn = '1.c.p';	
			} elseif ($firstvowel_l == 'ּ' && $secondvowel_l == 'ו') {
				$verb_pgn = '3.c.p';	
			} elseif ($firstvowel_l == 'י' && $thirdletter <> 'י') {
				$verb_pgn = '1.c.s';	
			} elseif ($firstvowel_l == 'ָ' && $secondvowel_l == 'ת') {
				$verb_pgn = '2.m.s';	
			} elseif ($firstvowel_l == 'ת' && $secondvowel_l == 'י') {
				$verb_pgn = '2.f.s';	
			} else {
				$verb_pgn = '3.m.s';
			}	
		} else {
			if ($firstvowel_l == 'ם' && $secondvowel_l == 'ֶ' && $thirdvowel_l == 'ּ' && $fourthvowel_l == 'ת') {
				$verb_pgn = '2.m.p';
			} elseif ($firstvowel_l == 'ן' && $secondvowel_l == 'ֶ' && $thirdvowel_l == 'ּ' && $fourthvowel_l == 'ת') {
				$verb_pgn = '2.f.p';
			} elseif ($firstvowel_l == 'ה' && $verb_root <> 'היה') {
				$verb_pgn = '3.f.s';			
			} elseif ($firstvowel_l == 'ּ' && $secondvowel_l == 'ו' && $thirdvowel_l == 'נ') {
				$verb_pgn = '1.c.p';	
			} elseif ($firstvowel_l == 'ּ' && $secondvowel_l == 'ו') {
				$verb_pgn = '3.c.p';	
			} elseif ($firstvowel_l == 'י' && $thirdletter <> 'י' && $verb_type <> 'Special<br>Haya') {
				$verb_pgn = '1.c.s';	
			} elseif ($firstvowel_l == 'ָ' && $secondvowel_l == 'ּ' && $thirdvowel_l == 'ת') {
				$verb_pgn = '2.m.s';	
			} elseif ($firstvowel_l == 'ְ' && $secondvowel_l == 'ּ' && $thirdvowel_l == 'ת') {
				$verb_pgn = '2.f.s';	
			} else {
				$verb_pgn = '3.m.s';
			}			
		}



	} elseif (substr_count($verb_tense, 'Imperfect') > 0) {

		if ($firstvowel_l == 'י' && $secondvowel_l == 'ִ' && ($verb_type == 'Weak<br>I-Yud' || $verb_type == 'Weak<br>I-Waw')) {
			$verb_pgn = '2.f.s';
		} elseif ($firstvowel_l == 'ה' && $firstletter_a == 'ת' && $thirdletter <> 'ה') {
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

	} elseif (substr_count($verb_tense, 'Jussive') > 0) {
		$verb_pgn = '3.p';

	}

	//final output
	$output_verb = '<br>'.$verb_type.'<br>root '.$verb_root.'<br>'.$verb_tense.'<br>'.$verb_pgn;

	return $output_verb;

}

?>
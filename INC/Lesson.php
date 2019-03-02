<?php

if (($book = 'Gen' && $chapter = '1') || ($book = '' && $chapter = '')) {
	echo '<button onclick="Lesson1()" class="btn btn-primary">Learn Genesis Chapter 1 in Hebrew in 31 days (Beginner)</button>';
} elseif ($book = 'Gen' && $chapter = '2') {
	echo '<button onclick="Lesson2()" class="btn btn-primary">Learn Genesis Chapter 2 in Hebrew in 25 days (Intermediate)</button>';
}

?>
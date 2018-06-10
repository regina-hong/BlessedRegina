$(function(){

  // Upon selecting Book, it should redirect to Chapter 1 of that book
  $('#dynamic_select_book').on('change', function () {
      var url = "AncientBiblicalHebrewGrammarStudy.php?book=" + $(this).val() + "&chapter=1";
      if (url) { // require a URL
          window.location = encodeURI(url); // redirect
      }
      return false;
  });

  // Upon selecting Chapter, it should redirect to all verses of that chapter
  $('#dynamic_select_chapter').on('change', function () {
      var book = $('#dynamic_select_book').find(":selected").val();
      var url = "AncientBiblicalHebrewGrammarStudy.php?" + "&book=" + book + "&chapter=" + $(this).val();
      if (url) { // require a URL
          window.location = encodeURI(url); // redirect
      }
      return false;
  });

  // Upon selecting Verse, it should redirect to the specific verses of that chapter
  $('#dynamic_select_verse').on('change', function () {
      var book = $('#dynamic_select_book').find(":selected").val();
      var chapter = $('#dynamic_select_chapter').find(":selected").val();
      var url = "AncientBiblicalHebrewGrammarStudy.php?" + "&book=" + book + "&chapter=" + chapter + "&verse=" + $(this).val() ;
      if (url) { // require a URL
          window.location = encodeURI(url); // redirect
      }
      return false;
  });

});
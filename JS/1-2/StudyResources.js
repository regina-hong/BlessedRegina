$(function(){

  // Upon selecting Book, it should redirect to Chapter 1 of that book
  $('#dynamic_select_book').on('change', function () {
      var url = "StudyResources.php?book=" + $(this).val() + "&chapter=1";
      if (url) { // require a URL
          window.location = encodeURI(url); // redirect
      }
      return false;
  });

  // Upon selecting Chapter, it should redirect to all verses of that chapter
  $('#dynamic_select_chapter').on('change', function () {
      var book = $('#dynamic_select_book').find(":selected").val();
      var url = "StudyResources.php?" + "&book=" + book + "&chapter=" + $(this).val();
      if (url) { // require a URL
          window.location = encodeURI(url); // redirect
      }
      return false;
  });

});
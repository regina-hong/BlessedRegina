$(function(){

  // Upon selecting Book, it should redirect to Chapter 1 of that book
  $('#dynamic_select_book').on('change', function () {
      var url = "TheBibleColorCoded.php?book=" + $(this).val() + "&chapter=1";
      if (url) { // require a URL
          window.location = encodeURI(url); // redirect
      }
      return false;
  });

  // Upon selecting Chapter, it should redirect to all verses of that chapter
  $('#dynamic_select_chapter').on('change', function () {
      var book = $('#dynamic_select_book').find(":selected").val();
      var url = "TheBibleColorCoded.php?" + "&book=" + book + "&chapter=" + $(this).val();
      if (url) { // require a URL
          window.location = encodeURI(url); // redirect
      }
      return false;
  });

  // Upon selecting Verse, it should redirect to the specific verses of that chapter
  $('#dynamic_select_verse').on('change', function () {
      var book = $('#dynamic_select_book').find(":selected").val();
      var chapter = $('#dynamic_select_chapter').find(":selected").val();
      var url = "TheBibleColorCoded.php?" + "&book=" + book + "&chapter=" + chapter + "&verse=" + $(this).val() ;
      if (url) { // require a URL
          window.location = encodeURI(url); // redirect
      }
      return false;
  });

  // Upon entering Hebrew Word, send parameter
  $('#dynamic_select_word').on('change', function () {
      var url = "HebrewStrong.php?word=" + $(this).val();
      if (url) { // require a URL
          window.location = encodeURI(url); // redirect
      }
      return false;
  });

  // Upon selecting Strong's ID, send parameter
  $('#dynamic_select_id').on('change', function () {
      var url = "HebrewStrong.php?id=" + $(this).val();
      if (url) { // require a URL
          window.location = encodeURI(url); // redirect
      }
      return false;
  });

  // Upon selecting Definition, send parameter
  $('#dynamic_select_def').on('change', function () {
      var url = "HebrewStrong.php?def=" + $(this).val();
      if (url) { // require a URL
          window.location = encodeURI(url); // redirect
      }
      return false;
  });

  // Upon selecting Meaning, send parameter
  $('#dynamic_select_meaning').on('change', function () {
      var url = "HebrewStrong.php?meaning=" + $(this).val();
      if (url) { // require a URL
          window.location = encodeURI(url); // redirect
      }
      return false;
  });

});

function ShowHideEnglish(refid) {

    var x = document.getElementsByClassName(refid);

    if (x[0].style.color == 'grey') {
      
      for (var i=0;i<x.length;i+=1){
        x[i].style.color = 'white';
      }

    } else {

      for (var i=0;i<x.length;i+=1){
        x[i].style.color = 'grey';
      }

    }

}
$(function(){

  // Upon entering Hebrew Word, send parameter
  $('#dynamic_select_id').on('change', function () {
      var url = "Analysis.php?id=" + $(this).val();
      if (url) { // require a URL
          window.location = encodeURI(url); // redirect
      }
      return false;
  });

  // Upon selecting Strong's ID, send parameter
  $('#dynamic_select_vword').on('change', function () {
      var url = "Analysis.php?vword=" + $(this).val();
      if (url) { // require a URL
          window.location = encodeURI(url); // redirect
      }
      return false;
  });

  // Upon selecting Definition, send parameter
  $('#dynamic_select_cword').on('change', function () {
      var url = "Analysis.php?cword=" + $(this).val();
      if (url) { // require a URL
          window.location = encodeURI(url); // redirect
      }
      return false;
  });

});

function ShowHideReference(refid) {

    var x = document.getElementsByClassName(refid);

    if (x[0].style.display === 'none') {
      
      for (var i=0;i<x.length;i+=1){
        x[i].style.display = 'block';
      }

    } else {

      for (var i=0;i<x.length;i+=1){
        x[i].style.display = 'none';
      }

    }

}
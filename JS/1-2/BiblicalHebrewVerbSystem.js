$(function(){

  var root1 = '';
  var root2 = '';
  var root3 = '';

  // Upon selecting root1, it should show verb roots that start with this letter
  $('#dynamic_select_root_1').on('change', function () {
      var root1str =  $(this).val();
      root1 = root1str;
      $('tr[id^=root]').hide();
      $('tr[id*=root' + root1str + ']').show();
      return false;
  });

  // Upon selecting root2, it should show verb roots that contain with this letter
  $('#dynamic_select_root_2').on('change', function () {
      var root2str =  $(this).val();
      root2 = root2str;
      $('tr[id^=root]').hide();
      $('tr[id*=root' + root1 + root2str + ']').show();
      return false;
  });

  // Upon selecting root3, it should show verb roots that end with this letter
  $('#dynamic_select_root_3').on('change', function () {
      var root3str =  $(this).val();
      root3 = root3str;
      $('tr[id^=root]').hide();
      $('tr[id*=root' + root1 + root2 + root3str + ']').show();
      return false;
  });

});
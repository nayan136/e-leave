

$('.button').click(function(){

  $.ajax({
    url: '../super_admin/reset_year.php',
    type: 'post',
    data: { "reset_year": true},
    success: function(response) {
       //alert(response);
     window.location.replace("../super_admin/admin_list.php");

     },
     error: function(response) {
      alert("failed");
     }
  });


});

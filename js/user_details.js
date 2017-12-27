$("#button1").click(function cl_list(){
  var value = $('.ui.dropdown' ).dropdown('get value');
  var id = $('.hidden_id').val();
  var name = $('.hidden_name').val();

  $.ajax({
    url: '../super_admin/update_department.php',
    type: 'post',
    data: {
       "department": value,
       "user_id" : id
     },
    success: function(response) {

        var link = "../super_admin/user_details.php?user_id="+id +"&name="+name;
        window.location.replace(link);

     },
     error: function(response) {
      alert("failed");
     }
  });
});

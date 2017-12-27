$("#button1").click(function head_list(){
  $.ajax({
    url: '../report/superadmin_admin_list_report.php',
    success: function(response) {
      //window.location.replace("../admin/report.php");
     },
     error: function(response) {
      alert("failed");
     }
  });
});

$("#button2").click(function cl_list(){
  var value = $('.ui.dropdown' ).dropdown('get value');

  $.ajax({
    url: '../report/superadmin_report_dept_wise_list.php',
    type: 'post',
    data: { "department": value},
    success: function(response) {
      window.location.replace("../super_admin/report.php");
     },
     error: function(response) {
      alert("failed");
     }
  });
});

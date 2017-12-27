
var date1 ;

$('#rangestart').calendar({
  type: 'date',
  monthFirst: false,
  formatter: {
    date: function (date, settings) {

      if (!date) return '';
      var day = date.getDate();
      var month = date.getMonth() + 1;
      var year = date.getFullYear();
      date1 = year + '/' + month + '/' + day;
      return date1;
    }
  }
});


	$("#button1").click(function daily_report(){
    sendData();
	});

  $("#button2").click(function daily_report(){
    $.ajax({
      url: '../report/admin_report_user_cl_details.php',
      success: function(response) {
        //window.location.replace("../admin/report.php");
       },
       error: function(response) {
        alert("failed");
       }
    });
  });

  $("#button3").click(function history_report(){
    $.ajax({
      url: '../report/user_history_report.php',
      success: function(response) {
        //window.location.replace("../admin/report.php");
       },
       error: function(response) {
        alert("failed");
       }
    });
  });

  function sendData(){
		$.ajax({
	    url: '../report/admin_daily_absent_report.php',
	    type: 'post',
	    data: { "date": date1},
	    success: function(response) {
	    	//window.location.replace("../admin/report.php");
	     },
	     error: function(response) {
	     	alert("failed");
	     }
		});
	}

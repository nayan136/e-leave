$(document).ready(function(){

	var application_id;
	var status;
	var user_id;
	$("#approved .approved").click(function approve(){

		application_id = $(this).val();
		status = "approved";
		alert (application_id);
		//sendData();


	});

	// $("#rejected").click(function decline(){

	// 	application_id = $(this).val();
	// 	status = "rejected";
	// 	sendData();

	// });

	function sendData(){
		$.ajax({
	    url: '../admin/functions.php',
	    type: 'post',
	    data: { "application_id": application_id,"status": status},
	    success: function(response) { 
	    	window.location.replace("../admin/pending_application_new.php");
	     },
	     error: function(response) { 
	     	alert("failed"); 
	     }
		});
	}

});


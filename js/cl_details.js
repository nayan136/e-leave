 $(document).on('change','#selector',function(){
  //    $.ajax({
	 //  	url: '../admin/status_changed.php',
	 //    type: 'get',
	 //    data: {"status": $("#selector").val()},
	 //    success: function(response) {
	    	
	 //  }
 	// });
 	// $('.ui.dropdown').dropdown({
 	// 	onChange: function(){
 	// 		alert("change");
 	// 	}
 	// });
 	
 	//alert($("#selector").val());
 	value = $("#selector").val();
 	if(value == "all"){

 		link = "../admin/cl_details.php"
 	}else{
 		link = "../admin/status_changed.php?status="+value;
 	}
 	
 	 window.location.replace(link);
});
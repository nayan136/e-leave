	$(document).ready(function() {
		var holidaysByName=[];
		var holidaysByDate = [];

		function removeFromArray( position){
			holidaysByName.splice(position,1);
			holidaysByDate.splice(position,1);
			alert(holidaysByDate.length);
		};
		
		$('#calendar').fullCalendar({

			// height: auto,
			aspectRatio: 2,
			header:{
				left: 'prev,next today',
				center: 'title',
				right: ''
			},

			fixedWeekCount:false,
			businessHours: true,

			dayClick: function(date, view){
				//alert("a day has been clicked" + date.format());
				//alert('Current view: ' + view.name);
				if($(this).css('background-color') == "rgb(220, 20, 60)"){
					$(this).css('background-color', 'white');
					var position = $.inArray(date.format(),holidaysByDate );
					removeFromArray(position);
					 // $.each(holidaysByDate, function (index, value)  
		    //             {  		                     
		    //                 alert(value);  
		    //             }); 
					
				}else{
					$(this).css('background-color', 'rgb(220, 20, 60)');
					
					var holiday = prompt("Please enter holiday name:", "sdf");
				    if (holiday == null || holiday == "") {
				        $(this).css('background-color', 'white');

				    } else {
				        holidaysByName.push(holiday);
				        holidaysByDate.push(date.format());

				    }
				 	
				}
				
				
			}

		});

		
	});
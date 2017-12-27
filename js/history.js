$(document).ready(function(){

  var currentTime = new Date();
  var currentYear = currentTime.getFullYear();

  var link = "./application_history.php";
  function loadYears(){
    $.ajax({
          type: "POST",
          url: link,
          data: {
            'user': "user"
          },
          success: function(data) {
            // alert(data);
           var i = 0;
           var years = $.parseJSON(data);
           var size = Object.keys(years).length;
           var select = '<select id="dropdown_list">';
           $.each(years,function(){
             if(years[i] == currentYear){
               select += '<option selected="selected" value="'+years[i]+'">';
             }else{
               select += '<option value="'+years[i]+'">';
             }

             select += years[i] +'</option>';
             i++;
           })
           select += "</select>";
           $(".dropdown_year").html(select);
         }
    });
}

function loadApplications(year){

  $.ajax({
      type: 'POST',
      url: link,
      data:{
        'application': "application",
        'year': year
      },
      success: function(data){
        var array = $.parseJSON(data);
        var header = ['Check Time', 'Apply Time', 'Status', 'Details'];
        createTable(header, array);
      }
  });

}

function createTable(header,data){

   var table = '<table class="ui celled table">';
   var thead = '<thead><tr>';
   $.each(header, function(key, value){

     thead = thead + '<th>'+ value + '</th>';

   });
   thead = thead + '</tr></thead>';

   tbody = '<tbody>';
   $.each(data, function(){
     tbody = tbody + '<tr>';
     var check_time ='';
     if(this['admin_check_time'] == "Not Check"){
       tbody = tbody + '<td><div class="ui red ribbon label">'+ this['admin_check_time'] + '</div></td>';
     }else{
        tbody = tbody + '<td>'+ this['admin_check_time'] + '</td>';
     }
     tbody = tbody + '<td>'+ this['apply_time'] + '</td>';
     tbody = tbody + '<td>'+ this['status'] + '</td>';
     tbody = tbody + '<td>'+ '<a href="user_application_details.php?application_id='+this['id'] +'">details</a>' + '</td>';
     tbody = tbody + '</tr>';
   });
   tbody = tbody + '</tbody>';
   result = table + thead + tbody + '</table>';
   $(".application_table").html(result);
 };


  loadYears();
  loadApplications(currentYear);

  $(document).on('change','#dropdown_list', function () {
    var year = this.value;
    loadApplications(year);
  });


  $('.application_history').on('click', function(){
      var value = $('#dropdown_list').val();
      $.ajax({
            type: "POST",
            url: 'report/user_history_report.php',
            data: {
              'year': value
            },
            success: function(data) {

           }
      });
  });


});

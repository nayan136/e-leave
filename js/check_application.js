$(document).ready(function(){

  var link = "../super_admin/check.php";
  function loadApplicationInfo(application_id){
    $.ajax({
          type: "POST",
          url: link,
          data: {
            'application': application_id
          },
          success: function(data) {
            if(data == "error"){
              result = '<h3>Application Id format is incorrect</h3>';
              $(".application_table").html(result);
            }else{
              //alert(data.Groups.length);
              // var array = $.parseJSON(data);
               var obj = JSON.parse(data);
               //alert($.type(array));
              var header = ['Property','Details'];
              //var body = [array['check_time'], array['apply_time'], array['status'], array['id']];
              if(Object.keys(obj).length > 3){
                createTable(header, obj);
              }else{
                result = '<h3>Application Id is not present</h3>';
                $(".application_table").html(result);
              }
              }

            }
    });
  }


  function createTable(header,data){

    var property = ['Name', 'ip', 'Device', 'Cl Days', 'Starting Date', 'End Date', 'Shift', 'Apply Time', 'Admin Check Time', 'Status', 'Reason'];
    var details = ['full_name','ip','device', 'cl_days_leave', 'from_date', 'to_date', 'half_day', 'apply_time', 'admin_check_time', 'status', 'reason'];

    var table = '<table class="ui celled table">';
    var thead = '<thead><tr>';

    $.each(header, function(key, value){
      thead = thead + '<th>'+ value + '</th>';
    });

    thead = thead + '</tr></thead>';

    tbody = '<tbody>';
    $i=0;
    $.each(property, function(){
      tbody = tbody + '<tr>';
      tbody = tbody + '<td>'+ property[$i] + '</td>';
      if(data[details[5]] == "0000-00-00"){
        data[details[5]] = "";
      }

      if(data[details[8]] == "0000-00-00"){
        data[details[8]] = "Not Check";
      }

      tbody = tbody + '<td>'+ data[details[$i]] + '</td>';
      tbody = tbody + '</tr>';
      $i++;
    });
    tbody = tbody + '</tbody>';

    result = table + thead + tbody + '</table>';


     $(".application_table").html(result);

  }


  // method calling
  $(".button_search").click(function(){
    var application_id = $(".search_application").val();
    //alert(application_id);
    loadApplicationInfo(application_id);
  });



});



$("#search_name").click(function(){
  name = $(".search_name_text").val();
  if(name !=""){
     
        link = "../admin/check_all_users.php?name="+name;
         window.location.replace(link);
      }

});

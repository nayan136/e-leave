$(document).ready(function(){
  $('.ui.sidebar').sidebar({
      context: $('.bottom.segment')
    });
    // .sidebar('attach events', '#m_menu');

  $('#hide_sidebar').click(function(){
      $('#m_menu1').sidebar('toggle');
  })
})


  // $(window).resize(function() {
  // // Detect if the resized screen is mobile or desktop width
  //     if($(window).width() < 991) {
  //         // console.log('desktop');
  //         $('#m_menu').sidebar('hide');
  //     // }else if($(window).width() > 991){
  //     //   $('#m_menu').sidebar('visible');
  //     }
  //
  // });

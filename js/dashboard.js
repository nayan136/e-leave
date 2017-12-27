 // $('a.sidebar-toggle').click(function () {
 //    $('#sidebar').sidebar('toggle')
 //  })

 $('.ui.sidebar').sidebar({
     context: $('.bottom.segment')
   })
   .sidebar('attach events', '#m_menu');

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



// $('.ui.sidebar')
//   .sidebar({
//     context: $('#otherstuff')
//   })

// $(document).ready(function() {
// 	$(".ui.sidebar").sidebar({
//     	context: $('#otherstuff')
//     });

//     //$('a').click(function() { $('.ui.sidebar').sidebar('toggle'); });
//     $('a.sidebar-toggle').click(function () {
//     $('#sidebar').sidebar('toggle')
//   })
// });

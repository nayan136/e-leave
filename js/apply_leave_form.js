

// $('#rangestart').calendar({
//   type: 'date',
//   endCalendar: $('#rangeend')
// });
// $('#rangeend').calendar({
//   type: 'date',
//   startCalendar: $('#rangestart')
// });

$('.top.menu .item').tab();

// $('#rangestart, #rangeend').calendar({
//   type: 'date',
//   monthFirst: false,
//   formatter: {
//     date: function (date, settings) {
//       if (!date) return '';
//       var day = date.getDate();
//       var month = date.getMonth() + 1;
//       var year = date.getFullYear();
//       return year + '/' + month + '/' + day;
//     }
//   }
// });
var today = new Date();
//var date2 = moment(date).format('YYYY-MM-DD');

$('#rangestart, #rangestart1, #rangestart2').calendar({
  type: 'date',
  initialDate: null,
  monthFirst: false,  
  selector: {
    popup: '.ui.popup',
    input: 'input',
    activator: 'input'
  },
   popupOptions: {
      position: 'bottom left',
      lastResort: 'bottom left'
    },
  formatter: {
    date: function (date, settings) {
      if (!date) return '';
      var day = date.getDate();
      var month = date.getMonth() + 1;
      var year = date.getFullYear();
      return year + '/' + month + '/' + day;
    }
  },
  minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()-4),

  // maxDate: new Date(today.getFullYear(), today.getMonth(), today.getDate() )
});

$('#rangeend').calendar({
  type: 'date',
  startCalendar: $('#rangestart2'),
  initialDate: null,
  monthFirst: false,
  popupOptions: {
    position: 'bottom left',
    lastResort: 'bottom left'
  },
  formatter: {
    date: function (date, settings) {
      if (!date) return '';
      var day = date.getDate();
      var month = date.getMonth() + 1;
      var year = date.getFullYear();
      return year + '/' + month + '/' + day;
    }
  },
  //minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()-4),

    maxDate: new Date($('#rangestart2'))
});

$('.address.checkbox').checkbox({
  onChecked: function() {
    $('.contact').show(500);
  },
  onUnchecked: function() {
    $('.contact').hide(500);
  }
});

// $('form')
//   .form({
//     on: 'blur',
//     fields: {
//       from_date: {
//         identifier: 'from_date',
//         rules: [
//           {
//             type   : 'empty',
//             prompt : 'Please enter starting date'
//           }
//         ]
//       },
//       to_date: {
//         identifier: 'to_date',
//         rules: [
//           {
//             type   : 'empty',
//             prompt : 'Please enter end date'

//           }

//         ]
//       },

//         cl_days_leave: {
//         identifier: 'cl_days_leave',
//         rules: [
//           {
//             type   : 'empty',
//             prompt : 'Please enter numbers of days'

//           },
//           {
//             type  : 'integer[1..12]',
//             prompt: 'Please enter valid number'

//           }
//         ]
//       }

//         reason: {
//         identifier: 'reason',
//         rules: [
//           {
//             type   : 'empty',
//             prompt : 'Please enter purpose'

//           }
//         ]
//       }
//     }
//   })
// ;

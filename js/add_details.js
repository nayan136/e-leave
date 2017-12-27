$('form')
  .form({
    on: 'blur',
    fields: {
      email: {
        identifier: 'email',
        rules: [
          {
            type   : 'email',
            prompt : 'Please enter valid email'
          }
        ]
      },
      phone_number: {
        identifier: 'phone_number',
        rules: [
          {
            type   : 'length[10]',
            prompt : 'Your phone number should be 10 characters'

          },
          {
            type  :'integer',
            prompt: 'something wrong with the phone number'
          }
        ]
      }
    }
  })
;

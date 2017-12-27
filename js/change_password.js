$('form')
  .form({
    on: 'blur',
    fields: {
      new_password: {
        identifier: 'new_password',
        rules: [
          {
            type   : 'empty',
            prompt : 'Please enter your new password'
          }
        ]
      },
      confirm_password: {
        identifier: 'confirm_password',
        rules: [
          {
            type   : 'empty',
            prompt : 'Please enter confirm password'
        
          },
          {
            type  :'match[new_password]',
            prompt: 'confirm password is mismatch'
          }
        ]
      }
    }
  })
;
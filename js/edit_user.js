$('form')
  .form({
    on: 'blur',
    fields: {
      change_username: {
        identifier: 'change_username',
        rules: [
          {
            type   : 'empty',
            prompt : 'Please enter your username'
          }
        ]
      },
      change_password: {
        identifier: 'change_password',
        rules: [
          {
            type   : 'empty',
            prompt : 'Please enter a password'
        
          }
        ]
      },
      change_name: {
        identifier: 'change_name',
        rules: [
          {
            type   : 'empty',
            prompt : 'Please enter a password'
        
          }
        ]
      },
      change_designation: {
        identifier: 'change_designation',
        rules: [
          {
            type   : 'empty',
            prompt : 'Please enter a password'
        
          }
        ]
      }
    }
  })
;
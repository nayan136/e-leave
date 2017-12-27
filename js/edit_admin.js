$('form')
  .form({
    on: 'blur',
    fields: {
      edit_username: {
        identifier: 'edit_username',
        rules: [
          {
            type   : 'empty',
            prompt : 'Please enter your username'
          }
        ]
      },
      edit_password: {
        identifier: 'edit_password',
        rules: [
          {
            type   : 'empty',
            prompt : 'Please enter a password'
        
          }
        ]
      },
      edit_name: {
        identifier: 'edit_name',
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
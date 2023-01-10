function showpass(){ //เเสดง Password
  var pass = document.getElementById('password');
  if(pass.type == 'password'){
      pass.type = 'text';

  }else if(pass.type == 'text'){

      pass.type = 'password';
  }

}
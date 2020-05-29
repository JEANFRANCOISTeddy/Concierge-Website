function verif_mail(){

  const container = document.getElementById('errorEmail');
  const userEmail = document.getElementById('email').value;
  if( userEmail.indexOf('@') != -1 ){
    console.log('ok');
  }else{
    if( inputError ){
      const inputError = document.createElement('h6');
      inputError.innerHTML = 'Champs de saisis non valide';
      inputError.style.color = 'red';
      container.appendChild(inputError);
    }
  }

}

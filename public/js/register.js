function getErrorElement(input) {
  return input.parentElement.querySelector('.erro');
}

function removeAllSpaces(str) {
  return str.replace(/\s+/g, '');
}

function validateEmail(email) {
  let re = /\S+@\S+\.\S+/;
  return re.test(email);
}

//Verificações do submit

document.getElementById("form").addEventListener('submit', function(e){


    //variáveis
    let usernamein = document.getElementById("user")
    let emailin = document.getElementById("email")
    let senhain = document.getElementById("senha")
    let confirmin = document.getElementById("confirm")


    let usernameError = getErrorElement(usernamein);
    let emailError = getErrorElement(emailin);
    let senhaError = getErrorElement(senhain);
    let confirmError = getErrorElement(confirmin);
    let veri = true;

  //Tratando Username

    usernameError.textContent = "";

    let username = usernamein.value

    if(removeAllSpaces(username) == ""){
        usernameError.textContent = "Nome de usuário precisa estar preenchido!"
        veri = false
    }

  //Tratando Email

  emailError.textContent = ""

  let email = emailin.value

  email = email.trim()

  if (email == ""){
    emailError.textContent = "Email precisa estar preenchido!"
    veri = false
  }else if(!validateEmail(email)){
    emailError.textContent = "Email invalido!"
    veri = false
  }


  //Tratando senha

  senhaError.textContent = ""
  let senha = senhain.value


  if(removeAllSpaces(senha) == ""){
    senhaError.textContent = "Senha precisa estar preenchida com letras e números!"
    veri = false
  } else if(!/[a-zA-Z]/.test(senha)){
    senhaError.textContent = "Senha precisa possuir letras! Acentos não são permitidos"
    veri = false
  } else if(!/\d/.test(senha)){
    senhaError.textContent = "Senha precisa conter números!"
    veri = false
  }else if(/[\u00C0-\u017F]/.test(senha)){
    senhaError.textContent = "Senha não pode possuir acentos!"
    veri = false
  
  }


  //Tratando confirmação de senha

  confirmError.textContent = ""
  let confirm = confirmin.value

  if(confirm != senha){
    confirmError.textContent = "As senhas não batem, escreva novamente!"
    veri = false
  }

  console.log(veri)

  if(!veri){
    e.preventDefault()
  }

})
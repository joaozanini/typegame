function getErrorElement(input) {
  return input.closest('.form-group').querySelector('.erro');
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
    let usernamein = document.getElementById("username")
    let nicknamein = document.getElementById("nickname")
    let emailin = document.getElementById("email")
    let senhain = document.getElementById("senha")
    let confirmin = document.getElementById("password2")


    let usernameError = getErrorElement(usernamein);
    let nicknameError = getErrorElement(nicknamein)
    let emailError = getErrorElement(emailin);
    let senhaError = getErrorElement(senhain);
    let confirmError = getErrorElement(confirmin);
    let veri = true;

  //Tratando Username

    usernameError.textContent = "";

    let username = usernamein.value


    if(removeAllSpaces(username) == ""){
        usernameError.textContent = "Username needs to be filled!"
        veri = false
    }

    //Tratando nickname

    nicknameError.textContent = "";
    let nickname = nicknamein.value

    if(removeAllSpaces(nickname) == ""){
      nicknameError.textContent = "Nickname needs to be filled!"
      veri = false
    }


  //Tratando Email

  emailError.textContent = ""

  let email = emailin.value

  email = email.trim()

  if (email == ""){
    emailError.textContent = "Email needs to be filled!"
    veri = false
  }else if(!validateEmail(email)){
    emailError.textContent = "Invalid email!"
    veri = false
  }


  //Tratando senha

  senhaError.textContent = ""
  let senha = senhain.value
  

  if(removeAllSpaces(senha) == ""){
    senhaError.textContent = "Password needs to be filled with letters and numbers!"
    veri = false
  } else if(!/[a-zA-Z]/.test(senha)){
    senhaError.textContent = "Needs to contain letters, special characters like (', @, ~, etc...) are not allowed! "
    veri = false
  } else if(!/\d/.test(senha)){
    senhaError.textContent = "Needs to contain numbers!"
    veri = false
  }else if(/[\u00C0-\u017F]/.test(senha)){
    senhaError.textContent = "Special characters are not allowed!"
    veri = false
  }else if(senha.length < 8){
    senhaError.textContent = "Needs to have more than 8 characteres"
    veri=false
  }


  //Tratando confirmação de senha

  confirmError.textContent = ""
  let confirm = confirmin.value

  if(confirm != senha){
    confirmError.textContent = "Passwords do not match, try again!"
    veri = false
  }


  if(!veri){
    e.preventDefault()
  }

})

const senhaInput = document.getElementById("senha");
const confirmInput = document.getElementById("password2");
const eyeBtn = document.getElementById("show1")
const toggleConfirmBtn = document.getElementById("show2")

if (eyeBtn && senhaInput) {
  eyeBtn.addEventListener("mousedown", () => {
    senhaInput.type = "text";
  });

  eyeBtn.addEventListener("mouseup", () => {
    senhaInput.type = "password";
  });

  eyeBtn.addEventListener("mouseleave", () => {
    senhaInput.type = "password";
  });
}

if (toggleConfirmBtn && confirmInput) {
  toggleConfirmBtn.onmousedown = () => {
    confirmInput.type = "text";
  };

  toggleConfirmBtn.onmouseup = () => {
    confirmInput.type = "password";
  };

  toggleConfirmBtn.onmouseleave = () => {
    confirmInput.type = "password";
  };
}
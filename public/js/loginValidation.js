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
      let emailin = document.getElementById("email")
      let senhain = document.getElementById("senha")
  
      let emailError = getErrorElement(emailin);
      let senhaError = getErrorElement(senhain);
      let veri = true;

      
  
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
      senhaError.textContent = "Password needs to be filled!"
      veri = false
    }
  
    if(!veri){
      e.preventDefault()
    }
  
  })
  
  const senhaInput = document.getElementById("senha");
  const eyeBtn = document.getElementById("show1")
  
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

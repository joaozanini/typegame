function getErrorElement(input) {
    return input.closest('.form-group').querySelector('.erro');
  }
  
  function removeAllSpaces(str) {
    return str.replace(/\s+/g, '');
  }
  
  
  //Verificações do submit
  
  document.getElementById("form").addEventListener('submit', function(e){
  
  
      //variáveis
      let ligain = document.getElementById("liga")
      let senhain = document.getElementById("senha")
  
      let ligaError = getErrorElement(ligain);
      let senhaError = getErrorElement(senhain);
      let veri = true;

      
  
    //Tratando Liga
  
    ligaError.textContent = ""
  
    let liga = ligain.value
  
    liga = liga.trim()
  
    if (liga == ""){
      ligaError.textContent = "League needs to be filled!"
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
  
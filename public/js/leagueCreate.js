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
    let confirmin = document.getElementById("password2")


    let ligaError = getErrorElement(ligain);
    let senhaError = getErrorElement(senhain);
    let confirmError = getErrorElement(confirmin);
    let veri = true;

  //Tratando nome da liga

    ligaError.textContent = "";

    let liga = ligain.value


    if(removeAllSpaces(liga) == ""){
        ligaError.textContent = "League name needs to be filled!"
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

const commands = {
  ":game": game,
  ":profile": profile,
  ":leagues": league,
  ":help": help,
};




function game() {
  window.location.href = "game.php"
}

function profile() {
  window.location.href = "profile.php"
}

function league() {
  window.location.href = "league.php"
}


function help() {
  if (document.getElementById("helpOverlay")) return;

  const overlay = document.createElement("div");
  overlay.id = "helpOverlay";
  overlay.classList.add("help-overlay");

  const commandsList = document.createElement("div");
  commandsList.classList.add("help-commands");
  commandsList.innerHTML = `
    <h2>Available Commands</h2>
    <ul>
      <li><code>:game</code> — Goes to game page</li>
      <li><code>:leagues</code> — Goes to leagues page</li>
      <li><code>:profile</code> — Goes to profile page</li>    
      <li><code>:help</code> — Show this help</li>
    </ul>
  `;

  const closeBtn = document.createElement("button");
  closeBtn.textContent = "Close [Esc]";
  closeBtn.classList.add("help-close-btn");
  closeBtn.addEventListener("click", () => {
    document.body.removeChild(overlay);
  });

  overlay.appendChild(commandsList);
  overlay.appendChild(closeBtn);
  document.body.appendChild(overlay);

  function escClose(e) {
    if (e.key === "Escape") {
      if (document.getElementById("helpOverlay")) {
        document.body.removeChild(overlay);
        document.removeEventListener("keydown", escClose);
      }
    }
  }

  document.addEventListener("keydown", escClose);
}
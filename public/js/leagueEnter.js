function getErrorElement(input) {
    return input.closest('.form-group').querySelector('.erro');
  }
  
  function removeAllSpaces(str) {
    return str.replace(/\s+/g, '');
  }
  
let ligain = document.getElementById("liga")
let senhain = document.getElementById("senha")
  
function validateEnterLeague() {
  const ligain = document.getElementById("liga");
  const senhain = document.getElementById("senha");

  const ligaError = getErrorElement(ligain);
  const senhaError = getErrorElement(senhain);

  let veri = true;

  // Limpa mensagens de erro anteriores
  ligaError.textContent = "";
  senhaError.textContent = "";

  const liga = ligain.value.trim();
  const senha = senhain.value;

  // Verificação do nome da liga
  if (liga === "") {
    ligaError.textContent = "League needs to be filled!";
    veri = false;
  }

  // Verificação da senha
  if (removeAllSpaces(senha) === "") {
    senhaError.textContent = "Password needs to be filled!";
    veri = false;
  }

  return veri;
}

document.getElementById("form").addEventListener('submit', function(e){
  if (!validateEnterLeague()) {
    e.preventDefault();
  }
});


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

  const commands = {
  ":game": game,
  ":profile": profile,
  ":leagues": league,
  ":create": createleague,
  ":name": leagueName,
  ":password": passwordf,
  ":enterLeague": enterL,
  ":help": help,
};



function game() {
  window.location.href = "game.php"
}

function profile() {
  window.location.href = "profile.php"
}

function league(){
    window.location.href = "league.php"
}

function createleague(){
    window.location.href = "leagueCreate.php"
}

function leagueName(){
  ligain.focus();
}

function passwordf(){
  senhain.focus();
}


function enterL() {
  const logForm = document.getElementById("form");
  if (validateEnterLeague()) {
    logForm.requestSubmit();
  }
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
      <li><code>:create</code> — Create a league</li>
      <li><code>:name</code> — Focus on league name</li>
      <li><code>:password</code> — Focus on password</li>
      <li><code>:enterLeague</code> — Enter in the inserted league</li>
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
  
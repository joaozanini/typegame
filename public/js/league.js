const commands = {
  ":game": game,
  ":profile": profile,
  ":create": create,
  ":help": help,
};


function create(){
    window.location.href = "leagueCreate.php"
}

function enter(){
    window.location.href = "leagueEnter.php"
}

function game() {
  window.location.href = "game.php"
}

function profile() {
  window.location.href = "profile.php"
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
      <li><code>:profile</code> — Goes to profile page</li>
      <li><code>:create</code> — Create a new league</li>  
      <li><code>:enter</code> — Mouse only :(</li>   
      <li><code>:view</code> — Mouse only :(</li>
      <li><code>:leave</code> — Mouse only :(</li>       
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
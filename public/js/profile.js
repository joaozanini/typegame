const commands = {
  ":game": game,
  ":leagues": league,
  ":logout": confirmLogout,
  ":help": help,
};

function confirmLogout() {
    const confirmacao = confirm("Tem certeza que deseja fazer logout?");
    if (confirmacao) {
         window.location.href = "logout.php";
    }
}


function game() {
  window.location.href = "game.php"
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
      <li><code>:logout</code> — Logout</li>
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


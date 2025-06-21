  const selectBox = document.getElementById("custom-select");
  const selected = selectBox.querySelector(".select-selected");
  const selectedText = selectBox.querySelector(".selected-text");
  const options = selectBox.querySelector(".select-items");
  const hiddenInput = document.getElementById("grupoSelecionado");
  const form = document.getElementById("groupForm");


  selected.addEventListener("click", () => {
    options.classList.toggle("select-hide");
    selectBox.classList.toggle("active");
  });


  options.querySelectorAll("div").forEach(option => {
    option.addEventListener("click", () => {
      const value = option.dataset.value;
      selectedText.textContent = option.textContent;
      hiddenInput.value = value;

      options.classList.add("select-hide");
      selectBox.classList.remove("active");

      form.submit();
    });
  });

  document.addEventListener("click", (e) => {
    if (!selectBox.contains(e.target)) {
      options.classList.add("select-hide");
      selectBox.classList.remove("active");
    }
  });

document.querySelectorAll("th.sort").forEach(header => {
  let ascending = true;

  header.addEventListener("click", () => {
    const table = header.closest("table");
    const tbody = table.querySelector("tbody");
    const rows = Array.from(tbody.querySelectorAll("tr"));

    const index = Array.from(header.parentNode.children).indexOf(header);

    const isNumericColumn = !isNaN(rows[0].children[index].textContent.trim());

    rows.sort((a, b) => {
      let aText = a.children[index].textContent.trim();
      let bText = b.children[index].textContent.trim();

      if (isNumericColumn) {
        aText = parseFloat(aText);
        bText = parseFloat(bText);
      }

      return ascending ? aText - bText : bText - aText;
    });

    rows.forEach(row => tbody.appendChild(row));

    document.querySelectorAll("th.sort .ordem").forEach(span => {
      span.innerHTML = "&#9662;";
    });

    const arrowSpan = header.querySelector(".ordem");
    arrowSpan.innerHTML = ascending ? "&#9652;" : "&#9662;";

    ascending = !ascending;
  });
});

const commands = {
  ":game": game,
  ":profile": profile,
  ":create": create,
  ":enter": enter,
  ":open": openSelectMenu,
  ":close":closeSelectMenu,
  ":selectLeague": selectLeagueByName,
  ":sortWeek": sortWeek,
  ":sortTotal": sortTotal,
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

function openSelectMenu() {
  options.classList.remove("select-hide");
  selectBox.classList.add("active");
}

function closeSelectMenu() {
  options.classList.add("select-hide");
  selectBox.classList.remove("active");
}

function selectLeagueByName(name) {
  const target = options.querySelector(`div[data-value="${name}"]`);
  if (target) {
    target.click();
  } else {
    const input = document.getElementById("commandText");
    input.value = "";
    input.placeholder = `League "${name}" not found`;
  }
}

function sortWeek() {
  const headers = document.querySelectorAll("th.sort");
  for (const header of headers) {
    if (header.textContent.toLowerCase().includes("weekly")) {
      header.click();
      return;
    }
  }

  const input = document.getElementById("commandText");
  input.value = "";
  input.placeholder = `Weekly score column not found`;
}

function sortTotal() {
  const headers = document.querySelectorAll("th.sort");
  for (const header of headers) {
    if (header.textContent.toLowerCase().includes("total")) {
      header.click();
      return;
    }
  }

  const input = document.getElementById("commandText");
  input.value = "";
  input.placeholder = `Total score column not found`;
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
      <li><code>:enter</code> — Enter a league</li>
      <li><code>:open</code> — Open the league selection menu</li>
      <li><code>:close</code> — Close the league selection menu</li>
      <li><code>:select &lt;name&gt;</code> — Select a league by name</li>
      <li><code>:sortWeek</code> — Sort by weekly score</li>
      <li><code>:sortTotal</code> — Sort by total score</li>     
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
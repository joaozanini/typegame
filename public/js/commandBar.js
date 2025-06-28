const commandBar = document.createElement("div");
commandBar.id = "commandBar";

const input = document.createElement("input");
input.type = "text";
input.id = "commandText";
input.autocomplete = "off"; 
input.spellcheck = false;

commandBar.appendChild(input);
document.body.appendChild(commandBar);
commandBar.style.display = "none";


document.addEventListener("keydown", function (e) {
  if (e.key === "Escape") {
    if (commandBar.style.display === "none") {
      commandBar.style.display = "block";
      input.focus();
    } else {
      commandBar.style.display = "none";
    }
  }

  if (e.key === "Enter" && commandBar.style.display === "block") {
    e.preventDefault();
    const command = input.value.trim();


    if (command.startsWith(":select ")) {
      const name = command.slice(8).trim();
      selectLeagueByName(name);
      input.value = "";
      return;
    }

    if (commands[command]) {
      input.placeholder = "";
      commands[command]();
      commandBar.style.display = "none";
    } else {
      input.value = "";
      input.placeholder = "Unknown command";
    }

    input.value = "";
  }
});


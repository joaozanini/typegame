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

let emailin = document.getElementById("email")
let senhain = document.getElementById("senha")
  
function validateForm() {
  let emailError = getErrorElement(emailin);
  let senhaError = getErrorElement(senhain);
  let veri = true;

  emailError.textContent = "";
  senhaError.textContent = "";

  let email = emailin.value.trim();
  if (email === "") {
    emailError.textContent = "Email needs to be filled!";
    veri = false;
  } else if (!validateEmail(email)) {
    emailError.textContent = "Invalid email!";
    veri = false;
  }

  let senha = senhain.value;
  if (removeAllSpaces(senha) === "") {
    senhaError.textContent = "Password needs to be filled!";
    veri = false;
  }

  return veri;
}

document.getElementById("form").addEventListener('submit', function(e) {
  if (!validateForm()) {
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
  ":help": help,
  ":email": emailf,
  ":password": passwordf,
  ":home": home,
  ":sign up": signup,
  ":play!": play,
};

function signup() {
  window.location.href = "register.php"
}

function home() {
  window.location.href = "index.php"
}

function emailf(){
  emailin.focus();
}

function passwordf(){
  senhain.focus();
}

function play() {
  const logForm = document.getElementById("form");
  if (validateForm()) {
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
      <li><code>:sign up</code> — Sign up</li>
      <li><code>:home</code> — Goes back to home page</li>
      <li><code>:email</code> — Focus on email</li>
      <li><code>:password</code> — Focus on password</li>
      <li><code>:play!</code> — Complete login and goes to play page</li>
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
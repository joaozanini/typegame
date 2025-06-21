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

let usernamein = document.getElementById("username")
let nicknamein = document.getElementById("nickname")
let emailin = document.getElementById("email")
let senhain = document.getElementById("senha")
let confirmin = document.getElementById("password2")

//Verificações do submit

function validateForm() {
  let usernameError = getErrorElement(usernamein);
  let nicknameError = getErrorElement(nicknamein);
  let emailError = getErrorElement(emailin);
  let senhaError = getErrorElement(senhain);
  let confirmError = getErrorElement(confirmin);
  let veri = true;

  // Reset all error messages
  usernameError.textContent = "";
  nicknameError.textContent = "";
  emailError.textContent = "";
  senhaError.textContent = "";
  confirmError.textContent = "";

  // Username
  let username = usernamein.value;
  if (removeAllSpaces(username) === "") {
    usernameError.textContent = "Username needs to be filled!";
    veri = false;
  }

  // Nickname
  let nickname = nicknamein.value;
  if (removeAllSpaces(nickname) === "") {
    nicknameError.textContent = "Nickname needs to be filled!";
    veri = false;
  }

  // Email
  let email = emailin.value.trim();
  if (email === "") {
    emailError.textContent = "Email needs to be filled!";
    veri = false;
  } else if (!validateEmail(email)) {
    emailError.textContent = "Invalid email!";
    veri = false;
  }

  // Password
  let senha = senhain.value;
  if (removeAllSpaces(senha) === "") {
    senhaError.textContent = "Password needs to be filled with letters and numbers!";
    veri = false;
  } else if (!/[a-zA-Z]/.test(senha)) {
    senhaError.textContent = "Needs to contain letters, special characters like (', @, ~, etc...) are not allowed!";
    veri = false;
  } else if (!/\d/.test(senha)) {
    senhaError.textContent = "Needs to contain numbers!";
    veri = false;
  } else if (/[\u00C0-\u017F]/.test(senha)) {
    senhaError.textContent = "Special characters are not allowed!";
    veri = false;
  } else if (senha.length < 8) {
    senhaError.textContent = "Needs to have more than 8 characters";
    veri = false;
  }

  // Password confirmation
  let confirm = confirmin.value;
  if (confirm !== senha) {
    confirmError.textContent = "Passwords do not match, try again!";
    veri = false;
  }

  return veri;
}

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

//submit por botão
document.getElementById("form").addEventListener('submit', function(e){
  if (!validateForm()) {
    e.preventDefault();
  }
});

const commands = {
  ":help": help,
  ":username": userf,
  ":nickname": nickf,
  ":email": emailf,
  ":password": passwordf,
  ":passwordConfirm": confirmf,
  ":home": home,
  ":sign in": signin,
  ":submit": submitc,
};

function signin() {
  window.location.href = "login.php"
}

function home() {
  window.location.href = "index.php"
}

function userf(){
  usernamein.focus();
}

function nickf(){
  nicknamein.focus();
}

function emailf(){
  emailin.focus();
}

function passwordf(){
  senhain.focus();
}

function confirmf(){
  confirmin.focus();
}

function submitc() {
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
      <li><code>:sign in</code> — Sign in</li>
      <li><code>:home</code> — Goes back to home page</li>
      <li><code>:username</code> — Focus on username</li>
      <li><code>:nickname</code> — Focus on nickname</li>
      <li><code>:email</code> — Focus on email</li>
      <li><code>:password</code> — Focus on password</li>
      <li><code>:passwordConfirm</code> — Focus on confirm password</li>      
      <li><code>:submit</code> — Submit registration and log in automatically</li>
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
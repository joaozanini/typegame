document.addEventListener('DOMContentLoaded', () => {
    const textDisplay = document.getElementById('text-display');
    const statsContainer = document.getElementById('stats');
    const timerDisplay = document.getElementById('timer')
    let currentIndex = 0;
    let startTime = null;
    let errorCount = 0;
    let characters = [];
    let timerId = null;
    let titleTimerId = null; 
    const maxTime = 60 * 1000;
    let handleKeyDown;

    // Carrega as palavras do JSON
    fetch('js/words.json')
        .then(response => {
            if (!response.ok) throw new Error('Erro ao carregar words.json');
            return response.json();
        })
        .then(words => {
            if (!Array.isArray(words)) throw new Error('Formato inválido do words.json');

            const randomizedWords = shuffleArray(words);
            const textToType = randomizedWords.join(' ');
            characters = textToType.split('').map((char, index) => ({
                char,
                element: null,
                status: 'pending',
                position: index
            }));

            displayCharacters(characters, textDisplay);
            setupKeyboardListener();
            startTitleUpdater(); // Inicia o atualizador de título
        })
        .catch(error => {
            console.error('Erro:', error);
            textDisplay.innerHTML = `<p class="error">${error.message}</p>`;
        });

    function shuffleArray(array) {
        const newArray = [...array];
        for (let i = newArray.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [newArray[i], newArray[j]] = [newArray[j], newArray[i]];
        }
        return newArray;
    }

    function displayCharacters(chars, container) {
        container.innerHTML = '';
        chars.forEach(charObj => {
            const span = document.createElement('span');
            span.textContent = charObj.char;
            span.id = `char-${charObj.position}`;
            container.appendChild(span);
            charObj.element = span;
        });

        if (chars.length > 0) {
            chars[0].element.classList.add('current');
        }
    }

    function setupKeyboardListener() {
        handleKeyDown = (e) => {
            if (document.getElementById("commandBar")?.style.display === "block") return;

            if (e.key === 'Backspace') {
                handleBackspace();
                e.preventDefault();
                return;
            }

            if (e.key.length > 1 && e.key !== ' ') return;

            if (!startTime) {
                console.log('[DEBUG] Timer iniciado');
                startTime = new Date();
                startTimer();

            }

            const currentChar = characters[currentIndex];
            if (!currentChar) {
                // Se não há mais caracteres para digitar, o jogo já deveria ter terminado
                e.preventDefault();
                return;
            }

            if (e.key === currentChar.char) {
                currentChar.status = 'correct';
                currentChar.element.classList.add('correct');
                currentChar.element.classList.remove('incorrect');
            } else {
                currentChar.status = 'incorrect';
                currentChar.element.classList.add('incorrect');
                currentChar.element.classList.remove('correct');
                errorCount++;
            }

            currentChar.element.classList.remove('current');
            currentIndex++;

            if (currentIndex < characters.length) {
                characters[currentIndex].element.classList.add('current');
            } else {
                finishGame();
                document.removeEventListener('keydown', handleKeyDown);
                if (timerDisplay) timerDisplay.innerText = '';
            }

            e.preventDefault();
        };

        document.addEventListener('keydown', handleKeyDown);
    }

    function handleBackspace() {
        if (currentIndex === 0) return;

        const currentChar = characters[currentIndex];
        if (currentChar) { // Remove a classe 'current' do caracter atual antes de voltar
            currentChar.element.classList.remove('current');
        }

        currentIndex--;
        const prevChar = characters[currentIndex];

        if (prevChar.status === 'incorrect') {
            errorCount--;
        }

        prevChar.status = 'pending';
        prevChar.element.classList.remove('correct', 'incorrect');
        prevChar.element.classList.add('current');
    }

    function startTimer() {
        timerId = setTimeout(() => {
            console.log('[TIMER] Tempo esgotado');
            finishGame();
            document.removeEventListener('keydown', handleKeyDown);
        }, maxTime);
    }

    function finishGame() {
        if (timerId) {
            clearTimeout(timerId);
            timerId = null;
        }
        if (titleTimerId) { // Limpa o setInterval do título
            clearInterval(titleTimerId);
            titleTimerId = null;
            document.title = 'Typos!'; // Resetar o título
        }


        const endTime = new Date();
        const totalTime = startTime ? (endTime - startTime) / 1000 : 0;
        const totalChars = characters.length;
        const charsTyped = currentIndex;
        // WPM (Words Per Minute) = (Caracteres Digitados / 5) / (Tempo Total em Minutos)
        const wpm = totalTime > 0 ? Math.round((charsTyped / 5) / (totalTime / 60)) : 0;
        // Precisão = ((Caracteres Digitados - Erros) / Caracteres Digitados) * 100
        const accuracy = charsTyped > 0 ? Math.round(((charsTyped - errorCount) / charsTyped) * 100) : 0;

        statsContainer.innerHTML = `
            <h3>Result</h3>
            <p>Time: ${totalTime.toFixed(1)} seconds</p>
            <p>Speed: ${wpm} WPM</p>
            <p>Precision: ${accuracy}%</p>
            <p>Errors: ${errorCount}</p>
            <button onclick="location.reload()">↻ Play again</button>
        `;
        statsContainer.style.border = "5px solid #08ee83"

        postResult({ time: totalTime, wpm, accuracy, errors: errorCount });
    }

    function postResult(data) {
        fetch('../src/Controllers/GameController.php', { 
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) throw new Error('Erro no envio do resultado');
            return response.json();
        })
        .then(result => {
            console.log('Resultado enviado com sucesso:', result);
        })
        .catch(err => {
            console.error('Erro ao enviar resultado:', err);
        });
    }

    function updateTitle() {
        if (startTime) {
            const elapsed = new Date() - startTime;
            const remainingTime = Math.max(0, maxTime - elapsed);
            const timeText = `${(remainingTime / 1000).toFixed(1)}s`;

            document.title = `Time left: ${timeText}`;
            if (timerDisplay) {
                timerDisplay.innerText = `⏱ ${timeText}`;
            }

            if (timeText === `0.1s`) {
                timerDisplay.innerText = '⏱ 0.0s';
            }
        } else {
            document.title = 'Typos!';
            if (timerDisplay) timerDisplay.innerText = '';
        }
        
    }


    function startTitleUpdater() {
        titleTimerId = setInterval(updateTitle, 100);
    }
});

const commands = {
  ":leagues": league,
  ":profile": profile,
   ":reset": reset,
  ":help": help,
};



function profile() {
  window.location.href = "profile.php"
}

function league() {
  window.location.href = "league.php"
}

function reset(){
    location.reload()
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
      <li><code>:leagues</code> — Goes to leagues page</li>
      <li><code>:profile</code> — Goes to profile page</li>     
      <li><code>:reset</code> — Resets the game</li>
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

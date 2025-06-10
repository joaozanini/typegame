document.addEventListener('DOMContentLoaded', () => {
    const textDisplay = document.getElementById('text-display');
    const statsContainer = document.getElementById('stats');
    let currentIndex = 0;
    let startTime = null;
    let errorCount = 0;
    let characters = [];

    // Carrega as palavras do JSONa
    fetch('words.json')
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
                status: 'pending', // 'pending', 'correct', 'incorrect'
                position: index
            }));

            displayCharacters(characters, textDisplay);
            setupKeyboardListener();
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
        const handleKeyDown = (e) => {
            if (e.key === 'Backspace') {
                handleBackspace();
                e.preventDefault();
                return;
            }

            if (e.key.length > 1 && e.key !== ' ') return;

            if (startTime === null) {
                startTime = new Date();
            }

            const currentChar = characters[currentIndex];

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
            }

            e.preventDefault();
        };

        document.addEventListener('keydown', handleKeyDown);
    }

    function handleBackspace() {
        if (currentIndex === 0) return;

        const currentChar = characters[currentIndex];
        if (currentChar) {
            currentChar.element.classList.remove('current');
        }

        currentIndex--;
        const prevChar = characters[currentIndex];

        // Se estava incorreto, diminui o contador de erros
        if (prevChar.status === 'incorrect') {
            errorCount--;
        }

        // Reseta o caractere anterior
        prevChar.status = 'pending';
        prevChar.element.classList.remove('correct', 'incorrect');
        prevChar.element.classList.add('current');
    }

    function finishGame() {
        const endTime = new Date();
        const totalTime = (endTime - startTime) / 1000;
        const totalChars = characters.length;
        const wpm = Math.round((totalChars / 5) / (totalTime / 60));
        const accuracy = Math.round(((totalChars - errorCount) / totalChars) * 100);

        statsContainer.innerHTML = `
            <h3>Resultado</h3>
            <p>🔹 Tempo: ${totalTime.toFixed(1)} segundos</p>
            <p>🔹 Velocidade: ${wpm} PPM</p>
            <p>🔹 Precisão: ${accuracy}%</p>
            <p>🔹 Erros: ${errorCount}</p>
            <button onclick="location.reload()">↻ Jogar Novamente</button>
        `;
    }
});
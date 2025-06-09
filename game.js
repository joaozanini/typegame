document.addEventListener('DOMContentLoaded', () => {
    
    const textDisplay = document.getElementById('text-display');
    const statsContainer = document.getElementById('stats');
    let currentIndex = 0;
    let startTime = null;
    let errorCount = 0;
    let characters = [];
    let errorHistory = [];

    iniciarJogo();

    function iniciarJogo() {
        carregarPalavras()
            .then(palavras => prepararTexto(palavras))
            .then(texto => prepararCaracteres(texto))
            .then(chars => {
                characters = chars;
                exibirCaracteres(characters, textDisplay);
                iniciarListeners();
            })
            .catch(erro => mostrarErro(erro));
    }

    function carregarPalavras() {
        return fetch('words.json')
            .then(response => {
                if (!response.ok) throw new Error('Erro ao carregar words.json');
                return response.json();
            })
            .then(words => {
                if (!Array.isArray(words)) throw new Error('Formato inválido do words.json');
                return embaralharArray(words);
            });
    }

    function prepararTexto(palavras) {
        return palavras.join(' ');
    }

    function prepararCaracteres(texto) {
        return texto.split('').map((char, index) => ({
            char,
            element: null,
            status: 'pending',
            position: index
        }));
    }

    function exibirCaracteres(chars, container) {
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

    function iniciarListeners() {
        document.addEventListener('keydown', lidarComTecla);
    }

    function lidarComTecla(e) {
        if (e.key === 'Backspace') {
            desfazerCaractere();
            e.preventDefault();
            return;
        }

        if (e.key.length > 1 && e.key !== ' ') return;

        if (startTime === null) {
            startTime = new Date();
        }

        const atual = characters[currentIndex];

        if (e.key === atual.char) {
            marcarCorreto(atual);
        } else {
            marcarIncorreto(atual, e.key);
        }

        atual.element.classList.remove('current');
        currentIndex++;

        if (currentIndex < characters.length) {
            characters[currentIndex].element.classList.add('current');
        } else {
            finalizarJogo();
            document.removeEventListener('keydown', lidarComTecla);
        }

        e.preventDefault();
    }

    function marcarCorreto(caractere) {
        caractere.status = 'correct';
        caractere.element.classList.add('correct');
        caractere.element.classList.remove('incorrect');
    }

    function marcarIncorreto(caractere, entrada) {
        caractere.status = 'incorrect';
        caractere.element.classList.add('incorrect');
        caractere.element.classList.remove('correct');
        errorCount++;
        errorHistory.push({ posicao: caractere.position, correto: caractere.char, digitado: entrada });
    }

    function desfazerCaractere() {
        if (currentIndex === 0) return;

        const atual = characters[currentIndex];
        if (atual) atual.element.classList.remove('current');

        currentIndex--;
        const anterior = characters[currentIndex];

        if (anterior.status === 'incorrect') {
            errorCount--;
            // Remove último erro relacionado a essa posição
            errorHistory = errorHistory.filter(err => err.posicao !== anterior.position);
        }

        anterior.status = 'pending';
        anterior.element.classList.remove('correct', 'incorrect');
        anterior.element.classList.add('current');
    }

    function finalizarJogo() {
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
            <h4>Histórico de Erros:</h4>
            <ul>
                ${errorHistory.map(err => `<li>Posição ${err.posicao + 1}: digitado '${err.digitado}' em vez de '${err.correto}'</li>`).join('')}
            </ul>
            <button onclick="location.reload()">↻ Jogar Novamente</button>
        `;
    }

    function mostrarErro(erro) {
        console.error('Erro:', erro);
        textDisplay.innerHTML = `<p class="error">${erro.message}</p>`;
    }

    function embaralharArray(array) {
        const novoArray = [...array];
        for (let i = novoArray.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [novoArray[i], novoArray[j]] = [novoArray[j], novoArray[i]];
        }
        return novoArray;
    }
});

let words = [];

async function loadWords() {
    try {
        const response = await fetch('words.json');

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        words = await response.json();
        console.log('Palavras carregadas:', words.length);

        initializeGame();
    } catch (error) {
        console.error('Erro ao carregar as palavras:', error);
        alert('Não foi possível carregar as palavras do jogo. Por favor, tente novamente.');
    }
}

$(document).ready(function() {
    loadWords();
});

function initializeGame() {
    const selectedWords = shuffleArray(words).slice(0, 20);
    console.log('Palavras para a partida:', selectedWords);
}

function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}

// restante da sua lógica do jogo (captura de entrada, cronômetro, etc.)
const reels = [
  document.getElementById('reel1'),
  document.getElementById('reel2'),
  document.getElementById('reel3')
];

const spinBtn = document.getElementById('spinBtn');
const resultText = document.getElementById('result');

const symbols = ['🍒','🍋','🔔','⭐','💎'];

spinBtn.addEventListener('click', () => {
  let results = [];

  reels.forEach(reel => {
    const randomSymbol = symbols[Math.floor(Math.random() * symbols.length)];
    reel.textContent = randomSymbol;
    results.push(randomSymbol);
  });

  if(results[0] === results[1] && results[1] === results[2]) {
    resultText.textContent = '🎉 WYGRANA! 🎉';
  } else {
    resultText.textContent = 'Spróbuj jeszcze raz!';
  }
});

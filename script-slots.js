const reels = [
  document.getElementById('reel1'),
  document.getElementById('reel2'),
  document.getElementById('reel3')
];

const spinBtn = document.getElementById('spinBtn');
const resultText = document.getElementById('result');

const spinSound = document.getElementById('spinSound');
const winSound = document.getElementById('winSound');

const symbols = ['🍒','🍋','🔔','⭐','💎'];

spinBtn.addEventListener('click', () => {
  spinSound.currentTime = 0;
  spinSound.play();

  resultText.textContent = '';
  
  reels.forEach((reel, index) => {
    reel.classList.add('spin-animation');
    setTimeout(() => {
      const randomSymbol = symbols[Math.floor(Math.random() * symbols.length)];
      reel.textContent = randomSymbol;
      reel.classList.remove('spin-animation');
      if(index === reels.length - 1) checkWin();
    }, 500 + index * 200);
  });
});

function checkWin() {
  const results = reels.map(r => r.textContent);
  if(results[0] === results[1] && results[1] === results[2]) {
    resultText.textContent = '🎉 WYGRANA! 🎉';
    winSound.currentTime = 0;
    winSound.play();
  } else {
    resultText.textContent = 'Spróbuj jeszcze raz!';
  }
}


const rouletteBtn = document.getElementById('rouletteSpin');
const rouletteResult = document.getElementById('rouletteResult');

rouletteBtn.addEventListener('click', () => {
  const number = Math.floor(Math.random() * 37); // 0-36
  rouletteResult.textContent = `🎯 Wypadło: ${number}`;
});


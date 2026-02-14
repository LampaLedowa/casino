onst btn = document.getElementById('rouletteSpin');
const result = document.getElementById('rouletteResult');
const wheel = document.getElementById('wheel');
const ball = document.getElementById('ball');
const sound = document.getElementById('rouletteSound');

let spinning = false;

// europejska ruletka kolory
function getColor(num) {
  if (num === 0) return '🟢 zielone';
  const redNumbers = [1,3,5,7,9,12,14,16,18,19,21,23,25,27,30,32,34,36];
  return redNumbers.includes(num) ? '🔴 czerwone' : '⚫ czarne';
}

btn.addEventListener('click', () => {
  if (spinning) return;
  spinning = true;

  result.textContent = '';

  sound.currentTime = 0;
  sound.play();

  // obrót koła
  const wheelDeg = 3000 + Math.floor(Math.random() * 2000);
  wheel.style.transform = `rotate(${wheelDeg}deg)`;

  // obrót kulki przeciwnie
  const ballDeg = - (3000 + Math.floor(Math.random() * 2000));
  ball.style.transform = `rotate(${ballDeg}deg)`;

  const number = Math.floor(Math.random() * 37);
  const color = getColor(number);

  setTimeout(() => {
    result.textContent = `🎯 ${number} — ${color}`;
    spinning = false;
  }, 4000);
});

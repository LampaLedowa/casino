const btn = document.getElementById('rouletteSpin');
const result = document.getElementById('rouletteResult');
const wheel = document.getElementById('wheel');
const ball = document.getElementById('ball');
const sound = document.getElementById('rouletteSound');

let spinning = false;

function getColor(num){
  if(num === 0) return '🟢 Zielone';
  const redNumbers = [1,3,5,7,9,12,14,16,18,19,21,23,25,27,30,32,34,36];
  return redNumbers.includes(num) ? '🔴 Czerwone' : '⚫ Czarne';
}

btn.addEventListener('click', ()=>{
  if(spinning) return;
  spinning = true;
  result.textContent = '';

  // odtwarzanie dźwięku
  sound.currentTime = 0;
  sound.play();

  // losowy obrót koła
  const wheelDeg = 3600 + Math.floor(Math.random()*360);
  wheel.style.transition = 'transform 4s cubic-bezier(.17,.67,.83,.67)';
  wheel.style.transform = `rotate(${wheelDeg}deg)`;

  // kulka
  const ballDeg = - (3600 + Math.floor(Math.random()*360));
  ball.style.transition = 'transform 4s cubic-bezier(.17,.67,.83,.67)';
  ball.style.transform = `rotate(${ballDeg}deg)`;

  const number = Math.floor(Math.random()*37);
  const color = getColor(number);

  setTimeout(()=>{
    result.textContent = `🎯 ${number} — ${color}`;
    spinning = false;
  }, 4000);
});

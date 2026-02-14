const btn = document.getElementById('rouletteSpin');
const result = document.getElementById('rouletteResult');
const wheel = document.getElementById('wheel');
const sound = document.getElementById('rouletteSound');

let spinning = false;

btn.addEventListener('click', () => {
  if (spinning) return;
  spinning = true;

  result.textContent = '';

  // dźwięk
  sound.currentTime = 0;
  sound.play();

  // losowy obrót
  const randomDeg = 2000 + Math.floor(Math.random() * 2000);
  wheel.style.transform = `rotate(${randomDeg}deg)`;

  // losowanie numeru
  const number = Math.floor(Math.random() * 37);

  setTimeout(() => {
    result.textContent = `🎯 Wypadło: ${number}`;
    spinning = false;
  }, 3000);
});

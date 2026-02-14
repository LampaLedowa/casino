const canvas = document.getElementById("rouletteCanvas");
const ctx = canvas.getContext("2d");
const spinBtn = document.getElementById("rouletteSpin");
const result = document.getElementById("rouletteResult");
const balanceEl = document.getElementById("playerBalance");
const nameEl = document.getElementById("playerNameDisplay");
const numbersGrid = document.getElementById("numbersGrid");
const betBtns = document.querySelectorAll(".bet-btn");

// Inicjalizacja gracza z localStorage
let player = {
  name: localStorage.getItem("playerName") || "Gracz",
  balance: parseInt(localStorage.getItem("playerBalance")) || 1000
};
balanceEl.textContent = player.balance;
nameEl.textContent = player.name;

// Funkcja aktualizacji salda
function updateBalance(amount){
  player.balance += amount;
  balanceEl.textContent = player.balance;
  localStorage.setItem("playerBalance", player.balance);
}

// Generowanie numerków 0-36
const numbers = [];
for(let i=0;i<=36;i++){ numbers.push(i); }

numbers.forEach(num=>{
  const btn = document.createElement("button");
  btn.classList.add("number-btn");
  btn.textContent = num;
  btn.dataset.number = num;
  numbersGrid.appendChild(btn);
});

let currentBet = { type:"", value:null };

// Obsługa obstawiania kolorów
betBtns.forEach(btn=>{
  btn.addEventListener("click",()=>{
    currentBet.type = "color";
    currentBet.value = btn.dataset.bet;
    result.textContent = `Postawiono na: ${currentBet.value}`;
  });
});

// Obsługa obstawiania numerów
document.querySelectorAll(".number-btn").forEach(btn=>{
  btn.addEventListener("click", ()=>{
    currentBet.type = "number";
    currentBet.value = parseInt(btn.dataset.number);
    result.textContent = `Postawiono na numer: ${currentBet.value}`;
  });
});

// Rysowanie koła ruletki
function drawRoulette(){
  const radius = 200;
  const colors = ["#ff0000","#000000"];
  const startAngle = -Math.PI/2;
  const angleStep = (2*Math.PI)/37;

  for(let i=0;i<37;i++){
    ctx.beginPath();
    ctx.moveTo(radius,radius);
    ctx.arc(radius,radius,radius,startAngle+i*angleStep,startAngle+(i+1)*angleStep);
    if(i===0) ctx.fillStyle="#008000"; // zielony 0
    else ctx.fillStyle = colors[i%2];
    ctx.fill();
    ctx.strokeStyle="#fff";
    ctx.stroke();
  }
}
drawRoulette();

// SPIN ruletki
spinBtn.addEventListener("click", ()=>{
  if(player.balance < 50){ alert("Nie masz środków!"); return; }
  updateBalance(-50);

  // losowy numer
  const winningNumber = Math.floor(Math.random()*37);
  let winningColor = winningNumber===0 ? "green" : (winningNumber%2===0 ? "black":"red");

  // animacja kulki
  let angle = 0;
  const spinFrames = 50 + Math.floor(Math.random()*50);
  let frame=0;
  function animateBall(){
    frame++;
    angle += 0.3 + Math.random()*0.2;
    const radius = 180;
    const x = 200 + radius*Math.cos(angle);
    const y = 200 + radius*Math.sin(angle);
    const ball = document.getElementById("rouletteBall");
    ball.style.left = (x-10)+"px";
    ball.style.top = (y-10)+"px";

    if(frame < spinFrames) requestAnimationFrame(animateBall);
    else {
      // wynik
      let winAmount = 0;
      if(currentBet.type==="color" && currentBet.value===winningColor) winAmount=100;
      else if(currentBet.type==="number" && currentBet.value===winningNumber) winAmount=500;
      result.textContent = `Wylosowano ${winningNumber} (${winningColor.toUpperCase()})` + (winAmount>0? " – WYGRAŁEŚ!":" – PRZEGRAŁEŚ!");
      updateBalance(winAmount);
    }
  }
  animateBall();
});


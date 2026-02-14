window.addEventListener("DOMContentLoaded", ()=>{

const canvas = document.getElementById("rouletteCanvas");
const ctx = canvas.getContext("2d");
const spinBtn = document.getElementById("rouletteSpin");
const result = document.getElementById("rouletteResult");
const balanceEl = document.getElementById("playerBalance");
const nameEl = document.getElementById("playerNameDisplay");
const numbersGrid = document.getElementById("numbersGrid");
const betBtns = document.querySelectorAll(".bet-btn");

// Gracz z localStorage
let player = {
  name: localStorage.getItem("playerName") || "Gracz",
  balance: parseInt(localStorage.getItem("playerBalance")) || 1000
};

balanceEl.textContent = player.balance;
nameEl.textContent = player.name;

function updateBalance(amount){
  player.balance += amount;
  balanceEl.textContent = player.balance;
  localStorage.setItem("playerBalance", player.balance);
}

// Numerki 0-36
const numbers = [];
for(let i=0;i<=36;i++) numbers.push(i);

numbers.forEach(num=>{
  const btn = document.createElement("button");
  btn.classList.add("number-btn");
  btn.textContent = num;
  btn.dataset.number = num;
  numbersGrid.appendChild(btn);
});

// Obstawienie
let currentBet = { type:"", value:null };
betBtns.forEach(btn=>{
  btn.addEventListener("click",()=>{ currentBet.type="color"; currentBet.value=btn.dataset.bet; result.textContent=`Postawiono na: ${currentBet.value}`; });
});
document.querySelectorAll(".number-btn").forEach(btn=>{
  btn.addEventListener("click",()=>{ currentBet.type="number"; currentBet.value=parseInt(btn.dataset.number); result.textContent=`Postawiono na numer: ${currentBet.value}`; });
});

// Rysowanie koła
function drawRoulette(){
  const radius = 200;
  const colors = ["#ff0000","#000000"];
  const startAngle = -Math.PI/2;
  const angleStep = (2*Math.PI)/37;
  for(let i=0;i<37;i++){
    ctx.beginPath();
    ctx.moveTo(radius,radius);
    ctx.arc(radius,radius,radius,startAngle+i*angleStep,startAngle+(i+1)*angleStep);
    ctx.fillStyle = i===0 ? "#008000" : colors[i%2];
    ctx.fill();
    ctx.strokeStyle="#fff"; ctx.stroke();
  }
}
drawRoulette();

// SPIN
spinBtn.addEventListener("click",()=>{
  if(player.balance < 50){ alert("Nie masz środków!"); return; }
  updateBalance(-50);

  const winningNumber = Math.floor(Math.random()*37);
  const winningColor = winningNumber===0 ? "green" : (winningNumber%2===0 ? "black":"red");

  let angle=0; let frame=0; const spinFrames=50+Math.floor(Math.random()*50);
  function animateBall(){
    frame++;
    angle+=0.3+Math.random()*0.2;
    const radius=180;
    const x=200+radius*Math.cos(angle);
    const y=200+radius*Math.sin(angle);
    const ball=document.getElementById("rouletteBall");
    ball.style.left=(x-10)+"px"; ball.style.top=(y-10)+"px";
    if(frame<spinFrames) requestAnimationFrame(animateBall);
    else{
      let winAmount=0;
      if(currentBet.type==="color" && currentBet.value===winningColor) winAmount=100;
      else if(currentBet.type==="number" && currentBet.value===winningNumber) winAmount=500;
      result.textContent=`Wylosowano ${winningNumber} (${winningColor.toUpperCase()})` + (winAmount>0? " – WYGRAŁEŚ!":" – PRZEGRAŁEŚ!");
      updateBalance(winAmount);
    }
  }
  animateBall();
});

});

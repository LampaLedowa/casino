const canvas = document.getElementById("rouletteCanvas");
const ctx = canvas.getContext("2d");
const spinBtn = document.getElementById("rouletteSpin");
const result = document.getElementById("rouletteResult");
const balanceEl = document.getElementById("balance");
const numbersGrid = document.getElementById("numbersGrid");
const betBtns = document.querySelectorAll(".bet-btn");
const ball = document.getElementById("rouletteBall");

let balance = 1000;
let currentBet = null;

const numbers = [
{num:0,color:'green'}, {num:32,color:'red'}, {num:15,color:'black'},
{num:19,color:'red'}, {num:4,color:'black'}, {num:21,color:'red'},
{num:2,color:'black'}, {num:25,color:'red'}, {num:17,color:'black'},
{num:34,color:'red'}, {num:6,color:'black'}, {num:27,color:'red'},
{num:13,color:'black'}, {num:36,color:'red'}, {num:11,color:'black'},
{num:30,color:'red'}, {num:8,color:'black'}, {num:23,color:'red'},
{num:10,color:'black'}, {num:5,color:'red'}, {num:24,color:'black'},
{num:16,color:'red'}, {num:33,color:'black'}, {num:1,color:'red'},
{num:20,color:'black'}, {num:14,color:'red'}, {num:31,color:'black'},
{num:9,color:'red'}, {num:22,color:'black'}, {num:18,color:'red'},
{num:29,color:'black'}, {num:7,color:'red'}, {num:28,color:'black'},
{num:12,color:'red'}, {num:35,color:'black'}, {num:3,color:'red'},
{num:26,color:'black'}
];

function drawWheel(rotation=0){
  const radius = 180;
  const center = 200;
  ctx.clearRect(0,0,400,400);
  const arc = (2*Math.PI)/numbers.length;

  numbers.forEach((n,i)=>{
    const start = i*arc + rotation;
    const end = start+arc;
    ctx.beginPath();
    ctx.moveTo(center,center);
    ctx.arc(center,center,radius,start,end);
    ctx.fillStyle = n.color==='red'?'#c00':(n.color==='black'?'#000':'#0a5');
    ctx.fill();
    ctx.strokeStyle="#fff";
    ctx.stroke();

    const angle = start + arc/2;
    ctx.save();
    ctx.translate(center,center);
    ctx.rotate(angle);
    ctx.textAlign="right";
    ctx.fillStyle="#fff";
    ctx.font="16px Arial";
    ctx.fillText(n.num,radius-20,5);
    ctx.restore();
  });
}

numbers.forEach(n=>{
  const btn = document.createElement("button");
  btn.textContent = n.num;
  btn.classList.add(n.color);
  btn.addEventListener('click', ()=>currentBet=n.num);
  numbersGrid.appendChild(btn);
});

betBtns.forEach(btn=>{
  btn.addEventListener('click', ()=>currentBet=btn.dataset.bet);
});

spinBtn.addEventListener('click', ()=>{
  if(currentBet===null){ alert("Wybierz numer lub kolor!"); return; }

  const winnerIndex = Math.floor(Math.random()*numbers.length);
  const winner = numbers[winnerIndex];

  let rotation = 0;
  let speed = 0.3 + Math.random()*0.3;
  const deceleration = 0.003 + Math.random()*0.002;
  let ballAngle = Math.random()*2*Math.PI;
  const ballSpeed = 0.1 + Math.random()*0.05;

  const animate = ()=>{
    drawWheel(rotation);
    rotation += speed;
    speed -= deceleration;

    const radius = 160;
    const center = 200;
    ballAngle -= ballSpeed;
    const x = center + Math.cos(ballAngle) * radius;
    const y = center + Math.sin(ballAngle) * radius;
    ball.style.left = x-10+'px';
    ball.style.top = y-10+'px';

    if(speed>0){
      requestAnimationFrame(animate);
    } else {
      const arc = (2*Math.PI)/numbers.length;
      rotation = 2*Math.PI - winnerIndex*arc;
      drawWheel(rotation);
      const finalAngle = winnerIndex*arc;
      const ballX = center + Math.cos(-finalAngle + Math.PI/2) * radius;
      const ballY = center + Math.sin(-finalAngle + Math.PI/2) * radius;
      ball.style.left = ballX-10+'px';
      ball.style.top = ballY-10+'px';

      let win=false;
      if(currentBet==='red' && winner.color==='red') win=true;
      else if(currentBet==='black' && winner.color==='black') win=true;
      else if(currentBet==='green' && winner.color==='green') win=true;
      else if(currentBet===winner.num) win=true;

      if(win){ balance+=100; result.textContent=`WYGRAŁEŚ! Numer: ${winner.num} — ${winner.color}`; }
      else{ balance-=100; result.textContent=`PRZEGRAŁEŚ! Numer: ${winner.num} — ${winner.color}`; }

      balanceEl.textContent=balance;
      currentBet=null;
    }
  };

  animate();
});

drawWheel();

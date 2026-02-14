let balance=1000;
  document.getElementById('balance').textContent=balance;
}

function addMoney(){
  const val=Number(document.getElementById('addMoneyInput').value);
  if(!isNaN(val)&&val>0){balance+=val;updateBalance();}
}

function canPlay(bet){
  if(balance<bet){alert('Brak kasy 😢');return false}
  balance-=bet;updateBalance();return true;
}

// ROULETTE
function spinRoulette(){
  const bet=getBet();
  if(!canPlay(bet))return;

  const wheel=document.getElementById('wheel');
  const deg=720+Math.random()*720;
  wheel.style.transform=`rotate(${deg}deg)`;

  setTimeout(()=>{
    const number=Math.floor(Math.random()*37);
    let win=false;
    if(number===7){balance+=bet*10;win=true}
    updateBalance();
    document.getElementById('rouletteResult').textContent=
      'Wylosowano: '+number+(win?' 🎉 JACKPOT!':'');
  },1000);
}

// POKER
function drawCard(){
  const bet=getBet();
  if(!canPlay(bet))return;
  const cards=['A','K','Q','J','10','9','8','7'];
  const card=cards[Math.floor(Math.random()*cards.length)];
  let text='Karta: '+card;
  if(card==='A'){balance+=bet*3;text='🔥 Trafiłeś ASA!'}
  updateBalance();
  document.getElementById('pokerResult').textContent=text;
}

// SLOTS
function spinSlots(){
  const bet=getBet();
  if(!canPlay(bet))return;
  const el=document.getElementById('slotsAnim');
  const symbols=['🍒','🍋','🔔','⭐','💎'];

  let spins=0;
  const anim=setInterval(()=>{
    const s1=symbols[Math.floor(Math.random()*symbols.length)];
    const s2=symbols[Math.floor(Math.random()*symbols.length)];
    const s3=symbols[Math.floor(Math.random()*symbols.length)];
    el.textContent=`${s1} ${s2} ${s3}`;
    spins++;
    if(spins>10){
      clearInterval(anim);
      if(s1===s2&&s2===s3){balance+=bet*5;el.textContent+= ' 🎉'}
      updateBalance();
      document.getElementById('slotsResult').textContent=el.textContent;
    }
  },100);
}

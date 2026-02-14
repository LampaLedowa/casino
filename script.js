const spinBtn = document.getElementById("slotsSpin");
const result = document.getElementById("slotsResult");
const balanceEl = document.getElementById("playerBalance");
const nameEl = document.getElementById("playerNameDisplay");

const reels = [
  document.getElementById("reel1"),
  document.getElementById("reel2"),
  document.getElementById("reel3")
];

const symbols = ["🍒","🍋","🔔","💎","🍉","⭐"];

// Pobieramy dane gracza z localStorage
let player = {
  name: localStorage.getItem("playerName") || "Gracz",
  balance: parseInt(localStorage.getItem("playerBalance")) || 1000
};

// Ustaw pasek gracza
nameEl.textContent = player.name;
balanceEl.textContent = player.balance;

// Funkcja aktualizacji salda
function updateBalance(amount){
  player.balance += amount;
  balanceEl.textContent = player.balance;
  localStorage.setItem("playerBalance", player.balance);
}

// Animacja bębnów i wynik
spinBtn.addEventListener("click", ()=>{
  if(player.balance < 50){ alert("Nie masz wystarczających środków!"); return; }
  updateBalance(-50);

  const finalSymbols = [];
  for(let i=0;i<3;i++){ finalSymbols.push(symbols[Math.floor(Math.random()*symbols.length)]); }

  let frame = 0;
  const maxFrames = 50;
  const delays = [0,5,10];

  function animate(){
    frame++;
    for(let i=0;i<3;i++){
      if(frame > delays[i]){
        if(frame < maxFrames){
          reels[i].textContent = symbols[Math.floor(Math.random()*symbols.length)];
        } else {
          reels[i].textContent = finalSymbols[i];
        }
      }
    }

    if(frame < maxFrames){
      requestAnimationFrame(animate);
    } else {
      let winAmount = 0;
      if(finalSymbols[0]===finalSymbols[1] && finalSymbols[1]===finalSymbols[2]){
        result.textContent = `WYGRAŁEŚ! Symbol: ${finalSymbols[0]}`;
        winAmount = 500;
      } else if(finalSymbols[0]===finalSymbols[1] || finalSymbols[1]===finalSymbols[2] || finalSymbols[0]===finalSymbols[2]){
        result.textContent = `Częściowa wygrana!`;
        winAmount = 150;
      } else {
        result.textContent = `PRZEGRAŁEŚ!`;
      }
      updateBalance(winAmount);
    }
  }

  animate();
});

const spinBtn = document.getElementById("slotsSpin");
const result = document.getElementById("slotsResult");
const balanceEl = document.getElementById("balance");

const reels = [
  document.getElementById("reel1"),
  document.getElementById("reel2"),
  document.getElementById("reel3")
];

let balance = 1000;

const symbols = ["🍒","🍋","🔔","💎","🍉","⭐"];

spinBtn.addEventListener("click", () => {
  balance -= 50; // koszt SPIN
  balanceEl.textContent = balance;

  let stops = [];
  reels.forEach((reel,i)=>{
    let spins = 10 + Math.floor(Math.random()*10); // losowa liczba obrotów
    let symbol = null;
    for(let j=0;j<spins;j++){
      symbol = symbols[Math.floor(Math.random()*symbols.length)];
      reel.textContent = symbol;
    }
    stops.push(symbol);
  });

  // sprawdzenie wyniku
  if(stops[0]===stops[1] && stops[1]===stops[2]){
    result.textContent = `WYGRAŁEŚ! Symbol: ${stops[0]}`;
    balance += 500; // wygrana
  } else if(stops[0]===stops[1] || stops[1]===stops[2] || stops[0]===stops[2]){
    result.textContent = `Częściowa wygrana!`;
    balance += 150;
  } else {
    result.textContent = `PRZEGRAŁEŚ!`;
  }

  balanceEl.textContent = balance;
});

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
  if(balance < 50){
    alert("Nie masz wystarczająco środków!");
    return;
  }

  balance -= 50;
  balanceEl.textContent = balance;
  result.textContent = "";

  // Losowe symbole końcowe
  const finalSymbols = [];
  for(let i=0;i<3;i++){
    finalSymbols.push(symbols[Math.floor(Math.random()*symbols.length)]);
  }

  let frame = 0;
  const maxFrames = 50; // ilość klatek animacji
  const delays = [0, 5, 10]; // opóźnienia dla kolejnych bębnów

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
      // Sprawdzenie wyniku
      if(finalSymbols[0]===finalSymbols[1] && finalSymbols[1]===finalSymbols[2]){
        result.textContent = `WYGRAŁEŚ! Symbol: ${finalSymbols[0]}`;
        balance += 500;
      } else if(finalSymbols[0]===finalSymbols[1] || finalSymbols[1]===finalSymbols[2] || finalSymbols[0]===finalSymbols[2]){
        result.textContent = `Częściowa wygrana!`;
        balance += 150;
      } else {
        result.textContent = `PRZEGRAŁEŚ!`;
      }
      balanceEl.textContent = balance;
    }
  }

  animate();
});

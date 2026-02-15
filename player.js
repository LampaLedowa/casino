window.addEventListener("DOMContentLoaded", ()=>{

  const balanceEl = document.getElementById("playerBalance");
  const nameEl = document.getElementById("playerNameDisplay");

  let player = {
    name: localStorage.getItem("playerName") || "Gracz",
    balance: parseInt(localStorage.getItem("playerBalance")) || 1000
  };

  function updateBalance(amount){
    player.balance += amount;
    balanceEl.textContent = player.balance;
    localStorage.setItem("playerBalance", player.balance);
  }

  nameEl.textContent = player.name;
  balanceEl.textContent = player.balance;

  window.player = player;
  window.updateBalance = updateBalance;
});

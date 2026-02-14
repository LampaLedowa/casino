<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TotalCasino</title>
<link rel="stylesheet" href="style-main.css">
</head>
<body>

<div class="casino-container">

  <!-- Pasek gracza -->
  <div class="player-bar" id="playerBar" style="display:none;">
    <span id="playerNameDisplay"></span> • Saldo: $<span id="playerBalance">0</span>
  </div>

  <header>
    <h1>TotalCasino 🎰</h1>
  </header>

  <main id="loginSection">
    <!-- LOGOWANIE -->
    <div class="login-box">
      <h2>Logowanie</h2>
      <input type="text" id="playerNameInput" placeholder="Wpisz swoją nazwę">
      <button id="loginBtn">Zaloguj</button>
    </div>
  </main>

  <main id="casinoMenu" style="display:none;">
    <!-- PANEL WPŁAT -->
    <div class="deposit-box">
      <h2>Wpłać środki</h2>
      <input type="number" id="depositAmount" placeholder="Kwota">
      <button id="depositBtn">Wpłać</button>
    </div>

    <!-- WYBÓR GRY -->
    <h2>Wybierz grę:</h2>
    <div class="game-icons">
      <a href="slots.html">
        <img src="./assets/images/slot-icon.png" alt="Slots">
        <p>Slots</p>
      </a>
      <a href="roulette.html">
        <img src="./assets/images/roulette-icon.png" alt="Ruletka">
        <p>Ruletka</p>
      </a>
    </div>
  </main>

</div>

<script>
// Zmienna gracza
let player = { name: "", balance: 0 };

// LOGOWANIE
const loginBtn = document.getElementById("loginBtn");
loginBtn.addEventListener("click", ()=>{
  const name = document.getElementById("playerNameInput").value.trim();
  if(name === ""){
    alert("Podaj nazwę gracza!");
    return;
  }
  player.name = name;
  player.balance = 1000; // startowe saldo

  document.getElementById("playerNameDisplay").textContent = player.name;
  document.getElementById("playerBalance").textContent = player.balance;

  document.getElementById("loginSection").style.display = "none";
  document.getElementById("casinoMenu").style.display = "block";
  document.getElementById("playerBar").style.display = "block";
});

// WPŁATA
const depositBtn = document.getElementById("depositBtn");
depositBtn.addEventListener("click", ()=>{
  const amount = parseInt(document.getElementById("depositAmount").value);
  if(isNaN(amount) || amount <= 0){
    alert("Podaj poprawną kwotę!");
    return;
  }
  player.balance += amount;
  document.getElementById("playerBalance").textContent = player.balance;
  document.getElementById("depositAmount").value = "";
  alert(`Wpłacono $${amount} na konto`);
});
</script>

</body>
</html>

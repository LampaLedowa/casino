<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>🎰 Mini Kasyno ULTRA</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>🎰 Mini Kasyno ULTRA</h1>
    <p> tylko zabawa</p>
    <div class="money">Saldo: $<span id="balance">1000</span></div>

    <div class="money-controls">
      <input type="number" id="addMoneyInput" placeholder="Dodaj $" />
      <button onclick="addMoney()">Dodaj kasę</button>
    </div>

    <div class="bet-controls">
      <p>🎯 Twój zakład:</p>
      <input type="number" id="betInput" value="100" />
    </div>
  </header>

  <main class="container">

    <section class="card">
      <h2>🎡 Ruletka</h2>
      <div class="wheel" id="wheel">🎡</div>
      <button onclick="spinRoulette()">Zakręć</button>
      <div id="rouletteResult" class="result"></div>
    </section>

    <section class="card">
      <h2>🃏 Poker</h2>
      <button onclick="drawCard()">Dobierz kartę</button>
      <div id="pokerResult" class="result"></div>
    </section>

    <section class="card">
      <h2>🎰 Sloty</h2>
      <div class="slots" id="slotsAnim">❔ ❔ ❔</div>
      <button onclick="spinSlots()">Kręć sloty</button>
      <div id="slotsResult" class="result"></div>
    </section>

  </main>

  <footer>
    <p>© 2026 Mini Kasyno ULTRA </p>
  </footer>

  <script src="script.js"></script>
</body>
</html>

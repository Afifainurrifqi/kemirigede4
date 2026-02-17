<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Maintenance Game</title>
  <style>
    :root{
      --bg1:#0b1020;
      --bg2:#121a33;
      --panel:#0e1430cc;
      --text:#e9f0ff;
      --muted:#b9c7ff;
      --accent:#7c5cff;
      --accent2:#38e6b5;
      --danger:#ff5c7a;
      --shadow: 0 18px 55px rgba(0,0,0,.45);
    }
    *{ box-sizing:border-box; }
    html,body{ height:100%; }
    body{
      margin:0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, "Noto Sans", sans-serif;
      color:var(--text);
      background: radial-gradient(1200px 900px at 70% 10%, #263a7a 0%, var(--bg1) 55%, #070a14 100%);
      display:grid;
      place-items:center;
      overflow:hidden;
    }

    /* subtle stars */
    .stars{
      position:fixed; inset:-25%;
      background-image:
        radial-gradient(2px 2px at 20% 30%, rgba(255,255,255,.7) 30%, transparent 31%),
        radial-gradient(1px 1px at 70% 10%, rgba(255,255,255,.6) 35%, transparent 36%),
        radial-gradient(1px 1px at 40% 80%, rgba(255,255,255,.5) 35%, transparent 36%),
        radial-gradient(2px 2px at 85% 65%, rgba(255,255,255,.65) 30%, transparent 31%),
        radial-gradient(1px 1px at 10% 60%, rgba(255,255,255,.5) 35%, transparent 36%),
        radial-gradient(1px 1px at 55% 45%, rgba(255,255,255,.4) 35%, transparent 36%);
      opacity:.35;
      animation: drift 45s linear infinite;
      pointer-events:none;
    }
    @keyframes drift{
      from{ transform: translate3d(0,0,0); }
      to{ transform: translate3d(-6%, 4%, 0); }
    }

    .wrap{
      width:min(980px, 94vw);
      display:grid;
      gap:14px;
    }

    .panel{
      background: var(--panel);
      border: 1px solid rgba(255,255,255,.10);
      border-radius: 18px;
      box-shadow: var(--shadow);
      backdrop-filter: blur(10px);
      overflow:hidden;
    }

    .top{
      display:flex;
      justify-content:space-between;
      gap:14px;
      padding:18px 18px 12px;
      align-items:flex-start;
      flex-wrap:wrap;
    }

    .title{
      display:flex;
      gap:12px;
      align-items:flex-start;
      min-width: 260px;
    }
    .badge{
      width:44px; height:44px;
      border-radius: 12px;
      background:
        radial-gradient(circle at 30% 30%, rgba(255,255,255,.35), transparent 45%),
        linear-gradient(135deg, rgba(124,92,255,.95), rgba(56,230,181,.85));
      box-shadow: 0 12px 28px rgba(124,92,255,.20);
      flex:0 0 auto;
      position:relative;
    }
    .badge::after{
      content:"";
      position:absolute; inset:12px;
      border-radius:9px;
      border:2px dashed rgba(255,255,255,.55);
    }
    h1{
      margin:0;
      font-size: clamp(20px, 3vw, 32px);
      line-height:1.1;
      letter-spacing:-0.02em;
    }
    .sub{
      margin:7px 0 0;
      color: var(--muted);
      font-size: 14px;
      line-height: 1.5;
      max-width: 520px;
    }

    .hud{
      display:flex;
      gap:10px;
      align-items:center;
      flex-wrap:wrap;
    }
    .chip{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding: 9px 11px;
      border-radius: 999px;
      background: rgba(255,255,255,.06);
      border: 1px solid rgba(255,255,255,.10);
      font-size: 13px;
      user-select:none;
      white-space:nowrap;
    }
    .dot{
      width: 9px; height: 9px;
      border-radius:999px;
      background: var(--accent2);
      box-shadow: 0 0 0 4px rgba(56,230,181,.14);
      animation: pulse 1.1s ease-in-out infinite;
    }
    @keyframes pulse{
      0%,100%{ transform:scale(1); opacity:.85; }
      50%{ transform:scale(1.25); opacity:1; }
    }

    .btn{
      border: 0;
      cursor:pointer;
      color: var(--text);
      font-weight: 700;
      padding: 10px 12px;
      border-radius: 12px;
      background: rgba(255,255,255,.08);
      border: 1px solid rgba(255,255,255,.12);
      transition: transform .12s ease, background .12s ease;
      user-select:none;
    }
    .btn:hover{ transform: translateY(-1px); background: rgba(255,255,255,.11); }
    .btn.primary{
      background: linear-gradient(135deg, rgba(124,92,255,.95), rgba(56,230,181,.80));
      border-color: rgba(255,255,255,.16);
      box-shadow: 0 14px 35px rgba(124,92,255,.18);
    }

    .game{
      position:relative;
      height: 420px;
      width:100%;
      background:
        radial-gradient(900px 260px at 60% 20%, rgba(124,92,255,.18), transparent 60%),
        linear-gradient(to bottom, rgba(0,0,0,.15), rgba(0,0,0,.40));
      border-top: 1px solid rgba(255,255,255,.08);
      overflow:hidden;
    }
    @media (max-width: 560px){
      .game{ height: 460px; }
    }

    /* scanlines */
    .game::before{
      content:"";
      position:absolute; inset:0;
      background: repeating-linear-gradient(
        to bottom,
        rgba(255,255,255,.05) 0 1px,
        rgba(0,0,0,0) 1px 3px
      );
      opacity:.20;
      pointer-events:none;
      mix-blend-mode: overlay;
    }

    .hint{
      position:absolute;
      left: 14px; right: 14px; top: 12px;
      display:flex;
      justify-content:space-between;
      gap:10px;
      flex-wrap:wrap;
      font-size: 13px;
      color: rgba(233,240,255,.88);
      opacity:.92;
    }
    .hint .mini{
      padding: 7px 10px;
      border-radius: 999px;
      background: rgba(255,255,255,.06);
      border: 1px solid rgba(255,255,255,.10);
      backdrop-filter: blur(6px);
      display:flex;
      gap:8px;
      align-items:center;
      white-space:nowrap;
    }
    .progress{
      width: 170px;
      height: 10px;
      border-radius:999px;
      background: rgba(255,255,255,.10);
      overflow:hidden;
      position:relative;
    }
    .progress > div{
      height:100%;
      width: 0%;
      background: linear-gradient(90deg, var(--danger), #ffd86a);
      transition: width .2s ease;
    }

    .center{
      position:absolute;
      inset:0;
      display:grid;
      place-items:center;
      pointer-events:none;
      text-align:center;
      padding: 0 18px;
    }
    .center h2{
      margin:0;
      font-size: clamp(18px, 2.7vw, 26px);
    }
    .center p{
      margin:8px 0 0;
      color: var(--muted);
      line-height:1.5;
      max-width: 560px;
    }

    /* Bug (target) */
    .bug{
      position:absolute;
      width: 52px;
      height: 52px;
      border-radius: 14px;
      background:
        radial-gradient(circle at 30% 25%, rgba(255,255,255,.35), transparent 45%),
        linear-gradient(135deg, rgba(255,92,122,.95), rgba(124,92,255,.75));
      box-shadow: 0 14px 35px rgba(255,92,122,.18);
      border: 1px solid rgba(255,255,255,.14);
      display:grid;
      place-items:center;
      cursor:pointer;
      user-select:none;
      transform: translateZ(0);
      animation: pop .12s ease-out;
    }
    @keyframes pop{
      from{ transform: scale(.92); opacity:.7; }
      to{ transform: scale(1); opacity:1; }
    }
    .bug::before{
      content:"🐞";
      font-size: 22px;
      filter: drop-shadow(0 8px 14px rgba(0,0,0,.35));
    }
    .bug.miss{
      background: linear-gradient(135deg, rgba(255,255,255,.12), rgba(255,255,255,.05));
      box-shadow: 0 14px 35px rgba(0,0,0,.10);
    }
    .bug.miss::before{ content:"💥"; }

    /* little floating text */
    .float{
      position:absolute;
      font-weight: 800;
      font-size: 14px;
      pointer-events:none;
      text-shadow: 0 10px 24px rgba(0,0,0,.45);
      animation: floatUp .6s ease-out forwards;
    }
    @keyframes floatUp{
      from{ transform: translateY(0); opacity:1; }
      to{ transform: translateY(-24px); opacity:0; }
    }

    /* overlay end */
    .overlay{
      position:absolute;
      inset:0;
      display:none;
      place-items:center;
      background: rgba(0,0,0,.35);
      backdrop-filter: blur(6px);
      padding: 18px;
    }
    .overlay .card{
      width:min(520px, 94%);
      border-radius: 16px;
      border: 1px solid rgba(255,255,255,.12);
      background: rgba(14,20,48,.85);
      box-shadow: var(--shadow);
      padding: 16px;
      text-align:center;
    }
    .overlay h3{ margin:0; font-size:22px; }
    .overlay p{ margin:10px 0 0; color: var(--muted); line-height:1.5; }
    .overlay .row{
      display:flex;
      gap:10px;
      justify-content:center;
      flex-wrap:wrap;
      margin-top: 14px;
    }

    /* footer text */
    .footerText{
      text-align:center;
      color: rgba(233,240,255,.92);
      font-size: 14.5px;
      padding: 10px 4px 0;
    }

    @media (prefers-reduced-motion: reduce){
      *{ animation:none !important; transition:none !important; }
    }
  </style>
</head>
<body>
  <div class="stars" aria-hidden="true"></div>

  <div class="wrap">
    <section class="panel">
      <div class="top">
        <div class="title">
          <div class="badge" aria-hidden="true"></div>
          <div>
            <h1>Web e sek dibenakno yo</h1>
            {{-- <p class="sub">
              Klik <b>🐞 bug</b> yang muncul untuk “memperbaiki web”.
              Semakin banyak bug kamu beresin, semakin tinggi progres “repair”-nya.
            </p> --}}
          </div>
        </div>

        <div class="hud">
          <div class="chip"><span class="dot" aria-hidden="true"></span><span id="stateText">Ready</span></div>
          <div class="chip">Score: <b id="score">0</b></div>
          <div class="chip">Time: <b id="time">20</b>s</div>
          <button class="btn primary" id="startBtn">Start</button>
        </div>
      </div>

      <div class="game" id="game" aria-label="Game area">
        <div class="hint" aria-hidden="true">
          <div class="mini">OPO AE SEH SENG DI BENAKNO: <b>DATA TOK KOK PAK</b></div>
          <div class="mini">SERVER HP
            <span class="progress"><div id="hp"></div></span>
          </div>
        </div>

        <div class="center" id="center">
          <div>
            <h2>SENG SABAR NGGEH MARINE MARI KOK, DOLAN GAME SEK AE KLIK "START" DI POJOK ATAS</h2>
          </div>
        </div>

        <div class="overlay" id="overlay">
          <div class="card">
            <h3 id="endTitle">Selesai!</h3>
            <p id="endText">Score kamu: <b>0</b>. Web-nya makin stabil 😄</p>
            <div class="row">
              <button class="btn primary" id="restartBtn">Play Again</button>
              <button class="btn" id="closeBtn">Close</button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="footerText">
      " Web Sedang Perbaiki, seng sabar nggeh bapak :") "
    </div>
  </div>

  <script>
    const game = document.getElementById("game");
    const startBtn = document.getElementById("startBtn");
    const restartBtn = document.getElementById("restartBtn");
    const closeBtn = document.getElementById("closeBtn");
    const overlay = document.getElementById("overlay");
    const center = document.getElementById("center");

    const scoreEl = document.getElementById("score");
    const timeEl = document.getElementById("time");
    const stateText = document.getElementById("stateText");
    const hpEl = document.getElementById("hp");
    const endText = document.getElementById("endText");
    const endTitle = document.getElementById("endTitle");

    let running = false;
    let score = 0;
    let timeLeft = 20;
    let tickTimer = null;
    let spawnTimer = null;

    function clamp(n, a, b){ return Math.max(a, Math.min(b, n)); }
    function rand(min, max){ return Math.random() * (max - min) + min; }

    function setHpFromScore(){
      // target score for "100% stabilized"
      const target = 25;
      const pct = clamp((score / target) * 100, 0, 100);
      hpEl.style.width = pct + "%";
    }

    function clearBugs(){
      game.querySelectorAll(".bug, .float").forEach(el => el.remove());
    }

    function spawnBug(){
      if (!running) return;

      const rect = game.getBoundingClientRect();
      const size = 52;

      // keep away from top HUD a bit
      const paddingTop = 56;
      const x = rand(14, rect.width - size - 14);
      const y = rand(paddingTop, rect.height - size - 14);

      const bug = document.createElement("div");
      bug.className = "bug";
      bug.style.left = x + "px";
      bug.style.top  = y + "px";

      // lifetime: disappears if not clicked (counts as miss)
      const life = rand(550, 950);
      const born = performance.now();

      const onClick = (ev) => {
        ev.stopPropagation();
        if (!running) return;

        score += 1;
        scoreEl.textContent = String(score);
        setHpFromScore();

        floatText("+1", x + 18, y - 6, true);
        bug.remove();
      };

      bug.addEventListener("click", onClick, { passive: true });
      game.appendChild(bug);

      // auto-miss if not clicked in time
      setTimeout(() => {
        if (!running) return;
        if (!bug.isConnected) return;

        // mark miss
        bug.classList.add("miss");
        floatText("miss", x + 10, y - 6, false);

        // remove after a tiny moment
        setTimeout(() => bug.remove(), 160);
      }, life);

      // small wobble for fun (no CSS animation needed per bug)
      const wobble = () => {
        if (!bug.isConnected || !running) return;
        const t = (performance.now() - born) / 1000;
        bug.style.transform = `translateY(${Math.sin(t * 10) * 2}px)`;
        requestAnimationFrame(wobble);
      };
      requestAnimationFrame(wobble);
    }

    function floatText(txt, x, y, good){
      const f = document.createElement("div");
      f.className = "float";
      f.textContent = txt;
      f.style.left = x + "px";
      f.style.top  = y + "px";
      f.style.color = good ? "rgba(56,230,181,.95)" : "rgba(255,92,122,.95)";
      game.appendChild(f);
      setTimeout(() => f.remove(), 650);
    }

    function startGame(){
      if (running) return;
      running = true;

      score = 0;
      timeLeft = 20;

      scoreEl.textContent = "0";
      timeEl.textContent = String(timeLeft);
      stateText.textContent = "Playing…";
      hpEl.style.width = "0%";

      overlay.style.display = "none";
      center.style.display = "none";
      clearBugs();

      // timer tick
      tickTimer = setInterval(() => {
        timeLeft -= 1;
        timeEl.textContent = String(timeLeft);

        if (timeLeft <= 0){
          endGame();
        }
      }, 1000);

      // spawn loop (slightly ramps up)
      let base = 520;
      spawnTimer = setInterval(() => {
        spawnBug();
        // occasional extra spawn
        if (Math.random() < 0.35) spawnBug();

        base = Math.max(260, base - 6);
      }, 420);

      startBtn.textContent = "Restart";
    }

    function endGame(){
      if (!running) return;
      running = false;

      clearInterval(tickTimer);
      clearInterval(spawnTimer);
      tickTimer = null;
      spawnTimer = null;

      clearBugs();

      const stabilized = score >= 25;
      endTitle.textContent = stabilized ? "Server Stabilized! ✨" : "Time’s Up!";
      endText.innerHTML = `Score kamu: <b>${score}</b>. ${stabilized ? "Web-nya makin stabil 😄" : "Coba lagi biar makin stabil 💪"}`;

      stateText.textContent = "Paused";
      overlay.style.display = "grid";
    }

    // click on game area = small penalty (optional fun)
    game.addEventListener("click", (e) => {
      if (!running) return;
      // prevent penalty if click was on bug (handled there)
      if (e.target.classList.contains("bug")) return;

      // tiny penalty to encourage aiming
      if (score > 0 && Math.random() < 0.35){
        score -= 1;
        scoreEl.textContent = String(score);
        setHpFromScore();
        floatText("-1", e.offsetX, e.offsetY, false);
      }
    });

    startBtn.addEventListener("click", () => startGame());
    restartBtn.addEventListener("click", () => { overlay.style.display="none"; startGame(); });
    closeBtn.addEventListener("click", () => { overlay.style.display="none"; stateText.textContent = "Ready"; center.style.display="grid"; });

    // allow "Start" button to act as restart while running
    startBtn.addEventListener("click", () => {
      if (running){
        // quick restart
        running = false;
        clearInterval(tickTimer);
        clearInterval(spawnTimer);
        clearBugs();
        startGame();
      }
    }, { once:false });
  </script>
</body>
</html>

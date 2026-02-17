<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Maintenance Mode</title>
  <style>
    :root{
      --bg1:#0b1020;
      --bg2:#121a33;
      --bg3:#1b2750;
      --panel:#0e1430cc;
      --text:#e9f0ff;
      --muted:#b9c7ff;
      --accent:#7c5cff;
      --accent2:#38e6b5;
      --danger:#ff5c7a;
      --shadow: 0 18px 50px rgba(0,0,0,.45);
      --pixel: 2px;
    }

    *{ box-sizing: border-box; }
    html,body{ height:100%; }
    body{
      margin:0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, "Noto Sans", sans-serif;
      color:var(--text);
      background: radial-gradient(1200px 900px at 70% 10%, #263a7a 0%, var(--bg1) 55%, #070a14 100%);
      overflow:hidden;
    }

    /* --- Scene wrapper --- */
    .scene{
      position:relative;
      height:100%;
      width:100%;
      display:grid;
      place-items:center;
      padding: 28px 18px;
    }

    /* --- Sky: stars + subtle drift --- */
    .sky{
      position:absolute;
      inset:0;
      overflow:hidden;
      pointer-events:none;
    }
    .stars, .stars::before, .stars::after{
      content:"";
      position:absolute;
      inset:-30%;
      background-image:
        radial-gradient(2px 2px at 20% 30%, rgba(255,255,255,.7) 30%, transparent 31%),
        radial-gradient(1px 1px at 70% 10%, rgba(255,255,255,.6) 35%, transparent 36%),
        radial-gradient(1px 1px at 40% 80%, rgba(255,255,255,.5) 35%, transparent 36%),
        radial-gradient(2px 2px at 85% 65%, rgba(255,255,255,.65) 30%, transparent 31%),
        radial-gradient(1px 1px at 10% 60%, rgba(255,255,255,.5) 35%, transparent 36%),
        radial-gradient(1px 1px at 55% 45%, rgba(255,255,255,.4) 35%, transparent 36%),
        radial-gradient(2px 2px at 30% 15%, rgba(255,255,255,.55) 30%, transparent 31%),
        radial-gradient(1px 1px at 92% 25%, rgba(255,255,255,.45) 35%, transparent 36%);
      opacity:.55;
      filter: blur(.1px);
      animation: drift 40s linear infinite;
      transform: translate3d(0,0,0);
    }
    .stars::before{ opacity:.35; animation-duration: 55s; }
    .stars::after{ opacity:.25; animation-duration: 75s; }
    @keyframes drift{
      from{ transform: translate3d(0,0,0); }
      to{ transform: translate3d(-8%, 6%, 0); }
    }

    /* --- Parallax layers --- */
    .parallax{
      position:absolute;
      inset:0;
      overflow:hidden;
      pointer-events:none;
    }
    .layer{
      position:absolute;
      left:0; right:0;
      bottom:0;
      height: 60%;
      background-repeat: repeat-x;
      image-rendering: pixelated;
      transform: translate3d(0,0,0);
    }

    /* Distant mountains */
    .layer.back{
      height: 55%;
      background-image:
        linear-gradient(transparent 0 60%, rgba(0,0,0,.0) 60%),
        repeating-linear-gradient(
          90deg,
          transparent 0 18px,
          rgba(0,0,0,.0) 18px 24px
        );
      mask-image: radial-gradient(1200px 600px at 40% 100%, black 45%, transparent 75%);
      background:
        linear-gradient(to top, rgba(123,95,255,.14), transparent 45%),
        linear-gradient(to top, rgba(56,230,181,.08), transparent 55%),
        linear-gradient(to top, rgba(0,0,0,.0), rgba(0,0,0,.0));
      opacity: .9;
    }

    /* Mid hills: repeating “blocks” */
    .layer.mid{
      height: 42%;
      background-image:
        linear-gradient(to top, rgba(124,92,255,.12), transparent 60%),
        repeating-linear-gradient(
          90deg,
          rgba(23,34,74,.85) 0 36px,
          rgba(23,34,74,.85) 36px 42px,
          rgba(30,44,94,.9) 42px 66px,
          rgba(30,44,94,.9) 66px 72px
        );
      bottom: 14%;
      opacity: .85;
      animation: scrollMid 18s linear infinite;
    }
    @keyframes scrollMid{
      from{ background-position: 0 0, 0 0; }
      to{ background-position: 0 0, -520px 0; }
    }

    /* Foreground: ground tiles */
    .layer.front{
      height: 26%;
      background-image:
        linear-gradient(to top, rgba(0,0,0,.45), rgba(0,0,0,0)),
        repeating-linear-gradient(
          90deg,
          rgba(10,14,30,1) 0 24px,
          rgba(15,20,44,1) 24px 48px
        ),
        repeating-linear-gradient(
          90deg,
          rgba(56,230,181,.08) 0 2px,
          transparent 2px 12px,
          rgba(124,92,255,.08) 12px 14px,
          transparent 14px 24px
        );
      bottom: 0;
      animation: scrollFront 8s linear infinite;
    }
    @keyframes scrollFront{
      from{ background-position: 0 0, 0 0, 0 0; }
      to{ background-position: 0 0, -640px 0, -640px 0; }
    }

    /* floating coins */
    .coins{
      position:absolute;
      inset:0;
      pointer-events:none;
      opacity:.9;
    }
    .coin{
      position:absolute;
      width: 14px;
      height: 14px;
      border-radius: 4px;
      background:
        linear-gradient(135deg, rgba(255,255,255,.35), transparent 40%),
        radial-gradient(circle at 35% 30%, #fff6bf 0 35%, transparent 36%),
        linear-gradient(#ffd86a, #ffb347);
      box-shadow: 0 8px 18px rgba(0,0,0,.25);
      image-rendering: pixelated;
      animation: floatCoin 3.2s ease-in-out infinite, spinCoin 1.1s steps(2) infinite;
      filter: saturate(1.1);
    }
    @keyframes floatCoin{
      0%,100%{ transform: translate3d(0,0,0); opacity:.75; }
      50%{ transform: translate3d(0,-14px,0); opacity:1; }
    }
    @keyframes spinCoin{
      0%,100%{ border-radius: 4px; }
      50%{ border-radius: 7px; }
    }

    /* --- UI Panel --- */
    .panel{
      position:relative;
      width:min(920px, 94vw);
      border-radius: 18px;
      background: var(--panel);
      backdrop-filter: blur(10px);
      box-shadow: var(--shadow);
      border: 1px solid rgba(255,255,255,.10);
      overflow:hidden;
    }

    .panel-inner{
      display:grid;
      grid-template-columns: 1.05fr .95fr;
      gap: 18px;
      padding: 22px;
    }

    @media (max-width: 860px){
      .panel-inner{ grid-template-columns: 1fr; }
    }

    .headline{
      display:flex;
      align-items:flex-start;
      gap: 12px;
    }
    .badge{
      flex:0 0 auto;
      width: 44px;
      height: 44px;
      border-radius: 12px;
      background:
        radial-gradient(circle at 30% 30%, rgba(255,255,255,.35), transparent 45%),
        linear-gradient(135deg, rgba(124,92,255,.95), rgba(56,230,181,.85));
      box-shadow: 0 12px 28px rgba(124,92,255,.22);
      position:relative;
    }
    .badge::after{
      content:"";
      position:absolute;
      inset: 12px;
      border-radius: 9px;
      border: 2px dashed rgba(255,255,255,.55);
      opacity:.9;
    }

    h1{
      margin:0;
      font-size: clamp(22px, 3.1vw, 34px);
      line-height:1.1;
      letter-spacing: -0.02em;
    }
    .sub{
      margin: 8px 0 0;
      color: var(--muted);
      font-size: 14.5px;
      line-height: 1.5;
    }

    .status-row{
      margin-top: 16px;
      display:flex;
      align-items:center;
      gap: 10px;
      flex-wrap:wrap;
    }

    .chip{
      display:inline-flex;
      align-items:center;
      gap: 8px;
      padding: 8px 10px;
      border-radius: 999px;
      border: 1px solid rgba(255,255,255,.12);
      background: rgba(255,255,255,.06);
      color: var(--text);
      font-size: 13px;
      user-select:none;
      white-space:nowrap;
    }
    .dot{
      width: 8px;
      height: 8px;
      border-radius: 999px;
      background: var(--accent2);
      box-shadow: 0 0 0 4px rgba(56,230,181,.14);
      animation: pulse 1.2s ease-in-out infinite;
    }
    @keyframes pulse{
      0%,100%{ transform: scale(1); opacity:.9; }
      50%{ transform: scale(1.25); opacity:1; }
    }

    /* progress */
    .progress{
      margin-top: 14px;
      padding: 10px;
      border-radius: 14px;
      background: rgba(0,0,0,.25);
      border: 1px solid rgba(255,255,255,.10);
    }
    .bar{
      height: 12px;
      border-radius: 999px;
      background: rgba(255,255,255,.08);
      overflow:hidden;
      position:relative;
    }
    .fill{
      height:100%;
      width: 12%;
      border-radius: 999px;
      background: linear-gradient(90deg, rgba(124,92,255,.95), rgba(56,230,181,.9));
      box-shadow: 0 10px 20px rgba(56,230,181,.10);
      transition: width .35s ease;
      position:relative;
    }
    .fill::after{
      content:"";
      position:absolute;
      inset:0;
      background:
        repeating-linear-gradient(90deg, rgba(255,255,255,.22) 0 10px, transparent 10px 18px);
      opacity:.25;
      animation: shimmer 1.2s linear infinite;
    }
    @keyframes shimmer{
      from{ transform: translateX(0); }
      to{ transform: translateX(36px); }
    }
    .prog-meta{
      margin-top: 8px;
      display:flex;
      justify-content:space-between;
      gap: 12px;
      font-size: 13px;
      color: var(--muted);
    }

    /* right side: "game screen" */
    .screen{
      position:relative;
      border-radius: 16px;
      border: 1px solid rgba(255,255,255,.12);
      background:
        radial-gradient(800px 280px at 55% 20%, rgba(124,92,255,.18), transparent 60%),
        linear-gradient(to bottom, rgba(0,0,0,.25), rgba(0,0,0,.38));
      overflow:hidden;
      min-height: 230px;
      box-shadow: 0 16px 50px rgba(0,0,0,.35);
    }

    /* CRT / scanlines */
    .screen::before{
      content:"";
      position:absolute;
      inset:0;
      background:
        repeating-linear-gradient(
          to bottom,
          rgba(255,255,255,.05) 0 1px,
          rgba(0,0,0,0) 1px 3px
        );
      opacity:.22;
      pointer-events:none;
      mix-blend-mode: overlay;
    }
    .screen::after{
      content:"";
      position:absolute;
      inset:-20%;
      background: radial-gradient(circle at 50% 40%, rgba(255,255,255,.10), transparent 55%);
      opacity:.35;
      animation: glow 6s ease-in-out infinite;
      pointer-events:none;
    }
    @keyframes glow{
      0%,100%{ transform: translate3d(0,0,0); opacity:.28;}
      50%{ transform: translate3d(2%, -2%, 0); opacity:.42;}
    }

    /* character + props */
    .playfield{
      position:absolute;
      left:0; right:0; bottom:0;
      height: 78%;
    }

    .groundline{
      position:absolute;
      left:0; right:0; bottom: 18px;
      height: 3px;
      background: rgba(56,230,181,.35);
      opacity:.65;
      filter: blur(.2px);
    }

    .runner{
      position:absolute;
      left: 16%;
      bottom: 22px;
      width: 68px;
      height: 68px;
      transform: translateZ(0);
      animation: bob 0.7s ease-in-out infinite;
    }
    @keyframes bob{
      0%,100%{ transform: translate3d(0,0,0); }
      50%{ transform: translate3d(0,-3px,0); }
    }

    /* Pixel “robot” made of divs */
    .robot{
      position:absolute;
      left: 8px;
      top: 6px;
      width: 52px;
      height: 52px;
      image-rendering: pixelated;
    }
    .px{
      position:absolute;
      width: var(--pixel);
      height: var(--pixel);
      background: #fff;
      opacity:.0;
    }

    /* We'll draw robot with box-shadow pixels for performance */
    .robot::before{
      content:"";
      position:absolute;
      left: 10px;
      top: 8px;
      width: var(--pixel);
      height: var(--pixel);
      background: transparent;
      box-shadow:
        /* head */
        0px 0px #b9c7ff, 2px 0px #b9c7ff, 4px 0px #b9c7ff, 6px 0px #b9c7ff, 8px 0px #b9c7ff, 10px 0px #b9c7ff,
        0px 2px #b9c7ff, 2px 2px #0b1020, 4px 2px #0b1020, 6px 2px #0b1020, 8px 2px #0b1020, 10px 2px #b9c7ff,
        0px 4px #b9c7ff, 2px 4px #0b1020, 4px 4px #38e6b5, 6px 4px #38e6b5, 8px 4px #0b1020, 10px 4px #b9c7ff,
        0px 6px #b9c7ff, 2px 6px #0b1020, 4px 6px #0b1020, 6px 6px #0b1020, 8px 6px #0b1020, 10px 6px #b9c7ff,
        0px 8px #b9c7ff, 2px 8px #b9c7ff, 4px 8px #b9c7ff, 6px 8px #b9c7ff, 8px 8px #b9c7ff, 10px 8px #b9c7ff,

        /* body */
        4px 10px #7c5cff, 6px 10px #7c5cff,
        2px 12px #7c5cff, 4px 12px #7c5cff, 6px 12px #7c5cff, 8px 12px #7c5cff,
        2px 14px #7c5cff, 4px 14px #0b1020, 6px 14px #0b1020, 8px 14px #7c5cff,
        2px 16px #7c5cff, 4px 16px #7c5cff, 6px 16px #7c5cff, 8px 16px #7c5cff,

        /* legs */
        4px 18px #b9c7ff, 6px 18px #b9c7ff,
        4px 20px #b9c7ff, 6px 20px #b9c7ff;
      transform: scale(2.1);
      transform-origin: top left;
      filter: drop-shadow(0 10px 18px rgba(0,0,0,.35));
    }

    /* walking legs via pseudo overlay */
    .runner::after{
      content:"";
      position:absolute;
      left: 8px;
      top: 6px;
      width: 52px;
      height: 52px;
      background: transparent;
      box-shadow:
        18px 52px rgba(0,0,0,0);
      animation: walk 0.55s steps(2) infinite;
    }
    @keyframes walk{
      0%{ transform: translate3d(0,0,0); }
      50%{ transform: translate3d(0,1px,0); }
      100%{ transform: translate3d(0,0,0); }
    }

    /* server rack prop */
    .server{
      position:absolute;
      right: 12%;
      bottom: 22px;
      width: 90px;
      height: 96px;
      border-radius: 10px;
      background: linear-gradient(#0b1020, #060814);
      border: 1px solid rgba(255,255,255,.10);
      box-shadow: 0 18px 40px rgba(0,0,0,.45);
      overflow:hidden;
    }
    .server .slot{
      margin: 10px 10px 0;
      height: 16px;
      border-radius: 8px;
      background: rgba(255,255,255,.07);
      border: 1px solid rgba(255,255,255,.08);
      position:relative;
      overflow:hidden;
    }
    .server .slot::after{
      content:"";
      position:absolute;
      left: 10px; top: 50%;
      width: 8px; height: 8px;
      margin-top: -4px;
      border-radius: 999px;
      background: var(--accent2);
      box-shadow: 0 0 0 4px rgba(56,230,181,.10);
      animation: blink 1.1s steps(2) infinite;
    }
    .server .slot:nth-child(2)::after{ animation-duration: 0.9s; background: var(--accent); box-shadow: 0 0 0 4px rgba(124,92,255,.12);}
    .server .slot:nth-child(3)::after{ animation-duration: 1.3s; background: #ffd86a; box-shadow: 0 0 0 4px rgba(255,216,106,.12);}
    @keyframes blink{ 0%,100%{ opacity:.35; } 50%{ opacity:1; } }

    /* sparks near server */
    .spark{
      position:absolute;
      right: 21%;
      bottom: 86px;
      width: 10px;
      height: 10px;
      border-radius: 3px;
      background: linear-gradient(#fff, #ffd86a);
      opacity:.0;
      transform: rotate(15deg);
      animation: spark 1.8s ease-in-out infinite;
      filter: drop-shadow(0 10px 16px rgba(0,0,0,.35));
    }
    .spark:nth-child(2){ animation-delay: .35s; right: 24%; bottom: 72px; }
    .spark:nth-child(3){ animation-delay: .8s; right: 19%; bottom: 70px; }
    @keyframes spark{
      0%{ opacity:0; transform: translate3d(0,8px,0) rotate(15deg) scale(.8); }
      20%{ opacity:1; }
      40%{ opacity:0; transform: translate3d(10px,-10px,0) rotate(45deg) scale(1); }
      100%{ opacity:0; }
    }

    /* HUD top */
    .hud{
      position:absolute;
      left: 14px;
      top: 12px;
      display:flex;
      gap: 10px;
      align-items:center;
      font-size: 12.5px;
      color: rgba(233,240,255,.9);
      opacity:.92;
    }
    .hud .mini{
      padding: 7px 10px;
      border-radius: 999px;
      background: rgba(255,255,255,.06);
      border: 1px solid rgba(255,255,255,.10);
      backdrop-filter: blur(6px);
      display:flex;
      align-items:center;
      gap:8px;
      white-space:nowrap;
    }
    .mini b{ font-weight: 700; }
    .hp{
      width: 90px;
      height: 8px;
      border-radius: 999px;
      background: rgba(255,255,255,.10);
      overflow:hidden;
      position:relative;
    }
    .hp .hpfill{
      height:100%;
      width: 68%;
      background: linear-gradient(90deg, var(--danger), #ffd86a);
      animation: hpwiggle 3.2s ease-in-out infinite;
    }
    @keyframes hpwiggle{
      0%,100%{ width: 62%; }
      50%{ width: 78%; }
    }

    /* Footer hint */
    .foot{
      margin-top: 14px;
      display:flex;
      gap: 10px;
      flex-wrap:wrap;
      align-items:center;
      color: rgba(233,240,255,.88);
      font-size: 13px;
    }
    .link{
      color: var(--text);
      text-decoration:none;
      border-bottom: 1px dashed rgba(233,240,255,.35);
    }
    .link:hover{ border-bottom-color: rgba(233,240,255,.75); }

    /* make it look crisp on low DPI too */
    @media (prefers-reduced-motion: reduce){
      *{ animation: none !important; transition: none !important; }
    }
  </style>
</head>
<body>
  <div class="scene">
    <div class="sky">
      <div class="stars"></div>
    </div>

    <div class="parallax" aria-hidden="true">
      <div class="layer back"></div>
      <div class="layer mid"></div>
      <div class="layer front"></div>
      <div class="coins" id="coins"></div>
    </div>

    <main class="panel" role="main" aria-label="Halaman maintenance">
      <div class="panel-inner">
        <!-- LEFT: copy + progress -->
        <section>
          <div class="headline">
            <div class="badge" aria-hidden="true"></div>
            <div>
              <h1>Server lagi di-upgrade 🛠️</h1>
              <p class="sub">
                Kita sedang “respawn” sistem biar makin cepat dan stabil. Halaman ini sengaja dibuat
                seperti layar game — tapi tenang, ini cuma animasi.
              </p>
            </div>
          </div>

          <div class="status-row">
            <div class="chip"><span class="dot" aria-hidden="true"></span><span id="statusText">Compiling shaders…</span></div>
            <div class="chip">ETA: <span id="etaText">~2–4 menit</span></div>
            <div class="chip">Build: <b id="buildText">v1.0.7</b></div>
          </div>

          <div class="progress" aria-label="Progress maintenance">
            <div class="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="12">
              <div class="fill" id="fill"></div>
            </div>
            <div class="prog-meta">
              <span id="percentText">12%</span>
              <span id="tipText">Tip: minum air dulu 🌊</span>
            </div>
          </div>

          <div class="foot">
            <span>Kalau urgent:</span>
            <a class="link" href="mailto:support@yourdomain.com">support@yourdomain.com</a>
            <span>•</span>
            <a class="link" href="/" onclick="return false;">Coba refresh nanti</a>
          </div>
        </section>

        <!-- RIGHT: "game screen" -->
        <aside class="screen" aria-label="Animasi gaya game">
          <div class="hud" aria-hidden="true">
            <div class="mini">QUEST: <b>Patch The Realm</b></div>
            <div class="mini">SERVER HP
              <span class="hp"><span class="hpfill"></span></span>
            </div>
          </div>

          <div class="playfield" aria-hidden="true">
            <div class="groundline"></div>

            <div class="runner" title="robot-runner">
              <div class="robot"></div>
            </div>

            <div class="server" title="server-rack">
              <div class="slot"></div>
              <div class="slot"></div>
              <div class="slot"></div>
              <div class="slot"></div>
            </div>

            <div class="spark"></div>
            <div class="spark"></div>
            <div class="spark"></div>
          </div>
        </aside>
      </div>
    </main>
  </div>

  <script>
    // --- Floating coins (pure decor) ---
    const coinsWrap = document.getElementById('coins');
    const COIN_COUNT = 10;

    function rand(min, max){ return Math.random() * (max - min) + min; }

    for (let i=0; i<COIN_COUNT; i++){
      const c = document.createElement('div');
      c.className = 'coin';
      c.style.left = rand(6, 94) + '%';
      c.style.top  = rand(12, 62) + '%';
      c.style.animationDelay = rand(0, 2.8) + 's';
      c.style.animationDuration = rand(2.6, 4.2) + 's, ' + rand(0.9, 1.5) + 's';
      c.style.opacity = rand(0.55, 0.95);
      coinsWrap.appendChild(c);
    }

    // --- Progress loop + changing status ---
    const fill = document.getElementById('fill');
    const percentText = document.getElementById('percentText');
    const statusText = document.getElementById('statusText');
    const etaText = document.getElementById('etaText');
    const tipText = document.getElementById('tipText');
    const progBar = document.querySelector('[role="progressbar"]');

    const statuses = [
      "Checking inventory…",
      "Patching binaries…",
      "Compiling shaders…",
      "Summoning uptime…",
      "Restarting dungeon…",
      "Optimizing loot tables…",
      "Cleaning cache goblins…",
      "Deploying hotfix…",
      "Migrating scrolls (DB)…",
      "Warming up servers…"
    ];

    const tips = [
      "Tip: minum air dulu 🌊",
      "Tip: stretch 10 detik 🧘",
      "Tip: tarik napas — pelan 😮‍💨",
      "Tip: cek lagi 2 menit ya ⏳",
      "Tip: jangan panik, cuma maintenance 😄"
    ];

    let p = 12;
    let statusIdx = 2;
    let tipIdx = 0;

    function setProgress(val){
      const v = Math.max(0, Math.min(100, val));
      fill.style.width = v + "%";
      percentText.textContent = v + "%";
      progBar.setAttribute("aria-valuenow", String(v));
    }

    function loop(){
      // random-ish increment
      const inc = Math.random() < 0.15 ? rand(0, 2) : rand(2, 7);
      p = p + inc;

      // playful slow-down near the end, then "complete" and restart
      if (p > 92) p += rand(0, 1.2);
      if (p >= 100){
        p = 100;
        setProgress(100);
        statusText.textContent = "Finishing touches…";
        etaText.textContent = "sebentar lagi";
        tipText.textContent = "Tip: refresh halaman dalam beberapa detik ✨";

        setTimeout(() => {
          // restart loop like a game loading screen
          p = rand(6, 18);
          statusIdx = Math.floor(rand(0, statuses.length));
          tipIdx = Math.floor(rand(0, tips.length));
          statusText.textContent = statuses[statusIdx];
          etaText.textContent = "~2–4 menit";
          tipText.textContent = tips[tipIdx];
          setProgress(Math.round(p));
        }, 1400);

        return;
      }

      // rotate status/tip occasionally
      if (Math.random() < 0.22){
        statusIdx = (statusIdx + 1) % statuses.length;
        statusText.textContent = statuses[statusIdx];
      }
      if (Math.random() < 0.12){
        tipIdx = (tipIdx + 1) % tips.length;
        tipText.textContent = tips[tipIdx];
      }

      setProgress(Math.round(p));
      setTimeout(loop, rand(520, 980));
    }

    setProgress(Math.round(p));
    setTimeout(loop, 700);

    // Randomize build label each load
    const buildText = document.getElementById('buildText');
    const major = 1, minor = 0, patch = Math.floor(rand(5, 12));
    buildText.textContent = `v${major}.${minor}.${patch}`;
  </script>
</body>
</html>

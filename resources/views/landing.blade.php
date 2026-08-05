<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#6c63ff">

    <title>SITAKRO | Akses Ditutup Sementara</title>
    <link rel="shortcut icon" href="{{ asset('assets2/img/logodesa.png') }}" type="image/x-icon">

    <style>
        :root {
            --purple: #6c63ff;
            --purple-dark: #4f46d9;
            --pink: #ff7eb6;
            --yellow: #ffd166;
            --mint: #69e6c2;
            --ink: #25243a;
            --muted: #6f6d86;
            --paper: #ffffff;
            --shadow: 0 25px 70px rgba(65, 55, 145, 0.22);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 28px 16px;
            overflow-x: hidden;
            color: var(--ink);
            background:
                radial-gradient(circle at 12% 15%, rgba(255, 209, 102, .55) 0 8%, transparent 9%),
                radial-gradient(circle at 88% 18%, rgba(105, 230, 194, .42) 0 10%, transparent 11%),
                radial-gradient(circle at 82% 88%, rgba(255, 126, 182, .30) 0 12%, transparent 13%),
                linear-gradient(135deg, #f5f1ff 0%, #eef8ff 45%, #fff7ec 100%);
            font-family: "Trebuchet MS", "Segoe UI", Arial, sans-serif;
        }

        .background-decor {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .bubble {
            position: absolute;
            border: 3px solid rgba(108, 99, 255, .16);
            border-radius: 50%;
            animation: floatBubble 7s ease-in-out infinite;
        }

        .bubble:nth-child(1) {
            width: 74px;
            height: 74px;
            top: 9%;
            left: 6%;
        }

        .bubble:nth-child(2) {
            width: 42px;
            height: 42px;
            top: 72%;
            left: 12%;
            animation-delay: -2s;
        }

        .bubble:nth-child(3) {
            width: 98px;
            height: 98px;
            top: 60%;
            right: 5%;
            animation-delay: -4s;
        }

        .star {
            position: absolute;
            font-size: clamp(20px, 3vw, 36px);
            animation: twinkle 2.2s ease-in-out infinite;
        }

        .star.one {
            top: 12%;
            right: 12%;
        }

        .star.two {
            bottom: 12%;
            left: 8%;
            animation-delay: -1s;
        }

        .maintenance-card {
            position: relative;
            width: min(920px, 100%);
            padding: clamp(28px, 5vw, 62px);
            text-align: center;
            background: rgba(255, 255, 255, .88);
            border: 2px solid rgba(255, 255, 255, .95);
            border-radius: 34px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            isolation: isolate;
        }

        .maintenance-card::before,
        .maintenance-card::after {
            content: "";
            position: absolute;
            z-index: -1;
            border-radius: 999px;
            filter: blur(2px);
        }

        .maintenance-card::before {
            width: 130px;
            height: 130px;
            top: -32px;
            left: -28px;
            background: rgba(255, 209, 102, .48);
        }

        .maintenance-card::after {
            width: 150px;
            height: 150px;
            right: -36px;
            bottom: -42px;
            background: rgba(105, 230, 194, .35);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            min-height: 54px;
            margin-bottom: 22px;
            padding: 8px 18px;
            border: 1px solid #ebe9ff;
            border-radius: 999px;
            background: #fff;
            box-shadow: 0 8px 24px rgba(55, 46, 126, .10);
            font-weight: 900;
            letter-spacing: .08em;
            color: var(--purple-dark);
        }

        .brand img {
            width: 38px;
            height: 38px;
            object-fit: contain;
        }

        .brand img.is-hidden {
            display: none;
        }

        .brand-fallback {
            display: none;
            width: 38px;
            height: 38px;
            place-items: center;
            border-radius: 12px;
            color: #fff;
            background: linear-gradient(135deg, var(--purple), var(--pink));
        }

        .brand-fallback.is-visible {
            display: grid;
        }

        .lock-scene {
            position: relative;
            width: 190px;
            height: 190px;
            margin: 0 auto 25px;
            animation: hover 3.2s ease-in-out infinite;
        }

        .lock-body {
            position: absolute;
            left: 34px;
            bottom: 18px;
            width: 122px;
            height: 104px;
            border: 5px solid #3f3977;
            border-radius: 30px 30px 38px 38px;
            background: linear-gradient(145deg, #8b83ff, var(--purple));
            box-shadow: 0 18px 30px rgba(79, 70, 217, .28);
        }

        .lock-body::before {
            content: "";
            position: absolute;
            left: 26px;
            top: -74px;
            width: 62px;
            height: 78px;
            border: 11px solid #3f3977;
            border-bottom: 0;
            border-radius: 40px 40px 0 0;
        }

        .eye {
            position: absolute;
            top: 33px;
            width: 10px;
            height: 13px;
            border-radius: 50%;
            background: #292540;
            animation: blink 4s infinite;
        }

        .eye.left {
            left: 35px;
        }

        .eye.right {
            right: 35px;
        }

        .mouth {
            position: absolute;
            left: 50%;
            top: 60px;
            width: 30px;
            height: 15px;
            transform: translateX(-50%);
            border-bottom: 4px solid #292540;
            border-radius: 0 0 50% 50%;
        }

        .cheek {
            position: absolute;
            top: 54px;
            width: 16px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 126, 182, .75);
        }

        .cheek.left {
            left: 17px;
        }

        .cheek.right {
            right: 17px;
        }

        .key-hole {
            position: absolute;
            left: 50%;
            bottom: 13px;
            width: 13px;
            height: 23px;
            transform: translateX(-50%);
            border-radius: 9px 9px 5px 5px;
            background: #403a78;
        }

        .spark {
            position: absolute;
            font-size: 26px;
            animation: twinkle 1.9s ease-in-out infinite;
        }

        .spark.first {
            top: 24px;
            right: 10px;
        }

        .spark.second {
            bottom: 18px;
            left: 6px;
            animation-delay: -.9s;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 18px;
            padding: 8px 15px;
            border-radius: 999px;
            color: #8b5b00;
            background: #fff5ce;
            border: 1px solid #ffe69a;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .status-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #ffad1f;
            box-shadow: 0 0 0 6px rgba(255, 173, 31, .16);
            animation: pulse 1.6s ease-out infinite;
        }

        h1 {
            max-width: 780px;
            margin: 0 auto;
            font-size: clamp(30px, 5.5vw, 62px);
            line-height: 1.08;
            letter-spacing: -.035em;
            font-weight: 1000;
            text-wrap: balance;
        }

        h1 .highlight {
            display: inline-block;
            color: var(--purple);
            text-shadow: 3px 4px 0 rgba(255, 209, 102, .55);
        }

        .description {
            max-width: 660px;
            margin: 22px auto 0;
            color: var(--muted);
            font-size: clamp(15px, 2vw, 18px);
            line-height: 1.75;
        }

        .countdown-title {
            margin-top: 29px;
            color: #4f4c67;
            font-size: 14px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .12em;
        }

        .countdown {
            display: grid;
            grid-template-columns: repeat(4, minmax(76px, 1fr));
            gap: 12px;
            max-width: 590px;
            margin: 13px auto 0;
        }

        .time-box {
            padding: 15px 8px 13px;
            border: 1px solid #ebe9ff;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 10px 24px rgba(65, 55, 145, .09);
        }

        .time-value {
            display: block;
            color: var(--purple-dark);
            font-size: clamp(25px, 4vw, 38px);
            line-height: 1;
            font-weight: 1000;
            font-variant-numeric: tabular-nums;
        }

        .time-label {
            display: block;
            margin-top: 7px;
            color: #8a879c;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .fun-button {
            appearance: none;
            border: 0;
            margin-top: 28px;
            padding: 14px 22px;
            border-radius: 16px;
            color: #fff;
            background: linear-gradient(135deg, var(--purple), #8d72ff);
            box-shadow: 0 12px 24px rgba(79, 70, 217, .28);
            font: inherit;
            font-weight: 900;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .fun-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 30px rgba(79, 70, 217, .34);
        }

        .fun-button:active {
            transform: translateY(0) scale(.98);
        }

        .footer-note {
            margin-top: 25px;
            color: #9996aa;
            font-size: 13px;
        }

        .toast {
            position: fixed;
            left: 50%;
            bottom: 25px;
            z-index: 99;
            width: min(92vw, 430px);
            padding: 13px 18px;
            transform: translate(-50%, 25px);
            border-radius: 16px;
            color: #fff;
            background: #292540;
            box-shadow: 0 14px 35px rgba(27, 24, 54, .32);
            text-align: center;
            font-weight: 800;
            opacity: 0;
            visibility: hidden;
            transition: .3s ease;
        }

        .toast.show {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, 0);
        }

        .shake {
            animation: shake .45s ease-in-out;
        }

        @keyframes hover {
            0%, 100% { transform: translateY(0) rotate(-1deg); }
            50% { transform: translateY(-10px) rotate(1deg); }
        }

        @keyframes blink {
            0%, 45%, 50%, 100% { transform: scaleY(1); }
            47% { transform: scaleY(.08); }
        }

        @keyframes twinkle {
            0%, 100% { transform: scale(.85) rotate(-8deg); opacity: .55; }
            50% { transform: scale(1.18) rotate(8deg); opacity: 1; }
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(255, 173, 31, .35); }
            70% { box-shadow: 0 0 0 10px rgba(255, 173, 31, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 173, 31, 0); }
        }

        @keyframes floatBubble {
            0%, 100% { transform: translateY(0) rotate(0); }
            50% { transform: translateY(-18px) rotate(10deg); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-9px) rotate(-1deg); }
            40% { transform: translateX(8px) rotate(1deg); }
            60% { transform: translateX(-6px); }
            80% { transform: translateX(4px); }
        }

        @media (max-width: 600px) {
            body {
                padding: 14px;
            }

            .maintenance-card {
                padding: 28px 16px 30px;
                border-radius: 26px;
            }

            .lock-scene {
                width: 165px;
                height: 165px;
                transform: scale(.9);
                margin-bottom: 12px;
            }

            .countdown {
                grid-template-columns: repeat(2, minmax(100px, 1fr));
                max-width: 360px;
            }

            .description {
                line-height: 1.6;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>
<body>
    <div class="background-decor" aria-hidden="true">
        <span class="bubble"></span>
        <span class="bubble"></span>
        <span class="bubble"></span>
        <span class="star one">✨</span>
        <span class="star two">⭐</span>
    </div>

    <main class="maintenance-card" id="maintenanceCard">
        <div class="brand">
            <img
                id="brandLogo"
                src="{{ asset('assets/images/logositakro.png') }}"
                alt="Logo SITAKRO"
            >
            <span class="brand-fallback" id="brandFallback" aria-hidden="true">S</span>
            <span>KEMIRIGEDE</span>
        </div>

        <div class="lock-scene" aria-hidden="true">
            <span class="spark first">✨</span>
            <span class="spark second">⭐</span>
            <div class="lock-body">
                <span class="eye left"></span>
                <span class="eye right"></span>
                <span class="cheek left"></span>
                <span class="cheek right"></span>
                <span class="mouth"></span>
                <span class="key-hole"></span>
            </div>
        </div>

        <div class="status-pill">
            <span class="status-dot"></span>
            Akses sedang dikunci
        </div>

        <h1>
            AKSES WEBSITE MASIH DI TUTUP SEMENTARA
            <span class="highlight">DIBUKA TAHUN 2027</span>
        </h1>

        <p class="description">
            Tenang, websitenya tidak hilang kok. SITAKRO sedang istirahat sebentar
            dan akan kembali menyapa pada tahun 2027. 🔐
        </p>

        <p class="countdown-title" id="countdownTitle">Menuju 1 Januari 2027</p>

        <section class="countdown" id="countdown" aria-label="Hitung mundur menuju tahun 2027">
            <div class="time-box">
                <span class="time-value" id="days">000</span>
                <span class="time-label">Hari</span>
            </div>
            <div class="time-box">
                <span class="time-value" id="hours">00</span>
                <span class="time-label">Jam</span>
            </div>
            <div class="time-box">
                <span class="time-value" id="minutes">00</span>
                <span class="time-label">Menit</span>
            </div>
            <div class="time-box">
                <span class="time-value" id="seconds">00</span>
                <span class="time-label">Detik</span>
            </div>
        </section>

        <button class="fun-button" id="tryButton" type="button">
            🔑 Coba Buka Sekarang
        </button>

        <p class="footer-note">
            &copy; <span id="currentYear"></span> SITAKRO Desa Wates
        </p>
    </main>

    <div class="toast" id="toast" role="status" aria-live="polite">
        Belum bisa dibuka ya... kuncinya baru aktif tahun 2027 😄
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            'use strict';

            const openingDate = new Date('2027-01-01T00:00:00+07:00').getTime();
            const card = document.getElementById('maintenanceCard');
            const toast = document.getElementById('toast');
            const tryButton = document.getElementById('tryButton');
            const logo = document.getElementById('brandLogo');
            const fallback = document.getElementById('brandFallback');

            const elements = {
                days: document.getElementById('days'),
                hours: document.getElementById('hours'),
                minutes: document.getElementById('minutes'),
                seconds: document.getElementById('seconds'),
                title: document.getElementById('countdownTitle')
            };

            let toastTimer;

            function pad(value, length = 2) {
                return String(value).padStart(length, '0');
            }

            function updateCountdown() {
                const distance = openingDate - Date.now();

                if (distance <= 0) {
                    elements.days.textContent = '000';
                    elements.hours.textContent = '00';
                    elements.minutes.textContent = '00';
                    elements.seconds.textContent = '00';
                    elements.title.textContent = 'Tahun 2027 sudah tiba';
                    return;
                }

                const day = Math.floor(distance / 86400000);
                const hour = Math.floor((distance % 86400000) / 3600000);
                const minute = Math.floor((distance % 3600000) / 60000);
                const second = Math.floor((distance % 60000) / 1000);

                elements.days.textContent = pad(day, 3);
                elements.hours.textContent = pad(hour);
                elements.minutes.textContent = pad(minute);
                elements.seconds.textContent = pad(second);
            }

            function showLockedMessage() {
                card.classList.remove('shake');
                void card.offsetWidth;
                card.classList.add('shake');

                toast.classList.add('show');
                clearTimeout(toastTimer);
                toastTimer = setTimeout(function () {
                    toast.classList.remove('show');
                }, 3000);
            }

            tryButton.addEventListener('click', showLockedMessage);

            logo.addEventListener('error', function () {
                logo.classList.add('is-hidden');
                fallback.classList.add('is-visible');
            });

            document.getElementById('currentYear').textContent = new Date().getFullYear();

            updateCountdown();
            window.setInterval(updateCountdown, 1000);
        });
    </script>
</body>
</html>

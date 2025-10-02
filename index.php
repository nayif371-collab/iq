<?php /* Homepage */ ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>IQ Test | Home</title>
  <style>
    :root{
      --bg1:#0f172a; --bg2:#111827; --card:#0b1022; --accent:#7c3aed; --accent2:#22d3ee;
      --text:#e5e7eb; --muted:#9ca3af; --ok:#22c55e; --warn:#f59e0b; --err:#ef4444;
      --shadow: 0 20px 60px rgba(0,0,0,.35), inset 0 0 0 1px rgba(255,255,255,.04);
      --radius: 22px;
    }
    *{box-sizing:border-box}
    body{
      margin:0; min-height:100svh; color:var(--text); font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, "Noto Sans", "Helvetica Neue", sans-serif;
      background: radial-gradient(1200px 600px at 20% -10%, rgba(124,58,237,.25), transparent),
                  radial-gradient(1000px 500px at 110% 10%, rgba(34,211,238,.18), transparent),
                  linear-gradient(180deg, var(--bg1), var(--bg2));
      display:grid; place-items:center; padding:24px;
    }
    .wrap{max-width:1080px; width:100%}
    .hero{
      background: linear-gradient(180deg, rgba(255,255,255,.03), rgba(255,255,255,.01));
      border:1px solid rgba(255,255,255,.06);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: clamp(20px, 4vw, 40px);
      display:grid; gap:20px;
      backdrop-filter: blur(6px);
    }
    h1{
      font-size: clamp(28px, 4vw, 48px); margin:0;
      line-height:1.1; letter-spacing:.2px;
      background: linear-gradient(90deg, #fff, #c7d2fe);
      -webkit-background-clip:text; background-clip:text; color:transparent;
    }
    .sub{color:var(--muted); font-size: clamp(14px, 2vw, 18px); line-height:1.6}
    .pill{
      display:inline-flex; gap:10px; align-items:center; padding:10px 14px; border-radius:999px;
      background: rgba(124,58,237,.12); border:1px solid rgba(124,58,237,.35);
      color:#ddd; font-weight:600; width:fit-content
    }
    .grid{display:grid; gap:14px; grid-template-columns: repeat(3, minmax(0,1fr))}
    .card{
      background: linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,.01));
      border:1px solid rgba(255,255,255,.06);
      border-radius: 18px; padding:16px; box-shadow: var(--shadow);
      display:grid; gap:8px
    }
    .muted{color:var(--muted); font-size:14px}
    .cta{
      display:flex; gap:12px; flex-wrap:wrap; margin-top:10px
    }
    .btn{
      cursor:pointer; border:none; border-radius:14px; padding:14px 18px; font-weight:700;
      letter-spacing:.3px; font-size:16px; transition:.2s transform, .2s box-shadow, .2s background;
      box-shadow: 0 10px 30px rgba(124,58,237,.35);
      background: linear-gradient(90deg, var(--accent), #5b21b6);
      color:white
    }
    .btn:hover{ transform: translateY(-1px) }
    .btn.alt{
      background: linear-gradient(90deg, var(--accent2), #0593a8);
      box-shadow: 0 10px 30px rgba(34,211,238,.35);
      color:#0b1220
    }
    footer{color:var(--muted); font-size:13px; text-align:center; margin-top:14px}
    @media (max-width:900px){ .grid{grid-template-columns: 1fr 1fr} }
    @media (max-width:640px){ .grid{grid-template-columns: 1fr} .cta{justify-content:stretch} .btn{flex:1} }
  </style>
</head>
<body>
  <div class="wrap">
    <section class="hero">
      <span class="pill">🧠 SmartCheck • Adaptive IQ Quiz</span>
      <h1>Measure your reasoning with a quick, research-inspired IQ test</h1>
      <p class="sub">
        This brief assessment samples <strong>logical reasoning</strong>, <strong>pattern recognition</strong>,
        and <strong>numerical ability</strong>. You’ll get an estimated IQ score (scaled to a 55–145 range),
        a strengths breakdown, and tips for improvement. Take around 8–10 minutes in a quiet place.
      </p>
 
      <div class="grid">
        <div class="card">
          <strong>Logical Reasoning</strong>
          <div class="muted">Deduction, syllogisms, conditionals</div>
        </div>
        <div class="card">
          <strong>Pattern Recognition</strong>
          <div class="muted">Analogies, sequences, visual logic</div>
        </div>
        <div class="card">
          <strong>Numerical Ability</strong>
          <div class="muted">Arithmetic puzzles, number patterns</div>
        </div>
      </div>
 
      <div class="cta">
        <button class="btn" id="start">Start Test</button>
        <button class="btn alt" id="how">How it works</button>
      </div>
    </section>
    <footer>© <?php echo date('Y'); ?> SmartCheck. For education only — not a clinical tool.</footer>
  </div>
 
  <script>
    // Clear any previous run
    localStorage.removeItem('iq_answers');
    // version your questions; results page will check this:
    localStorage.setItem('iq_version', 'v1');
 
    document.getElementById('start').addEventListener('click', () => {
      // JS redirection (no PHP header)
      window.location.href = 'quiz.php';
    });
 
    document.getElementById('how').addEventListener('click', () => {
      alert(
        "About this test:\\n\\n" +
        "• You’ll answer 15 multiple-choice questions.\\n" +
        "• Questions adapt in variety and difficulty.\\n" +
        "• Score is scaled to an IQ-style range (55–145).\\n" +
        "• You’ll see strengths and improvement tips at the end."
      );
    });
  </script>
</body>
</html>

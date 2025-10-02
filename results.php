<?php /* Results Page */ ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>IQ Test | Results</title>
  <style>
    :root{
      --bg:#0a0f1f; --panel:#0c132a; --border:rgba(255,255,255,.06); --muted:#9ca3af; --text:#e6e9ef;
      --primary:#7c3aed; --accent:#22d3ee; --ok:#22c55e; --warn:#f59e0b; --err:#ef4444;
      --radius:20px; --shadow:0 24px 70px rgba(0,0,0,.35), inset 0 0 0 1px rgba(255,255,255,.04);
    }
    *{box-sizing:border-box}
    body{
      margin:0; min-height:100svh; color:var(--text);
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, "Noto Sans", "Helvetica Neue", sans-serif;
      background:
        radial-gradient(900px 400px at 120% -10%, rgba(34,211,238,.15), transparent),
        radial-gradient(800px 400px at -10% 10%, rgba(124,58,237,.2), transparent),
        linear-gradient(180deg, #0f172a, #0a0f1f);
      display:grid; place-items:center; padding:18px;
    }
    .wrap{
      width:min(980px,100%);
      background: linear-gradient(180deg, rgba(255,255,255,.03), rgba(255,255,255,.01));
      border:1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow);
      padding: clamp(16px, 3vw, 28px); display:grid; gap:18px
    }
    .head{display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap}
    .badge{padding:8px 12px; background: rgba(124,58,237,.15); border:1px solid rgba(124,58,237,.35); border-radius:999px}
    h2{margin:0; font-size: clamp(20px, 3.2vw, 28px)}
    .score{
      display:grid; grid-template-columns: 1.2fr .8fr; gap:16px
    }
    .card{
      background: linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,.01));
      border:1px solid var(--border); border-radius: 16px; padding:16px; display:grid; gap:12px
    }
    .big{font-size: clamp(30px, 7vw, 64px); font-weight:900; line-height:1}
    .muted{color:var(--muted)}
    .bar{height:12px; border-radius:999px; background: rgba(255,255,255,.06); overflow:hidden}
    .fill{height:100%; width:0%; background: linear-gradient(90deg, var(--primary), var(--accent))}
    .grid{display:grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap:12px}
    .tag{font-size:12px; padding:6px 8px; border:1px solid rgba(255,255,255,.14); border-radius:999px; width:fit-content}
    .actions{display:flex; gap:10px; flex-wrap:wrap}
    .btn{cursor:pointer; border:none; border-radius:12px; padding:12px 16px; font-weight:800}
    .btn.primary{background: linear-gradient(90deg, var(--primary), #5b21b6); color:white}
    .btn.alt{background: linear-gradient(90deg, var(--accent), #0593a8); color:#001018}
    .list{display:grid; gap:8px}
    @media (max-width:880px){ .score{grid-template-columns: 1fr} }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="head">
      <div>
        <div class="badge">SmartCheck IQ</div>
        <h2>Your Results</h2>
      </div>
      <div class="tag" id="attempt"></div>
    </div>
 
    <section class="score">
      <div class="card">
        <div class="big" id="iq">—</div>
        <div class="muted" id="summary">Calculating…</div>
        <div class="bar"><div class="fill" id="fill"></div></div>
        <div class="grid">
          <div class="card">
            <strong>Logical</strong>
            <div class="muted"><span id="lg"></span>% correct</div>
          </div>
          <div class="card">
            <strong>Pattern</strong>
            <div class="muted"><span id="pt"></span>% correct</div>
          </div>
          <div class="card">
            <strong>Numerical</strong>
            <div class="muted"><span id="nm"></span>% correct</div>
          </div>
        </div>
      </div>
 
      <div class="card">
        <strong>Recommendations</strong>
        <div class="list" id="recs">
          <div class="muted">Loading suggestions…</div>
        </div>
        <div class="actions">
          <button class="btn primary" id="retake">Retake Test</button>
          <button class="btn alt" id="share">Share Result</button>
          <button class="btn" id="copy" style="border:1px solid rgba(255,255,255,.18)">Copy Summary</button>
        </div>
      </div>
    </section>
 
    <div class="muted" style="text-align:center">Note: This is an educational estimate, not a clinical diagnosis.</div>
  </div>
 
  <script>
    // Load persisted data
    const version = localStorage.getItem('iq_version') || 'v1';
    const qKey = 'iq_questions_'+version;
    const questions = JSON.parse(localStorage.getItem(qKey) || '[]');
    const answers = JSON.parse(localStorage.getItem('iq_answers') || '[]');
 
    if(!questions.length || !answers.length){
      alert('No quiz data found. Redirecting to start.');
      window.location.href = 'index.php';
    }
 
    // Score computation
    const total = questions.length;
    let correct = 0;
    const byDomain = {};
    const byDomainCorrect = {};
    questions.forEach((q, i) => {
      byDomain[q.domain] = (byDomain[q.domain]||0) + 1;
      if(answers[i] === q.answer){
        correct++;
        byDomainCorrect[q.domain] = (byDomainCorrect[q.domain]||0) + 1;
      }
    });
 
    const pct = Math.round((correct/total)*100);
    // Simple IQ scaling 55–145 (educational only)
    const IQ = Math.round(55 + (correct/total)*90);
 
    // UI Bindings
    document.getElementById('iq').textContent = `${IQ}`;
    document.getElementById('summary').textContent =
      `You answered ${correct} of ${total} correctly (${pct}%). Estimated IQ: ${IQ}.`;
    document.getElementById('fill').style.width = `${pct}%`;
 
    // domain percents
    const lgPct = Math.round(((byDomainCorrect['Logical Reasoning']||0)/(byDomain['Logical Reasoning']||1))*100);
    const ptPct = Math.round(((byDomainCorrect['Pattern Recognition']||0)/(byDomain['Pattern Recognition']||1))*100);
    const nmPct = Math.round(((byDomainCorrect['Numerical Ability']||0)/(byDomain['Numerical Ability']||1))*100);
    document.getElementById('lg').textContent = isNaN(lgPct)?0:lgPct;
    document.getElementById('pt').textContent = isNaN(ptPct)?0:ptPct;
    document.getElementById('nm').textContent = isNaN(nmPct)?0:nmPct;
 
    // attempt tag
    const dt = new Date();
    document.getElementById('attempt').textContent = `Attempt: ${dt.toLocaleDateString()} ${dt.toLocaleTimeString()}`;
 
    // Recommendations (personalized based on weaker areas)
    const recs = [];
    function pushRec(title, tip){
      const div = document.createElement('div');
      div.innerHTML = `<strong>${title}:</strong> <span class="muted">${tip}</span>`;
      document.getElementById('recs').appendChild(div);
    }
    const list = document.getElementById('recs'); list.innerHTML='';
 
    if (lgPct < 80) pushRec('Logical Reasoning',
      'Practice syllogisms & conditional logic. Explain why each wrong option is wrong.');
    else pushRec('Logical Reasoning', 'Great! Try LSAT-style logic games to push further.');
 
    if (ptPct < 80) pushRec('Pattern Recognition',
      'Do analogies and sequence puzzles. Spot how numbers change (add, multiply, alternate).');
    else pushRec('Pattern Recognition', 'Advance to matrix patterns and Raven-style problems.');
 
    if (nmPct < 80) pushRec('Numerical Ability',
      'Strengthen mental math: percents, averages, and speed arithmetic.');
    else pushRec('Numerical Ability', 'Explore number theory puzzles and speed drills.');
 
    if (pct < 50) pushRec('General Strategy',
      'Slow down slightly, read carefully, and eliminate two options before choosing.');
    else if (pct >= 85) pushRec('Challenge',
      'Consider timed practice and mixed high-difficulty sets.');
 
    // Actions
    document.getElementById('retake').addEventListener('click', () => {
      localStorage.removeItem('iq_answers');
      // JS redirection
      window.location.href = 'quiz.php';
    });
 
    document.getElementById('share').addEventListener('click', async () => {
      const text = `I just took the SmartCheck IQ test! Score: ${IQ} (Correct: ${correct}/${total}).`;
      if (navigator.share) {
        try { await navigator.share({title:'My IQ Result', text}); }
        catch(e){}
      } else {
        alert('Sharing not supported. Use Copy Summary instead.');
      }
    });
 
    document.getElementById('copy').addEventListener('click', async () => {
      const lines = [
        `SmartCheck IQ Result`,
        `Estimated IQ: ${IQ}`,
        `Correct: ${correct}/${total} (${pct}%)`,
        `Logical: ${lgPct}% | Pattern: ${ptPct}% | Numerical: ${nmPct}%`,
        `Date: ${dt.toLocaleDateString()} ${dt.toLocaleTimeString()}`
      ].join('\n');
      try{
        await navigator.clipboard.writeText(lines);
        alert('Summary copied to clipboard!');
      }catch(e){
        alert('Copy failed. Select and copy manually:\n\n'+lines);
      }
    });
  </script>
</body>
</html>
 
Syntax highlighting powered by GeSHi
Help Guide | License

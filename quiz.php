<?php /* Quiz Page */ ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>IQ Test | Quiz</title>
  <style>
    :root{
      --bg:#0b1020; --panel:#0c132a; --border:rgba(255,255,255,.06); --muted:#9ca3af; --text:#e6e9ef;
      --primary:#7c3aed; --primary2:#22d3ee; --ok:#22c55e; --warn:#f59e0b; --err:#ef4444;
      --radius:20px; --shadow:0 20px 60px rgba(0,0,0,.35), inset 0 0 0 1px rgba(255,255,255,.04);
    }
    *{box-sizing:border-box}
    body{
      margin:0; min-height:100svh; color:var(--text);
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, "Noto Sans", "Helvetica Neue", sans-serif;
      background:
        radial-gradient(900px 400px at 120% -10%, rgba(34,211,238,.15), transparent),
        radial-gradient(800px 400px at -10% 10%, rgba(124,58,237,.2), transparent),
        linear-gradient(180deg, #0f172a, #0b1020);
      display:grid; place-items:center; padding:18px;
    }
    .shell{
      width: min(980px, 100%);
      background: linear-gradient(180deg, rgba(255,255,255,.03), rgba(255,255,255,.01));
      border:1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow);
      padding: clamp(16px, 3vw, 28px); display:grid; gap:18px
    }
    .top{display:flex; justify-content:space-between; gap:10px; align-items:center; flex-wrap:wrap}
    .badge{padding:8px 12px; background: rgba(124,58,237,.15); border:1px solid rgba(124,58,237,.35); border-radius:999px}
    .muted{color:var(--muted)}
    h2{margin:0; font-size: clamp(18px, 3vw, 24px)}
    .progress{
      width:100%; height:10px; border-radius:999px; background: rgba(255,255,255,.06); overflow:hidden
    }
    .bar{height:100%; width:0%; background: linear-gradient(90deg, var(--primary), var(--primary2))}
    .qbox{
      background: linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,.01));
      border:1px solid var(--border); border-radius: 16px; padding: 16px; display:grid; gap:14px
    }
    .qtext{font-size: clamp(16px, 2.5vw, 20px)}
    .opts{display:grid; gap:10px}
    .opt{
      display:flex; gap:12px; align-items:center; padding:12px; border-radius:12px; cursor:pointer;
      background: rgba(255,255,255,.02); border:1px solid rgba(255,255,255,.07); transition:.15s transform,.15s background
    }
    .opt:hover{transform: translateY(-1px); background: rgba(255,255,255,.04)}
    .opt input{accent-color: #a78bfa; width:18px; height:18px}
    .nav{display:flex; gap:10px; flex-wrap:wrap; justify-content:space-between; align-items:center}
    .left, .right{display:flex; gap:10px; align-items:center}
    .btn{
      cursor:pointer; border:none; border-radius:12px; padding:12px 16px; font-weight:700;
      background: linear-gradient(90deg, var(--primary), #5b21b6); color:white; box-shadow: 0 8px 24px rgba(124,58,237,.35)
    }
    .btn.ghost{background: transparent; color: var(--text); border:1px solid rgba(255,255,255,.14); box-shadow:none}
    .btn.alt{background: linear-gradient(90deg, var(--primary2), #0593a8); color:#001018; font-weight:800}
    .pill{font-size:13px; padding:8px 10px; border-radius:999px; border:1px solid rgba(255,255,255,.14)}
    @media (max-width:640px){ .nav{gap:8px} .btn{flex:1} .left,.right{flex:1} }
  </style>
</head>
<body>
  <main class="shell">
    <div class="top">
      <div>
        <div class="badge">SmartCheck IQ</div>
        <h2 id="title">Question 1 of 15</h2>
        <div class="muted" id="domainHint">Domain: —</div>
      </div>
      <div class="pill" id="timer">⏱️ 10:00</div>
    </div>
 
    <div class="progress"><div class="bar" id="bar"></div></div>
 
    <section class="qbox">
      <div class="qtext" id="qtext">Loading…</div>
      <div class="opts" id="opts"></div>
    </section>
 
    <div class="nav">
      <div class="left">
        <button class="btn ghost" id="back">← Previous</button>
        <button class="btn ghost" id="clear">Clear</button>
      </div>
      <div class="right">
        <button class="btn" id="next">Next →</button>
        <button class="btn alt" id="submit">Submit</button>
      </div>
    </div>
    <div class="muted">Tip: You can navigate with arrow keys and select with 1–4.</div>
  </main>
 
  <script>
    // ------------------ Question Bank (v1) ------------------
    const QUESTIONS_V1 = [
      // Logical Reasoning (5)
      {id:1, domain:'Logical Reasoning', q:'If all Bloops are Razzies and all Razzies are Lazzies, which is true?',
        options:['All Bloops are Lazzies','All Lazzies are Bloops','Some Bloops are not Lazzies','No Bloops are Lazzies'], answer:0},
      {id:2, domain:'Logical Reasoning', q:'Which completes: If A ⇒ B and B ⇒ C, then:', options:['A ⇒ C','C ⇒ A','A ⇔ C','A and C independent'], answer:0},
      {id:3, domain:'Logical Reasoning', q:'Find the odd one out: 2, 6, 12, 20, 30, 43, 56',
        options:['12','30','43','56'], answer:2},
      {id:4, domain:'Logical Reasoning', q:'“Only if it rains will the match stop.” Which implies?',
        options:['If it rains, match stops','If match stops, it rained','If it does not rain, match stops','Rain guarantees match continues'], answer:0},
      {id:5, domain:'Logical Reasoning', q:'Which statement must be true?',
        options:['Some rectangles are squares','All squares are rectangles','No squares are rectangles','All rectangles are squares'], answer:1},
 
      // Pattern Recognition (5)
      {id:6, domain:'Pattern Recognition', q:'What comes next? 3, 9, 27, __',
        options:['54','72','81','93'], answer:2},
      {id:7, domain:'Pattern Recognition', q:'Complete the analogy: HAND : GLOVE :: FOOT : __',
        options:['Shoe','Sock','Boot','Lace'], answer:0},
      {id:8, domain:'Pattern Recognition', q:'Number series: 1, 1, 2, 3, 5, 8, __',
        options:['11','12','13','21'], answer:2},
      {id:9, domain:'Pattern Recognition', q:'Which pair follows the pattern? AB, BC, CD, __',
        options:['DE','EF','AD','BD'], answer:0},
      {id:10, domain:'Pattern Recognition', q:'Fill the blank: 4, 6, 9, 13, 18, __',
        options:['22','24','27','28'], answer:2},
 
      // Numerical Ability (5)
      {id:11, domain:'Numerical Ability', q:'If 4x + 5 = 29, then x =',
        options:['5','6','7','8'], answer:1},
      {id:12, domain:'Numerical Ability', q:'What is 15% of 240?',
        options:['32','34','36','38'], answer:2},
      {id:13, domain:'Numerical Ability', q:'A train 120m long at 60 m/s passes a pole in:',
        options:['1 s','2 s','3 s','4 s'], answer:1},
      {id:14, domain:'Numerical Ability', q:'Find the missing term: 7, 14, 28, 56, __',
        options:['63','70','98','112'], answer:3},
      {id:15, domain:'Numerical Ability', q:'If the average of 10 and x is 19, x =',
        options:['19','28','29','38'], answer:2},
    ];
 
    // Persist question set + version so results can compute accurately
    (function persistBank(){
      const v = 'v1';
      localStorage.setItem('iq_version', v);
      localStorage.setItem('iq_questions_'+v, JSON.stringify(QUESTIONS_V1));
    })();
 
    // ------------------ Quiz State ------------------
    const total = QUESTIONS_V1.length;
    let idx = 0;
    let answers = JSON.parse(localStorage.getItem('iq_answers') || '[]'); // array of selected option index
    if (answers.length !== total) answers = Array(total).fill(null);
 
    const qtext = document.getElementById('qtext');
    const optsBox = document.getElementById('opts');
    const title = document.getElementById('title');
    const domainHint = document.getElementById('domainHint');
    const bar = document.getElementById('bar');
 
    function render(){
      const q = QUESTIONS_V1[idx];
      title.textContent = `Question ${idx+1} of ${total}`;
      domainHint.textContent = `Domain: ${q.domain}`;
      qtext.textContent = q.q;
 
      // progress
      const done = answers.filter(a => a !== null).length;
      bar.style.width = `${Math.round((done/total)*100)}%`;
 
      // options
      optsBox.innerHTML = '';
      q.options.forEach((text, i) => {
        const opt = document.createElement('label');
        opt.className = 'opt';
        opt.innerHTML = `
          <input type="radio" name="choice" ${answers[idx]===i?'checked':''} />
          <div><strong>${String.fromCharCode(65+i)}.</strong> ${text}</div>
        `;
        opt.addEventListener('click', () => {
          answers[idx] = i;
          localStorage.setItem('iq_answers', JSON.stringify(answers));
          render(); // refresh selection state/progress
        });
        optsBox.appendChild(opt);
      });
 
      // buttons visibility
      document.getElementById('back').disabled = idx===0;
      document.getElementById('next').disabled = idx===total-1;
    }
 
    // Navigation
    document.getElementById('next').addEventListener('click', () => { if(idx<total-1){ idx++; render(); }});
    document.getElementById('back').addEventListener('click', () => { if(idx>0){ idx--; render(); }});
    document.getElementById('clear').addEventListener('click', () => { answers[idx]=null; localStorage.setItem('iq_answers', JSON.stringify(answers)); render(); });
 
    // Keyboard shortcuts
    window.addEventListener('keydown', (e) => {
      if(e.key==='ArrowRight') document.getElementById('next').click();
      if(e.key==='ArrowLeft') document.getElementById('back').click();
      if(['1','2','3','4'].includes(e.key)){
        answers[idx] = parseInt(e.key,10)-1;
        localStorage.setItem('iq_answers', JSON.stringify(answers));
        render();
      }
    });
 
    // Timer (10 minutes)
    let seconds = 10*60;
    const timerEl = document.getElementById('timer');
    const t = setInterval(() => {
      seconds--;
      const m = Math.floor(seconds/60).toString().padStart(2,'0');
      const s = (seconds%60).toString().padStart(2,'0');
      timerEl.textContent = `⏱️ ${m}:${s}`;
      if(seconds<=0){ clearInterval(t); submitQuiz(true); }
    }, 1000);
 
    // Submit
    document.getElementById('submit').addEventListener('click', () => submitQuiz(false));
    function submitQuiz(auto=false){
      const unanswered = answers.reduce((acc,v,i)=> (v===null ? acc.concat(i+1) : acc), []);
      if(unanswered.length && !auto){
        if(!confirm(`You have ${unanswered.length} unanswered question(s). Submit anyway?`)) return;
      }
      // persist and go to results
      localStorage.setItem('iq_answers', JSON.stringify(answers));
      // JS redirect
      window.location.href = 'results.php';
    }
 
    // Initial render
    render();
  </script>
</body>
</html>

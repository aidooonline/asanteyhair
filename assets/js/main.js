/**
 * Asantey Hair & Beauty — main.js v3.0
 */
(function(){
'use strict';

const $ = (s,c=document)=>c.querySelector(s);
const $$ = (s,c=document)=>[...c.querySelectorAll(s)];

/* ── HEADER ──────────────────────────────────────────────────── */
function initHeader(){
  const hdr = $('.hdr');
  if(!hdr) return;
  let last=0, ticking=false;

  function update(){
    const y = window.scrollY;
    // Hide on scroll down, show on scroll up
    if(y > 200){
      if(y > last) hdr.classList.add('up');
      else hdr.classList.remove('up');
    } else {
      hdr.classList.remove('up');
    }
    last=y; ticking=false;
  }

  window.addEventListener('scroll',()=>{
    if(!ticking){ requestAnimationFrame(update); ticking=true; }
  },{passive:true});
}

/* ── HAMBURGER ───────────────────────────────────────────────── */
function initHamburger(){
  const btn = $('#hamburger');
  const nav = $('#mobile-nav');
  if(!btn||!nav) return;

  btn.addEventListener('click',()=>{
    const open = btn.getAttribute('aria-expanded')==='true';
    btn.setAttribute('aria-expanded',!open);
    btn.classList.toggle('open');
    nav.classList.toggle('open');
    document.body.style.overflow = open ? '' : 'hidden';
  });

  document.addEventListener('keydown',e=>{
    if(e.key==='Escape'){
      btn.setAttribute('aria-expanded','false');
      btn.classList.remove('open');
      nav.classList.remove('open');
      document.body.style.overflow='';
    }
  });

  document.addEventListener('click',e=>{
    if(!btn.contains(e.target)&&!nav.contains(e.target)){
      btn.setAttribute('aria-expanded','false');
      btn.classList.remove('open');
      nav.classList.remove('open');
      document.body.style.overflow='';
    }
  });
}

/* ── HEADER NAV DROPDOWNS ────────────────────────────────────── */
function initDropdowns(){
  $$('.site-nav .menu-item-has-children').forEach(item=>{
    const sub = item.querySelector('.sub-menu');
    if(!sub) return;
    item.addEventListener('mouseenter',()=>sub.style.display='block');
    item.addEventListener('mouseleave',()=>sub.style.display='none');
  });
}

/* ── LIGHTBOX ────────────────────────────────────────────────── */
function initLightbox(){
  const items = $$('.gallery-item');
  if(!items.length) return;

  const lb = document.createElement('div');
  lb.className='lightbox';
  lb.setAttribute('role','dialog');
  lb.setAttribute('aria-modal','true');
  lb.innerHTML=`
    <div class="lightbox__inner">
      <button class="lightbox__close" aria-label="Close">&times;</button>
      <button class="lightbox__nav lightbox__prev" aria-label="Previous">&#8249;</button>
      <img class="lightbox__img" src="" alt="">
      <button class="lightbox__nav lightbox__next" aria-label="Next">&#8250;</button>
    </div>`;
  document.body.appendChild(lb);

  const img   = lb.querySelector('.lightbox__img');
  const close = lb.querySelector('.lightbox__close');
  const prev  = lb.querySelector('.lightbox__prev');
  const next  = lb.querySelector('.lightbox__next');
  let cur=0;

  const srcs = items.map(el=>({
    src: el.querySelector('img')?.src||'',
    alt: el.querySelector('img')?.alt||''
  }));

  function open(i){
    cur=i; img.src=srcs[i].src; img.alt=srcs[i].alt;
    lb.classList.add('open');
    document.body.style.overflow='hidden';
    close.focus();
  }
  function closeLb(){lb.classList.remove('open');document.body.style.overflow='';}
  function showPrev(){open((cur-1+srcs.length)%srcs.length);}
  function showNext(){open((cur+1)%srcs.length);}

  items.forEach((el,i)=>{
    el.addEventListener('click',()=>open(i));
    el.setAttribute('tabindex','0');
    el.addEventListener('keydown',e=>{if(e.key==='Enter')open(i);});
  });

  close.addEventListener('click',closeLb);
  prev.addEventListener('click',showPrev);
  next.addEventListener('click',showNext);
  lb.addEventListener('click',e=>{if(e.target===lb)closeLb();});
  document.addEventListener('keydown',e=>{
    if(!lb.classList.contains('open')) return;
    if(e.key==='ArrowLeft') showPrev();
    if(e.key==='ArrowRight') showNext();
    if(e.key==='Escape') closeLb();
  });
}

/* ── AJAX FORMS ──────────────────────────────────────────────── */
function initForms(){
  $$('form[data-action]').forEach(form=>{
    form.addEventListener('submit',async e=>{
      e.preventDefault();
      const action = form.dataset.action;
      const btn    = form.querySelector('[type="submit"]');
      const ok     = form.querySelector('.form-msg--success');
      const err    = form.querySelector('.form-msg--error');
      if(!action||!window.ahData) return;

      const orig = btn.innerHTML;
      btn.disabled=true; btn.innerHTML='Sending&#8230;';
      if(ok){ok.style.display='none';ok.textContent='';}
      if(err){err.style.display='none';err.textContent='';}

      try{
        const fd = new FormData(form);
        fd.append('action',action);
        fd.append('nonce',window.ahData.nonce);
        const res  = await fetch(window.ahData.ajaxUrl,{method:'POST',body:fd});
        const json = await res.json();
        if(json.success){
          if(ok){ok.textContent=json.data.message;ok.style.display='block';}
          form.reset();
        } else {
          if(err){err.textContent=json.data?.message||'Something went wrong.';err.style.display='block';}
        }
      } catch{
        if(err){err.textContent='Network error. Please try WhatsApp instead.';err.style.display='block';}
      } finally{
        btn.disabled=false; btn.innerHTML=orig;
      }
    });
  });
}

/* ── SCROLL REVEAL ───────────────────────────────────────────── */
function initReveal(){
  const els = $$('.reveal, .ah-reveal');
  if(!els.length) return;
  if('IntersectionObserver' in window){
    const io = new IntersectionObserver(entries=>{
      entries.forEach(en=>{
        if(en.isIntersecting){
          en.target.classList.add('visible');
          io.unobserve(en.target);
        }
      });
    },{threshold:.1});
    els.forEach(el=>io.observe(el));
  } else {
    els.forEach(el=>el.classList.add('visible'));
  }
}

/* ── PRODUCT FILTER ──────────────────────────────────────────── */
function initFilter(){
  const btns  = $$('.filter-btn');
  const cards = $$('.product-card[data-category]');
  if(!btns.length||!cards.length) return;

  btns.forEach(btn=>{
    btn.addEventListener('click',()=>{
      const cat = btn.dataset.filter;
      btns.forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');
      cards.forEach(c=>{
        const show = cat==='all'||c.dataset.category===cat;
        c.style.opacity='0';
        c.style.transform='translateY(8px)';
        setTimeout(()=>{
          c.style.display = show ? '' : 'none';
          if(show) requestAnimationFrame(()=>{
            c.style.opacity='1';c.style.transform='';
          });
        },200);
      });
    });
  });
}

/* ── ACCORDION ───────────────────────────────────────────────── */
function initAccordion(){
  $$('.acc__trigger, .accordion__trigger').forEach(trigger=>{
    trigger.setAttribute('aria-expanded','false');
    trigger.addEventListener('click',()=>{
      const item   = trigger.closest('.accordion__item');
      const isOpen = item.classList.contains('accordion__item--open');
      $$('.accordion__item--open').forEach(el=>{
        el.classList.remove('accordion__item--open');
        el.querySelector('.acc__trigger').setAttribute('aria-expanded','false');
      });
      if(!isOpen){
        item.classList.add('accordion__item--open');
        trigger.setAttribute('aria-expanded','true');
      }
    });
  });
}

/* ── SMOOTH ANCHORS ──────────────────────────────────────────── */
function initAnchors(){
  $$('a[href^="#"]').forEach(a=>{
    a.addEventListener('click',e=>{
      const id=a.getAttribute('href').slice(1);
      const el=document.getElementById(id);
      if(!el) return;
      e.preventDefault();
      const top=el.getBoundingClientRect().top+window.scrollY-88;
      window.scrollTo({top,behavior:'smooth'});
    });
  });
}

/* ── MARQUEE PAUSE ON HOVER (already in CSS) ────────────────── */

/* ── INIT ────────────────────────────────────────────────────── */

function initHeroSlider(){
  var slider = document.querySelector('#hero-slider');
  if(!slider) return;
  var slides  = Array.from(slider.querySelectorAll('.hs-slide'));
  var dots    = Array.from(slider.querySelectorAll('.hs-dot'));
  var prev    = slider.querySelector('.hs-prev');
  var next    = slider.querySelector('.hs-next');
  var muteBtn = document.getElementById('hs-mute');
  var progBar = document.getElementById('hs-progress-bar');
  var cur = 0, timer = null, isMuted = true, paused = false;

  if(slides.length === 0) return;
  if(slides[0]) slides[0].classList.add('hs-slide--active');

  /* --- Progress bar --- */
  function startProgress(duration){
    if(!progBar) return;
    progBar.classList.remove('hs-progress__bar--running');
    progBar.style.width = '0%';
    // Force reflow
    void progBar.offsetWidth;
    progBar.classList.add('hs-progress__bar--running');
    progBar.style.transitionDuration = duration + 's';
    progBar.style.width = '100%';
  }
  function stopProgress(){
    if(!progBar) return;
    progBar.classList.remove('hs-progress__bar--running');
    progBar.style.width = '0%';
  }

  /* --- Slide transition --- */
  function goTo(idx){
    if(idx === cur && slides.length > 1) return;
    var oldSlide = slides[cur];
    var newIdx = (idx + slides.length) % slides.length;
    var newSlide = slides[newIdx];

    // Mark leaving slide for crossfade
    oldSlide.classList.remove('hs-slide--active');
    oldSlide.classList.add('hs-slide--leaving');
    setTimeout(function(){ oldSlide.classList.remove('hs-slide--leaving'); }, 1300);

    // Deactivate dot
    if(dots[cur]) dots[cur].classList.remove('hs-dot--active');

    cur = newIdx;
    newSlide.classList.add('hs-slide--active');
    if(dots[cur]) dots[cur].classList.add('hs-dot--active');

    // Handle video on new slide
    var mp4 = newSlide.querySelector('video.hs-mp4');
    if(mp4){
      mp4.currentTime = 0;
      mp4.muted = isMuted;
      mp4.play().catch(function(){});
    }

    // Pause videos on old slide
    var oldMp4 = oldSlide.querySelector('video.hs-mp4');
    if(oldMp4){ oldMp4.pause(); }

    // Show/hide mute button
    updateMuteButton();

    // Schedule next
    scheduleNext();
  }

  /* --- Auto-advance scheduling --- */
  function scheduleNext(){
    clearTimeout(timer);
    if(paused || slides.length <= 1) return;

    var slide = slides[cur];
    var type  = slide.dataset.type;
    var dur   = parseInt(slide.dataset.duration, 10) || 6;

    if(type === 'video'){
      // For MP4: wait for video end (loop will restart, we advance)
      var mp4 = slide.querySelector('video.hs-mp4');
      if(mp4 && mp4.duration && isFinite(mp4.duration)){
        dur = Math.ceil(mp4.duration);
      } else {
        dur = 10; // fallback for streaming/unknown duration
      }
    }

    startProgress(dur);
    timer = setTimeout(function(){ goTo(cur + 1); }, dur * 1000);
  }

  /* --- Mute toggle --- */
  function updateMuteButton(){
    if(!muteBtn) return;
    var slide = slides[cur];
    var hasVideo = slide.querySelector('video.hs-mp4') || slide.querySelector('iframe.hs-yt');
    muteBtn.style.display = hasVideo ? 'flex' : 'none';
    muteBtn.setAttribute('data-state', isMuted ? 'muted' : 'unmuted');
  }

  if(muteBtn){
    // Set initial muted state from first slide
    var firstMuted = slides[0].dataset.muted;
    isMuted = firstMuted !== 'false';
    muteBtn.setAttribute('data-state', isMuted ? 'muted' : 'unmuted');

    muteBtn.addEventListener('click', function(){
      isMuted = !isMuted;
      muteBtn.setAttribute('data-state', isMuted ? 'muted' : 'unmuted');

      // Toggle all MP4 videos
      slides.forEach(function(s){
        var v = s.querySelector('video.hs-mp4');
        if(v) v.muted = isMuted;
      });

      // Toggle YouTube iframes (via postMessage)
      slides.forEach(function(s){
        var iframe = s.querySelector('iframe.hs-yt');
        if(iframe && iframe.contentWindow){
          iframe.contentWindow.postMessage(JSON.stringify({
            event: 'command',
            func: isMuted ? 'mute' : 'unMute'
          }), '*');
        }
      });
    });
  }

  /* --- Dot navigation --- */
  dots.forEach(function(d, i){
    d.addEventListener('click', function(){ goTo(i); });
  });

  /* --- Arrow navigation --- */
  if(prev) prev.addEventListener('click', function(){ goTo(cur - 1); });
  if(next) next.addEventListener('click', function(){ goTo(cur + 1); });

  /* --- Keyboard --- */
  document.addEventListener('keydown', function(e){
    // Only respond if hero is in viewport
    var rect = slider.getBoundingClientRect();
    if(rect.bottom < 0 || rect.top > window.innerHeight) return;
    if(e.key === 'ArrowLeft') goTo(cur - 1);
    if(e.key === 'ArrowRight') goTo(cur + 1);
  });

  /* --- Touch swipe --- */
  var touchX = 0;
  slider.addEventListener('touchstart', function(e){
    touchX = e.changedTouches[0].screenX;
  }, {passive: true});
  slider.addEventListener('touchend', function(e){
    var diff = e.changedTouches[0].screenX - touchX;
    if(Math.abs(diff) > 50){
      if(diff < 0) goTo(cur + 1);
      else goTo(cur - 1);
    }
  }, {passive: true});

  /* --- Pause on hover (desktop) --- */
  slider.addEventListener('mouseenter', function(){
    paused = true;
    clearTimeout(timer);
    stopProgress();
  });
  slider.addEventListener('mouseleave', function(){
    paused = false;
    scheduleNext();
  });

  /* --- Pause when tab hidden --- */
  document.addEventListener('visibilitychange', function(){
    if(document.hidden){
      paused = true;
      clearTimeout(timer);
      stopProgress();
    } else {
      paused = false;
      scheduleNext();
    }
  });

  /* --- Init --- */
  updateMuteButton();
  if(slides.length > 1) scheduleNext();
}

document.addEventListener('DOMContentLoaded',()=>{
  initHeroSlider();
  initHeader();
  initHamburger();
  initDropdowns();
  initLightbox();
  initForms();
  initReveal();
  initFilter();
  initAccordion();
  initAnchors();
});

})();

/**
 * Asantey Hair & Beauty — WooCommerce JS
 * Cart, ATC, mini-cart and sticky-ATC removed.
 * Remaining: product gallery, lightbox, tabs, coupon toggle, cart auto-update.
 */
(function($){
'use strict';

/* ── COUPON TOGGLE ON CHECKOUT ────────────────────────────── */
function initCouponToggle(){
  var notice = document.querySelector('.woocommerce-checkout .showcoupon');
  if(!notice) return;
  notice.addEventListener('click', function(e){
    e.preventDefault();
    var box = document.querySelector('.checkout_coupon');
    if(box) box.style.display = box.style.display === 'none' ? 'block' : 'none';
  });
}

/* ── CART PAGE: AUTO UPDATE ON QTY CHANGE ─────────────────── */
function initCartAutoUpdate(){
  var form = document.querySelector('form.woocommerce-cart-form');
  if(!form) return;
  form.querySelectorAll('input.qty').forEach(function(input){
    input.addEventListener('change', function(){
      setTimeout(function(){
        var btn = form.querySelector('[name="update_cart"]');
        if(btn && !btn.disabled) btn.click();
      }, 500);
    });
  });
}

/* ── INIT ─────────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function(){
  initCouponToggle();
  initCartAutoUpdate();
});

})(jQuery);

/* ================================================================
   SINGLE PRODUCT / HAIR PRODUCT — GALLERY, LIGHTBOX, TABS
   ================================================================ */
(function(){
'use strict';

/* ── THUMBNAIL SWITCHER ──────────────────────────────────── */
function initGallery(){
  var thumbs  = document.querySelectorAll('.wcp-thumb');
  var mainImg = document.getElementById('wcp-main-img');
  if(!thumbs.length || !mainImg) return;

  thumbs.forEach(function(btn){
    btn.addEventListener('click', function(){
      thumbs.forEach(function(t){ t.classList.remove('wcp-thumb--on'); });
      btn.classList.add('wcp-thumb--on');
      mainImg.style.opacity = '0';
      mainImg.style.transition = 'opacity .22s';
      setTimeout(function(){
        mainImg.src = btn.dataset.full;
        mainImg.onload = function(){ mainImg.style.opacity = '1'; };
        if(mainImg.complete) mainImg.style.opacity = '1';
      }, 200);
    });
  });
}

/* ── LIGHTBOX ────────────────────────────────────────────── */
function initLightbox(){
  var lb      = document.getElementById('wcp-lb');
  var lbImg   = document.getElementById('wcp-lb-img');
  var lbClose = document.getElementById('wcp-lb-close');
  var zoomBtn = document.getElementById('wcp-zoom');
  var mainWrap= document.getElementById('wcp-main');
  var mainImg = document.getElementById('wcp-main-img');
  if(!lb) return;

  function openLb(){
    if(!mainImg) return;
    lbImg.src = mainImg.src;
    lb.removeAttribute('hidden');
    document.body.style.overflow = 'hidden';
    if(lbClose) setTimeout(function(){ lbClose.focus(); }, 50);
  }
  function closeLb(){
    lb.setAttribute('hidden','');
    document.body.style.overflow = '';
  }

  if(zoomBtn) zoomBtn.addEventListener('click', openLb);
  if(mainWrap) mainWrap.addEventListener('click', function(e){
    if(zoomBtn && (e.target===zoomBtn || zoomBtn.contains(e.target))) return;
    openLb();
  });
  if(lbClose) lbClose.addEventListener('click', closeLb);
  if(lb) lb.addEventListener('click', function(e){ if(e.target===lb) closeLb(); });
  document.addEventListener('keydown', function(e){
    if(e.key==='Escape' && lb && !lb.hasAttribute('hidden')) closeLb();
  });
}

/* ── TABS ────────────────────────────────────────────────── */
function initTabs(){
  var tabs   = document.querySelectorAll('.wcp-tab');
  var panels = document.querySelectorAll('.wcp-panel');
  if(!tabs.length) return;

  function openTab(id){
    tabs.forEach(function(t){
      t.classList.remove('wcp-tab--on');
      t.setAttribute('aria-selected','false');
    });
    panels.forEach(function(p){
      p.classList.remove('wcp-panel--on');
      p.setAttribute('hidden','');
    });
    var activeTab   = document.querySelector('.wcp-tab[data-tab="'+id+'"]');
    var activePanel = document.getElementById('wcp-panel-'+id);
    if(activeTab){ activeTab.classList.add('wcp-tab--on'); activeTab.setAttribute('aria-selected','true'); }
    if(activePanel){ activePanel.classList.add('wcp-panel--on'); activePanel.removeAttribute('hidden'); }
  }

  tabs.forEach(function(tab){
    tab.addEventListener('click', function(){ openTab(tab.dataset.tab); });
  });

  var rLink = document.querySelector('.wcp-rcount[data-opentab]');
  if(rLink){
    rLink.addEventListener('click', function(e){
      e.preventDefault();
      openTab('reviews');
      var ts = document.getElementById('wcp-tabs');
      if(ts) window.scrollTo({ top: ts.offsetTop - 100, behavior:'smooth' });
    });
  }
}

/* ── INIT ────────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function(){
  initGallery();
  initLightbox();
  initTabs();
});

})();

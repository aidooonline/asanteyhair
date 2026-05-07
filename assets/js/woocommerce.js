/**
 * Asantey Hair & Beauty — WooCommerce JS
 */
(function($){
'use strict';

/* ── MINI CART ─────────────────────────────────────────────── */
function initMiniCart(){
  var cart     = document.getElementById('ah-mini-cart');
  var overlay  = document.getElementById('ah-mini-cart-overlay');
  var closeBtn = document.getElementById('ah-mini-cart-close');
  var cartIcon = document.getElementById('ah-cart-icon');

  if(!cart) return;

  function openCart(){
    cart.classList.add('open');
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
    if(closeBtn) closeBtn.focus();
  }
  function closeCart(){
    cart.classList.remove('open');
    overlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  if(cartIcon) cartIcon.addEventListener('click', openCart);
  if(closeBtn) closeBtn.addEventListener('click', closeCart);
  if(overlay)  overlay.addEventListener('click', closeCart);

  document.addEventListener('keydown', function(e){
    if(e.key === 'Escape') closeCart();
  });

  // Open cart automatically after adding item
  $(document.body).on('wc_fragments_refreshed added_to_cart', function(){
    openCart();
    // Re-bind remove buttons in mini cart
    bindMiniCartRemove();
  });
}

function bindMiniCartRemove(){
  var body = document.getElementById('ah-mini-cart-body');
  if(!body) return;
  body.querySelectorAll('.remove_from_cart_button').forEach(function(btn){
    btn.addEventListener('click', function(e){
      e.preventDefault();
      var productId = btn.dataset.product_id;
      var cartKey   = btn.dataset.cart_item_key;
      if(!cartKey) return;
      if(typeof wc_cart_params === 'undefined') return;
      $.ajax({
        type: 'POST',
        url: wc_cart_params.wc_ajax_url.replace('%%endpoint%%','remove_from_cart'),
        data: { cart_item_key: cartKey },
        success: function(){
          $(document.body).trigger('wc_fragment_refresh');
        }
      });
    });
  });
}

/* ── QUANTITY +/- BUTTONS ─────────────────────────────────── */
function initQtyButtons(){
  // Add +/- buttons around qty inputs on product pages
  function enhanceQty(input){
    if(input.dataset.enhanced) return;
    input.dataset.enhanced = '1';
    var wrapper = document.createElement('div');
    wrapper.className = 'wc-qty-wrap';

    var minus = document.createElement('button');
    minus.type = 'button';
    minus.className = 'wc-qty-btn wc-qty-minus';
    minus.textContent = '−';
    minus.setAttribute('aria-label', 'Decrease quantity');

    var plus = document.createElement('button');
    plus.type = 'button';
    plus.className = 'wc-qty-btn wc-qty-plus';
    plus.textContent = '+';
    plus.setAttribute('aria-label', 'Increase quantity');

    input.parentNode.insertBefore(wrapper, input);
    wrapper.appendChild(minus);
    wrapper.appendChild(input);
    wrapper.appendChild(plus);

    minus.addEventListener('click', function(){
      var val = parseInt(input.value, 10) || 1;
      var min = parseInt(input.getAttribute('min'), 10) || 1;
      if(val > min) input.value = val - 1;
      input.dispatchEvent(new Event('change'));
    });
    plus.addEventListener('click', function(){
      var val = parseInt(input.value, 10) || 1;
      var max = parseInt(input.getAttribute('max'), 10) || 999;
      if(val < max) input.value = val + 1;
      input.dispatchEvent(new Event('change'));
    });
  }

  document.querySelectorAll('input.qty').forEach(enhanceQty);
  // Re-run after variation changes
  $(document.body).on('found_variation', function(){
    document.querySelectorAll('input.qty').forEach(enhanceQty);
  });
}

/* ── PRODUCT IMAGE GALLERY ZOOM ───────────────────────────── */
function initProductGallery(){
  var images = document.querySelectorAll('.woocommerce-product-gallery__image a');
  if(!images.length) return;

  // Simple custom lightbox for product images
  var lb = document.createElement('div');
  lb.className = 'wc-img-lb';
  lb.innerHTML = '<div class="wc-img-lb__inner"><button class="wc-img-lb__close">&times;</button><img src="" alt=""></div>';
  document.body.appendChild(lb);

  var lbImg   = lb.querySelector('img');
  var lbClose = lb.querySelector('.wc-img-lb__close');

  images.forEach(function(a){
    a.addEventListener('click', function(e){
      e.preventDefault();
      var src = a.getAttribute('href');
      if(!src) return;
      lbImg.src = src;
      lb.classList.add('open');
      document.body.style.overflow = 'hidden';
    });
  });

  lbClose.addEventListener('click', function(){
    lb.classList.remove('open');
    document.body.style.overflow = '';
  });
  lb.addEventListener('click', function(e){
    if(e.target === lb || e.target === lb.querySelector('.wc-img-lb__inner')){
      lb.classList.remove('open');
      document.body.style.overflow = '';
    }
  });
  document.addEventListener('keydown', function(e){
    if(e.key === 'Escape' && lb.classList.contains('open')){
      lb.classList.remove('open');
      document.body.style.overflow = '';
    }
  });
}

/* ── STICKY ADD TO CART (mobile) ──────────────────────────── */
function initStickyCart(){
  var form = document.querySelector('form.cart');
  var btn  = document.querySelector('.single_add_to_cart_button');
  if(!form || !btn || window.innerWidth > 768) return;

  var sticky = document.createElement('div');
  sticky.className = 'wc-sticky-cart';
  sticky.innerHTML = '<button class="wc-sticky-cart__btn">' + btn.textContent + '</button>';
  document.body.appendChild(sticky);

  var stickyBtn = sticky.querySelector('.wc-sticky-cart__btn');
  stickyBtn.addEventListener('click', function(){
    btn.click();
  });

  // Show when form is out of view
  var io = new IntersectionObserver(function(entries){
    entries.forEach(function(en){
      sticky.classList.toggle('visible', !en.isIntersecting);
    });
  }, { threshold: 0 });
  io.observe(form);
}

/* ── COUPON TOGGLE ON CHECKOUT ────────────────────────────── */
function initCouponToggle(){
  var notice = document.querySelector('.woocommerce-checkout .showcoupon');
  if(!notice) return;
  notice.addEventListener('click', function(e){
    e.preventDefault();
    var couponBox = document.querySelector('.checkout_coupon');
    if(couponBox) couponBox.style.display = couponBox.style.display === 'none' ? 'block' : 'none';
  });
}

/* ── CART QUANTITY UPDATE (auto update) ───────────────────── */
function initCartAutoUpdate(){
  var form = document.querySelector('form.woocommerce-cart-form');
  if(!form) return;

  form.querySelectorAll('input.qty').forEach(function(input){
    input.addEventListener('change', function(){
      setTimeout(function(){
        var updateBtn = form.querySelector('[name="update_cart"]');
        if(updateBtn && !updateBtn.disabled) updateBtn.click();
      }, 500);
    });
  });
}

/* ── INIT ─────────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function(){
  initMiniCart();
  bindMiniCartRemove();
  initQtyButtons();
  initProductGallery();
  initStickyCart();
  initCouponToggle();
  initCartAutoUpdate();
});

})(jQuery);

/* ================================================================
   SINGLE PRODUCT — PILL VARIATION SELECTORS + GALLERY + TABS
   ================================================================ */
(function(){
'use strict';

/* ── PILL VARIATION SELECTOR ─────────────────────────────── */
function initPillVariations(){
  var form = document.getElementById('wcp-var-form');
  if(!form) return;

  var variations      = (typeof wcpVariations !== 'undefined') ? wcpVariations : [];
  var productId       = (typeof wcpProductId  !== 'undefined') ? wcpProductId  : 0;
  var atcBtn          = document.getElementById('wcp-atc-btn');
  var varIdInput      = document.getElementById('wcp-variation-id');
  var varPriceDisplay = document.getElementById('wcp-var-price');
  var chosen          = {}; // { attr_name: value }

  /* Build a map: attrName -> selected value */
  function getChosen(){ return chosen; }

  /* Find matching variation given current selections */
  function findVariation(){
    if(!variations.length) return null;
    return variations.find(function(v){
      if(!v.variation_is_active || !v.variation_is_visible) return false;
      for(var attr in v.attributes){
        var vVal    = v.attributes[attr];
        var chosen_ = chosen[attr] || '';
        // empty attribute means "any"
        if(vVal && vVal !== '' && vVal !== chosen_) return false;
      }
      return true;
    }) || null;
  }

  /* Check if all attributes selected */
  function allChosen(){
    var pills = form.querySelectorAll('.wcp-attr');
    for(var i=0;i<pills.length;i++){
      var attr = pills[i].dataset.attr;
      if(!chosen[attr]) return false;
    }
    return true;
  }

  /* Update availability on pills based on current selections */
  function updateAvailability(){
    var allPills = form.querySelectorAll('.wcp-pill-opt');
    allPills.forEach(function(p){
      var attr  = p.dataset.attr;
      var val   = p.dataset.value;
      // Temporarily set this value and check if any variation matches
      var test  = Object.assign({}, chosen);
      test[attr] = val;
      var matches = variations.some(function(v){
        if(!v.variation_is_active||!v.variation_is_visible) return false;
        for(var a in v.attributes){
          var vv = v.attributes[a];
          var tv = test[a]||'';
          if(vv&&vv!==''&&vv!==tv) return false;
        }
        return true;
      });
      p.classList.toggle('wcp-unavail', !matches);
    });
  }

  /* Handle pill click */
  form.addEventListener('click', function(e){
    var btn = e.target.closest('.wcp-pill-opt');
    if(!btn || btn.classList.contains('wcp-unavail')) return;

    var attr = btn.dataset.attr;
    var val  = btn.dataset.value;

    // Toggle: clicking active pill deselects it
    if(chosen[attr] === val){
      delete chosen[attr];
      btn.setAttribute('aria-pressed','false');
    } else {
      chosen[attr] = val;
      // Deactivate siblings
      form.querySelectorAll('.wcp-pill-opt[data-attr="'+attr+'"]').forEach(function(p){
        p.setAttribute('aria-pressed','false');
      });
      btn.setAttribute('aria-pressed','true');
    }

    // Update hidden select
    var select = form.querySelector('select[name="'+attr+'"]');
    if(select) select.value = chosen[attr] || '';

    // Update label showing chosen value
    var chosenSpan = document.getElementById('chosen-' + attr.replace('attribute_',''));
    if(chosenSpan) chosenSpan.textContent = chosen[attr] ? '— ' + chosen[attr] : '';

    // Update availability
    updateAvailability();

    // Find variation + update price + enable ATC
    var match = allChosen() ? findVariation() : null;

    if(match){
      varIdInput.value = match.variation_id;
      if(varPriceDisplay) varPriceDisplay.innerHTML = match.price_html || '';
      if(atcBtn){
        atcBtn.disabled = !match.is_purchasable || match.max_qty === 0;
        atcBtn.value    = match.variation_id;
      }
    } else {
      varIdInput.value = 0;
      if(varPriceDisplay) varPriceDisplay.innerHTML = '';
      if(atcBtn) atcBtn.disabled = true;
    }
  });

  // Initial availability update
  updateAvailability();
}

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
        // If already cached (onload may not fire)
        if(mainImg.complete) mainImg.style.opacity = '1';
      }, 200);
    });
  });
}

/* ── LIGHTBOX ────────────────────────────────────────────── */
function initLightbox(){
  var lb       = document.getElementById('wcp-lb');
  var lbImg    = document.getElementById('wcp-lb-img');
  var lbClose  = document.getElementById('wcp-lb-close');
  var zoomBtn  = document.getElementById('wcp-zoom');
  var mainWrap = document.getElementById('wcp-main');
  var mainImg  = document.getElementById('wcp-main-img');
  if(!lb) return;

  function open(){
    if(!mainImg) return;
    lbImg.src = mainImg.src;
    lb.removeAttribute('hidden');
    document.body.style.overflow = 'hidden';
    if(lbClose) setTimeout(function(){ lbClose.focus(); }, 50);
  }
  function close(){
    lb.setAttribute('hidden','');
    document.body.style.overflow = '';
  }

  if(zoomBtn) zoomBtn.addEventListener('click', open);
  if(mainWrap) mainWrap.addEventListener('click', function(e){
    if(zoomBtn && (e.target===zoomBtn||zoomBtn.contains(e.target))) return;
    open();
  });
  if(lbClose) lbClose.addEventListener('click', close);
  lb.addEventListener('click', function(e){ if(e.target===lb) close(); });
  document.addEventListener('keydown', function(e){
    if(e.key==='Escape' && lb && !lb.hasAttribute('hidden')) close();
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

  // Rating link opens reviews tab
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

/* ── QTY STEPPER ─────────────────────────────────────────── */
function initQtyStepper(){
  var form = document.getElementById('wcp-var-form') || document.querySelector('.wcp-form-wrap form');
  if(!form) return;
  form.addEventListener('click', function(e){
    var btn = e.target.closest('.wcp-qty-btn');
    if(!btn) return;
    var input = form.querySelector('.wcp-qty-input') || form.querySelector('input.qty');
    if(!input) return;
    var val = parseInt(input.value,10)||1;
    var min = parseInt(input.min||'1',10);
    var max = parseInt(input.max||'99',10);
    if(btn.classList.contains('wcp-qty-minus') && val > min) input.value = val - 1;
    if(btn.classList.contains('wcp-qty-plus') && val < max) input.value = val + 1;
  });
}

/* ── MOBILE STICKY ATC ───────────────────────────────────── */
function initStickyAtc(){
  var formWrap = document.querySelector('.wcp-form-wrap');
  if(!formWrap || window.innerWidth > 860) return;
  var titleEl = document.querySelector('.wcp-title');
  var sticky  = document.createElement('div');
  sticky.className = 'wcp-sticky';
  sticky.innerHTML = '<span class="wcp-sticky__name">'+(titleEl?titleEl.textContent.trim():'')+'</span>'
                   + '<button class="wcp-sticky__btn" type="button">Add to Bag</button>';
  document.body.appendChild(sticky);

  sticky.querySelector('.wcp-sticky__btn').addEventListener('click', function(){
    var atcBtn = document.getElementById('wcp-atc-btn') || document.querySelector('.single_add_to_cart_button');
    if(atcBtn) atcBtn.click();
  });

  if('IntersectionObserver' in window){
    new IntersectionObserver(function(entries){
      sticky.classList.toggle('on', !entries[0].isIntersecting);
    },{threshold:0}).observe(formWrap);
  }
}

/* ── INIT ────────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function(){
  initPillVariations();
  initGallery();
  initLightbox();
  initTabs();
  initQtyStepper();
  initStickyAtc();
});

})();

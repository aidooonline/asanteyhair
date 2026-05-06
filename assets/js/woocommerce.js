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

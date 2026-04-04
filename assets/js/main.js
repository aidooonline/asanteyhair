/**
 * Asantey Hair & Beauty — Main JS
 * Sticky header · Hamburger · Lightbox · AJAX Forms · Scroll reveal · Filter · Accordion
 */

(function () {
  'use strict';

  /* ============================================================
     UTILITY
     ============================================================ */
  const $ = (sel, ctx = document) => ctx.querySelector(sel);
  const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];

  /* ============================================================
     STICKY HEADER
     ============================================================ */
  function initStickyHeader() {
    const header = $('.site-header');
    if (!header) return;

    let lastScroll = 0;

    window.addEventListener('scroll', () => {
      const scrollY = window.scrollY;

      if (scrollY > 80) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }

      // Hide on scroll down, show on scroll up
      if (scrollY > lastScroll && scrollY > 200) {
        header.classList.add('hidden');
      } else {
        header.classList.remove('hidden');
      }

      lastScroll = scrollY;
    }, { passive: true });
  }

  /* ============================================================
     MOBILE HAMBURGER MENU
     ============================================================ */
  function initHamburger() {
    const toggle = $('.hamburger');
    const nav    = $('.mobile-nav');
    const body   = document.body;

    if (!toggle || !nav) return;

    toggle.addEventListener('click', () => {
      const isOpen = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', !isOpen);
      toggle.classList.toggle('open');
      nav.classList.toggle('open');
      body.classList.toggle('menu-open');
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
      if (!toggle.contains(e.target) && !nav.contains(e.target)) {
        toggle.setAttribute('aria-expanded', 'false');
        toggle.classList.remove('open');
        nav.classList.remove('open');
        body.classList.remove('menu-open');
      }
    });

    // Close on ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        toggle.setAttribute('aria-expanded', 'false');
        toggle.classList.remove('open');
        nav.classList.remove('open');
        body.classList.remove('menu-open');
      }
    });
  }

  /* ============================================================
     GALLERY LIGHTBOX
     ============================================================ */
  function initLightbox() {
    const items = $$('.gallery-item');
    if (!items.length) return;

    // Create lightbox DOM with correct class names
    const lb = document.createElement('div');
    lb.className = 'lightbox';
    lb.setAttribute('role', 'dialog');
    lb.setAttribute('aria-modal', 'true');
    lb.setAttribute('aria-label', 'Image viewer');
    lb.innerHTML = `
      <div class="lightbox__inner">
        <button class="lightbox__close" aria-label="Close">&times;</button>
        <button class="lightbox__nav lightbox__prev" aria-label="Previous">&#8249;</button>
        <img class="lightbox__img" src="" alt="" loading="lazy">
        <button class="lightbox__nav lightbox__next" aria-label="Next">&#8250;</button>
      </div>
    `;
    document.body.appendChild(lb);

    const img   = lb.querySelector('.lightbox__img');
    const close = lb.querySelector('.lightbox__close');
    const prev  = lb.querySelector('.lightbox__prev');
    const next  = lb.querySelector('.lightbox__next');
    let current = 0;

    const srcs = items.map(item => ({
      src: item.querySelector('img')?.src || '',
      alt: item.querySelector('img')?.alt || '',
    }));

    function open(index) {
      current = index;
      img.src = srcs[index].src;
      img.alt = srcs[index].alt;
      lb.classList.add('open');
      document.body.style.overflow = 'hidden';
      close.focus();
    }

    function closeLb() {
      lb.classList.remove('open');
      document.body.style.overflow = '';
    }

    function showPrev() { open((current - 1 + srcs.length) % srcs.length); }
    function showNext() { open((current + 1) % srcs.length); }

    items.forEach((item, i) => {
      item.addEventListener('click', () => open(i));
      item.setAttribute('role', 'button');
      item.setAttribute('tabindex', '0');
      item.addEventListener('keydown', e => { if (e.key === 'Enter') open(i); });
    });

    close.addEventListener('click', closeLb);
    prev.addEventListener('click', showPrev);
    next.addEventListener('click', showNext);

    lb.addEventListener('click', e => { if (e.target === lb) closeLb(); });

    document.addEventListener('keydown', e => {
      if (!lb.classList.contains('open')) return;
      if (e.key === 'ArrowLeft')  showPrev();
      if (e.key === 'ArrowRight') showNext();
      if (e.key === 'Escape')     closeLb();
    });
  }

  /* ============================================================
     AJAX FORMS
     ============================================================ */
  function initForms() {
    $$('form[data-action]').forEach(form => {
      form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const action      = form.dataset.action;
        const submitBtn   = form.querySelector('[type="submit"]');
        const successMsg  = form.querySelector('.form-msg--success, .ah-form-msg--success');
        const errorMsg    = form.querySelector('.form-msg--error, .ah-form-msg--error');

        if (!action || !window.ahData) return;

        // UI: loading state
        const btnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Sending&hellip;';

        if (successMsg) { successMsg.style.display = 'none'; successMsg.textContent = ''; }
        if (errorMsg)   { errorMsg.style.display   = 'none'; errorMsg.textContent = ''; }

        // Build form data
        const data = new FormData(form);
        data.append('action', action);
        data.append('nonce', window.ahData.nonce);

        try {
          const res  = await fetch(window.ahData.ajaxUrl, { method: 'POST', body: data });
          const json = await res.json();

          if (json.success) {
            if (successMsg) {
              successMsg.textContent = json.data.message;
              successMsg.style.display = 'block';
            }
            form.reset();
          } else {
            if (errorMsg) {
              errorMsg.textContent = json.data.message || 'Something went wrong. Please try again.';
              errorMsg.style.display = 'block';
            }
          }
        } catch (err) {
          if (errorMsg) {
            errorMsg.textContent = 'Network error. Please try again or contact us via WhatsApp.';
            errorMsg.style.display = 'block';
          }
        } finally {
          submitBtn.disabled = false;
          submitBtn.innerHTML = btnText;
        }
      });
    });
  }

  /* ============================================================
     SCROLL REVEAL
     ============================================================ */
  function initScrollReveal() {
    const els = $$('.reveal');
    if (!els.length) return;

    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.12 });

      els.forEach(el => observer.observe(el));
    } else {
      // Fallback: show all
      els.forEach(el => el.classList.add('visible'));
    }
  }

  /* ============================================================
     PRODUCT FILTER
     ============================================================ */
  function initFilter() {
    const filterBtns = $$('.filter-btn');
    const cards      = $$('.product-card[data-category]');

    if (!filterBtns.length || !cards.length) return;

    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const cat = btn.dataset.filter;

        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        cards.forEach(card => {
          if (cat === 'all' || card.dataset.category === cat) {
            card.style.display = '';
            requestAnimationFrame(() => { card.style.opacity = '1'; card.style.transform = 'translateY(0)'; });
          } else {
            card.style.opacity = '0';
            card.style.transform = 'translateY(10px)';
            setTimeout(() => { card.style.display = 'none'; }, 250);
          }
        });
      });
    });
  }

  /* ============================================================
     FAQ ACCORDION
     ============================================================ */
  function initAccordion() {
    $$('.accordion__trigger').forEach(trigger => {
      trigger.addEventListener('click', () => {
        const item    = trigger.closest('.accordion__item');
        const isOpen  = item.classList.contains('accordion__item--open');
        const content = item.querySelector('.accordion__body');

        // Close siblings
        $$('.accordion__item--open').forEach(openItem => {
          openItem.classList.remove('accordion__item--open');
          openItem.querySelector('.accordion__trigger').setAttribute('aria-expanded', 'false');
        });

        if (!isOpen) {
          item.classList.add('accordion__item--open');
          trigger.setAttribute('aria-expanded', 'true');
        }
      });

      trigger.setAttribute('aria-expanded', 'false');
    });
  }

  /* ============================================================
     SMOOTH ANCHOR SCROLL
     ============================================================ */
  function initSmoothScroll() {
    $$('a[href^="#"]').forEach(link => {
      link.addEventListener('click', (e) => {
        const id  = link.getAttribute('href').slice(1);
        const el  = document.getElementById(id);
        if (!el) return;
        e.preventDefault();
        const offset = 90; // header height
        const top = el.getBoundingClientRect().top + window.scrollY - offset;
        window.scrollTo({ top, behavior: 'smooth' });
      });
    });
  }

  /* ============================================================
     LAZY LOAD IMAGES (native + polyfill)
     ============================================================ */
  function initLazyLoad() {
    if ('loading' in HTMLImageElement.prototype) return; // native support

    $$('img[loading="lazy"]').forEach(img => {
      if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(entries => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              const image = entry.target;
              image.src = image.dataset.src || image.src;
              observer.unobserve(image);
            }
          });
        });
        observer.observe(img);
      }
    });
  }

  /* ============================================================
     HEADER NAVIGATION DROPDOWNS (desktop)
     ============================================================ */
  function initNavDropdowns() {
    $$('.site-nav > .menu-item-has-children').forEach(item => {
      const link = item.querySelector('a');
      const sub  = item.querySelector('.sub-menu');
      if (!sub) return;

      item.addEventListener('mouseenter', () => sub.style.display = 'block');
      item.addEventListener('mouseleave', () => sub.style.display = 'none');

      link.addEventListener('focus', () => sub.style.display = 'block');
      sub.addEventListener('focusout', (e) => {
        if (!item.contains(e.relatedTarget)) sub.style.display = 'none';
      });
    });
  }

  /* ============================================================
     INIT ALL
     ============================================================ */
  document.addEventListener('DOMContentLoaded', () => {
    initStickyHeader();
    initHamburger();
    initLightbox();
    initForms();
    initScrollReveal();
    initFilter();
    initAccordion();
    initSmoothScroll();
    initLazyLoad();
    initNavDropdowns();
  });

})();

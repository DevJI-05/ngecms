// ===========================
// NAV TOGGLE (mobile)
// ===========================
document.addEventListener('DOMContentLoaded', function () {
  var toggle = document.querySelector('.nav-toggle');
  var navLinks = document.querySelector('.nav-links');
  if (toggle && navLinks) {
    toggle.addEventListener('click', function () {
      navLinks.classList.toggle('open');
    });
    // close on link click
    navLinks.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function () { navLinks.classList.remove('open'); });
    });
  }

  // Mark active nav link
  var current = location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-links a').forEach(function (a) {
    var href = a.getAttribute('href');
    if (href === current) a.classList.add('active');
  });
});

// ===========================
// SMOOTH SCROLL
// ===========================
document.querySelectorAll('a[href^="#"]').forEach(function (a) {
  a.addEventListener('click', function (e) {
    var target = document.querySelector(this.getAttribute('href'));
    if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
  });
});

// ===========================
// WHATSAPP HELPER
// ===========================
function openWhatsApp(phone, msg) {
  var url = 'https://wa.me/' + phone + (msg ? '?text=' + encodeURIComponent(msg) : '');
  window.open(url, '_blank');
}

// ===========================
// FILTER HELPER
// ===========================
function initFilter(tagClass, cardClass, dataAttr) {
  document.querySelectorAll('.' + tagClass).forEach(function (btn) {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.' + tagClass).forEach(function (b) { b.classList.remove('on'); });
      this.classList.add('on');
      var val = this.dataset.filter;
      document.querySelectorAll('.' + cardClass).forEach(function (c) {
        c.style.display = (val === 'all' || c.dataset[dataAttr] === val) ? '' : 'none';
      });
    });
  });
}

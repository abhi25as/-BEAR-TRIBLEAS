/* ═══════════════════════════════════════════════════════════════
   BEAR TRIBLEAS — script.js  (unified, all pages)
   Handles: Cart Functionality (Add, Remove, Qty), Drawers, 
            Filters, and Interactive UI Elements.
═══════════════════════════════════════════════════════════════ */

/* ─────────────────────────────────────────────────────────────
   SHARED CART STORAGE  (localStorage key: bt_cart)
───────────────────────────────────────────────────────────────*/
function getCart() { 
    // This strictly filters out "ghost" items with 0 or negative quantities
    const cart = JSON.parse(localStorage.getItem('bt_cart') || '[]');
    return cart.filter(item => item.qty > 0);
}

function saveCart(c) { 
    // Filter out any accidental 0-quantity items before saving
    const cleanedCart = c.filter(item => item.qty > 0);
    localStorage.setItem('bt_cart', JSON.stringify(cleanedCart)); 
}

function priceToNum(str) { 
    // Handles cases where price might already be a number
    if (typeof str === 'number') return str;
    return parseInt((str || '0').replace(/[₹,\s]/g, ''), 10) || 0; 
}

function numToPrice(n) { 
    return '₹' + n.toLocaleString('en-IN'); 
}
// Ensure this is exactly what you have in your script.js
function getCart() { 
    const cart = JSON.parse(localStorage.getItem('bt_cart') || '[]');
    return cart.filter(item => item.qty > 0); // This line is the "Ghost Buster"
}
/* ─────────────────────────────────────────────────────────────
   CART ACTIONS (Add, Remove, Update Qty)
───────────────────────────────────────────────────────────────*/

// Add generic product to cart
window.addToCart = function(id, name, price, img) {
  const key  = String(id);
  const cart = getCart();
  const ex   = cart.find(x => x.id === key);
  if (ex) ex.qty++;
  else cart.push({ id: key, name, price: numToPrice(price), qty: 1, img: img || '' });
  saveCart(cart);
  _refreshAllBadges();
  _renderLegacyDrawer();
  _openLegacyDrawer();
};

// Add product variant (reads selected size/price from page)
window.addVariantToCart = function(id, productName, imgUrl) {
  const sel  = document.getElementById('variant-' + id);
  const qtyI = document.getElementById('qty-' + id);
  if (!sel) return;
  const price    = parseInt(sel.value, 10) || 0;
  const variant  = sel.options[sel.selectedIndex].text.split('—')[0].trim();
  const qty      = Math.max(1, parseInt(qtyI?.value || 1, 10));
  const fullName = `${productName} (${variant})`;
  const key      = `${id}-${variant}`;
  const cart = getCart();
  const ex   = cart.find(x => x.id === key);
  if (ex) ex.qty += qty;
  else cart.push({ id: key, name: fullName, price: numToPrice(price), qty, img: imgUrl || '' });
  saveCart(cart);
  if (qtyI) qtyI.value = 1;
  _refreshAllBadges();
  _renderLegacyDrawer();
  _openLegacyDrawer();
};

// Increment or Decrement Item Quantity
// Increment or Decrement Item Quantity
window.updateCartItem = function(id, delta) {
    if (cartData[id]) {
        cartData[id].qty += delta;
        
        // If qty reaches 0, delete it from the object entirely
        if (cartData[id].qty <= 0) {
            delete cartData[id];
        }
        
        saveCart(Object.values(cartData)); // Save the cleaned list
        _refreshAllBadges();
        _renderNewDrawer();    // Refresh UI
    }
};

// Remove Item Entirely
window.removeCartItem = function(id) {
    if (cartData[id]) {
        delete cartData[id]; // Delete the key from the object
        saveCart(Object.values(cartData)); // Save the cleaned list
        _refreshAllBadges();
        _renderNewDrawer();
    }
};
// Fallback for older buttons
window.removeFromCart = window.removeCartItem;

/* ─────────────────────────────────────────────────────────────
   DRAWER TOGGLES & MODALS
───────────────────────────────────────────────────────────────*/

// Light Theme Drawer Toggle
window.toggleCart = function() {
  const drawer  = document.getElementById('cartDrawer');
  const overlay = document.getElementById('cartOverlay');
  if (!drawer) return;
  const opening = !drawer.classList.contains('open');
  drawer.classList.toggle('open');
  overlay?.classList.toggle('show');
  if (opening) { _renderLegacyDrawer(); document.body.style.overflow = 'hidden'; }
  else { document.body.style.overflow = ''; }
};

// Checkout routing / Modal Opening
window.processCheckout = function() {
  if (!getCart().length) return;
  window.location.href = 'crate.php';
};

window.openCheckout = function() {
  const cart = getCart();
  if (!cart.length) { alert('Your crate is empty!'); return; }
  const total = cart.reduce((s, x) => s + priceToNum(x.price) * x.qty, 0);
  const modal = document.getElementById('checkoutModal');
  const amtEl = document.getElementById('modal-amount');
  const qrEl  = document.getElementById('upi-qr-code');
  if (amtEl) amtEl.textContent = numToPrice(total);
  if (qrEl)  qrEl.src = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=upi://pay?pa=beartribleas@upi&am=${total}&cu=INR`;
  if (modal) { modal.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
};

window.closeCheckout = function() {
  const modal = document.getElementById('checkoutModal');
  if (modal) { modal.style.display = 'none'; document.body.style.overflow = ''; }
};

window.submitPayment = function() {
  alert('Payment submitted! Your gear is being prepped. 🐻');
  saveCart([]);
  _refreshAllBadges();
  _renderNewDrawer();
  _renderLegacyDrawer();
  _renderCratePage();
  window.closeCheckout();
};

window.togglePayment = function(type) {
  const upiSec = document.getElementById('section-upi');
  const cardSec = document.getElementById('section-card');
  if(upiSec) upiSec.style.display = type === 'upi' ? 'block' : 'none';
  if(cardSec) cardSec.style.display = type === 'card' ? 'block' : 'none';
  document.getElementById('tab-upi')?.classList.toggle('active', type === 'upi');
  document.getElementById('tab-card')?.classList.toggle('active', type === 'card');
};

/* ─────────────────────────────────────────────────────────────
   RENDER FUNCTIONS
───────────────────────────────────────────────────────────────*/

function _refreshAllBadges() {
  const cart  = getCart();
  const count = cart.reduce((s, x) => s + (x.qty || 1), 0);
  document.querySelectorAll('#cart-count, .cart-count').forEach(el => el.textContent = count);
  const nb = document.getElementById('cart-badge');
  if (nb) { nb.textContent = count; nb.classList.toggle('show', count > 0); }
}

// 1. Renders the Dark Theme Drawer (index.php)
function _renderNewDrawer() {
  const body    = document.getElementById('cart-body');
  const totalEl = document.getElementById('cart-total');
  if (!body) return;

  const items = Object.entries(cartData); // This only gets items currently in the object

  if (items.length === 0) {
    body.innerHTML = `
      <div class="cart-empty-state">
        <p>Your bag is empty</p>
      </div>`;
    if (totalEl) totalEl.textContent = '₹0';
    return;
  }
  // ... rest of your map function
}

  let total = 0;
  body.innerHTML = cart.map((item) => {
    const price = priceToNum(item.price);
    const qty   = item.qty || 1;
    total += price * qty;
    return `
    <div style="display:flex; gap:16px; padding:20px 0; border-bottom:1px solid rgba(201,168,76,.15);">
      <div style="width:75px; height:96px; background:#1d1a17; border-radius:4px; overflow:hidden; flex-shrink:0;">
        ${item.img ? `<img src="${item.img}" style="width:100%;height:100%;object-fit:cover;">` : ''}
      </div>
      <div style="flex:1;">
        <div style="font-family:'Cormorant Garamond', serif; font-size:17px; color:#f0e9dd; margin-bottom:4px;">${item.name}</div>
        <div style="font-family:'Space Mono', monospace; font-size:14px; color:#c9a84c;">${item.price}</div>
        
        <div style="display:flex; align-items:center; gap:12px; margin-top:12px;">
          <button onclick="window.updateCartItem('${item.id}', -1)" style="width:26px;height:26px;border:1px solid rgba(201,168,76,.4);background:transparent;color:#c9a84c;border-radius:2px;cursor:pointer;display:flex;align-items:center;justify-content:center;">−</button>
          <span style="font-family:'Space Mono', monospace; font-size:13px; color:#f0e9dd; min-width:16px; text-align:center;">${qty}</span>
          <button onclick="window.updateCartItem('${item.id}', 1)" style="width:26px;height:26px;border:1px solid rgba(201,168,76,.4);background:transparent;color:#c9a84c;border-radius:2px;cursor:pointer;display:flex;align-items:center;justify-content:center;">+</button>
        </div>

      </div>
      <button onclick="window.removeCartItem('${item.id}')" style="background:none; border:none; color:#7a6f63; font-size:20px; cursor:pointer; align-self:flex-start; padding-left:10px;">✕</button>
    </div>`;
  }).join('');

  if (totalEl) totalEl.textContent = numToPrice(total);
/* In script.js */
const dot  = document.getElementById('cursor-dot');
const ring = document.getElementById('cursor-ring');

if (dot && ring) {
  let mx = innerWidth/2, my = innerHeight/2, rx = mx, ry = my;
  
  document.addEventListener("DOMContentLoaded", () => {

    const dot = document.getElementById("cursor-dot");
    const ring = document.getElementById("cursor-ring");

    if (!dot || !ring) return;

    let mouseX = 0;
    let mouseY = 0;
    let ringX = 0;
    let ringY = 0;

    document.addEventListener("mousemove", (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;

        dot.style.left = mouseX + "px";
        dot.style.top = mouseY + "px";
    });

    function animate() {
        ringX += (mouseX - ringX) * 0.15;
        ringY += (mouseY - ringY) * 0.15;

        ring.style.left = ringX + "px";
        ring.style.top = ringY + "px";

        requestAnimationFrame(animate);
    }

    animate();
});
}
// 2. Renders the Light Theme Drawer (Category Pages)
function _renderLegacyDrawer() {
  const container = document.getElementById('cartItemsContainer');
  const totalEl   = document.getElementById('cartTotal');
  if (!container) return;
  const cart = getCart();
  
  if (!cart.length) {
    container.innerHTML = '<p style="text-align:center;margin-top:3rem;color:#777;">Your crate is empty.</p>';
    if (totalEl) totalEl.textContent = '₹0.00';
    return;
  }

  let total = 0;
  container.innerHTML = cart.map(item => {
    const price = priceToNum(item.price);
    const qty   = item.qty || 1;
    total += price * qty;
    return `
    <div style="display:flex;gap:15px;margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid #e0dcd3;">
      ${item.img ? `<img src="${item.img}" style="width:70px;height:70px;object-fit:cover;border-radius:6px;">` : ''}
      <div style="flex:1;">
        <h4 style="font-size:15px;margin-bottom:5px;font-weight:800;color:#5C3D26;">${item.name}</h4>
        <p style="font-weight:800;margin-top:5px;color:#1A1A1A;">${item.price}</p>
        
        <div style="display:flex; align-items:center; gap:12px; margin-top:10px;">
          <button onclick="window.updateCartItem('${item.id}', -1)" style="width:26px;height:26px;border:1px solid #d1ccc5;background:transparent;border-radius:4px;cursor:pointer;font-weight:bold;">−</button>
          <span style="font-size:14px; font-weight:bold; min-width:16px; text-align:center;">${qty}</span>
          <button onclick="window.updateCartItem('${item.id}', 1)" style="width:26px;height:26px;border:1px solid #d1ccc5;background:transparent;border-radius:4px;cursor:pointer;font-weight:bold;">+</button>
        </div>

        <button onclick="window.removeCartItem('${item.id}')" style="background:none;border:none;color:#d9534f;cursor:pointer;font-size:11px;margin-top:12px;font-weight:700;letter-spacing:.5px;">REMOVE</button>
      </div>
    </div>`;
  }).join('');
  if (totalEl) totalEl.textContent = numToPrice(total) + '.00';
}

// 3. Renders the Main Crate Page (crate.php)
function _renderCratePage() {
  const crateContainer = document.getElementById('crate-container');
  const crateTotal     = document.getElementById('crate-total');
  const crateSub       = document.getElementById('crate-subtotal');
  const crateCount     = document.getElementById('crate-count');
  const summaryBox     = document.getElementById('crate-summary');
  if (!crateContainer) return;
  
  const cart = getCart();
  if (!cart.length) {
    crateContainer.innerHTML = '<div style="text-align:center;padding:80px 20px;"><p style="font-size:1.2rem;color:#777;margin-bottom:24px;">Your crate is empty.</p><a href="index.php" style="display:inline-block;padding:14px 32px;background:#5C3D26;color:#fff;font-weight:700;border-radius:4px;text-decoration:none;">Continue Shopping →</a></div>';
    if (summaryBox) summaryBox.style.display = 'none';
    if (crateCount) crateCount.textContent = '0';
    return;
  }

  let total = 0;
  crateContainer.innerHTML = cart.map(item => {
    const price = priceToNum(item.price);
    const qty   = item.qty || 1;
    total += price * qty;
    return `
    <div style="display:flex; gap:20px; padding:24px 0; border-bottom:1px solid #e0dcd3; align-items:flex-start;">
      <img src="${item.img || ''}" alt="${item.name}" style="width:90px;height:90px;object-fit:cover;border-radius:8px;flex-shrink:0;border:1px solid #e0dcd3;">
      <div style="flex:1;">
        <h3 style="font-size:1.1rem;font-weight:800;color:#2C352D;margin-bottom:8px;">${item.name}</h3>
        <p style="font-size:15px;color:#555;margin-bottom:12px;">${item.price} × ${qty} = <strong style="color:#2C352D;font-size:1.1rem;">${numToPrice(price*qty)}</strong></p>

        <div style="display:flex; align-items:center; gap:16px;">
          <div style="display:flex; align-items:center; gap:12px;">
            <button onclick="window.updateCartItem('${item.id}', -1)" style="width:30px;height:30px;border:1px solid #d1ccc5;background:#fff;border-radius:4px;cursor:pointer;font-weight:bold;">−</button>
            <span style="font-family:monospace; font-size:15px; min-width:16px; text-align:center;">${qty}</span>
            <button onclick="window.updateCartItem('${item.id}', 1)" style="width:30px;height:30px;border:1px solid #d1ccc5;background:#fff;border-radius:4px;cursor:pointer;font-weight:bold;">+</button>
          </div>
          <button onclick="window.removeCartItem('${item.id}')" style="background:none;border:1px solid #e0dcd3;color:#c0392b;font-size:12px;font-weight:700;cursor:pointer;padding:6px 14px;border-radius:4px;">Remove</button>
        </div>
      </div>
    </div>`;
  }).join('');

  const totalStr = numToPrice(total);
  if (crateTotal) crateTotal.textContent = totalStr;
  if (crateSub) crateSub.textContent = totalStr;
  if (crateCount) crateCount.textContent = cart.reduce((s,x)=>s+(x.qty||1),0);
  if (summaryBox) summaryBox.style.display = 'block';
}

function _openLegacyDrawer() {
  const drawer  = document.getElementById('cartDrawer');
  const overlay = document.getElementById('cartOverlay');
  if (!drawer) return;
  drawer.classList.add('open');
  overlay?.classList.add('show');
  document.body.style.overflow = 'hidden';
}

function _openNewDrawer() {
  const d = document.getElementById('cart-drawer');
  const o = document.getElementById('cart-overlay');
  if (!d) return;
  d.classList.add('open');
  o?.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function _closeNewDrawer() {
  const d = document.getElementById('cart-drawer');
  const o = document.getElementById('cart-overlay');
  if (!d) return;
  d.classList.remove('open');
  o?.classList.remove('open');
  document.body.style.overflow = '';
}


/* ═══════════════════════════════════════════════════════════
   DOM READY — Wires up UI behaviours
═══════════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {

  // Render Carts globally on load
  _refreshAllBadges();
  _renderLegacyDrawer();
  _renderNewDrawer();
  _renderCratePage();

  // Dark Theme Drawer buttons
  document.querySelectorAll('[data-cart-open]').forEach(b => b.addEventListener('click', () => {
    _renderNewDrawer();
    _openNewDrawer();
  }));
  document.querySelectorAll('[data-cart-close]').forEach(b => b.addEventListener('click', _closeNewDrawer));
  document.getElementById('cart-overlay')?.addEventListener('click', _closeNewDrawer);
  document.addEventListener('keydown', e => { if (e.key === 'Escape') { _closeNewDrawer(); }});

  // Light Theme Overlay closure
  document.getElementById('cartOverlay')?.addEventListener('click', () => {
    document.getElementById('cartDrawer')?.classList.remove('open');
    document.getElementById('cartOverlay')?.classList.remove('show');
    document.body.style.overflow = '';
  });

  // "Add to Cart" interceptor for index.php buttons
  document.addEventListener('click', e => {
    const btn = e.target.closest('[data-add-cart]');
    if (!btn) return;
    const name  = btn.dataset.name;
    const price = btn.dataset.price;
    const img   = btn.dataset.img || ''; 
    const key   = name + (btn.dataset.variant || '');
    const c     = getCart();
    const ex    = c.find(x => x.id === key);
    if (ex) ex.qty++;
    else c.push({ id: key, name, price, qty: 1, img }); 
    saveCart(c);
    _refreshAllBadges();
    _renderNewDrawer();
    _openNewDrawer();
    _ripple(btn);
  });

  function _ripple(el) {
    const r = document.createElement('span');
    r.style.cssText = 'position:absolute;border-radius:50%;width:50px;height:50px;background:rgba(201,168,76,.35);transform:scale(0);animation:btRipple .5s linear;pointer-events:none;top:50%;left:50%;margin:-25px 0 0 -25px;';
    el.style.position = 'relative';
    el.appendChild(r);
    r.addEventListener('animationend', () => r.remove());
  }
  if (!document.getElementById('bt-ripple-style')) {
    const s = document.createElement('style');
    s.id = 'bt-ripple-style';
    s.textContent = '@keyframes btRipple{to{transform:scale(3.5);opacity:0;}}';
    document.head.appendChild(s);
  }

  // Custom Cursor
  const dot  = document.getElementById('cursor-dot');
  const ring = document.getElementById('cursor-ring');
  if (dot && ring) {
    let mx = innerWidth/2, my = innerHeight/2, rx = mx, ry = my;
    document.addEventListener('mousemove', e => { mx = e.clientX; my = e.clientY; });
    (function loop() {
      rx += (mx-rx)*.14; ry += (my-ry)*.14;
      dot.style.left  = mx+'px'; dot.style.top  = my+'px';
      ring.style.left = rx+'px'; ring.style.top = ry+'px';
      requestAnimationFrame(loop);
    })();
  }

  // Sticky Nav Logic
  const mainNav = document.getElementById('main-nav');
  if (mainNav) {
    const onScroll = () => mainNav.classList.toggle('scrolled', scrollY > 55);
    addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  // Mobile Hamburger Logic
  const hamburger = document.getElementById('nav-hamburger');
  const mobileNav = document.getElementById('mobile-nav-overlay');
  if (hamburger && mobileNav) {
    let open = false;
    const bars = hamburger.querySelectorAll('span');
    hamburger.addEventListener('click', () => {
      open = !open;
      mobileNav.classList.toggle('open', open);
      bars[0].style.transform = open ? 'translateY(6.5px) rotate(45deg)'  : '';
      bars[1].style.opacity   = open ? '0' : '';
      bars[2].style.transform = open ? 'translateY(-6.5px) rotate(-45deg)' : '';
    });
    mobileNav.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
      open = false; mobileNav.classList.remove('open');
      bars.forEach(b => { b.style.transform=''; b.style.opacity=''; });
    }));
  }

  // Reveal Animations
  const revealEls = document.querySelectorAll('.reveal');
  if (revealEls.length) {
    const obs = new IntersectionObserver(entries =>
      entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); obs.unobserve(e.target); } }),
      { threshold: 0.1 }
    );
    revealEls.forEach(el => obs.observe(el));
  }

  // Smooth anchor scroll
 // ... (previous code)
  
  // Smooth anchor scroll
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    // ... logic ...
  });

}); // end DOMContentLoaded


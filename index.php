<?php
/* ═══════════════════════════════════════════════════════
   BEAR TRIBLEAS — index.php (Homepage)
═══════════════════════════════════════════════════════ */

// ── Form Handling ──────────────────────────────────────
$nl_status  = '';
$con_status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nl_email'])) {
        $email = filter_var(trim($_POST['nl_email']), FILTER_SANITIZE_EMAIL);
        $nl_status = filter_var($email, FILTER_VALIDATE_EMAIL) ? 'ok' : 'err';
    }
    if (isset($_POST['con_submit'])) {
        $name = htmlspecialchars(trim($_POST['con_name']    ?? ''));
        $mail = filter_var(trim($_POST['con_email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $msg  = htmlspecialchars(trim($_POST['con_message'] ?? ''));
        $con_status = ($name && filter_var($mail, FILTER_VALIDATE_EMAIL) && $msg) ? 'ok' : 'err';
    }
}

// ── Data ───────────────────────────────────────────────
$featured_products = [
    ['name'=>'The Kodiak Hoodie',      'price'=>'₹3,499', 'badge'=>'New',     'badge_type'=>'new',  'desc'=>'Heavyweight fleece, drop shoulder',   'img'=>'https://images.unsplash.com/photo-1556821840-3a63f95609a7?auto=format&fit=crop&w=600&q=80'],
    ['name'=>'Grizzly Cargo Trousers', 'price'=>'₹4,299', 'badge'=>'',        'badge_type'=>'',     'desc'=>'Ripstop nylon, utility pockets',      'img'=>'https://images.unsplash.com/photo-1542272604-787c3835535d?auto=format&fit=crop&w=600&q=80'],
    ['name'=>'Tribleas Forest Tee',    'price'=>'₹1,799', 'badge'=>'Popular', 'badge_type'=>'sale', 'desc'=>'220gsm cotton, relaxed fit',          'img'=>'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=600&q=80'],
    ['name'=>'Paw Print Coach Jacket', 'price'=>'₹5,999', 'badge'=>'Limited', 'badge_type'=>'sale', 'desc'=>'Nylon shell, embroidered bear',       'img'=>'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?auto=format&fit=crop&w=600&q=80'],
    ['name'=>'Wilderness Joggers',     'price'=>'₹2,899', 'badge'=>'',        'badge_type'=>'',     'desc'=>'French terry, tapered cut',           'img'=>'https://images.unsplash.com/photo-1517438322307-e67111335449?auto=format&fit=crop&w=600&q=80'],
];

// Cleaned up Categories array with proper links
$categories = [
    ['name'=>'Tees',                    'count'=>'28 Pieces', 'link'=>'tees.php'],
    ['name'=>'Outerwear',               'count'=>'14 Pieces', 'link'=>'outerwear.php'],
    ['name'=>'Hoodies',                 'count'=>'19 Pieces', 'link'=>'hoodies.php'],
    ['name'=>'Backpacks & Accessories', 'count'=>'32 Pieces', 'link'=>'backpacks.php'],
    ['name'=>'Headwear',                'count'=>'32 Pieces', 'link'=>'headwear.php'],
    ['name'=>'Cargo',                   'count'=>'16 Pieces', 'link'=>'cargo.php'],
];

$features = [
    ['icon'=>'ship',   'title'=>'Free Shipping',      'desc'=>'On all orders above ₹2,000 — delivered to your den.'],
    ['icon'=>'leaf',   'title'=>'Ethically Sourced',  'desc'=>'Every fabric chosen with the earth and maker in mind.'],
    ['icon'=>'rotate', 'title'=>'Easy Returns',       'desc'=>'30-day no-questions returns on all unworn pieces.'],
    ['icon'=>'shield', 'title'=>'Quality Guaranteed', 'desc'=>'Every garment quality-checked before it leaves our hands.'],
];

$reviews = [
    ['text'=>'The Kodiak Hoodie is hands-down the best I\'ve ever owned. The weight, the drop shoulder, the way it holds shape — Bear Tribleas nails it.', 'name'=>'Aryan S.', 'loc'=>'Delhi', 'init'=>'A'],
    ['text'=>'I\'ve followed this brand since day one. The quality only gets better each season. Every drop feels intentional. Proud to be part of the tribe.', 'name'=>'Priya M.', 'loc'=>'Mumbai', 'init'=>'P'],
    ['text'=>'Ordered the Grizzly Cargos and they arrived in two days. Fit is immaculate — exactly as described. Even the packaging felt premium.', 'name'=>'Rishi K.', 'loc'=>'Bengaluru', 'init'=>'R'],
    ['text'=>'The Coach Jacket is a work of art. I\'ve gotten more compliments wearing this than anything else in my wardrobe. Worth every rupee.', 'name'=>'Naina T.', 'loc'=>'Jaipur', 'init'=>'N'],
];

$marquee_items = ['Bear Tribleas','Wear The Wild','SS 2025','Premium Quality','Limited Drops','Wilderness Luxury','Crafted Bold'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="Bear Tribleas — Wilderness Luxury Clothing. Where raw nature meets refined streetwear."/>
  <title>Bear Tribleas — Wear the Wild</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="style.css"/>
  
  <style>
    /* Dark Theme Checkout Modal Styles */
    .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.8); z-index:9000; align-items:center; justify-content:center; backdrop-filter:blur(5px); }
    .modal-box { background:var(--surface); border:1px solid rgba(201,168,76,.2); padding:40px; border-radius:4px; max-width:440px; width:90%; position:relative; text-align:center; }
    .close-modal { position:absolute; top:16px; right:20px; background:none; border:none; font-size:24px; cursor:pointer; color:var(--muted); transition:color .2s; }
    .close-modal:hover { color:var(--rust); }
    .modal-box h2 { font-family:var(--ff-display); font-size:2.2rem; color:var(--cream); letter-spacing:.05em; margin-bottom:8px; }
    .modal-amount { color:var(--gold); font-family:var(--ff-mono); font-size:1.1rem; margin-bottom:24px; font-weight:700; }
    .pay-tabs { display:flex; gap:10px; margin-bottom:20px; justify-content:center; }
    .pay-tab { padding:10px 24px; border:1px solid rgba(201,168,76,.2); background:transparent; border-radius:2px; cursor:pointer; font-family:var(--ff-mono); font-size:12px; color:var(--muted); transition:all .2s; text-transform:uppercase; letter-spacing:.1em; }
    .pay-tab.active { border-color:var(--gold); color:var(--gold); background:rgba(201,168,76,.08); }
    .pay-input { width:100%; padding:14px 18px; border:1px solid rgba(201,168,76,.2); border-radius:2px; font-family:var(--ff-body); font-size:14px; background:rgba(14,26,16,.5); color:var(--cream); outline:none; margin-bottom:16px; transition:border-color .2s; }
    .pay-input:focus { border-color:var(--gold); }
    .pay-btn { width:100%; background:var(--gold); border:none; border-radius:2px; color:#162418; font-family:var(--ff-mono); font-weight:700; font-size:13px; letter-spacing:.15em; text-transform:uppercase; padding:18px; cursor:pointer; transition:background .2s; }
    .pay-btn:hover { background:var(--gold-lt); }
  </style>
</head>
<body>
<div id="cursor-dot"></div>
<div id="cursor-ring"></div>
<div class="cart-overlay" id="cart-overlay"></div>

<div id="cart-drawer" role="dialog" aria-label="Shopping cart">
  <div class="cart-head">
    <h3>Your Bag</h3>
    <button class="cart-head-close" data-cart-close aria-label="Close cart">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
  </div>
  <div class="cart-body" id="cart-body"></div>
  <div class="cart-foot">
    <div class="cart-subtotal">
      <span>Total</span>
      <strong id="cart-total">₹0</strong>
    </div>
    <button class="cart-checkout-btn" onclick="openCheckout()" style="border:none; cursor:pointer;">Checkout</button>
  </div>
</div>

<div class="mobile-nav-overlay" id="mobile-nav-overlay">
  <a href="index.php">Home</a>
  <a href="#about">Story</a>
  <a href="#home-collections">Shop</a>
  <a href="#categories">Categories</a>
  <a href="#contact">Contact</a>
</div>

<nav id="main-nav" role="navigation" aria-label="Main navigation">
  <a href="index.php" class="nav-logo" aria-label="Bear Tribleas home">
    <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="width:36px; height:36px;">
      <circle cx="17" cy="13" r="7" fill="#c9a84c"/>
      <circle cx="43" cy="13" r="7" fill="#c9a84c"/>
      <ellipse cx="30" cy="34" rx="20" ry="18" fill="#c9a84c"/>
      <ellipse cx="22" cy="36" rx="4"  ry="5"  fill="#0e1a10"/>
      <ellipse cx="38" cy="36" rx="4"  ry="5"  fill="#0e1a10"/>
      <ellipse cx="30" cy="40" rx="6"  ry="4"  fill="#8c6832"/>
      <circle cx="27" cy="28" r="3" fill="#0e1a10"/>
      <circle cx="33" cy="28" r="3" fill="#0e1a10"/>
      <circle cx="27.8" cy="27.2" r="1" fill="#fff"/>
      <circle cx="33.8" cy="27.2" r="1" fill="#fff"/>
    </svg>
    <span class="nav-logo-text">Bear Tribleas</span>
  </a>

  <ul class="nav-links">
    <li><a href="#hero" class="active">Home</a></li>
    <li><a href="#about">Our Story</a></li>
    <li><a href="#home-collections">Collections</a></li>
    <li><a href="#categories">Categories</a></li>
    <li><a href="#contact">Contact</a></li>
  </ul>

  <div class="nav-actions">
    <button class="nav-cart-btn" data-cart-open aria-label="Open cart">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
        <line x1="3" y1="6" x2="21" y2="6"/>
        <path d="M16 10a4 4 0 01-8 0"/>
      </svg>
      <span class="cart-badge" id="cart-badge">0</span>
    </button>
    <a href="tees.php" class="nav-shop-btn">Shop Now</a>
    <button class="nav-hamburger" id="nav-hamburger" aria-label="Toggle menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<section id="hero">
  <div class="hero-bg" aria-hidden="true"></div>
  <div class="hero-grid" aria-hidden="true"></div>
  <div class="hero-bear-bg" aria-hidden="true">
    <svg viewBox="0 0 400 400" fill="var(--cream)" xmlns="http://www.w3.org/2000/svg">
      <circle cx="110" cy="70"  r="55"/>
      <circle cx="290" cy="70"  r="55"/>
      <ellipse cx="200" cy="230" rx="155" ry="140"/>
      <ellipse cx="60"  cy="340" rx="45"  ry="55"/>
      <ellipse cx="340" cy="340" rx="45"  ry="55"/>
      <ellipse cx="140" cy="355" rx="40"  ry="50"/>
      <ellipse cx="260" cy="355" rx="40"  ry="50"/>
    </svg>
  </div>

  <div class="hero-content">
    <p class="hero-eyebrow">SS 2025 Collection — Wilderness Luxury</p>
    <h1 class="hero-title">BEAR<em>TRIBLEAS</em></h1>
    <p class="hero-sub">Crafted for those who roam freely — where raw wilderness meets refined streetwear.</p>
    <div class="hero-ctas">
      <a href="tees.php" class="btn-primary"><span>Explore Collection</span></a>
      <a href="#about" class="btn-ghost">
        Our Story
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
          <line x1="5" y1="12" x2="19" y2="12"/>
          <polyline points="12 5 19 12 12 19"/>
        </svg>
      </a>
    </div>
  </div>

  <div class="hero-scroll-hint" aria-hidden="true">
    <div class="scroll-bar"></div>
    <span>Scroll</span>
  </div>
</section>

<div class="marquee-strip" aria-hidden="true">
  <div class="marquee-track">
    <?php foreach(array_merge($marquee_items,$marquee_items,$marquee_items,$marquee_items) as $item): ?>
    <span><?= htmlspecialchars($item) ?></span><span class="sep">✦</span>
    <?php endforeach; ?>
  </div>
</div>

<section id="about">
  <div class="container">
    <div class="about-grid">

      <div class="about-visual reveal">
        <div class="about-img">
          <img src="https://images.unsplash.com/photo-1551698618-1dfe5d97d256?auto=format&fit=crop&w=800&q=80" alt="Campaign Visual" style="width:100%; height:100%; object-fit:cover;">
        </div>
        <div class="about-badge">
          <strong>2018</strong>
          <small>Est.<br>in the wild</small>
        </div>
      </div>

      <div class="about-copy reveal" style="transition-delay:.18s;">
        <p class="section-label">Our Story</p>
        <h2 class="section-title">Born From <em>Nature,</em><br>Built For Streets</h2>
        <br>
        <p>Bear Tribleas was built on one belief: <strong>true style doesn't tame the wild — it channels it.</strong> From Himalayan forests to concrete cities, our garments bridge raw nature and urban identity.</p>
        <p>Every stitch is intentional. Every fabric is selected for feel, durability, and conscience. We design for the explorer — the one who walks into a room and commands attention without a word.</p>
        <p>Our drops are <strong>small-batch and thoughtfully made</strong> — because less made with meaning beats a flood of forgettable pieces.</p>
        <div class="stats-row">
          <div class="stat"><strong>12K+</strong><span>Happy Customers</span></div>
          <div class="stat"><strong>48</strong><span>Countries Reached</span></div>
          <div class="stat"><strong>100%</strong><span>Ethical Sourcing</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="home-collections">
  <div class="container">
    <div class="collections-head reveal">
      <div>
        <p class="section-label">Featured Drops</p>
        <h2 class="section-title">This <em>Season's</em><br>Finest</h2>
      </div>
      <a href="tees.php" class="view-all-link">
        View All Pieces
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </div>

    <div class="products-grid">
      <?php foreach($featured_products as $i => $p): ?>
      <div class="product-card <?= $i === 0 ? 'featured' : '' ?> reveal" style="transition-delay:<?= $i * .08 ?>s;">
        <div class="product-thumb">
          
          <?php if (!empty($p['img'])): ?>
            <img src="<?= htmlspecialchars($p['img']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" style="width:100%; height:100%; object-fit:cover;">
          <?php else: ?>
            <div class="product-thumb-ph">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" width="46" height="46">
                <path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.57a1 1 0 00.99.86H6v10c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V10h2.15a1 1 0 00.99-.86l.58-3.57a2 2 0 00-1.34-2.23z"/>
              </svg>
              <small><?= htmlspecialchars($p['desc']) ?></small>
            </div>
          <?php endif; ?>

          <?php if ($p['badge']): ?>
          <div class="product-badge <?= $p['badge_type'] ?>"><?= htmlspecialchars($p['badge']) ?></div>
          <?php endif; ?>
        </div>
        <div class="product-info">
          <div class="product-name"><?= htmlspecialchars($p['name']) ?></div>
          <div class="product-meta">
            <span class="product-price"><?= $p['price'] ?></span>
            <button class="product-add"
                    data-add-cart
                    data-name="<?= htmlspecialchars($p['name']) ?>"
                    data-price="<?= htmlspecialchars($p['price']) ?>"
                    data-img="<?= htmlspecialchars($p['img'] ?? '') ?>"
                    aria-label="Add <?= htmlspecialchars($p['name']) ?> to cart">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
              </svg>
            </button>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section id="categories">
  <div class="container">
    <div class="reveal">
      <p class="section-label">Shop By Category</p>
      <h2 class="section-title">Find Your <em>Wild</em></h2>
    </div>
    <div class="cats-grid">
      <?php foreach($categories as $i => $c): ?>
      <a href="<?= htmlspecialchars($c['link']) ?>" class="cat-card reveal" style="transition-delay:<?= $i*.1 ?>s;">
        <div class="cat-bg"></div>
        <div class="cat-icon">
          <svg viewBox="0 0 24 24" fill="var(--cream)">
            <?php if($i===0): ?><path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.57a1 1 0 00.99.86H6v10c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V10h2.15a1 1 0 00.99-.86l.58-3.57a2 2 0 00-1.34-2.23z"/>
            <?php elseif($i===1): ?><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/>
            <?php elseif($i===2): ?><path d="M6 2v11l3 9h2l1-6 1 6h2l3-9V2H6zm5 9H8V4h3v7zm5 0h-3V4h3v7z"/>
            <?php else: ?><path d="M3 9h18M3 9s0-7 9-7 9 7 9 7v13H3z"/><?php endif; ?>
          </svg>
        </div>
        <div class="cat-label">
          <h3><?= htmlspecialchars($c['name']) ?></h3>
          <span><?= htmlspecialchars($c['count']) ?></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section id="features">
  <div class="container">
    <div class="features-grid">
      <?php foreach($features as $f): ?>
      <div class="feat reveal">
        <div class="feat-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <?php if($f['icon']==='ship'): ?>
              <path d="M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h11a2 2 0 012 2v3m0 0h3l3 4v4h-3.5M17 8H7m0 9a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4z"/>
            <?php elseif($f['icon']==='leaf'): ?>
              <path d="M11 20A7 7 0 014 13C4 9 7 4 12 2c0 3 1.5 5 3 6 1.5 1 3 1.5 3 4a4 4 0 01-7 2.65"/><path d="M12 22v-3"/>
            <?php elseif($f['icon']==='rotate'): ?>
              <polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/>
            <?php else: ?>
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            <?php endif; ?>
          </svg>
        </div>
        <h4><?= htmlspecialchars($f['title']) ?></h4>
        <p><?= htmlspecialchars($f['desc']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section id="testimonials">
  <div class="container">
    <div class="reveal">
      <p class="section-label">What They Say</p>
      <h2 class="section-title">The <em>Tribe</em> Speaks</h2>
    </div>
    <div class="testi-slider">
      <div class="testi-track" id="testi-track">
        <?php foreach($reviews as $r): ?>
        <div class="testi-card">
          <div class="testi-quote">"</div>
          <p class="testi-text"><?= htmlspecialchars($r['text']) ?></p>
          <div class="testi-author">
            <div class="author-av"><?= htmlspecialchars($r['init']) ?></div>
            <div>
              <div class="testi-stars">★★★★★</div>
              <div class="author-name"><?= htmlspecialchars($r['name']) ?></div>
              <div class="author-loc"><?= htmlspecialchars($r['loc']) ?></div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="slider-nav">
      <button id="slider-prev" aria-label="Previous review">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
      </button>
      <button id="slider-next" aria-label="Next review">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
      </button>
    </div>
  </div>
</section>

<section id="newsletter">
  <div class="nl-bg-text" aria-hidden="true">SUBSCRIBE</div>
  <div class="container nl-content reveal">
    <p class="section-label">Join The Pack</p>
    <h2 class="section-title">Get Early <em>Access</em></h2>
    <p>Drop alerts, exclusive offers & wilderness stories — delivered to your inbox.</p>
    <form class="nl-form" id="nl-form" method="POST">
      <input type="email" name="nl_email" placeholder="Enter your email address" required aria-label="Email address"/>
      <button type="submit">Subscribe</button>
    </form>
    <?php if($nl_status==='ok'): ?>
      <p class="form-feedback ok">Welcome to the tribe! You're in. 🐻</p>
    <?php elseif($nl_status==='err'): ?>
      <p class="form-feedback err">Please enter a valid email address.</p>
    <?php endif; ?>
  </div>
</section>

<section id="contact">
  <div class="container">
    <div class="contact-grid">
      <div class="reveal">
        <p class="section-label">Get In Touch</p>
        <h2 class="section-title">Say <em>Hello</em></h2>
        <p>Questions about sizing, custom orders, or wholesale? The tribe is always open.</p>
        <div class="contact-detail">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          <span>hello@beartribleas.com</span>
        </div>
        <div class="contact-detail">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.9 11.86a19.79 19.79 0 01-3.07-8.67A2 2 0 012.81 1h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L7.09 8.91a16 16 0 006 6l.97-.96a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
          <span>+91 98765 43210</span>
        </div>
        <div class="contact-detail">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
          <span>Sector 14, Karnal<br>Haryana, India — 132001</span>
        </div>
      </div>

      <div class="reveal" style="transition-delay:.18s;">
        <form class="contact-form" method="POST">
          <div class="form-row">
            <div class="form-group">
              <label for="con_name">Full Name</label>
              <input type="text" id="con_name" name="con_name" placeholder="Your name" required/>
            </div>
            <div class="form-group">
              <label for="con_email">Email</label>
              <input type="email" id="con_email" name="con_email" placeholder="your@email.com" required/>
            </div>
          </div>
          <div class="form-group">
            <label for="con_message">Message</label>
            <textarea id="con_message" name="con_message" rows="5" placeholder="Tell us what's on your mind…" required></textarea>
          </div>
          <input type="hidden" name="con_submit" value="1"/>
          <?php if($con_status==='ok'): ?>
            <p class="form-feedback ok">Message received! We'll be in touch shortly.</p>
          <?php elseif($con_status==='err'): ?>
            <p class="form-feedback err">Please fill in all fields correctly.</p>
          <?php endif; ?>
          <button type="submit" class="form-submit">Send Message</button>
        </form>
      </div>
    </div>
  </div>
</section>

<footer id="main-footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <a href="index.php" class="nav-logo" aria-label="Bear Tribleas home">
          <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg" width="30" height="30">
            <circle cx="17" cy="13" r="7" fill="#c9a84c"/>
            <circle cx="43" cy="13" r="7" fill="#c9a84c"/>
            <ellipse cx="30" cy="34" rx="20" ry="18" fill="#c9a84c"/>
          </svg>
          <span class="nav-logo-text" style="font-size:1.3rem;">Bear Tribleas</span>
        </a>
        <p class="footer-brand-desc">Wear the wild. Every garment is a quiet rebellion against the ordinary — built for those who move with intention.</p>
        <div class="social-row">
          <a href="#" class="social-btn" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".5" fill="currentColor"/></svg>
          </a>
          <a href="#" class="social-btn" aria-label="Twitter / X">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          </a>
          <a href="#" class="social-btn" aria-label="YouTube">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.97C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.97A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>
          </a>
        </div>
      </div>

      <div class="footer-col">
        <h4>Shop</h4>
        <ul>
          <li><a href="tees.php">Tees</a></li>
          <li><a href="outerwear.php">Outerwear</a></li>
          <li><a href="hoodies.php">Hoodies</a></li>
          <li><a href="headwear.php">Headwear</a></li>
          <li><a href="backpacks.php">Backpacks</a></li>
          <li><a href="cargo.php">Cargo</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Help</h4>
        <ul>
          <li><a href="#">Size Guide</a></li>
          <li><a href="#">Shipping Info</a></li>
          <li><a href="#">Returns &amp; Exchanges</a></li>
          <li><a href="#">Track Order</a></li>
          <li><a href="#">FAQs</a></li>
          <li><a href="#contact">Contact Us</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <li><a href="#about">Our Story</a></li>
          <li><a href="#">Sustainability</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#">Wholesale</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms of Service</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; <?= date('Y') ?> Bear Tribleas. All rights reserved.</p>
      <p>Made with craft in Karnal, Haryana 🐻</p>
    </div>
  </div>
</footer>

<div class="modal-overlay" id="checkoutModal">
  <div class="modal-box">
    <button class="close-modal" onclick="closeCheckout()">&times;</button>
    <h2>Secure Checkout</h2>
    <p class="modal-amount">Total Due: <span id="modal-amount">₹0</span></p>
    <div class="pay-tabs">
      <button class="pay-tab active" id="tab-upi"  onclick="togglePayment('upi')">📱 Scan &amp; Pay</button>
      <button class="pay-tab"        id="tab-card" onclick="togglePayment('card')">💳 Card</button>
    </div>
    <div id="section-upi">
      <div style="margin-bottom:20px; display:flex; justify-content:center;">
        <img id="upi-qr-code" src="" alt="UPI QR Code" style="width:180px;height:180px;border:1px solid rgba(201,168,76,.2);border-radius:4px;padding:10px;background:rgba(14,26,16,.5);">
      </div>
      <input type="text" class="pay-input" placeholder="yourname@upi (optional)">
    </div>
    <div id="section-card" style="display:none;">
      <input type="text" class="pay-input" placeholder="Card Number — XXXX XXXX XXXX XXXX">
      <div style="display:flex; gap:10px;">
        <input type="text" class="pay-input" placeholder="MM / YY">
        <input type="text" class="pay-input" placeholder="CVV">
      </div>
    </div>
    <button class="pay-btn" onclick="submitPayment()">CONFIRM PAYMENT</button>
  </div>
</div>

<script src="script.js"></script>
</body>
</html>
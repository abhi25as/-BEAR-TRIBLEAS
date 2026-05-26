<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bear Tribleas | Heavy Tees</title>
  <style>
    :root{--primary-dark:#2C352D;--primary-light:#Fcfaf8;--accent-color:#5C3D26;--accent-hover:#3b2718;--grey-light:#EBEBE6;--grey-border:#e0dcd3;--text-dark:#1A1A1A;--text-muted:#555555;}
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;}
    body{background:var(--primary-light);color:var(--text-dark);overflow-x:hidden;}
    .top-bar{background:var(--primary-dark);color:#fff;display:flex;justify-content:space-between;padding:10px 5%;font-size:12px;font-weight:500;}
    @media(max-width:768px){.top-bar{display:none;}}
    .main-header{display:flex;align-items:center;justify-content:space-between;padding:15px 5%;background:#fff;border-bottom:1px solid var(--grey-border);position:sticky;top:0;z-index:100;box-shadow:0 4px 12px rgba(0,0,0,.03);}
    .logo{font-size:1.8rem;font-weight:300;letter-spacing:3px;text-transform:uppercase;color:var(--primary-dark);text-decoration:none;}
    .logo span{font-weight:800;color:#8B5A2B;}
    .search-bar{flex:1;max-width:450px;margin:0 30px;display:flex;background:var(--grey-light);border:1px solid var(--grey-border);border-radius:6px;padding:12px 15px;}
    .search-bar input{border:none;background:transparent;width:100%;outline:none;font-size:14px;}
    .header-actions{display:flex;align-items:center;gap:25px;}
    .sign-in-btn{background:#8B5A2B;color:#fff;border:none;padding:12px 24px;font-weight:700;font-size:13px;letter-spacing:1px;cursor:pointer;border-radius:4px;}
    .sign-in-btn:hover{background:var(--accent-hover);}
    .action-icon{display:flex;flex-direction:column;align-items:center;font-size:12px;cursor:pointer;font-weight:600;color:var(--text-dark);}
    .action-icon:hover{color:var(--accent-color);}
    .action-icon span.icon{font-size:22px;margin-bottom:4px;}
    .category-nav{display:flex;gap:40px;padding:20px 5%;background:#fff;overflow-x:auto;scrollbar-width:none;}
    .category-nav::-webkit-scrollbar{display:none;}
    .cat-item{display:flex;flex-direction:column;align-items:center;text-decoration:none;color:var(--text-dark);min-width:70px;transition:transform .2s;}
    .cat-item:hover{transform:translateY(-3px);}
    .cat-item img{width:70px;height:70px;object-fit:cover;margin-bottom:10px;border-radius:50%;border:2px solid transparent;transition:border-color .3s;}
    .cat-item:hover img,.cat-item.active img{border-color:var(--accent-color);}
    .cat-item span{font-size:13px;font-weight:600;}
    .hero{height:30vh;background:center/cover no-repeat;display:flex;align-items:center;justify-content:center;text-align:center;padding:40px 5%;position:relative;}
    .hero::after{content:'';position:absolute;inset:0;background:rgba(44,53,45,.7);}
    .hero-content{position:relative;z-index:10;color:#fff;}
    .content-section{padding:60px 5%;max-width:1400px;margin:0 auto;}
    .section-title{font-size:1.6rem;margin-bottom:30px;font-weight:800;letter-spacing:1px;text-transform:uppercase;display:flex;align-items:center;gap:15px;color:var(--primary-dark);}
    .section-title::after{content:'';flex:1;height:1px;background:var(--grey-border);}
    .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px;}
    .minimalist-card{background:#fff;border:1px solid #e8e2d9;border-radius:12px;overflow:hidden;display:flex;flex-direction:column;transition:transform .3s,box-shadow .3s;}
    .minimalist-card:hover{transform:translateY(-5px);box-shadow:0 10px 20px rgba(0,0,0,.06);}
    .product-image{width:100%;height:250px;object-fit:cover;border-bottom:1px solid var(--grey-border);}
    .card-content{padding:25px 20px;display:flex;flex-direction:column;flex:1;}
    .card-title{font-size:17px;font-weight:800;color:var(--accent-color);margin-bottom:20px;line-height:1.3;}
    .variant-select{width:100%;padding:10px;border:1px solid #d1ccc5;border-radius:6px;font-size:14px;color:#333;margin-bottom:15px;outline:none;background:#fff;cursor:pointer;}
    .qty-input-full{width:100%;padding:10px;border:1px solid #d1ccc5;border-radius:6px;font-size:14px;color:#333;margin-bottom:15px;outline:none;}
    .add-btn-small{background:var(--accent-color);color:#fff;border:none;border-radius:6px;padding:10px 24px;font-size:14px;font-weight:700;cursor:pointer;width:100%;margin-top:auto;transition:background .3s;}
    .add-btn-small:hover{background:var(--accent-hover);}
    .cart-drawer{position:fixed;top:0;right:-450px;width:400px;max-width:100%;height:100%;background:#fff;z-index:1000;transition:right .4s cubic-bezier(.4,0,.2,1);display:flex;flex-direction:column;box-shadow:-10px 0 30px rgba(0,0,0,.1);}
    .cart-drawer.open{right:0;}
    .cart-header{padding:25px 20px;border-bottom:1px solid var(--grey-border);display:flex;justify-content:space-between;align-items:center;}
    .cart-header h2{font-size:1.4rem;font-weight:800;text-transform:uppercase;color:var(--primary-dark);}
    .close-cart{background:none;border:none;color:var(--primary-dark);font-size:28px;cursor:pointer;}
    .cart-items-container{flex:1;overflow-y:auto;padding:20px;}
    .cart-item{display:flex;gap:15px;margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid var(--grey-border);}
    .cart-item-img{width:70px;height:70px;object-fit:cover;border-radius:6px;}
    .cart-item-details{flex:1;}
    .cart-item-details h4{font-size:15px;margin-bottom:5px;font-weight:800;color:var(--accent-color);}
    .cart-footer{padding:25px 20px;background:var(--grey-light);border-top:1px solid var(--grey-border);}
    .checkout-btn{width:100%;background:var(--accent-color);border:none;border-radius:4px;color:#fff;font-weight:700;font-size:14px;letter-spacing:1px;padding:18px;cursor:pointer;}
    .cart-overlay{position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:999;opacity:0;visibility:hidden;transition:all .3s;}
    .cart-overlay.show{opacity:1;visibility:visible;}
    footer{background:#fff;padding:60px 5% 30px;border-top:1px solid var(--grey-border);margin-top:40px;}
    .footer-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:40px;margin-bottom:40px;}
    .footer-col h4{font-size:16px;font-weight:700;margin-bottom:20px;text-transform:uppercase;color:var(--primary-dark);}
    .footer-col ul{list-style:none;}
    .footer-col ul li{margin-bottom:12px;}
    .footer-col ul li a{color:var(--text-muted);text-decoration:none;font-size:14px;}
    .footer-bottom{text-align:center;padding-top:30px;border-top:1px solid var(--grey-border);color:var(--text-muted);font-size:14px;}
  </style>
</head>
<body>

  <div class="cart-overlay" id="cartOverlay"></div>
  <div class="cart-drawer" id="cartDrawer">
    <div class="cart-header">
      <h2>Your Crate</h2>
      <button class="close-cart" onclick="toggleCart()">&times;</button>
    </div>
    <div class="cart-items-container" id="cartItemsContainer"></div>
    <div class="cart-footer">
      <div style="font-size:1.1rem;margin-bottom:20px;display:flex;justify-content:space-between;align-items:center;">
        <strong style="color:#555;">SUBTOTAL:</strong>
        <span id="cartTotal" style="font-size:1.5rem;font-weight:900;color:var(--accent-color);">₹0.00</span>
      </div>
      <button class="checkout-btn" onclick="window.location.href='crate.php'">PROCEED TO CHECKOUT</button>
    </div>
  </div>

  <header class="main-header">
    <a href="index.php" class="logo">BEAR<span>TRIBLEAS</span></a>
    <div class="search-bar"><span style="color:#888;margin-right:10px;">🔍</span><input type="text" placeholder="Search gear..."></div>
    <div class="header-actions">
      <button class="sign-in-btn">JOIN THE TRIBE</button>
      <div class="action-icon" onclick="toggleCart()"><span class="icon">🎒</span><span style="white-space:nowrap;">Crate <span id="cart-count">0</span></span></div>
    </div>
  </header>

  <nav class="category-nav">
    <a href="tees.php" class="cat-item active"><img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=150&q=80" alt="Heavy Tees"><span>Heavy Tees</span></a>
    <a href="hoodies.php" class="cat-item"><img src="https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=150&q=80" alt="Hoodies"><span>Hoodies</span></a>
    <a href="outerwear.php" class="cat-item"><img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=150&q=80" alt="Outerwear"><span>Outerwear</span></a>
    <a href="cargo.php" class="cat-item"><img src="https://images.unsplash.com/photo-1542272604-787c3835535d?w=150&q=80" alt="Cargo &amp; Denim"><span>Cargo &amp; Denim</span></a>
    <a href="headwear.php" class="cat-item"><img src="https://images.unsplash.com/photo-1576871337622-98d48d1cf531?w=150&q=80" alt="Headwear"><span>Headwear</span></a>
    <a href="backpacks.php" class="cat-item"><img src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=150&q=80" alt="Backpacks"><span>Backpacks</span></a>
  </nav>

  <div class="hero" style="background-image:url('https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=1600&q=80');">
    <div class="hero-content">
      <h1 style="font-size:4rem;text-transform:uppercase;letter-spacing:2px;">Heavy Tees</h1>
      <p style="font-size:1.2rem;margin-top:10px;">Premium 220gsm cotton essentials.</p>
    </div>
  </div>

  <section class="content-section">
    <div class="grid">
      <div class="minimalist-card">
        <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=400&q=80" class="product-image">
        <div class="card-content">
          <h3 class="card-title">Wilderness Oversized Tee</h3>
          <select id="variant-101" class="variant-select"><option value="1799">Medium — ₹1,799</option><option value="1999">XL — ₹1,999</option></select>
          <input type="number" id="qty-101" class="qty-input-full" value="1" min="1" max="20">
          <button class="add-btn-small" onclick="addVariantToCart(101,'Wilderness Oversized Tee','https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=400&q=80')">ADD TO CRATE</button>
        </div>
      </div>
      <div class="minimalist-card">
        <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?auto=format&fit=crop&w=400&q=80" class="product-image">
        <div class="card-content">
          <h3 class="card-title">Classic Heavyweight Tee</h3>
          <select id="variant-102" class="variant-select"><option value="1499">Medium — ₹1,499</option></select>
          <input type="number" id="qty-102" class="qty-input-full" value="1" min="1" max="20">
          <button class="add-btn-small" onclick="addVariantToCart(102,'Classic Heavyweight Tee','https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?auto=format&fit=crop&w=400&q=80')">ADD TO CRATE</button>
        </div>
      </div>
      <div class="minimalist-card">
        <img src="https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=400&q=80" class="product-image">
        <div class="card-content">
          <h3 class="card-title">Horizon Graphic Tee</h3>
          <select id="variant-103" class="variant-select"><option value="1899">Large — ₹1,899</option></select>
          <input type="number" id="qty-103" class="qty-input-full" value="1" min="1" max="20">
          <button class="add-btn-small" onclick="addVariantToCart(103,'Horizon Graphic Tee','https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=400&q=80')">ADD TO CRATE</button>
        </div>
      </div>
      <div class="minimalist-card">
        <img src="https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?auto=format&fit=crop&w=400&q=80" class="product-image">
        <div class="card-content">
          <h3 class="card-title">Basecamp Longsleeve</h3>
          <select id="variant-104" class="variant-select"><option value="2199">Medium — ₹2,199</option></select>
          <input type="number" id="qty-104" class="qty-input-full" value="1" min="1" max="20">
          <button class="add-btn-small" onclick="addVariantToCart(104,'Basecamp Longsleeve','https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?auto=format&fit=crop&w=400&q=80')">ADD TO CRATE</button>
        </div>
      </div>
    </div>
  </section>

  <script src="script.js"></script>
</body>
</html>
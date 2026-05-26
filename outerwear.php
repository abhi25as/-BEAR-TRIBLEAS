<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bear Tribleas | Outerwear</title>
  <style>
    :root{--primary-dark:#2C352D;--primary-light:#Fcfaf8;--accent-color:#5C3D26;--accent-hover:#3b2718;--grey-light:#EBEBE6;--grey-border:#e0dcd3;--text-dark:#1A1A1A;--text-muted:#555555;}
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;}
    body{background:var(--primary-light);color:var(--text-dark);overflow-x:hidden;}
    .main-header{display:flex;align-items:center;justify-content:space-between;padding:15px 5%;background:#fff;border-bottom:1px solid var(--grey-border);position:sticky;top:0;z-index:100;}
    .logo{font-size:1.8rem;font-weight:300;letter-spacing:3px;text-transform:uppercase;color:var(--primary-dark);text-decoration:none;}
    .logo span{font-weight:800;color:#8B5A2B;}
    .search-bar{flex:1;max-width:450px;margin:0 30px;display:flex;background:var(--grey-light);border:1px solid var(--grey-border);border-radius:6px;padding:12px 15px;}
    .search-bar input{border:none;background:transparent;width:100%;outline:none;font-size:14px;}
    .header-actions{display:flex;align-items:center;gap:25px;}
    .sign-in-btn{background:#8B5A2B;color:#fff;border:none;padding:12px 24px;font-weight:700;font-size:13px;letter-spacing:1px;cursor:pointer;border-radius:4px;}
    .action-icon{display:flex;flex-direction:column;align-items:center;font-size:12px;cursor:pointer;font-weight:600;color:var(--text-dark);}
    .category-nav{display:flex;gap:40px;padding:20px 5%;background:#fff;overflow-x:auto;}
    .cat-item{display:flex;flex-direction:column;align-items:center;text-decoration:none;color:var(--text-dark);min-width:70px;}
    .cat-item img{width:70px;height:70px;object-fit:cover;margin-bottom:10px;border-radius:50%;border:2px solid transparent;}
    .cat-item:hover img,.cat-item.active img{border-color:var(--accent-color);}
    .cat-item span{font-size:13px;font-weight:600;}
    .hero{height:30vh;background:center/cover no-repeat;display:flex;align-items:center;justify-content:center;text-align:center;padding:40px 5%;position:relative;}
    .hero::after{content:'';position:absolute;inset:0;background:rgba(44,53,45,.7);}
    .hero-content{position:relative;z-index:10;color:#fff;}
    .content-section{padding:60px 5%;max-width:1400px;margin:0 auto;}
    .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px;}
    .minimalist-card{background:#fff;border:1px solid #e8e2d9;border-radius:12px;overflow:hidden;display:flex;flex-direction:column;}
    .product-image{width:100%;height:250px;object-fit:cover;}
    .card-content{padding:25px 20px;display:flex;flex-direction:column;flex:1;}
    .card-title{font-size:17px;font-weight:800;color:var(--accent-color);margin-bottom:20px;}
    .variant-select, .qty-input-full{width:100%;padding:10px;border:1px solid #d1ccc5;border-radius:6px;font-size:14px;margin-bottom:15px;outline:none;}
    .add-btn-small{background:var(--accent-color);color:#fff;border:none;border-radius:6px;padding:10px;font-weight:700;cursor:pointer;width:100%;margin-top:auto;}
    .cart-drawer{position:fixed;top:0;right:-450px;width:400px;height:100%;background:#fff;z-index:1000;transition:right .4s;display:flex;flex-direction:column;box-shadow:-10px 0 30px rgba(0,0,0,.1);}
    .cart-drawer.open{right:0;}
    .cart-header{padding:25px 20px;border-bottom:1px solid var(--grey-border);display:flex;justify-content:space-between;}
    .close-cart{background:none;border:none;font-size:28px;cursor:pointer;}
    .cart-items-container{flex:1;overflow-y:auto;padding:20px;}
    .cart-footer{padding:25px 20px;background:var(--grey-light);}
    .checkout-btn{width:100%;background:var(--accent-color);border:none;padding:18px;color:#fff;font-weight:700;cursor:pointer;}
    .cart-overlay{position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:999;opacity:0;visibility:hidden;transition:all .3s;}
    .cart-overlay.show{opacity:1;visibility:visible;}
  </style>
</head>
<body>

  <div class="cart-overlay" id="cartOverlay"></div>
  <div class="cart-drawer" id="cartDrawer">
    <div class="cart-header"><h2>Your Crate</h2><button class="close-cart" onclick="toggleCart()">&times;</button></div>
    <div class="cart-items-container" id="cartItemsContainer"></div>
    <div class="cart-footer">
      <div style="font-size:1.1rem;margin-bottom:20px;display:flex;justify-content:space-between;">
        <strong>SUBTOTAL:</strong><span id="cartTotal" style="color:var(--accent-color);font-weight:900;">₹0.00</span>
      </div>
      <button class="checkout-btn" onclick="window.location.href='crate.php'">PROCEED TO CHECKOUT</button>
    </div>
  </div>

  <header class="main-header">
    <a href="index.php" class="logo">BEAR<span>TRIBLEAS</span></a>
    <div class="search-bar"><input type="text" placeholder="Search gear..."></div>
    <div class="header-actions">
      <div class="action-icon" onclick="toggleCart()"><span class="icon">🎒</span><span>Crate <span id="cart-count">0</span></span></div>
    </div>
  </header>

  <nav class="category-nav">
    <a href="tees.php" class="cat-item"><img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=150&q=80" alt="Heavy Tees"><span>Heavy Tees</span></a>
    <a href="hoodies.php" class="cat-item"><img src="https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=150&q=80" alt="Hoodies"><span>Hoodies</span></a>
    <a href="outerwear.php" class="cat-item active"><img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=150&q=80" alt="Outerwear"><span>Outerwear</span></a>
    <a href="cargo.php" class="cat-item"><img src="https://images.unsplash.com/photo-1542272604-787c3835535d?w=150&q=80" alt="Cargo &amp; Denim"><span>Cargo &amp; Denim</span></a>
    <a href="headwear.php" class="cat-item"><img src="https://images.unsplash.com/photo-1576871337622-98d48d1cf531?w=150&q=80" alt="Headwear"><span>Headwear</span></a>
    <a href="backpacks.php" class="cat-item"><img src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=150&q=80" alt="Backpacks"><span>Backpacks</span></a>
  </nav>

  <div class="hero" style="background-image:url('https://images.unsplash.com/photo-1591047139829-d91aecb6caea?auto=format&fit=crop&w=1600&q=80');">
    <div class="hero-content">
      <h1 style="font-size:4rem;text-transform:uppercase;letter-spacing:2px;">Outerwear</h1>
    </div>
  </div>

  <section class="content-section">
    <div class="grid">
      <div class="minimalist-card">
        <img src="https://images.unsplash.com/photo-1559551409-dadc959f76b8?auto=format&fit=crop&w=400&q=80" class="product-image">
        <div class="card-content">
          <h3 class="card-title">Trail Windbreaker</h3>
          <select id="variant-501" class="variant-select"><option value="3199">Medium — ₹3,199</option></select>
          <input type="number" id="qty-501" class="qty-input-full" value="1" min="1" max="20">
          <button class="add-btn-small" onclick="addVariantToCart(501,'Trail Windbreaker','https://images.unsplash.com/photo-1559551409-dadc959f76b8?auto=format&fit=crop&w=400&q=80')">ADD TO CRATE</button>
        </div>
      </div>
      <div class="minimalist-card">
        <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?auto=format&fit=crop&w=400&q=80" class="product-image">
        <div class="card-content">
          <h3 class="card-title">Paw Print Coach Jacket</h3>
          <select id="variant-502" class="variant-select"><option value="5999">Large — ₹5,999</option></select>
          <input type="number" id="qty-502" class="qty-input-full" value="1" min="1" max="20">
          <button class="add-btn-small" onclick="addVariantToCart(502,'Paw Print Coach Jacket','https://images.unsplash.com/photo-1591047139829-d91aecb6caea?auto=format&fit=crop&w=400&q=80')">ADD TO CRATE</button>
        </div>
      </div>
      <div class="minimalist-card">
        <img src="https://images.unsplash.com/photo-1544022613-e87ca75a784a?auto=format&fit=crop&w=400&q=80" class="product-image">
        <div class="card-content">
          <h3 class="card-title">Sierra Shell Jacket</h3>
          <select id="variant-503" class="variant-select"><option value="5499">Large — ₹5,499</option></select>
          <input type="number" id="qty-503" class="qty-input-full" value="1" min="1" max="20">
          <button class="add-btn-small" onclick="addVariantToCart(503,'Sierra Shell Jacket','https://images.unsplash.com/photo-1544022613-e87ca75a784a?auto=format&fit=crop&w=400&q=80')">ADD TO CRATE</button>
        </div>
      </div>
      <div class="minimalist-card">
        <img src="https://images.unsplash.com/photo-1551028719-00167b16eac5?auto=format&fit=crop&w=400&q=80" class="product-image">
        <div class="card-content">
          <h3 class="card-title">Tundra Puffer Vest</h3>
          <select id="variant-504" class="variant-select"><option value="4499">Medium — ₹4,499</option></select>
          <input type="number" id="qty-504" class="qty-input-full" value="1" min="1" max="20">
          <button class="add-btn-small" onclick="addVariantToCart(504,'Tundra Puffer Vest','https://images.unsplash.com/photo-1551028719-00167b16eac5?auto=format&fit=crop&w=400&q=80')">ADD TO CRATE</button>
        </div>
      </div>
    </div>
  </section>

  <script src="script.js"></script>
</body>
</html>
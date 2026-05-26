<!DOCTYPE html>
<html lang="en">
<head>
   <link rel="stylesheet" href="style.css"/>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bear Tribleas | Your Crate</title>
  
  <style>
    :root{--primary-dark:#2C352D;--primary-light:#Fcfaf8;--accent-color:#5C3D26;--accent-hover:#3b2718;--grey-light:#EBEBE6;--grey-border:#e0dcd3;--text-dark:#1A1A1A;--text-muted:#555555;}
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;}
    body{background:var(--primary-light);color:var(--text-dark);}
    .main-header{display:flex;align-items:center;justify-content:space-between;padding:18px 5%;background:#fff;border-bottom:1px solid var(--grey-border);position:sticky;top:0;z-index:100;box-shadow:0 4px 12px rgba(0,0,0,.03);}
    .logo{font-size:1.8rem;font-weight:300;letter-spacing:3px;text-transform:uppercase;color:var(--primary-dark);text-decoration:none;}
    .logo span{font-weight:800;color:#8B5A2B;}
    .back-link{text-decoration:none;color:var(--accent-color);font-weight:700;font-size:14px;letter-spacing:.5px;display:flex;align-items:center;gap:6px;}
    .back-link:hover{color:var(--accent-hover);}
    .content{padding:50px 5%;max-width:900px;margin:0 auto;}
    h1{font-size:2rem;font-weight:800;text-transform:uppercase;color:var(--primary-dark);margin-bottom:8px;}
    .crate-meta{color:var(--text-muted);font-size:14px;margin-bottom:40px;}
    .crate-meta strong{color:var(--accent-color);}
    /* Items */
    .crate-item{display:flex;gap:20px;padding:24px 0;border-bottom:1px solid var(--grey-border);align-items:flex-start;}
    .crate-item-img{width:90px;height:90px;object-fit:cover;border-radius:8px;flex-shrink:0;border:1px solid var(--grey-border);}
    .crate-item-info{flex:1;}
    .crate-item-info h3{font-size:1rem;font-weight:800;color:var(--primary-dark);margin-bottom:8px;}
    .crate-price{font-size:15px;color:var(--text-muted);margin-bottom:12px;}
    .crate-price strong{color:var(--primary-dark);font-size:1.1rem;}
    .crate-remove{background:none;border:1px solid #e0dcd3;color:#c0392b;font-size:12px;font-weight:700;cursor:pointer;padding:6px 14px;border-radius:4px;}
    .crate-empty{text-align:center;padding:80px 20px;}
    .crate-empty p{font-size:1.2rem;color:var(--text-muted);margin-bottom:24px;}
    .crate-empty a{display:inline-block;padding:14px 32px;background:var(--accent-color);color:#fff;font-weight:700;border-radius:4px;text-decoration:none;}
    /* Summary */
    .crate-summary{margin-top:30px;background:#fff;border:1px solid var(--grey-border);border-radius:10px;padding:30px;}
    .summary-row{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--grey-border);font-size:15px;}
    .summary-row:last-of-type{border-bottom:none;}
    .summary-row strong{font-size:1.4rem;color:var(--accent-color);}
    .checkout-btn{width:100%;background:var(--accent-color);border:none;border-radius:6px;color:#fff;font-weight:800;padding:20px;cursor:pointer;margin-top:20px;}
    /* Modal */
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:2000;align-items:center;justify-content:center;}
    .modal-overlay.open{display:flex;}
    .modal-box{background:#fff;padding:40px;border-radius:12px;max-width:440px;width:90%;position:relative;text-align:center;}
    .close-modal{position:absolute;top:16px;right:20px;background:none;border:none;font-size:24px;cursor:pointer;color:#888;}
    .modal-amount{color:var(--accent-color);font-weight:800;font-size:1.1rem;margin-bottom:20px;}
    .pay-tabs{display:flex;gap:10px;margin-bottom:20px;justify-content:center;}
    .pay-tab{padding:10px 24px;border:2px solid var(--grey-border);background:#fff;border-radius:6px;cursor:pointer;font-weight:700;font-size:14px;}
    .pay-tab.active{border-color:var(--accent-color);color:var(--accent-color);}
    .pay-input{width:100%;padding:12px 16px;border:1px solid var(--grey-border);border-radius:6px;font-size:15px;outline:none;margin-bottom:16px;}
    .pay-btn{width:100%;background:var(--accent-color);border:none;border-radius:6px;color:#fff;font-weight:800;padding:16px;cursor:pointer;}
  </style>
</head>
<body>

  <header class="main-header">
    <a href="index.php" class="logo">BEAR<span>TRIBLEAS</span></a>
    <a href="index.php" class="back-link">← Continue Shopping</a>
  </header>

  <div class="content">
    <h1>Your Crate</h1>
    <p class="crate-meta"><strong id="crate-count">0</strong> item(s) ready to ship</p>

    <div id="crate-container">
      </div>

    <div class="crate-summary" id="crate-summary" style="display:none;">
      <div class="summary-row"><span>Subtotal</span><span id="crate-subtotal">₹0</span></div>
      <div class="summary-row"><span>Shipping</span><span style="color:#27ae60;font-weight:700;">FREE</span></div>
      <div class="summary-row"><span>Total</span><strong id="crate-total">₹0</strong></div>
      <button class="checkout-btn" onclick="openCheckout()">🔒 SECURE CHECKOUT</button>
    </div>
  </div>

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
        <div style="margin-bottom:20px;">
          <img id="upi-qr-code" src="" alt="UPI QR Code" style="width:180px;height:180px;border:1px solid var(--grey-border);border-radius:8px;">
        </div>
        <input type="text" class="pay-input" placeholder="yourname@upi (optional)">
      </div>
      <div id="section-card" style="display:none;">
        <input type="text" class="pay-input" placeholder="Card Number">
        <input type="text" class="pay-input" placeholder="MM / YY">
        <input type="text" class="pay-input" placeholder="CVV">
      </div>
      <button class="pay-btn" onclick="submitPayment()">CONFIRM PAYMENT</button>
    </div>
  </div>

  <script src="script.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const cart = JSON.parse(localStorage.getItem('bt_cart') || '[]');
      const summary = document.getElementById('crate-summary');
      const subtotal = document.getElementById('crate-subtotal');
      if (cart.length > 0 && summary) {
        summary.style.display = 'block';
        const total = document.getElementById('crate-total')?.textContent || '₹0';
        if (subtotal) subtotal.textContent = total;
      }
    });
  </script>
</body>
</html>
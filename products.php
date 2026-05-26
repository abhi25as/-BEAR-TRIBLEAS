<?php
// Your data array
$products = [
    [
        "id" => 1,
        "name" => "Tribal Oversized Cotton Graphic T-Shirt",
        "price" => 1299,
        "mrp" => 2499,
        "image" => "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=400&q=80",
        "badge" => "BESTSELLER"
    ],
    [
        "id" => 2,
        "name" => "Heavyweight Grizzly Winter Hoodie",
        "price" => 2799,
        "mrp" => 4999,
        "image" => "https://images.unsplash.com/photo-1556821840-3a63f95609a7?auto=format&fit=crop&w=400&q=80",
        "badge" => "NEW"
    ],
    [
        "id" => 3,
        "name" => "Wilderness Multi-Pocket Cargo Pants",
        "price" => 2199,
        "mrp" => 3599,
        "image" => "https://images.unsplash.com/photo-1542272604-787c3835535d?auto=format&fit=crop&w=400&q=80",
        "badge" => ""
    ],
    [
        "id" => 4,
        "name" => "Urban Bear Knitted Winter Beanie Cap",
        "price" => 699,
        "mrp" => 999,
        "image" => "https://images.unsplash.com/photo-1576871337622-98d48d1cf531?auto=format&fit=crop&w=400&q=80",
        "badge" => "SALE"
    ]
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bear Tribleas Products</title>
    <link rel="stylesheet" href="style.css"/>
    <style>
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; padding: 20px; }
        .card { border: 1px solid #ddd; padding: 15px; border-radius: 8px; text-align: center; }
        .card img { max-width: 100%; height: auto; border-radius: 4px; }
        .badge { background: #ff4757; color: white; padding: 2px 8px; font-size: 12px; border-radius: 4px; }
        .price { font-weight: bold; color: #2ed573; }
        .mrp { text-decoration: line-through; color: #7f8c8d; font-size: 0.9em; }
    </style>
</head>
<body>

    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="card">
                <?php if (!empty($product['badge'])): ?>
                    <span class="badge"><?php echo htmlspecialchars($product['badge']); ?></span>
                <?php endif; ?>
                
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p>
                    <span class="price">₹<?php echo htmlspecialchars($product['price']); ?></span>
                    <span class="mrp">₹<?php echo htmlspecialchars($product['mrp']); ?></span>
                </p>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
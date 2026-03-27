<?php
require 'db.php';
session_start();
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
$featured = $pdo->query("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY RAND() LIMIT 8")->fetchAll();
?>
<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title>NovaNest</title>
<script src='https://cdn.tailwindcss.com'></script>
<link rel='preconnect' href='https://fonts.googleapis.com'>
<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
<link href='https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap' rel='stylesheet'>
<link rel='stylesheet' href='style.css'>
</head>
<body>

<?php $cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>
<header class="sticky top-0 z-50 bg-black/25 backdrop-blur-xl border-b border-white/10">
  <nav class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between gap-4">
    <a href="index.php" class="text-2xl font-extrabold tracking-[0.25em]">NOVANEST</a>
    <div class="hidden lg:flex items-center gap-7 text-sm text-slate-200">
      <a href="index.php" class="nav-link">Home</a>
      <a href="shop.php" class="nav-link">Shop</a>
      <a href="categories.php" class="nav-link">Categories</a>
      <a href="offers.php" class="nav-link">Offers</a>
      <a href="about.php" class="nav-link">About</a>
      <a href="contact.php" class="nav-link">Contact</a>
      <a href="cart.php" class="nav-link">Cart (<?= $cartCount ?>)</a>
    </div>
    <a href="shop.php" class="btn-gold px-5 py-2 rounded-full font-semibold">Shop Now</a>
  </nav>
</header>

<section class='max-w-7xl mx-auto px-4 pt-16 pb-12 grid lg:grid-cols-2 gap-12 items-center'>
  <div>
    <p class='uppercase tracking-[0.35em] text-xs text-slate-400 mb-4'>Luxury Multi Category Store</p>
    <h1 class='text-5xl md:text-7xl font-extrabold leading-tight mb-6'>A bold shopping experience built for modern <span class='text-cyan-300'>India</span>.</h1>
    <p class='text-slate-300 text-lg max-w-xl mb-8'>NovaNest brings premium electronics, fashion, home decor, beauty, and sports essentials together in one polished and feature-rich storefront.</p>
    <div class='flex flex-wrap gap-4'>
      <a href='shop.php' class='btn-gold px-7 py-3 rounded-full font-semibold'>Explore Products</a>
      <a href='offers.php' class='glass px-7 py-3 rounded-full font-semibold'>View Offers</a>
    </div>
  </div>
  <div class='glass rounded-[2rem] p-6'>
    <img src='https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=1200&q=80' alt='Shopping banner' class='w-full h-[430px] object-cover rounded-[1.5rem]'>
  </div>
</section>
<section class='max-w-7xl mx-auto px-4 py-10'>
  <div class='grid sm:grid-cols-2 lg:grid-cols-5 gap-5'>
    <?php foreach ($categories as $category): ?>
    <a href='shop.php?category=<?= urlencode($category['slug']) ?>' class='glass rounded-2xl p-6 card'>
      <div class='text-sm text-slate-400 mb-2'>Category</div>
      <div class='text-xl font-bold mb-2'><?= htmlspecialchars($category['name']) ?></div>
      <div class='text-slate-300'>Browse curated <?= htmlspecialchars(strtolower($category['name'])) ?> picks.</div>
    </a>
    <?php endforeach; ?>
  </div>
</section>
<section class='max-w-7xl mx-auto px-4 py-10'>
  <div class='flex items-center justify-between mb-8'>
    <h2 class='text-3xl font-bold'>Featured Products</h2>
    <a href='shop.php' class='text-cyan-300'>See all</a>
  </div>
  <div class='grid sm:grid-cols-2 lg:grid-cols-4 gap-6'>
    <?php foreach ($featured as $product): ?>
    <div class='glass rounded-3xl overflow-hidden card'>
      <img src='<?= htmlspecialchars($product['image_url']) ?>' alt='<?= htmlspecialchars($product['name']) ?>' class='w-full h-64 object-cover'>
      <div class='p-5'>
        <div class='flex items-center justify-between mb-2'>
          <span class='text-xs uppercase tracking-widest text-cyan-300'><?= htmlspecialchars($product['category_name']) ?></span>
          <span class='badge px-3 py-1 rounded-full text-xs'><?= htmlspecialchars($product['badge']) ?></span>
        </div>
        <h3 class='text-lg font-semibold mb-2'><?= htmlspecialchars($product['name']) ?></h3>
        <p class='text-slate-400 text-sm mb-4'>₹<?= number_format($product['price']) ?></p>
        <a href='product.php?id=<?= $product['id'] ?>' class='btn-cyan px-4 py-2 rounded-full text-sm font-semibold inline-block'>View Product</a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<footer class='mt-12 border-t border-white/10'>
  <div class='max-w-7xl mx-auto px-4 py-10 text-slate-400 flex flex-col md:flex-row gap-3 md:items-center md:justify-between'>
    <p>© <?= date('Y') ?> NovaNest. Premium shopping reimagined.</p>
    <p>Electronics, Fashion, Home Decor, Beauty, Sports.</p>
  </div>
</footer>
</body>
</html>

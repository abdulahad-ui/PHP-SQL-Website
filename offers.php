<?php require 'db.php'; session_start(); $offers = $pdo->query("SELECT * FROM products ORDER BY price DESC LIMIT 8")->fetchAll(); ?>
<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Offers | NovaNest</title><script src='https://cdn.tailwindcss.com'></script><link href='https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap' rel='stylesheet'><link rel='stylesheet' href='style.css'></head><body>
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
<main class='max-w-7xl mx-auto px-4 py-14'><h1 class='text-4xl font-extrabold mb-3'>Special Offers</h1><p class='text-slate-400 mb-8'>Premium picks and high-value products worth exploring today.</p><div class='grid sm:grid-cols-2 lg:grid-cols-4 gap-6'><?php foreach ($offers as $product): ?><div class='glass rounded-3xl overflow-hidden card'><img src='<?= htmlspecialchars($product['image_url']) ?>' class='w-full h-60 object-cover'><div class='p-5'><span class='badge px-3 py-1 rounded-full text-xs inline-block mb-3'>Offer</span><h3 class='text-lg font-semibold mb-2'><?= htmlspecialchars($product['name']) ?></h3><p class='text-slate-400 mb-4'>₹<?= number_format($product['price']) ?></p><a href='product.php?id=<?= $product['id'] ?>' class='btn-cyan px-4 py-2 rounded-full text-sm font-semibold inline-block'>View Product</a></div></div><?php endforeach; ?></div></main></body></html>

<?php require 'db.php'; session_start(); $categories = $pdo->query("SELECT c.*, COUNT(p.id) as total_products FROM categories c LEFT JOIN products p ON c.id = p.category_id GROUP BY c.id ORDER BY c.name")->fetchAll(); ?>
<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Categories | NovaNest</title><script src='https://cdn.tailwindcss.com'></script><link href='https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap' rel='stylesheet'><link rel='stylesheet' href='style.css'></head><body>
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
<main class='max-w-7xl mx-auto px-4 py-14'><h1 class='text-4xl font-extrabold mb-8'>Shop Categories</h1><div class='grid sm:grid-cols-2 lg:grid-cols-3 gap-6'><?php foreach ($categories as $category): ?><a href='shop.php?category=<?= urlencode($category['slug']) ?>' class='glass rounded-3xl p-8 card block'><div class='text-sm text-slate-400 mb-3'>Collection</div><h2 class='text-2xl font-bold mb-2'><?= htmlspecialchars($category['name']) ?></h2><p class='text-slate-300 mb-4'>Products available: <?= (int)$category['total_products'] ?></p><span class='text-cyan-300'>Explore category</span></a><?php endforeach; ?></div></main></body></html>

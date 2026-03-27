<?php
require 'db.php';
session_start();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = ? LIMIT 1");
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) exit('Product not found');
$related = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND id != ? LIMIT 4");
$related->execute([$product['category_id'], $product['id']]);
$relatedProducts = $related->fetchAll();
?>
<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title><?= htmlspecialchars($product['name']) ?> | NovaNest</title>
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

<main class='max-w-7xl mx-auto px-4 py-14'>
  <div class='glass rounded-[2rem] overflow-hidden grid lg:grid-cols-2'>
    <img src='<?= htmlspecialchars($product['image_url']) ?>' alt='<?= htmlspecialchars($product['name']) ?>' class='w-full h-full min-h-[460px] object-cover'>
    <div class='p-8 md:p-12'>
      <span class='badge px-3 py-1 rounded-full text-xs inline-block mb-4'><?= htmlspecialchars($product['badge']) ?></span>
      <div class='text-sm uppercase tracking-[0.3em] text-cyan-300 mb-3'><?= htmlspecialchars($product['category_name']) ?></div>
      <h1 class='text-4xl font-extrabold mb-4'><?= htmlspecialchars($product['name']) ?></h1>
      <p class='text-slate-300 leading-7 mb-6'><?= htmlspecialchars($product['description']) ?></p>
      <div class='flex items-center gap-4 mb-8'>
        <span class='text-4xl font-bold'>₹<?= number_format($product['price']) ?></span>
        <span class='px-4 py-2 rounded-full bg-white/5 border border-white/10 text-slate-300'>Stock: <?= (int)$product['stock'] ?></span>
      </div>
      <div class='flex flex-wrap gap-4'>
        <form action='cart.php' method='POST'>
          <input type='hidden' name='action' value='add'>
          <input type='hidden' name='product_id' value='<?= $product['id'] ?>'>
          <button class='btn-gold px-8 py-3 rounded-full font-semibold' type='submit'>Add to Cart</button>
        </form>
        <a href='shop.php' class='glass px-8 py-3 rounded-full font-semibold'>Back to Shop</a>
      </div>
    </div>
  </div>
  <section class='mt-12'>
    <h2 class='text-3xl font-bold mb-6'>Related Products</h2>
    <div class='grid md:grid-cols-2 lg:grid-cols-4 gap-6'>
      <?php foreach ($relatedProducts as $item): ?>
      <a href='product.php?id=<?= $item['id'] ?>' class='glass rounded-3xl overflow-hidden card block'>
        <img src='<?= htmlspecialchars($item['image_url']) ?>' class='w-full h-52 object-cover' alt='<?= htmlspecialchars($item['name']) ?>'>
        <div class='p-4'>
          <h3 class='font-semibold mb-2'><?= htmlspecialchars($item['name']) ?></h3>
          <p class='text-slate-400'>₹<?= number_format($item['price']) ?></p>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </section>
</main>
</body>
</html>

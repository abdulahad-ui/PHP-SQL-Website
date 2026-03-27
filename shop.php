<?php
require 'db.php';
session_start();
$selectedSlug = $_GET['category'] ?? '';
$search = trim($_GET['search'] ?? '');
$sort = $_GET['sort'] ?? 'latest';
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

$sql = "SELECT p.*, c.name AS category_name, c.slug FROM products p JOIN categories c ON p.category_id = c.id WHERE 1=1";
$params = [];
if ($selectedSlug !== '') { $sql .= " AND c.slug = ?"; $params[] = $selectedSlug; }
if ($search !== '') { $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)"; $params[] = "%$search%"; $params[] = "%$search%"; }
if ($sort === 'price_low') $sql .= " ORDER BY p.price ASC";
elseif ($sort === 'price_high') $sql .= " ORDER BY p.price DESC";
else $sql .= " ORDER BY p.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title>Shop | NovaNest</title>
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

<section class='max-w-7xl mx-auto px-4 py-12'>
  <div class='mb-8'>
    <h1 class='text-4xl font-extrabold mb-3'>Shop NovaNest</h1>
    <p class='text-slate-400'>Search, sort, and browse products with a cleaner premium experience.</p>
  </div>
  <form method='GET' class='glass rounded-3xl p-5 mb-8 grid md:grid-cols-4 gap-4'>
    <input type='text' name='search' value='<?= htmlspecialchars($search) ?>' placeholder='Search products...' class='search-input rounded-xl px-4 py-3'>
    <select name='category' class='search-input rounded-xl px-4 py-3'>
      <option value=''>All Categories</option>
      <?php foreach ($categories as $category): ?>
      <option value='<?= htmlspecialchars($category['slug']) ?>' <?= $selectedSlug === $category['slug'] ? 'selected' : '' ?>><?= htmlspecialchars($category['name']) ?></option>
      <?php endforeach; ?>
    </select>
    <select name='sort' class='search-input rounded-xl px-4 py-3'>
      <option value='latest' <?= $sort === 'latest' ? 'selected' : '' ?>>Latest</option>
      <option value='price_low' <?= $sort === 'price_low' ? 'selected' : '' ?>>Price Low to High</option>
      <option value='price_high' <?= $sort === 'price_high' ? 'selected' : '' ?>>Price High to Low</option>
    </select>
    <button class='btn-gold rounded-xl px-4 py-3 font-semibold' type='submit'>Apply Filters</button>
  </form>
  <div class='grid lg:grid-cols-[260px_1fr] gap-8'>
    <aside class='glass rounded-3xl p-6 h-fit'>
      <div class='text-lg font-bold mb-4'>Quick Access</div>
      <div class='flex flex-col gap-3 text-slate-300'>
        <a href='shop.php' class='hover:text-cyan-300'>All Products</a>
        <a href='offers.php' class='hover:text-cyan-300'>Today Offers</a>
        <a href='categories.php' class='hover:text-cyan-300'>All Categories</a>
        <a href='contact.php' class='hover:text-cyan-300'>Customer Support</a>
      </div>
    </aside>
    <div class='grid sm:grid-cols-2 xl:grid-cols-3 gap-6'>
      <?php foreach ($products as $product): ?>
      <div class='glass rounded-3xl overflow-hidden card'>
        <img src='<?= htmlspecialchars($product['image_url']) ?>' alt='<?= htmlspecialchars($product['name']) ?>' class='w-full h-64 object-cover'>
        <div class='p-5'>
          <div class='flex items-center justify-between mb-2'>
            <span class='text-xs uppercase tracking-widest text-cyan-300'><?= htmlspecialchars($product['category_name']) ?></span>
            <span class='badge px-3 py-1 rounded-full text-xs'><?= htmlspecialchars($product['badge']) ?></span>
          </div>
          <h3 class='text-xl font-semibold mb-2'><?= htmlspecialchars($product['name']) ?></h3>
          <p class='text-slate-400 text-sm mb-4'><?= htmlspecialchars(substr($product['description'],0,110)) ?>...</p>
          <div class='flex items-center justify-between gap-3'>
            <span class='text-2xl font-bold'>₹<?= number_format($product['price']) ?></span>
            <div class='flex gap-2'>
              <a href='product.php?id=<?= $product['id'] ?>' class='glass px-4 py-2 rounded-full text-sm'>Details</a>
              <form action='cart.php' method='POST'>
                <input type='hidden' name='action' value='add'>
                <input type='hidden' name='product_id' value='<?= $product['id'] ?>'>
                <button class='btn-cyan px-4 py-2 rounded-full text-sm font-semibold' type='submit'>Add</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
</body>
</html>

<?php
require 'db.php';
session_start();
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';
  $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
  if ($action === 'add' && $productId > 0) {
    if (!isset($_SESSION['cart'][$productId])) $_SESSION['cart'][$productId] = 0;
    $_SESSION['cart'][$productId]++;
  }
  if ($action === 'remove' && $productId > 0 && isset($_SESSION['cart'][$productId])) unset($_SESSION['cart'][$productId]);
  if ($action === 'clear') $_SESSION['cart'] = [];
  header('Location: cart.php'); exit;
}
$cart = $_SESSION['cart']; $items = []; $total = 0; $count = array_sum($cart);
if (!empty($cart)) {
  $ids = array_keys($cart); $placeholders = implode(',', array_fill(0, count($ids), '?'));
  $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
  $stmt->execute($ids); $products = $stmt->fetchAll();
  foreach ($products as $product) {
    $qty = $cart[$product['id']] ?? 0; $subtotal = $qty * $product['price']; $total += $subtotal;
    $items[] = ['product'=>$product,'qty'=>$qty,'subtotal'=>$subtotal];
  }
}
?>
<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title>Cart | NovaNest</title>
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

<main class='max-w-6xl mx-auto px-4 py-14'>
  <h1 class='text-4xl font-extrabold mb-8'>Your Cart</h1>
  <?php if (empty($items)): ?>
    <div class='glass rounded-3xl p-8'><p class='text-slate-300 text-lg'>Your cart is empty.</p><a href='shop.php' class='inline-block mt-5 btn-gold px-6 py-3 rounded-full font-semibold'>Start Shopping</a></div>
  <?php else: ?>
    <div class='grid lg:grid-cols-[1fr_340px] gap-8'>
      <div class='glass rounded-3xl p-6'>
        <div class='space-y-5'>
          <?php foreach ($items as $entry): $product = $entry['product']; ?>
          <div class='flex flex-col md:flex-row md:items-center gap-5 border-b border-white/10 pb-5'>
            <img src='<?= htmlspecialchars($product['image_url']) ?>' alt='<?= htmlspecialchars($product['name']) ?>' class='w-full md:w-28 h-28 object-cover rounded-2xl'>
            <div class='flex-1'>
              <h2 class='text-xl font-semibold mb-1'><?= htmlspecialchars($product['name']) ?></h2>
              <p class='text-slate-400 text-sm'>Quantity: <?= $entry['qty'] ?></p>
              <p class='text-slate-400 text-sm'>Unit Price: ₹<?= number_format($product['price']) ?></p>
            </div>
            <div class='md:text-right'>
              <div class='text-xl font-bold mb-3'>₹<?= number_format($entry['subtotal']) ?></div>
              <form action='cart.php' method='POST'>
                <input type='hidden' name='action' value='remove'>
                <input type='hidden' name='product_id' value='<?= $product['id'] ?>'>
                <button class='text-red-300 hover:text-red-200' type='submit'>Remove</button>
              </form>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <aside class='glass rounded-3xl p-6 h-fit'>
        <h3 class='text-2xl font-bold mb-6'>Order Summary</h3>
        <div class='flex justify-between text-slate-300 mb-3'><span>Items</span><span><?= $count ?></span></div>
        <div class='flex justify-between text-slate-300 mb-6'><span>Total</span><span>₹<?= number_format($total) ?></span></div>
        <a href='checkout.php' class='w-full btn-gold px-6 py-3 rounded-full font-semibold mb-4 block text-center'>Proceed to Checkout</a>
        <form action='cart.php' method='POST'><input type='hidden' name='action' value='clear'><button class='w-full glass px-6 py-3 rounded-full font-semibold' type='submit'>Clear Cart</button></form>
      </aside>
    </div>
  <?php endif; ?>
</main>
</body>
</html>

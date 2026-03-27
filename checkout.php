<?php require 'db.php'; session_start(); ?>
<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Checkout | NovaNest</title><script src='https://cdn.tailwindcss.com'></script><link href='https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap' rel='stylesheet'><link rel='stylesheet' href='style.css'></head><body>
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
<main class='max-w-5xl mx-auto px-4 py-14'><div class='glass rounded-[2rem] p-8'><h1 class='text-4xl font-extrabold mb-6'>Checkout</h1><div class='grid md:grid-cols-2 gap-4'><input class='search-input rounded-xl px-4 py-3' placeholder='Full Name'><input class='search-input rounded-xl px-4 py-3' placeholder='Phone Number'><input class='search-input rounded-xl px-4 py-3 md:col-span-2' placeholder='Address'><input class='search-input rounded-xl px-4 py-3' placeholder='City'><input class='search-input rounded-xl px-4 py-3' placeholder='Pincode'></div><button class='btn-gold px-6 py-3 rounded-xl font-semibold mt-6' type='button'>Place Order</button></div></main></body></html>

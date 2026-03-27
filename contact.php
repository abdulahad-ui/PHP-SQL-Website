<?php require 'db.php'; session_start(); ?>
<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Contact | NovaNest</title><script src='https://cdn.tailwindcss.com'></script><link href='https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap' rel='stylesheet'><link rel='stylesheet' href='style.css'></head><body>
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
<main class='max-w-4xl mx-auto px-4 py-14'><div class='glass rounded-[2rem] p-8'><h1 class='text-4xl font-extrabold mb-6'>Contact Us</h1><form class='grid md:grid-cols-2 gap-4'><input class='search-input rounded-xl px-4 py-3' placeholder='Your Name'><input class='search-input rounded-xl px-4 py-3' placeholder='Email Address'><input class='search-input rounded-xl px-4 py-3 md:col-span-2' placeholder='Subject'><textarea class='search-input rounded-xl px-4 py-3 md:col-span-2 min-h-[160px]' placeholder='Write your message'></textarea><button class='btn-gold px-6 py-3 rounded-xl font-semibold md:col-span-2' type='button'>Send Message</button></form></div></main></body></html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>VelloStore - Products</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800 font-sans">
  <!-- Navbar -->
  <nav class="flex items-center justify-between px-6 py-4 shadow-sm">
    <div class="flex items-center gap-2">
      <img src="https://via.placeholder.com/40" alt="Logo" class="rounded-full" />
      <span class="text-2xl font-bold text-gradient bg-gradient-to-r from-blue-500 to-orange-500 bg-clip-text text-transparent">VelloStore</span>
    </div>
    <ul class="flex gap-6 font-medium text-gray-700">
      <li><a href="index.html" class="hover:text-orange-500">Home</a></li>
      <li><a href="#" class="text-orange-500 border-b-2 border-orange-500">Products</a></li>
      <li><a href="#" class="hover:text-orange-500">Deals</a></li>
      <li><a href="#" class="hover:text-orange-500">Support</a></li>
    </ul>
    <div class="flex items-center gap-4">
      <div class="relative">
        <span class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs px-1.5 rounded-full">3</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m13-9l2 9m-5-6h-4" />
        </svg>
      </div>
      <button class="bg-gradient-to-r from-blue-500 to-orange-500 text-white px-4 py-1.5 rounded-lg font-semibold">Login</button>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="px-6 py-12 bg-gradient-to-r from-blue-500 to-cyan-400 rounded-xl text-white mx-4 mt-6">
    <div class="flex flex-col md:flex-row items-center justify-between">
      <div>
        <h1 class="text-3xl font-extrabold mb-2">Professional Tools & Electronics</h1>
        <p class="text-lg mb-4">Find the perfect equipment for your next project with our premium selection.</p>
        <div class="flex gap-4">
          <button class="bg-white text-blue-600 px-5 py-2 rounded-lg font-semibold">Shop Now</button>
          <button class="border border-white px-5 py-2 rounded-lg font-semibold">View Deals</button>
        </div>
      </div>
      <img src="https://via.placeholder.com/120" alt="Hero Icon" class="mt-6 md:mt-0" />
    </div>
  </section>

  <!-- Filters -->
  <div class="flex justify-end items-center gap-4 px-6 py-4">
    <select class="border px-4 py-2 rounded-lg">
      <option>All Categories</option>
      <option>Tech</option>
      <option>Tools</option>
    </select>
    <select class="border px-4 py-2 rounded-lg">
      <option>Sort by: Featured</option>
      <option>Price: Low to High</option>
      <option>Price: High to Low</option>
    </select>
  </div>

  <!-- Featured Products Title -->
  <h2 class="text-2xl font-bold px-6 py-2">Featured Products</h2>

  <!-- Product Grid -->
  <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-6 py-6">
    <!-- Product Card Example -->
    <div class="bg-orange-100 p-4 rounded-xl shadow relative">
      <span class="absolute top-2 right-2 bg-orange-500 text-white text-xs px-2 py-0.5 rounded-full">NEW</span>
      <div class="text-4xl text-orange-500">🔊</div>
      <h3 class="font-bold mt-2">Cordless Drill</h3>
      <p class="text-sm text-gray-600">Professional 20V Max with 2 batteries</p>
      <div class="flex justify-between items-center mt-2">
        <span class="font-bold text-lg">$129.99</span>
        <button class="bg-orange-500 text-white px-3 py-1 rounded">Add to Cart</button>
      </div>
    </div>
    <!-- Duplicate and vary for other products -->
    <!-- Add 7 more based on screenshot -->
  </section>

  <!-- Pagination -->
  <div class="flex justify-center items-center gap-2 py-6">
    <button class="px-3 py-1 rounded bg-gray-200">&#x2039;</button>
    <button class="px-3 py-1 rounded bg-orange-500 text-white">1</button>
    <button class="px-3 py-1 rounded bg-gray-100">2</button>
    <button class="px-3 py-1 rounded bg-gray-100">3</button>
    <span class="text-gray-500">...</span>
    <button class="px-3 py-1 rounded bg-gray-100">8</button>
    <button class="px-3 py-1 rounded bg-gray-200">&#x203A;</button>
  </div>

  <!-- Footer -->
  <footer class="text-center py-4 bg-black text-white text-sm">
    <p>Terms & Support</p>
  </footer>
</body>
</html>

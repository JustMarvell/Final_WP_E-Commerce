<!-- File: homepage.html -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VelloStore - Homepage</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-white text-gray-800 font-sans">
    <!-- Navbar -->
    <nav class="flex justify-between items-center px-6 py-4 shadow">
      <div class="flex items-center gap-2">
        <div class="bg-gradient-to-br from-blue-500 to-orange-400 rounded-full w-8 h-8 flex items-center justify-center text-white font-bold">⚡</div>
        <span class="text-xl font-bold text-gray-800">Vello<span class="text-orange-500">Store</span></span>
      </div>
      <ul class="flex gap-6 font-medium">
        <li><a href="#" class="text-gray-600 hover:text-orange-500">Home</a></li>
        <li><a href="#" class="text-orange-500 border-b-2 border-orange-500">Products</a></li>
        <li><a href="#" class="text-gray-600 hover:text-orange-500">Deals</a></li>
        <li><a href="#" class="text-gray-600 hover:text-orange-500">Support</a></li>
      </ul>
      <div class="flex items-center gap-4">
        <div class="relative">
          <span class="absolute top-0 right-0 text-xs bg-orange-500 text-white px-1 rounded-full">3</span>
          <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.35 5.4A1 1 0 007 20h10a1 1 0 001-1.2l-1.35-5.4M9 21h6"></path>
          </svg>
        </div>
        <button class="bg-gradient-to-r from-blue-500 to-orange-400 text-white px-4 py-1 rounded-full">Login</button>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="mt-10 px-6">
      <div class="rounded-xl bg-gradient-to-r from-blue-500 to-cyan-400 text-white p-10 flex flex-col md:flex-row items-center justify-between">
        <div>
          <h1 class="text-4xl font-bold mb-3">Professional Tools & Electronics</h1>
          <p class="text-lg mb-5">Explore premium gear for your next big project.</p>
          <div class="flex gap-4">
            <button class="bg-white text-blue-600 font-semibold px-6 py-2 rounded-lg">Shop Now</button>
            <button class="border border-white px-6 py-2 rounded-lg font-semibold">View Deals</button>
          </div>
        </div>
        <img src="https://www.svgrepo.com/show/384397/rocket-startup.svg" class="w-48 mt-8 md:mt-0" alt="Hero Art" />
      </div>
    </section>

    <!-- Login Box -->
    <section class="mt-16 px-6 flex justify-center">
      <div class="w-full max-w-sm bg-gray-100 p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold text-center mb-6">Login to VelloStore</h2>
        <form class="space-y-4">
          <input type="text" placeholder="Username" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" />
          <input type="password" placeholder="Password" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" />
          <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-orange-400 text-white font-semibold py-2 rounded-md">Login</button>
        </form>
      </div>
    </section>

    <!-- Footer -->
    <footer class="mt-20 px-6 py-6 text-sm text-center text-gray-600 border-t">
      &copy; 2025 VelloStore. All rights reserved.
    </footer>
  </body>
</html>

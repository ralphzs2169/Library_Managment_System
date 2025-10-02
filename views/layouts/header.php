<?php
    require_once __DIR__ . '/../../config/config.php';  
?>

<header class="bg-primary text-white shadow-lg sticky top-0 z-50 drop-shadow-custom">
  <div class="container mx-auto px-4 md:px-8 lg:px-12">
    <div class="flex justify-between items-center h-20">
      
      <!-- Logo Section -->
      <a href="<?php echo BASE_URL; ?>public/index.php" class="flex items-center space-x-3 hover:opacity-80 transition-opacity duration-300 cursor-pointer">
        <img src="<?php echo BASE_URL; ?>public/assets/images/logo.png" width="50" height="50" alt="Logo" class="rounded-full">
        <div>
          <h1 class="text-xl font-bold leading-tight">Smart Library</h1>
          <p class="text-xs text-gray-300">Management System</p>
        </div>
      </a>

      <!-- Desktop Navigation -->
      <nav class="hidden lg:flex items-center space-x-12">
        <a href="<?php echo BASE_URL; ?>public/index.php" class="nav-link text-sm font-medium tracking-wide uppercase cursor-pointer hover:text-secondary transition-colors duration-300">Home</a>
        <a href="about.php" class="nav-link text-sm font-medium tracking-wide uppercase cursor-pointer hover:text-secondary transition-colors duration-300">About</a>
        <a href="catalog.php" class="nav-link text-sm font-medium tracking-wide uppercase cursor-pointer hover:text-secondary transition-colors duration-300">Catalog</a>
      </nav>

      <!-- Desktop Auth Buttons -->
      <div class="hidden lg:flex items-center space-x-4">
        <a href="<?php echo BASE_URL; ?>views/auth/signup.php" class="nav-link hover-scale-md mx-6 py-2 text-sm font-medium rounded-lg cursor-pointer hover:text-secondary transition-colors duration-300">
          Sign Up
        </a>
        <a href="<?php echo BASE_URL; ?>views/auth/login.php" class="hover-scale-md px-8 py-2.5 bg-secondary text-primary text-sm font-bold rounded-lg shadow-md cursor-pointer">
          Login
        </a>
      </div>

      <!-- Mobile Menu Button -->
      <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-md hover:bg-gray-700 transition-all duration-300 cursor-pointer" aria-label="Toggle menu">
        <svg id="menu-icon" class="w-6 h-6 transition-transform duration-200 hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
        <svg id="close-icon" class="w-6 h-6 hidden transition-transform duration-200 hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="hidden lg:hidden bg-primary border-t border-white border-opacity-10">
    <div class="container mx-auto px-4 py-6 space-y-4">
      <a href="index.php" class="block py-3 px-4 text-center rounded-lg transition-all duration-300 hover:bg-gray-700 hover:text-secondary cursor-pointer">
        Home
      </a>
      <a href="about.php" class="block py-3 px-4 text-center rounded-lg transition-all duration-300 hover:bg-gray-700 hover:text-secondary cursor-pointer">
        About
      </a>
      <a href="catalog.php" class="block py-3 px-4 text-center rounded-lg transition-all duration-300 hover:bg-gray-700 hover:text-secondary cursor-pointer">
        Catalog
      </a>
      
      <!-- Improved Mobile Auth Buttons -->
      <div class="pt-4 space-y-3 border-t border-white border-opacity-30 mt-6">
        <button class="transition-all duration-300 hover:bg-gray-700 hover:text-secondary w-full py-3.5 px-4 text-center rounded-lg font-semibold tracking-wide shadow-sm cursor-pointer">
          Sign Up
        </button>
        <a href="<?php echo BASE_URL; ?>views/auth/login.php" class="hover-scale-sm w-full py-3.5 px-4 bg-secondary text-black rounded-lg font-bold tracking-wide shadow-md cursor-pointer block text-center">
          Login
        </a>
      </div>
    </div>
  </div>
</header>

<script>
  const mobileBtn = document.getElementById('mobile-menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');
  const menuIcon = document.getElementById('menu-icon');
  const closeIcon = document.getElementById('close-icon');

  mobileBtn.addEventListener('click', () => {
    const isOpen = mobileMenu.classList.contains('hidden');
    
    if (isOpen) {
      mobileMenu.classList.remove('hidden');
      menuIcon.classList.add('hidden');
      closeIcon.classList.remove('hidden');
    } else {
      mobileMenu.classList.add('hidden');
      menuIcon.classList.remove('hidden');
      closeIcon.classList.add('hidden');
    }
  });

  // Close mobile menu when clicking outside
  document.addEventListener('click', (e) => {
    if (!mobileBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
      mobileMenu.classList.add('hidden');
      menuIcon.classList.remove('hidden');
      closeIcon.classList.add('hidden');
    }
  });
</script>
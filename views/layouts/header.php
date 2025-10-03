<?php
    require_once __DIR__ . '/../../config/config.php';  
    require_once __DIR__ . '/../../app/Helpers/AuthHelper.php';
    require_once __DIR__ . '/../../app/Controllers/UserController.php';

    $userController = new UserController();
    $user = $userController->getUserInformation();

    $currentPage = basename($_SERVER['PHP_SELF']);
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
      <?php if (isLoggedIn()): ?>

        <div class="hidden lg:flex items-center space-x-2 relative">
          <img src="<?php echo BASE_URL; ?>public/assets/icons/notification.svg" alt="Notification Icon" class="w-8 h-8 rounded-full ">
          <div class="flex flex-col ">
            <span class="font-semibold text-sm"><?php echo htmlspecialchars($user['fullname']); ?></span>
            <span class=" text-xs"><?php echo htmlspecialchars($user['role']); ?></span>
          </div>

          <!-- Profile Button -->
          <button id="profileDropdown" class="flex items-center space-x-1 focus:outline-none cursor-pointer">
            <img src="<?php echo BASE_URL; ?>public/assets/icons/avatar.svg" alt="User Icon" class="hover-scale-lg w-8 h-8 rounded-full border-2 border-white">
            <img src="<?php echo BASE_URL; ?>public/assets/icons/dropdown-white.svg" alt="Profile Dropdown" class="hover-scale-lg w-6 h-6">
          </button>

          <!-- Profile Menu Dropdown -->
          <div class="absolute top-12 right-0 p-3 w-64 bg-white text-black text-sm rounded-md shadow-lg z-10 hidden" id="dropdownMenu">
            <h2 class="font-semibold text-xs text-gray-600 mb-2">1st Semester 2025-2026</h2>
            <hr class="my-2 border-gray-200">

            <div class="flex flex-col space-y-1">
              <a href="#" class="flex items-center space-x-3 px-2 py-1 rounded-md hover:bg-gray-100 transition-colors">
                <img src="<?php echo BASE_URL; ?>public/assets/icons/avatar-black.svg" class="w-5 h-5">
                <span>My Profile</span>
              </a>
              <a href="#" class="flex items-center space-x-3 px-2 py-1 rounded-md hover:bg-gray-100 transition-colors">
                <img src="<?php echo BASE_URL; ?>public/assets/icons/edit-profile.svg" class="w-5 h-5">
                <span>Edit Profile</span>
              </a>
            </div>

            <hr class="my-2 border-gray-200">

            <div class="flex flex-col space-y-1">
              <a href="#" class="flex items-center space-x-3 px-2 py-1 rounded-md hover:bg-gray-100 transition-colors">
                <img src="<?php echo BASE_URL; ?>public/assets/icons/my-borrowed-books.svg" class="w-5 h-5">
                <span>My Borrowed Books</span>
              </a>
              <a href="#" class="flex items-center space-x-3 px-2 py-1 rounded-md hover:bg-gray-100 transition-colors">
                <img src="<?php echo BASE_URL; ?>public/assets/icons/reservation.svg" class="w-5 h-5">
                <span>My Reservations</span>
              </a>
              <a href="#" class="flex items-center space-x-3 px-2 py-1 rounded-md hover:bg-gray-100 transition-colors">
                <img src="<?php echo BASE_URL; ?>public/assets/icons/history.svg" class="w-5 h-5">
                <span>Borrowing History</span>
              </a>
              <a href="#" class="flex items-center space-x-3 px-2 py-1 rounded-md hover:bg-gray-100 transition-colors">
                <img src="<?php echo BASE_URL; ?>public/assets/icons/payment.svg" class="w-5 h-5">
                <span>Fines & Payments</span>
              </a>
            </div>

            <hr class="my-2 border-gray-200">

            <form id="logoutForm">
              <button type="submit" id="logoutBtn" class="flex items-center space-x-3 px-2 py-2 rounded-md hover:bg-red-50 text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Logout</span>
              </button>
            </form>
          </div>
        </div>


      <?php else: ?>
            <div class="hidden lg:flex items-center space-x-4">
              <?php if ($currentPage !== 'signup.php'): ?>
                <a href="<?php echo BASE_URL; ?>views/auth/signup.php" class="nav-link hover-scale-md mx-6 py-2 text-sm font-medium rounded-lg cursor-pointer hover:text-secondary transition-colors duration-300">
                  Sign Up
                </a>          
              <?php endif; ?>
              
              <?php if ($currentPage !== 'login.php'): ?>
                <a href="<?php echo BASE_URL; ?>views/auth/login.php" class="hover-scale-md px-8 py-2.5 bg-secondary text-primary text-sm font-bold rounded-lg shadow-md cursor-pointer">
                  Login
                </a>
              <?php endif; ?>
        </div>
      <?php endif; ?>

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
      <?php if (isLoggedIn()): ?>
      <div class="pt-4 space-y-3 border-t border-white border-opacity-30 mt-6">
        <div class="text-center">
          <p class="text-sm">
            Hello, <span class="font-semibold"><?php echo htmlspecialchars($userController->getFullname()); ?></span>
          </p>
        </div>
      </div>
    <?php else: ?>
      <div class="pt-4 space-y-3 border-t border-white border-opacity-30 mt-6">
        <a href="<?php echo BASE_URL; ?>views/auth/signup.php" 
          class="transition-all duration-300 hover:bg-gray-700 hover:text-secondary w-full py-3.5 px-4 text-center rounded-lg font-semibold tracking-wide shadow-sm block">
          Sign Up
        </a>
        <a href="<?php echo BASE_URL; ?>views/auth/login.php" 
          class="hover-scale-sm w-full py-3.5 px-4 bg-secondary text-black rounded-lg font-bold tracking-wide shadow-md block text-center">
          Login
        </a>
      </div>
    <?php endif; ?>

    </div>
  </div>
</header>



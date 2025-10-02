<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Smart Library</title>
    <link rel="stylesheet" href="./../../public/css/output.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
     <?php include '../layouts/header.php'; ?>

    <div class="min-h-screen flex items-center justify-center bg-background">
        <div class="bg-white p-12 rounded-2xl shadow-lg w-full max-w-lg">
            <div class="flex flex-col items-center mb-2">
                <img src="<?php echo BASE_URL ?>public/assets/images/logo-white.png" width=60 height=60 alt="Logo" class="mb-2">
                <h2 class="text-5xl font-bold mb-6 text-center">Login</h2>
            </div>

            <form action="process_login.php" method="POST" class="space-y-6">
                
                <!-- Username Input -->
                <div class="relative">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <img src="<?php echo BASE_URL; ?>public/assets/icons/username.svg" alt="Username" class="absolute left-3 top-1/2 transform -translate-y-1/2 mt-3 w-10 h-15 pointer-events-none z-10">
                    <input type="text" id="username" name="username" required
                           placeholder="Enter your username"
                           class="mt-1 block w-full pl-16 bg-[#F2F2F2] font-extralight pr-4 py-4 border border-[#B1B1B1] rounded-2xl
                                focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent relative z-0">
                </div>
                <!-- Password Input -->
                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <img src="<?php echo BASE_URL; ?>public/assets/icons/password.svg" alt="Password" class="absolute left-4 top-1/2 transform -translate-y-1/2 mt-3 w-8 h-8 pointer-events-none z-10">
                    <input type="password" id="password" name="password" required
                           placeholder="Enter your password"
                           class="mt-1 block w-full pl-16 bg-[#F2F2F2] font-extralight pr-16 py-4 border border-[#B1B1B1] rounded-2xl
                                  focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent relative z-0">
                    <button type="button" id="togglePassword" class="absolute right-2 top-1/2 transform -translate-y-1/2 mt-3 z-10">
                        <img id="eyeIcon" src="<?php echo BASE_URL; ?>public/assets/icons/eye-off.svg" alt="Toggle password visibility" class="w-14 h-13 cursor-pointer hover:opacity-70 transition-opacity">
                    </button>
                </div>

                <div>
                    <button type="submit" class="hover-scale-sm cursor-pointer mt-4 w-full py-2.5 bg-secondary text-2xl text-white rounded-lg hover:bg-secondary-dark transition-colors duration-300">Login</button>
                </div>
            </form>

            <div class="flex items-center my-6">
                <hr class="flex-grow border-t border-gray-300">
                <span class="mx-4 text-gray-500">or</span>
                <hr class="flex-grow border-t border-gray-300">
            </div>

            <div class="mt-4 text-center">
                <p class="text-xs text-gray-600">Don't have an account yet? 
                    <a href="register.php" class="text-secondary font-medium underline">Sign Up Here</a>
                </p>
            </div>
        </div>
    </div>

    <?php include '../layouts/footer.php'; ?>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            if (type === 'text') {
                eyeIcon.src = '<?php echo BASE_URL; ?>public/assets/icons/eye-on.svg';
            } else {
                eyeIcon.src = '<?php echo BASE_URL; ?>public/assets/icons/eye-off.svg';
            }
        });
    </script>
</body>
</html>
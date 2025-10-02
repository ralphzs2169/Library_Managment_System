<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Smart Library</title>
    <link rel="stylesheet" href="./../../public/css/output.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
</head>

<body>
    <?php include '../layouts/header.php'; ?>

     <div class="min-h-screen flex items-center py-10 justify-center bg-background">
        <div class="bg-white p-10 rounded-2xl shadow-lg w-full max-w-2xl">
            <div class="flex flex-col items-center mb-4">
                <img src="<?php echo BASE_URL ?>public/assets/images/logo-white.png" width=55 height=55 alt="Logo" class="mb-2">
                <h2 class="text-4xl font-bold mb-5 text-center">Sign Up</h2>
            </div>

            <form action="process_login.php" method="POST" class="space-y-5">
                
                <!-- Personal Information Section -->
                <div>
                    <label class="block text-sm font-medium text-gray-700" >Personal Information</label>
                    <div class="grid grid-cols-3 gap-2 mb-2">
                        <!-- First Name -->
                        <input type="text" id="first_name" name="first_name" required
                               placeholder="First Name"
                               class="mt-1 block text-sm w-full bg-[#F2F2F2] font-extralight px-4 py-3  border border-[#B1B1B1] rounded-lg
                                    focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">        
                        <!-- Last Name -->
                        <input type="text" id="last_name" name="last_name" required
                               placeholder="Last Name"
                               class="mt-1 block text-sm w-full bg-[#F2F2F2] font-extralight px-4 py-3 border border-[#B1B1B1] rounded-lg
                                    focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                        <!-- Middle Initial -->
                        <input type="text" id="middle_initial" name="middle_initial" required
                               placeholder="Middle Initial"
                               class="mt-1 block text-sm w-full bg-[#F2F2F2] font-extralight px-4 py-3 border border-[#B1B1B1] rounded-lg
                                    focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                    </div>
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <!-- Email Address -->
                        <input type="email" id="email" name="email" required
                               placeholder="Email"
                               class="mt-1 block text-sm w-full bg-[#F2F2F2] font-extralight px-4 py-3 border border-[#B1B1B1] rounded-lg
                                    focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                        <!-- Contact Number -->
                        <input type="text" id="contact" name="contact" required
                               placeholder="Contact Number"
                               class="mt-1 block text-sm w-full bg-[#F2F2F2] font-extralight px-4 py-3 border border-[#B1B1B1] rounded-lg
                                    focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                    </div>

                </div>

                <!-- Account Information Section -->
                <div>
                    <label class="block text-sm font-medium text-gray-700" >Account Information</label>
                    <!-- Username -->
                    <input type="text" id="username" name="username" required
                               placeholder="Username"
                               class="mt-1 mb-2 block text-sm w-full bg-[#F2F2F2] font-extralight px-4 py-3  border border-[#B1B1B1] rounded-lg
                                    focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">  
                                    
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <!-- Password -->
                        <input type="password" id="password" name="password" required
                               placeholder="Password"
                               class="mt-1 block text-sm w-full bg-[#F2F2F2] font-extralight px-4 py-3 border border-[#B1B1B1] rounded-lg
                                    focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                        <!-- Confirm Password-->
                        <input type="password" id="confirm_password" name="confirm_password" required
                               placeholder="Confirm Password"
                               class="mt-1 block text-sm w-full bg-[#F2F2F2] font-extralight px-4 py-3 border border-[#B1B1B1] rounded-lg
                                    focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                    </div>
                </div>

                <!-- School Information Section -->
                   <div>
                    <label class="block text-sm font-medium text-gray-700" >School Information</label>
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <!-- Role -->
                        <select id="role" name="role" required
                                   class="cursor-pointer mt-1 block text-sm w-full bg-[#F2F2F2] font-extralight px-4 py-3 border border-[#B1B1B1] rounded-lg
                                    focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                            <option value="" disabled selected>Select Role</option>
                            <option value="student">Student</option>
                            <option value="faculty">Teacher</option>
                        </select>

                        <!-- ID Number-->
                        <input type="text" id="id_number" name="id_number" required disabled
                               placeholder="Select role first"
                               class="mt-1 block text-sm w-full bg-gray-200 font-extralight px-4 py-3 border border-[#B1B1B1] rounded-lg
                                    focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent disabled:cursor-not-allowed">
                    </div>    

                    <div class="grid grid-cols-2 gap-2 mb-4" id="school-details">
                        <!-- Year Level -->
                          <select id="year_level" name="year_level" required
                                   class="cursor-pointer mt-1 block text-sm w-full bg-[#F2F2F2] font-extralight px-4 py-3 border border-[#B1B1B1] rounded-lg
                                    focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                            <option value="" disabled selected>Select Year Level</option>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                        </select>
                        <!-- Department -->
                          <select id="department" name="department" required
                                   class="cursor-pointer mt-1 block text-sm w-full bg-[#F2F2F2] font-extralight px-4 py-3 border border-[#B1B1B1] rounded-lg
                                    focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                            <option value="" disabled selected>Select Department</option>
                            <option value="1">CCICT</option>
                            <option value="2">BEED</option>
                            <option value="3">BSED</option>
                            <option value="4">BSBA</option>
                        </select>
                    </div>
                </div>

                <div>
                    <button type="submit" class="hover-scale-sm cursor-pointer mt-4 w-full py-2.5 bg-secondary text-2xl text-white rounded-lg hover:bg-secondary-dark transition-colors duration-300">Sign Up</button>
                </div>
            </form>
                                  
            <div class="flex items-center my-6">
                <hr class="flex-grow border-t border-gray-300">
                <span class="mx-4 text-gray-500">or</span>
                <hr class="flex-grow border-t border-gray-300">
            </div>

            <div class="mt-4 text-center">
                <p class="text-xs text-gray-600">Already Have an Account? 
                    <a href="register.php" class="text-secondary font-medium underline">Login Now</a>
                </p>
            </div>
        </div>
    </div>


    <?php include '../layouts/footer.php'; ?>

    <script>
        const roleSelect = document.getElementById('role');
        const idNumberField = document.getElementById('id_number');
        const yearLevelField = document.getElementById('year_level');
        const departmentField = document.getElementById('department');
        const schoolDetailsContainer = document.getElementById('school-details');

        roleSelect.addEventListener('change', function() {
            const selectedRole = this.value;
            
            if (selectedRole === 'student') {
                idNumberField.disabled = false;
                idNumberField.placeholder = 'Student ID';
                idNumberField.classList.remove('bg-gray-200', 'disabled:cursor-not-allowed');
                idNumberField.classList.add('bg-[#F2F2F2]');
                
                // Show year level and use 2-column grid
                yearLevelField.style.display = 'block';
                yearLevelField.required = true;
                schoolDetailsContainer.classList.remove('grid-cols-1');
                schoolDetailsContainer.classList.add('grid-cols-2');
            } else if (selectedRole === 'faculty') {
                idNumberField.disabled = false;
                idNumberField.placeholder = 'Employee ID';
                idNumberField.classList.remove('bg-gray-200', 'disabled:cursor-not-allowed');
                idNumberField.classList.add('bg-[#F2F2F2]');
                
                // Hide year level and use 1-column grid for department
                yearLevelField.style.display = 'none';
                yearLevelField.required = false;
                yearLevelField.value = '';
                schoolDetailsContainer.classList.remove('grid-cols-2');
                schoolDetailsContainer.classList.add('grid-cols-1');
            } else {
                idNumberField.disabled = true;
                idNumberField.placeholder = 'Select role first';
                idNumberField.value = '';
                idNumberField.classList.remove('bg-[#F2F2F2]');
                idNumberField.classList.add('bg-gray-200', 'disabled:cursor-not-allowed');
                
                // Reset to default state
                yearLevelField.style.display = 'block';
                yearLevelField.required = true;
                yearLevelField.value = '';
                departmentField.value = '';
                schoolDetailsContainer.classList.remove('grid-cols-1');
                schoolDetailsContainer.classList.add('grid-cols-2');
            }
        });
    </script>
</body>
</html>
import { displayInputErrors, clearInputError, autoCapitalizeOnBlur, autoCapitalizeWords } from '../helpers.js';
import { API_ROUTES, BASE_URL } from '../config.js';
import { showError, showSuccessWithRedirect } from '../utils.js';

const firstnameField = document.getElementById('firstname');
const lastnameField = document.getElementById('lastname');
const middleInitialField = document.getElementById('middle_initial');


// Apply auto-capitalization to name fields
[firstnameField, lastnameField, middleInitialField].forEach(autoCapitalizeWords);
autoCapitalizeOnBlur([firstnameField, lastnameField, middleInitialField]);

//============= FORM FIELD DYNAMICS ==============
const roleSelect = document.getElementById('role');
const idNumberField = document.getElementById('id_number');
const yearLevelField = document.getElementById('year_level');
const departmentField = document.getElementById('department_id');

// Initialize disabled state on page load
document.addEventListener('DOMContentLoaded', function() {
    idNumberField.disabled = true;
    yearLevelField.disabled = true;
    departmentField.disabled = true;
});

//Functionality to enable/disable fields based on role selection
roleSelect.addEventListener('change', function() {
    const selectedRole = this.value;
    const yearLevelContainer = yearLevelField.closest('.field-container');
    const schoolDetailsContainer = document.getElementById('school-details');
    
    if (selectedRole === 'Student') {
        clearInputError(idNumberField);
        clearInputError(departmentField);
        clearInputError(yearLevelField);
    
        idNumberField.disabled = false;
        idNumberField.placeholder = 'Student ID';
        idNumberField.classList.remove('bg-gray-200', 'disabled:cursor-not-allowed');
        idNumberField.classList.add('bg-[#F2F2F2]');
        
        yearLevelField.disabled = false;
        yearLevelField.classList.remove('bg-gray-200', 'disabled:cursor-not-allowed');
        yearLevelField.classList.add('bg-[#F2F2F2]');
        
        departmentField.disabled = false;
        departmentField.classList.remove('bg-gray-200', 'disabled:cursor-not-allowed');
        departmentField.classList.add('bg-[#F2F2F2]');
        
        // Show year level container and maintain 2-column grid
        yearLevelContainer.style.display = 'block';
        schoolDetailsContainer.classList.remove('grid-cols-1');
        schoolDetailsContainer.classList.add('grid-cols-2');
    } else if (selectedRole === 'Teacher') {
        clearInputError(yearLevelField);
        clearInputError(departmentField);
        clearInputError(idNumberField);
        
        idNumberField.disabled = false;
        idNumberField.placeholder = 'Employee ID';
        idNumberField.classList.remove('bg-gray-200', 'disabled:cursor-not-allowed');
        idNumberField.classList.add('bg-[#F2F2F2]');
        
        yearLevelField.disabled = true;
        yearLevelField.value = '';
        yearLevelField.classList.remove('bg-[#F2F2F2]');
        yearLevelField.classList.add('bg-gray-200', 'disabled:cursor-not-allowed');
        
        departmentField.disabled = false;
        departmentField.classList.remove('bg-gray-200', 'disabled:cursor-not-allowed');
        departmentField.classList.add('bg-[#F2F2F2]');
        
        // Hide year level container and use 1-column grid for department
        yearLevelContainer.style.display = 'none';
        schoolDetailsContainer.classList.remove('grid-cols-2');
        schoolDetailsContainer.classList.add('grid-cols-1');
    } else {
        idNumberField.disabled = true;
        idNumberField.placeholder = 'Select role first';
        idNumberField.value = '';
        idNumberField.classList.remove('bg-[#F2F2F2]');
        idNumberField.classList.add('bg-gray-200', 'disabled:cursor-not-allowed');
        
        yearLevelField.disabled = true;
        yearLevelField.value = '';
        yearLevelField.classList.remove('bg-[#F2F2F2]');
        yearLevelField.classList.add('bg-gray-200', 'disabled:cursor-not-allowed');
        
        departmentField.disabled = true;
        departmentField.value = '';
        departmentField.classList.remove('bg-[#F2F2F2]');
        departmentField.classList.add('bg-gray-200', 'disabled:cursor-not-allowed');
        
        // Reset to default state - show year level and use 2-column grid
        yearLevelContainer.style.display = 'block';
        schoolDetailsContainer.classList.remove('grid-cols-1');
        schoolDetailsContainer.classList.add('grid-cols-2');
    }
});


const inputs = document.querySelectorAll('#signup-form input, #signup-form select');

// Clear errors on focus
inputs.forEach(input => {
    input.addEventListener('focus', function() {
        clearInputError(input);
    });
});
inputs.forEach(input => {
    clearInputError(input, /*recompute=*/false);
});

// Handle form submission
const signupForm = document.getElementById('signup-form');

signupForm.addEventListener('submit', async function(e) {
    e.preventDefault();

    // Blur currently focused form control so it loses focus on submit
    const active = document.activeElement;
    if (active && ['INPUT','SELECT','TEXTAREA','BUTTON'].includes(active.tagName)) {
        try { active.blur(); } catch (err) { /* ignore */ }
    }

    const form = e.target;
    const formData = new FormData(form);

    const data = {
        firstname: formData.get('firstname'),
        lastname: formData.get('lastname'),
        middle_initial: formData.get('middle_initial'),
        email: formData.get('email'),
        contact_no: formData.get('contact_no'),
        username: formData.get('username'),
        password: formData.get('password'),
        confirm_password: formData.get('confirm_password'),
        role: formData.get('role'),
        student_no: formData.get('role') === 'Student' ? formData.get('id_number') : null,
        employee_no: formData.get('role') === 'Teacher' ? formData.get('id_number') : null,
        year_level: formData.get('role') === 'Student' ? formData.get('year_level') : null,
        department_id: formData.get('role') === 'Student' || 
                        formData.get('role') === 'Teacher' ? formData.get('department_id') : null
    };

    try {
        const response = await fetch(API_ROUTES.SIGNUP, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.errors){
            displayInputErrors(result.errors);
            return;
        }

        showSuccessWithRedirect(
            'Account Successfully Created', 
            'You have successfully registered!',
             BASE_URL + 'views/auth/login.php'  
        );

    } catch (error) {
        console.error('Error:', error);
        showError('Something went wrong', 'Please try again later.');
    }
});


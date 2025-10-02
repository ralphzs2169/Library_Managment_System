const roleSelect = document.getElementById('role');
const idNumberField = document.getElementById('id_number');
const yearLevelField = document.getElementById('year_level');
const departmentField = document.getElementById('department_id');
const schoolInfoGrid = document.getElementById('school-info-grid');

const firstnameField = document.getElementById('firstname');
const lastnameField = document.getElementById('lastname');
const middleInitialField = document.getElementById('middle_initial');

function autoCapitalizeWords(field) {
  field.addEventListener('input', function () {
    let words = this.value.split(' ');
    this.value = words
      .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
      .join(' ');
  });
}

// Apply auto-capitalization to name fields
[firstnameField, lastnameField, middleInitialField].forEach(autoCapitalizeWords);

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function autoCapitalizeOnBlur(fields) {
  fields.forEach(field => {
    field.addEventListener('blur', () => {
      const value = field.value.trim();
      if (value) field.value = capitalizeFirstLetter(value);
    });
  });
}

autoCapitalizeOnBlur([firstnameField, lastnameField, middleInitialField]);

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
        clearErrors(idNumberField);
        clearErrors(departmentField);
        clearErrors(yearLevelField);
    
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
        clearErrors(yearLevelField);
        clearErrors(departmentField);
        clearErrors(idNumberField);
        
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
        clearErrors(input);
    });
});

function displayError(errors) {
    // Clear previous errors and reset all placeholders
    const errorPlaceholders = Array.from(document.querySelectorAll('.error-placeholder'));

    // clear text, visible class and any inline height from previous run
    errorPlaceholders.forEach(placeholder => {
        placeholder.textContent = '';
        placeholder.classList.remove('visible');
        placeholder.style.height = '';
    });

    inputs.forEach(input => {
        clearErrors(input, /*recompute=*/false);
    });

    // Display new errors
    for (const field in errors) {

        const fieldMapping = {
            'student_no': 'id_number',
            'employee_no': 'id_number'
        };

        const inputId = fieldMapping[field] || field;
        const inputElement = document.getElementById(inputId);
        const errorPlaceholder = document.getElementById(inputId + '-error-placeholder');

        if (inputElement && errorPlaceholder) {
            // Add error styling to input
            inputElement.classList.add('invalid-input');

            // Show error text (we'll compute heights afterwards)
            errorPlaceholder.textContent = errors[field];
            errorPlaceholder.classList.add('visible');
        }

        // Special case: show password errors on both password and confirm_password fields
        if (field === 'password') {
            const confirmPasswordElement = document.getElementById('confirm_password');
            const confirmPasswordPlaceholder = document.getElementById('confirm_password-error-placeholder');

            if (confirmPasswordElement && confirmPasswordPlaceholder) {
                confirmPasswordElement.classList.add('invalid-input');
                confirmPasswordPlaceholder.textContent = errors[field];
                confirmPasswordPlaceholder.classList.add('visible');
            }
        }
    }

    // After rendering errors, compute and apply equalized heights per grid row
    normalizePlaceholdersByRow();

    // After heights applied, scroll to first invalid field smoothly
    scrollToFirstError();
}

// Clear errors; optional recompute to avoid repeated recompute per field
function clearErrors(inputField, recompute = true) {
    // Add null check to prevent the error
    if (!inputField) {
        console.warn('Input field is null');
        return;
    }

    const errorPlaceholder = document.getElementById(inputField.id + '-error-placeholder');

    if (errorPlaceholder) {
        errorPlaceholder.textContent = '';
        errorPlaceholder.classList.remove('visible');
        errorPlaceholder.style.height = '';
    }
    inputField.classList.remove('invalid-input');

    if (recompute) {
        normalizePlaceholdersByRow();
    }
}

// New helper: group placeholders by their top position and set equal height per group
function normalizePlaceholdersByRow() {
    const placeholders = Array.from(document.querySelectorAll('#signup-form .error-placeholder'));
    if (!placeholders.length) return;

    // Reset any inline heights first
    placeholders.forEach(p => { p.style.height = ''; });

    // Group placeholders by their rounded top coordinate
    const groups = {};
    placeholders.forEach(p => {
        const rect = p.getBoundingClientRect();
        const topKey = Math.round(rect.top);
        if (!groups[topKey]) groups[topKey] = [];
        groups[topKey].push(p);
    });

    // For each group compute the max content height (scrollHeight) and set on all
    Object.values(groups).forEach(group => {
        let max = 0;
        group.forEach(p => {
            // scrollHeight works even when visibility:hidden
            const contentHeight = p.scrollHeight;
            if (contentHeight > max) max = contentHeight;
        });

        // Apply max (or clear if zero)
        group.forEach(p => {
            if (max > 0) {
                p.style.height = max + 'px';
            } else {
                p.style.height = '';
            }
        });
    });
}


document.getElementById('signup-form').addEventListener('submit', async function(e) {
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
        const response = await fetch('/LibraryManagementSystem/app/routes/api.php/signup', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.errors){
            displayError(result.errors);
            return;
        }

        Swal.fire({
            icon: 'success',
            title: 'Account Successfully Created',
            text: 'You have successfully registered!',
            confirmButtonColor: '#00ADB5'
        }).then(() => {
                window.location.href = '/LibraryManagementSystem/views/auth/login.php';
        });
       

    } catch (error) {
         console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Something went wrong',
            text: 'Please try again later.',
            confirmButtonColor: '#00ADB5'
        });
    }
});

// Smooth-scroll to first invalid input, focus and briefly highlight it
function scrollToFirstError() {
	const firstInvalid = document.querySelector('#signup-form .invalid-input');
	if (!firstInvalid) return;

	// Try to account for a fixed header if present
	const header = document.querySelector('header, .site-header');
	const headerHeight = header ? header.getBoundingClientRect().height + 50 : 80;

	const rect = firstInvalid.getBoundingClientRect();
	const scrollY = window.pageYOffset + rect.top - headerHeight;

	// Smooth scroll
	window.scrollTo({ top: Math.max(0, scrollY), behavior: 'smooth' });
}
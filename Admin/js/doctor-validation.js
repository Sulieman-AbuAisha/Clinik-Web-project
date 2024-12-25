document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (validateForm()) {
            this.submit();
        }
    });

    function validateForm() {
        let isValid = true;
        
        // Validate Name
        const name = document.getElementById('name');
        if (!/^[a-zA-Z\s]{2,50}$/.test(name.value.trim())) {
            showError(name, 'Name should contain only letters and spaces (2-50 characters)');
            isValid = false;
        } else {
            removeError(name);
        }

        // Validate Specialty
        const specialty = document.getElementById('specialty');
        if (!/^[a-zA-Z\s]{2,30}$/.test(specialty.value.trim())) {
            showError(specialty, 'Specialty should contain only letters and spaces (2-30 characters)');
            isValid = false;
        } else {
            removeError(specialty);
        }

        // Validate Experience
        const experience = document.getElementById('experience');
        if (isNaN(experience.value) || experience.value < 0 || experience.value > 50) {
            showError(experience, 'Experience should be a number between 0 and 50');
            isValid = false;
        } else {
            removeError(experience);
        }

        // Validate Gender
        const gender = document.getElementById('gender');
        if (!gender.value) {
            showError(gender, 'Please select a gender');
            isValid = false;
        } else {
            removeError(gender);
        }

        // Validate Nationality
        const nationality = document.getElementById('nationality');
        if (!/^[a-zA-Z\s]{2,30}$/.test(nationality.value.trim())) {
            showError(nationality, 'Nationality should contain only letters and spaces (2-30 characters)');
            isValid = false;
        } else {
            removeError(nationality);
        }

        // Validate Email
        const email = document.getElementById('email');
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
            showError(email, 'Please enter a valid email address');
            isValid = false;
        } else {
            removeError(email);
        }

        // Validate Working Days
        const workingDays = document.querySelectorAll('input[name="working_days[]"]:checked');
        if (workingDays.length === 0) {
            showError(workingDays[0]?.parentElement, 'Please select at least one working day');
            isValid = false;
        } else {
            removeError(workingDays[0].parentElement);
        }

        return isValid;
    }

    function showError(element, message) {
        // Remove existing error if any
        removeError(element);
        
        // Create and add error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.style.color = 'red';
        errorDiv.style.fontSize = '12px';
        errorDiv.style.marginTop = '5px';
        errorDiv.textContent = message;
        
        element.classList.add('error-input');
        element.parentElement.appendChild(errorDiv);
    }

    function removeError(element) {
        const existingError = element.parentElement.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        element.classList.remove('error-input');
    }
}); 
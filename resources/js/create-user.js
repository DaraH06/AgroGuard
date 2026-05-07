const form = document.getElementById('createUserForm');
const passwordInput = document.getElementById('password');
const passwordConfirmInput = document.getElementById('password_confirmation');
const emailInput = document.getElementById('email');
const submitBtn = form ? form.querySelector('button[type="submit"]') : null;

if (passwordInput && passwordConfirmInput) {
    // Password requirements validation
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        
        const hasLength = password.length >= 8;
        const hasUppercase = /[A-Z]/.test(password);
        const hasLowercase = /[a-z]/.test(password);
        const hasNumber = /[0-9]/.test(password);

        updateRequirement('req-length', hasLength);
        updateRequirement('req-uppercase', hasUppercase);
        updateRequirement('req-lowercase', hasLowercase);
        updateRequirement('req-number', hasNumber);

        validatePasswordMatch();
    });

    passwordConfirmInput.addEventListener('input', function() {
        validatePasswordMatch();
    });
}

function updateRequirement(id, isMet) {
    const element = document.getElementById(id);
    if (!element) return;
    if (isMet) {
        element.classList.add('met');
    } else {
        element.classList.remove('met');
    }
}

function validatePasswordMatch() {
    if (!passwordInput || !passwordConfirmInput) return;
    const password = passwordInput.value;
    const passwordConfirm = passwordConfirmInput.value;
    
    if (passwordConfirm && password !== passwordConfirm) {
        passwordConfirmInput.parentElement.classList.add('error');
    } else {
        passwordConfirmInput.parentElement.classList.remove('error');
    }
}

function isPasswordValid() {
    if (!passwordInput) return false;
    const password = passwordInput.value;
    return password.length >= 8 && 
            /[A-Z]/.test(password) && 
            /[a-z]/.test(password) && 
            /[0-9]/.test(password);
}

if (form) {
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validation
        const email = emailInput.value.trim();
        const password = passwordInput.value;
        const passwordConfirm = passwordConfirmInput.value;

        if (!email) {
            showAlert('Email harus diisi', 'error');
            emailInput.parentElement.classList.add('error');
            return;
        }

        if (!isPasswordValid()) {
            showAlert('Password harus memenuhi semua syarat', 'error');
            passwordInput.parentElement.classList.add('error');
            return;
        }

        if (password !== passwordConfirm) {
            showAlert('Password tidak cocok', 'error');
            passwordConfirmInput.parentElement.classList.add('error');
            return;
        }

        // Disable submit button and show loading
        submitBtn.disabled = true;
        document.getElementById('submitText').style.display = 'none';
        document.getElementById('submitSpinner').style.display = 'inline-block';

        try {
            // Retrieve route from data attribute
            const routeUrl = form.dataset.action;
            const routeRedirect = form.dataset.redirect;

            const response = await fetch(routeUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    email: email,
                    password: password,
                    password_confirmation: passwordConfirm
                })
            });

            const data = await response.json();

            if (data.success) {
                showAlert('User berhasil dibuat! Redirecting...', 'success');
                setTimeout(() => {
                    window.location.href = routeRedirect;
                }, 1500);
            } else {
                showAlert(data.message || 'Gagal membuat user', 'error');
                submitBtn.disabled = false;
                document.getElementById('submitText').style.display = 'inline';
                document.getElementById('submitSpinner').style.display = 'none';
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert('Terjadi kesalahan: ' + error.message, 'error');
            submitBtn.disabled = false;
            document.getElementById('submitText').style.display = 'inline';
            document.getElementById('submitSpinner').style.display = 'none';
        }
    });
}

function showAlert(message, type) {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.innerHTML = `
        <span>${message}</span>
        <button type="button" class="alert-close" onclick="this.parentElement.remove();">&times;</button>
    `;
    alertContainer.appendChild(alertDiv);

    if (type === 'error') {
        setTimeout(() => {
            if (alertDiv.parentElement) {
                alertDiv.remove();
            }
        }, 5000);
    }
}

// Remove error class when typing
if (emailInput) {
    emailInput.addEventListener('input', function() {
        this.parentElement.classList.remove('error');
    });
}

if (passwordInput) {
    passwordInput.addEventListener('input', function() {
        this.parentElement.classList.remove('error');
    });
}

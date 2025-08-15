/**
 * Global JavaScript Functions
 *
 * Reusable functions for the CX Shipment System
 * Contains utility functions, UI helpers, validation, and common operations
 *
 * @author CX Shipment System
 * @version 1.0
 */

// ============================================================================
// UTILITY FUNCTIONS
// ============================================================================

/**
 * Format date for display
 *
 * @param {string} dateString - Date string to format
 * @returns {string} Formatted date string
 */
function formatDate(dateString) {
	const date = new Date(dateString);
	return date.toLocaleDateString("en-US", {
		year: "numeric",
		month: "short",
		day: "numeric",
		hour: "2-digit",
		minute: "2-digit",
	});
}

/**
 * Format relative time
 *
 * @param {string} dateString - Date string to format
 * @returns {string} Relative time string
 */
function formatRelativeTime(dateString) {
	const date = new Date(dateString);
	const now = new Date();
	const diffInSeconds = Math.floor((now - date) / 1000);

	if (diffInSeconds < 60) {
		return "Just now";
	} else if (diffInSeconds < 3600) {
		const minutes = Math.floor(diffInSeconds / 60);
		return `${minutes} minute${minutes > 1 ? "s" : ""} ago`;
	} else if (diffInSeconds < 86400) {
		const hours = Math.floor(diffInSeconds / 3600);
		return `${hours} hour${hours > 1 ? "s" : ""} ago`;
	} else if (diffInSeconds < 2592000) {
		const days = Math.floor(diffInSeconds / 86400);
		return `${days} day${days > 1 ? "s" : ""} ago`;
	} else {
		return formatDate(dateString);
	}
}

/**
 * Format phone number as user types
 *
 * @param {HTMLElement} input - Phone input element
 */
function formatPhoneNumber(input) {
	let value = input.value.replace(/\D/g, "");

	if (value.length > 0) {
		if (value.length <= 3) {
			value = `(${value}`;
		} else if (value.length <= 6) {
			value = `(${value.slice(0, 3)}) ${value.slice(3)}`;
		} else {
			value = `(${value.slice(0, 3)}) ${value.slice(3, 6)}-${value.slice(
				6,
				10
			)}`;
		}
	}

	input.value = value;
}

// ============================================================================
// UI HELPER FUNCTIONS
// ============================================================================

/**
 * Show loading state for buttons
 *
 * @param {HTMLElement} button - Button element to show loading state
 * @returns {string} Original button text
 */
function showButtonLoading(button) {
	const originalText = button.innerHTML;
	button.innerHTML =
		'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
	button.disabled = true;

	return originalText;
}

/**
 * Hide loading state for buttons
 *
 * @param {HTMLElement} button - Button element to hide loading state
 * @param {string} originalText - Original button text to restore
 */
function hideButtonLoading(button, originalText) {
	button.innerHTML = originalText;
	button.disabled = false;
}

/**
 * Show loading state for form submission
 *
 * @param {HTMLElement} form - Form element
 */
function showFormLoading(form) {
	const submitButton = form.querySelector('button[type="submit"]');
	if (submitButton) {
		submitButton.disabled = true;
		submitButton.innerHTML =
			'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
	}
}

/**
 * Hide loading state for form submission
 *
 * @param {HTMLElement} form - Form element
 * @param {string} originalText - Original button text
 */
function hideFormLoading(form, originalText) {
	const submitButton = form.querySelector('button[type="submit"]');
	if (submitButton) {
		submitButton.disabled = false;
		submitButton.innerHTML = originalText;
	}
}

/**
 * Toggle password visibility
 *
 * @param {HTMLElement} input - Password input element
 * @param {HTMLElement} button - Toggle button element
 */
function togglePasswordVisibility(input, button) {
	const type = input.getAttribute("type") === "password" ? "text" : "password";
	input.setAttribute("type", type);

	const icon = button.querySelector("i");
	if (type === "text") {
		icon.classList.remove("bi-eye");
		icon.classList.add("bi-eye-slash");
	} else {
		icon.classList.remove("bi-eye-slash");
		icon.classList.add("bi-eye");
	}
}

/**
 * Initialize password toggle buttons
 */
function initializePasswordToggles() {
	const togglePassword = document.getElementById("togglePassword");
	const toggleConfirmPassword = document.getElementById(
		"toggleConfirmPassword"
	);
	const passwordInput = document.getElementById("password");
	const confirmPasswordInput = document.getElementById("confirm_password");

	if (togglePassword && passwordInput) {
		togglePassword.addEventListener("click", function () {
			togglePasswordVisibility(passwordInput, togglePassword);
		});
	}

	if (toggleConfirmPassword && confirmPasswordInput) {
		toggleConfirmPassword.addEventListener("click", function () {
			togglePasswordVisibility(confirmPasswordInput, toggleConfirmPassword);
		});
	}
}

// ============================================================================
// ALERT AND NOTIFICATION FUNCTIONS
// ============================================================================

/**
 * Show success toast notification
 *
 * @param {string} message - Success message to display
 */
function showSuccessToast(message) {
	// You can implement toast notifications here
	// For now, we'll use a simple alert
	alert(message);
}

/**
 * Show error toast notification
 *
 * @param {string} message - Error message to display
 */
function showErrorToast(message) {
	// TODO: Implement toast notifications
	alert("Error: " + message);
}

/**
 * Show success message
 *
 * @param {string} message - Success message
 */
function showSuccessMessage(message) {
	const alertDiv = document.createElement("div");
	alertDiv.className = "alert alert-success alert-dismissible fade show";
	alertDiv.innerHTML = `
        <i class="bi bi-check-circle"></i> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

	const form = document.querySelector("form");
	if (form) {
		form.parentNode.insertBefore(alertDiv, form);
	}
}

/**
 * Show error message
 *
 * @param {string} message - Error message
 */
function showErrorMessage(message) {
	const alertDiv = document.createElement("div");
	alertDiv.className = "alert alert-danger alert-dismissible fade show";
	alertDiv.innerHTML = `
        <i class="bi bi-exclamation-triangle"></i> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

	const form = document.querySelector("form");
	if (form) {
		form.parentNode.insertBefore(alertDiv, form);
	}
}

/**
 * Initialize alerts auto-hide
 */
function initializeAlerts() {
	$(".alert").each(function () {
		var $alert = $(this);
		setTimeout(function () {
			$alert.fadeOut();
		}, 5000);
	});
}

// ============================================================================
// VALIDATION FUNCTIONS
// ============================================================================

/**
 * Validate password confirmation
 *
 * @param {HTMLElement} passwordInput - Password input element
 * @param {HTMLElement} confirmPasswordInput - Confirm password input element
 */
function validatePasswordConfirmation(passwordInput, confirmPasswordInput) {
	const password = passwordInput.value;
	const confirmPassword = confirmPasswordInput.value;

	if (confirmPassword && password !== confirmPassword) {
		confirmPasswordInput.classList.add("is-invalid");
		showFieldError(confirmPasswordInput, "Passwords do not match");
	} else {
		confirmPasswordInput.classList.remove("is-invalid");
		hideFieldError(confirmPasswordInput);
	}
}

/**
 * Validate username format
 *
 * @param {HTMLElement} input - Username input element
 */
function validateUsername(input) {
	const username = input.value;
	const usernameRegex = /^[a-zA-Z0-9_]{3,50}$/;

	if (username && !usernameRegex.test(username)) {
		input.classList.add("is-invalid");
		showFieldError(
			input,
			"Username must be 3-50 characters long and contain only letters, numbers, and underscores"
		);
	} else {
		input.classList.remove("is-invalid");
		hideFieldError(input);
	}
}

/**
 * Validate email format
 *
 * @param {HTMLElement} input - Email input element
 */
function validateEmail(input) {
	const email = input.value;
	const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

	if (email && !emailRegex.test(email)) {
		input.classList.add("is-invalid");
		showFieldError(input, "Please enter a valid email address");
	} else {
		input.classList.remove("is-invalid");
		hideFieldError(input);
	}
}

/**
 * Validate phone number format
 *
 * @param {HTMLElement} input - Phone input element
 */
function validatePhone(input) {
	const phone = input.value;
	const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;

	if (phone && !phoneRegex.test(phone.replace(/\s/g, ""))) {
		input.classList.add("is-invalid");
		showFieldError(input, "Please enter a valid phone number");
	} else {
		input.classList.remove("is-invalid");
		hideFieldError(input);
	}
}

/**
 * Show field error message
 *
 * @param {HTMLElement} input - Input element
 * @param {string} message - Error message
 */
function showFieldError(input, message) {
	let errorDiv = input.parentNode.querySelector(".invalid-feedback");

	if (!errorDiv) {
		errorDiv = document.createElement("div");
		errorDiv.className = "invalid-feedback";
		input.parentNode.appendChild(errorDiv);
	}

	errorDiv.textContent = message;
}

/**
 * Hide field error message
 *
 * @param {HTMLElement} input - Input element
 */
function hideFieldError(input) {
	const errorDiv = input.parentNode.querySelector(".invalid-feedback");
	if (errorDiv) {
		errorDiv.remove();
	}
}

/**
 * Initialize form validation
 */
function initializeFormValidation() {
	const form = document.querySelector("form");
	if (!form) return;

	// Real-time password confirmation validation
	const passwordInput = document.getElementById("password");
	const confirmPasswordInput = document.getElementById("confirm_password");

	if (passwordInput && confirmPasswordInput) {
		confirmPasswordInput.addEventListener("input", function () {
			validatePasswordConfirmation(passwordInput, confirmPasswordInput);
		});

		passwordInput.addEventListener("input", function () {
			validatePasswordConfirmation(passwordInput, confirmPasswordInput);
		});
	}

	// Username validation (no spaces, alphanumeric and underscore only)
	const usernameInput = document.getElementById("username");
	if (usernameInput) {
		usernameInput.addEventListener("input", function () {
			validateUsername(usernameInput);
		});
	}

	// Email validation
	const emailInput = document.getElementById("email");
	if (emailInput) {
		emailInput.addEventListener("input", function () {
			validateEmail(emailInput);
		});
	}

	// Phone number validation
	const phoneInput = document.getElementById("phone");
	if (phoneInput) {
		phoneInput.addEventListener("input", function () {
			validatePhone(phoneInput);
		});
	}
}

// ============================================================================
// FORM HELPER FUNCTIONS
// ============================================================================

/**
 * Clear form data
 *
 * @param {HTMLElement} form - Form element
 */
function clearForm(form) {
	form.reset();

	// Clear validation states
	const inputs = form.querySelectorAll(".form-control, .form-select");
	inputs.forEach((input) => {
		input.classList.remove("is-invalid", "is-valid");
	});

	// Clear error messages
	const errorMessages = form.querySelectorAll(".invalid-feedback");
	errorMessages.forEach((error) => {
		error.remove();
	});
}

// ============================================================================
// MODAL HELPER FUNCTIONS
// ============================================================================

/**
 * Show confirmation modal
 *
 * @param {string} modalId - Modal element ID
 * @param {string} title - Modal title
 * @param {string} message - Modal message
 * @param {string} confirmUrl - URL for confirmation action
 * @param {string} confirmText - Confirm button text
 * @param {string} confirmClass - Confirm button CSS class
 */
function showConfirmationModal(
	modalId,
	title,
	message,
	confirmUrl,
	confirmText,
	confirmClass
) {
	const modal = new bootstrap.Modal(document.getElementById(modalId));
	const modalTitle = document.querySelector(`#${modalId} .modal-title`);
	const modalBody = document.querySelector(`#${modalId} .modal-body`);
	const confirmBtn = document.querySelector(`#${modalId} .btn-confirm`);

	if (modalTitle) modalTitle.textContent = title;
	if (modalBody) modalBody.textContent = message;
	if (confirmBtn) {
		confirmBtn.href = confirmUrl;
		confirmBtn.textContent = confirmText;
		confirmBtn.className = `btn ${confirmClass} btn-confirm`;
	}

	modal.show();
}

// ============================================================================
// DATA TABLE HELPER FUNCTIONS
// ============================================================================

/**
 * Initialize jQuery DataTable with common configuration
 *
 * @param {string} tableId - Table element ID
 * @param {object} options - Additional options to merge with defaults
 */
function initializeDataTable(tableId, options = {}) {
	const defaultOptions = {
		responsive: true,
		processing: true,
		serverSide: false,
		pageLength: 10,
		lengthMenu: [
			[10, 25, 50, 100],
			[10, 25, 50, 100],
		],
		language: {
			search: "Search:",
			lengthMenu: "Show _MENU_ entries per page",
			info: "Showing _START_ to _END_ of _TOTAL_ entries",
			infoEmpty: "Showing 0 to 0 of 0 entries",
			infoFiltered: "(filtered from _MAX_ total entries)",
			emptyTable: "No data available",
			zeroRecords: "No matching records found",
			processing: "Processing...",
			paginate: {
				first: "First",
				last: "Last",
				next: "Next",
				previous: "Previous",
			},
		},
		pagingType: "simple",
		dom:
			"<'row'<'col-3'l><'col-9'f>>" +
			"<'row dt-row'<'col-sm-12'tr>>" +
			"<'row'<'col-4'i><'col-8'p>>",
		initComplete: function () {
			$(".dataTables_wrapper").addClass("mt-3");
		},
	};

	// Merge options
	const finalOptions = { ...defaultOptions, ...options };

	return $(`#${tableId}`).DataTable(finalOptions);
}

// ============================================================================
// EXPORT FUNCTIONS TO GLOBAL SCOPE
// ============================================================================

// Utility functions
window.formatDate = formatDate;
window.formatRelativeTime = formatRelativeTime;
window.formatPhoneNumber = formatPhoneNumber;

// UI helper functions
window.showButtonLoading = showButtonLoading;
window.hideButtonLoading = hideButtonLoading;
window.showFormLoading = showFormLoading;
window.hideFormLoading = hideFormLoading;
window.togglePasswordVisibility = togglePasswordVisibility;
window.initializePasswordToggles = initializePasswordToggles;

// Alert and notification functions
window.showSuccessToast = showSuccessToast;
window.showErrorToast = showErrorToast;
window.showSuccessMessage = showSuccessMessage;
window.showErrorMessage = showErrorMessage;
window.initializeAlerts = initializeAlerts;

// Validation functions
window.validatePasswordConfirmation = validatePasswordConfirmation;
window.validateUsername = validateUsername;
window.validateEmail = validateEmail;
window.validatePhone = validatePhone;
window.showFieldError = showFieldError;
window.hideFieldError = hideFieldError;
window.initializeFormValidation = initializeFormValidation;

// Form helper functions
window.clearForm = clearForm;

// Modal helper functions
window.showConfirmationModal = showConfirmationModal;

// DataTable helper functions
window.initializeDataTable = initializeDataTable;

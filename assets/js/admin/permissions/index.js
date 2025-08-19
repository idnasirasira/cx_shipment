/**
 * Permissions Management JavaScript
 *
 * Handles all client-side functionality for permission management
 *
 * @author CX Shipment System
 * @version 1.0
 */

// Get base URL from meta tag or default
const baseUrl =
	document.querySelector('meta[name="base-url"]')?.getAttribute("content") ||
	"";

class PermissionsManager {
	constructor() {
		this.init();
	}

	init() {
		this.bindEvents();
		this.initializeComponents();
	}

	bindEvents() {
		// Permission name availability check
		const nameInput = document.getElementById("name");
		if (nameInput) {
			this.setupNameCheck(nameInput);
		}

		// Form validation
		const createForm = document.getElementById("createPermissionForm");
		if (createForm) {
			this.setupFormValidation(createForm);
		}

		const editForm = document.getElementById("editPermissionForm");
		if (editForm) {
			this.setupFormValidation(editForm);
		}

		const bulkAssignForm = document.getElementById("bulkAssignForm");
		if (bulkAssignForm) {
			this.setupBulkAssignForm(bulkAssignForm);
		}

		// Delete confirmation
		document.querySelectorAll(".delete-permission").forEach((button) => {
			button.addEventListener("click", (e) => this.handleDelete(e));
		});

		// Bulk assign actions
		const selectAllBtn = document.getElementById("selectAll");
		const deselectAllBtn = document.getElementById("deselectAll");

		if (selectAllBtn) {
			selectAllBtn.addEventListener("click", () => this.selectAllPermissions());
		}

		if (deselectAllBtn) {
			deselectAllBtn.addEventListener("click", () =>
				this.deselectAllPermissions()
			);
		}

		// Role selection change
		const roleSelect = document.getElementById("role_id");
		if (roleSelect) {
			roleSelect.addEventListener("change", (e) => this.handleRoleChange(e));
		}
	}

	initializeComponents() {
		// Initialize DataTables if present
		const permissionsTable = document.getElementById("permissionsTable");
		if (permissionsTable && typeof DataTableHelper !== "undefined") {
			// Use the DataTable helper for consistent styling
			this.dataTable = DataTableHelper.createAdminTable("permissionsTable", {
				columns: [
					{ select: [0], sortable: false }, // ID column
					{ select: [1], sortable: true }, // Name column
					{ select: [2], sortable: true }, // Description column
					{ select: [3], sortable: true }, // Assigned Roles column
					{ select: [4], sortable: true }, // Created column
					{ select: [5], sortable: false }, // Actions column
				],
			});
		}

		// Initialize tooltips
		if (typeof bootstrap !== "undefined") {
			const tooltipTriggerList = [].slice.call(
				document.querySelectorAll('[data-bs-toggle="tooltip"]')
			);
			tooltipTriggerList.map(function (tooltipTriggerEl) {
				return new bootstrap.Tooltip(tooltipTriggerEl);
			});
		}
	}

	setupNameCheck(input) {
		let timeout;
		const feedback = document.getElementById("nameFeedback");
		const originalName = input.dataset.originalName || "";

		input.addEventListener("input", () => {
			clearTimeout(timeout);
			const name = input.value.trim();

			if (name.length < 2) {
				this.clearValidation(input, feedback);
				return;
			}

			// Don't check if name hasn't changed
			if (name === originalName) {
				this.clearValidation(input, feedback);
				return;
			}

			// Validate naming convention
			if (!this.validatePermissionName(name)) {
				this.showInvalid(
					input,
					feedback,
					"Permission name should contain only lowercase letters and underscores"
				);
				return;
			}

			timeout = setTimeout(() => {
				this.checkNameAvailability(name, input, feedback);
			}, 500);
		});

		// Auto-format on blur
		input.addEventListener("blur", () => {
			const formattedName = this.formatPermissionName(input.value);
			input.value = formattedName;
		});
	}

	validatePermissionName(name) {
		const namePattern = /^[a-z_]+$/;
		return namePattern.test(name);
	}

	formatPermissionName(name) {
		let formatted = name.trim();

		// Convert to lowercase and replace spaces/hyphens with underscores
		formatted = formatted.toLowerCase().replace(/[^a-z0-9_]/g, "_");

		// Remove multiple consecutive underscores
		formatted = formatted.replace(/_+/g, "_");

		// Remove leading/trailing underscores
		formatted = formatted.replace(/^_+|_+$/g, "");

		return formatted;
	}

	async checkNameAvailability(name, input, feedback) {
		try {
			const formData = new FormData();
			formData.append("name", name);

			if (input.dataset.excludeId) {
				formData.append("exclude_id", input.dataset.excludeId);
			}

			const response = await fetch(
				baseUrl + "/admin/permissions/check_permission_name",
				{
					method: "POST",
					body: formData,
					headers: {
						"X-Requested-With": "XMLHttpRequest",
					},
				}
			);

			const data = await response.json();

			if (data.available) {
				this.showValid(input, feedback, "Permission name is available");
			} else {
				this.showInvalid(input, feedback, "Permission name already exists");
			}
		} catch (error) {
			console.error("Error checking permission name:", error);
		}
	}

	setupFormValidation(form) {
		form.addEventListener("submit", (e) => {
			if (!this.validatePermissionForm(form)) {
				e.preventDefault();
				return false;
			}
		});
	}

	setupBulkAssignForm(form) {
		form.addEventListener("submit", (e) => {
			if (!this.validateBulkAssignForm(form)) {
				e.preventDefault();
				return false;
			}
		});
	}

	validatePermissionForm(form) {
		const nameInput = form.querySelector("#name");
		if (!nameInput || !nameInput.value.trim()) {
			this.showAlert("Permission name is required.", "warning");
			return false;
		}

		const name = nameInput.value.trim();
		if (!this.validatePermissionName(name)) {
			this.showAlert(
				"Permission name should contain only lowercase letters and underscores.",
				"warning"
			);
			return false;
		}

		return true;
	}

	validateBulkAssignForm(form) {
		const roleSelect = form.querySelector("#role_id");
		const permissions = form.querySelectorAll(
			'input[name="permissions[]"]:checked'
		);

		if (!roleSelect || !roleSelect.value) {
			this.showAlert("Please select a role.", "warning");
			return false;
		}

		if (permissions.length === 0) {
			this.showAlert("Please select at least one permission.", "warning");
			return false;
		}

		return true;
	}

	selectAllPermissions() {
		document.querySelectorAll(".permission-checkbox").forEach((checkbox) => {
			checkbox.checked = true;
		});
		this.updatePermissionCount();
	}

	deselectAllPermissions() {
		document.querySelectorAll(".permission-checkbox").forEach((checkbox) => {
			checkbox.checked = false;
		});
		this.updatePermissionCount();
	}

	async handleRoleChange(e) {
		const roleId = e.target.value;
		if (!roleId) return;

		// Clear all checkboxes first
		document.querySelectorAll(".permission-checkbox").forEach((checkbox) => {
			checkbox.checked = false;
		});

		// Load existing permissions for this role
		const data = await this.getRolePermissions(roleId);

		if (data.permissions) {
			data.permissions.forEach((permissionId) => {
				const checkbox = document.getElementById(`permission_${permissionId}`);
				if (checkbox) {
					checkbox.checked = true;
				}
			});
		}

		this.updatePermissionCount();
	}

	updatePermissionCount() {
		const checkboxes = document.querySelectorAll(
			'input[name="permissions[]"]:checked'
		);
		const countElement = document.getElementById("permissionCount");

		if (countElement) {
			countElement.textContent = checkboxes.length;
		}
	}

	handleDelete(e) {
		e.preventDefault();
		const button = e.currentTarget;
		const permissionId = button.dataset.id;
		const permissionName = button.dataset.name;

		if (
			confirm(
				`Are you sure you want to delete the permission "${permissionName}"? This action cannot be undone.`
			)
		) {
			window.location.href =
				baseUrl + `/admin/permissions/delete/${permissionId}`;
		}
	}

	showValid(input, feedback, message) {
		input.classList.remove("is-invalid");
		input.classList.add("is-valid");
		feedback.textContent = message;
		feedback.className = "valid-feedback";
	}

	showInvalid(input, feedback, message) {
		input.classList.remove("is-valid");
		input.classList.add("is-invalid");
		feedback.textContent = message;
		feedback.className = "invalid-feedback";
	}

	clearValidation(input, feedback) {
		input.classList.remove("is-valid", "is-invalid");
		feedback.textContent = "";
	}

	showAlert(message, type = "info") {
		const alertDiv = document.createElement("div");
		alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
		alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

		const container = document.querySelector(".card-body");
		if (container) {
			container.insertBefore(alertDiv, container.firstChild);
		}
	}

	// AJAX method to get role permissions
	async getRolePermissions(roleId) {
		try {
			const formData = new FormData();
			formData.append("role_id", roleId);

			const response = await fetch(
				baseUrl + "/admin/roles/get_role_permissions",
				{
					method: "POST",
					body: formData,
					headers: {
						"X-Requested-With": "XMLHttpRequest",
					},
				}
			);

			return await response.json();
		} catch (error) {
			console.error("Error fetching role permissions:", error);
			return { permissions: [] };
		}
	}

	// Export permissions to CSV
	exportToCSV() {
		window.location.href = baseUrl + "/admin/permissions/export";
	}

	// Copy permission name to clipboard
	copyPermissionName(name) {
		navigator.clipboard
			.writeText(name)
			.then(() => {
				this.showAlert("Permission name copied to clipboard!", "success");
			})
			.catch(() => {
				this.showAlert("Failed to copy permission name.", "error");
			});
	}
}

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
	new PermissionsManager();
});

// Export for use in other modules
if (typeof module !== "undefined" && module.exports) {
	module.exports = PermissionsManager;
}

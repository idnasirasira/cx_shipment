/**
 * Roles Management JavaScript
 *
 * Handles all client-side functionality for role management
 *
 * @author CX Shipment System
 * @version 1.0
 */

// Get base URL from meta tag or default
const baseUrl =
	document.querySelector('meta[name="base-url"]')?.getAttribute("content") ||
	"";

class RolesManager {
	constructor() {
		this.init();
	}

	init() {
		this.bindEvents();
		this.initializeComponents();
	}

	bindEvents() {
		// Role name availability check
		const nameInput = document.getElementById("name");
		if (nameInput) {
			this.setupNameCheck(nameInput);
		}

		// Form validation
		const createForm = document.getElementById("createRoleForm");
		if (createForm) {
			this.setupFormValidation(createForm);
		}

		const editForm = document.getElementById("editRoleForm");
		if (editForm) {
			this.setupFormValidation(editForm);
		}

		// Delete confirmation
		document.querySelectorAll(".delete-role").forEach((button) => {
			button.addEventListener("click", (e) => this.handleDelete(e));
		});

		// Permission checkboxes
		document
			.querySelectorAll('input[name="permissions[]"]')
			.forEach((checkbox) => {
				checkbox.addEventListener("change", () => this.updatePermissionCount());
			});
	}

	initializeComponents() {
		// Initialize DataTables if present
		const rolesTable = document.getElementById("rolesTable");
		if (rolesTable && typeof DataTableHelper !== "undefined") {
			// Use the DataTable helper for consistent styling
			this.dataTable = DataTableHelper.createAdminTable("rolesTable", {
				columns: [
					{ select: [0], sortable: false }, // ID column
					{ select: [1], sortable: true }, // Name column
					{ select: [2], sortable: true }, // Description column
					{ select: [3], sortable: true }, // Users column
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

			timeout = setTimeout(() => {
				this.checkNameAvailability(name, input, feedback);
			}, 500);
		});
	}

	async checkNameAvailability(name, input, feedback) {
		try {
			const formData = new FormData();
			formData.append("name", name);

			if (input.dataset.excludeId) {
				formData.append("exclude_id", input.dataset.excludeId);
			}

			const response = await fetch(baseUrl + "/admin/roles/check_role_name", {
				method: "POST",
				body: formData,
				headers: {
					"X-Requested-With": "XMLHttpRequest",
				},
			});

			const data = await response.json();

			if (data.available) {
				this.showValid(input, feedback, "Role name is available");
			} else {
				this.showInvalid(input, feedback, "Role name already exists");
			}
		} catch (error) {
			console.error("Error checking role name:", error);
		}
	}

	setupFormValidation(form) {
		form.addEventListener("submit", (e) => {
			if (!this.validateForm(form)) {
				e.preventDefault();
				return false;
			}
		});
	}

	validateForm(form) {
		const permissions = form.querySelectorAll(
			'input[name="permissions[]"]:checked'
		);

		if (permissions.length === 0) {
			this.showAlert(
				"Please select at least one permission for this role.",
				"warning"
			);
			return false;
		}

		return true;
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
		const roleId = button.dataset.id;
		const roleName = button.dataset.name;

		if (
			confirm(
				`Are you sure you want to delete the role "${roleName}"? This action cannot be undone.`
			)
		) {
			window.location.href = baseUrl + `/admin/roles/delete/${roleId}`;
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

	// Load permissions for a role
	async loadRolePermissions(roleId) {
		const data = await this.getRolePermissions(roleId);

		// Clear all checkboxes first
		document
			.querySelectorAll('input[name="permissions[]"]')
			.forEach((checkbox) => {
				checkbox.checked = false;
			});

		// Check the permissions that belong to this role
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
}

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
	new RolesManager();
});

// Export for use in other modules
if (typeof module !== "undefined" && module.exports) {
	module.exports = RolesManager;
}

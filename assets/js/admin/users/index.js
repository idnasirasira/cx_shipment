/**
 * User Management JavaScript
 *
 * Handles jQuery DataTables initialization and user management interactions
 *
 * @author CX Shipment System
 * @version 1.0
 */

$(document).ready(function () {
	"use strict";

	// Initialize jQuery DataTable using global function
	initializeDataTable("usersTable", {
		order: [[8, "desc"]], // Sort by created date descending by default
		columnDefs: [
			{
				targets: [0, 1, 9], // ID, Profile, Actions columns
				orderable: false,
				searchable: false,
			},
			{
				targets: [6], // Status column
				orderable: true,
				searchable: true,
			},
			{
				targets: [7], // Last Login column
				orderable: true,
				searchable: false,
			},
		],
		language: {
			search: "Search users:",
			lengthMenu: "Show _MENU_ users per page",
			info: "Showing _START_ to _END_ of _TOTAL_ users",
			infoEmpty: "Showing 0 to 0 of 0 users",
			infoFiltered: "(filtered from _MAX_ total users)",
			emptyTable: "No users found",
			zeroRecords: "No matching users found",
		},
	});

	// Initialize alerts auto-hide
	initializeAlerts();
});

/**
 * Delete user confirmation
 *
 * @param {number} userId - User ID to delete
 * @param {string} username - Username for confirmation message
 */
function deleteUser(userId, username) {
	showConfirmationModal(
		"deleteModal",
		"Delete User",
		`Are you sure you want to delete user "${username}"? This action cannot be undone.`,
		`${baseUrl}admin/users/destroy/${userId}`,
		"Delete User",
		"btn-danger"
	);
}

/**
 * Toggle user status confirmation
 *
 * @param {number} userId - User ID to toggle status
 */
function toggleUserStatus(userId) {
	// Get current status from the button
	const button = event.target.closest("button");
	const isCurrentlyActive = button.classList.contains("btn-outline-secondary");

	if (isCurrentlyActive) {
		showConfirmationModal(
			"statusModal",
			"Deactivate User",
			"Are you sure you want to deactivate this user? They will not be able to log in until reactivated.",
			`${baseUrl}admin/users/toggle_status/${userId}`,
			"Deactivate User",
			"btn-warning"
		);
	} else {
		showConfirmationModal(
			"statusModal",
			"Activate User",
			"Are you sure you want to activate this user? They will be able to log in immediately.",
			`${baseUrl}admin/users/toggle_status/${userId}`,
			"Activate User",
			"btn-success"
		);
	}
}

// Export functions for global access
window.deleteUser = deleteUser;
window.toggleUserStatus = toggleUserStatus;

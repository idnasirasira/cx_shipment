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

	var handleModalEdit = function () {
		$("#editModal").on("show.bs.modal", function (e) {
			var modal = $(this);
			var $btnTrigger = $(e.relatedTarget);

			let url = $btnTrigger.attr("href");

			fetch(url)
				.then((res) => res.text())
				.then((html) => {
					modal.find(".modal-content").html(html);
				});
		});
		// Todo
	};

	var deleteModeal = function deleteUser(userId, username) {
		showConfirmationModal(
			"deleteModal",
			"Delete User",
			`Are you sure you want to delete user "${username}"? This action cannot be undone.`,
			`${baseUrl}admin/users/destroy/${userId}`,
			"Delete User",
			"btn-danger"
		);
	};

	deleteModeal();

	handleModalEdit();

	// Initialize alerts auto-hide
	initializeAlerts();
});

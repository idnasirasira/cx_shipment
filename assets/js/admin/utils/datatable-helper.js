/**
 * DataTable Helper Utility
 *
 * Provides reusable functions for simpleDataTables with Bootstrap 5 styling
 *
 * @author CX Shipment System
 * @version 1.0
 */

class DataTableHelper {
	constructor(tableId, options = {}) {
		this.tableId = tableId;
		this.table = null;
		this.options = {
			searchable: true,
			fixedHeight: true,
			perPage: 10,
			columns: [],
			...options,
		};

		this.init();
	}

	init() {
		const tableElement = document.getElementById(this.tableId);
		if (!tableElement || typeof simpleDatatables === "undefined") {
			console.warn(
				`DataTable ${this.tableId} not found or simpleDatatables not loaded`
			);
			return;
		}
		console.log(this.options.columns.columns);
		// Initialize DataTable
		this.table = new simpleDatatables.DataTable(
			`#${this.tableId}`,
			this.options
		);

		// Apply Bootstrap 5 styling
		this.applyBootstrapStyling();

		// Bind events
		this.bindEvents();
	}

	applyBootstrapStyling() {
		if (!this.table) return;

		// Move "per page dropdown" selector element out of label
		// to make it work with bootstrap 5. Add bs5 classes.
		this.adaptPageDropdown();

		// Add bs5 classes to pagination elements
		this.adaptPagination();
	}

	adaptPageDropdown() {
		if (!this.table || !this.table.wrapper) return;

		console.log(this.table.wrapper);
		const dropdown = this.table.wrapper.querySelector(".dataTable-dropdown");

		const selector = dropdown.querySelector(".dataTable-selector");

		if (dropdown) {
			dropdown.prepend(selector);
		}

		if (selector) {
			selector.classList.add("form-select");
		}
	}

	adaptPagination() {
		if (!this.table || !this.table.wrapper) return;

		const paginations = this.table.wrapper.querySelectorAll(
			"ul.dataTable-pagination-list"
		);

		for (const pagination of paginations) {
			pagination.classList.add(...["pagination", "pagination-primary"]);
		}

		const paginationLis = this.table.wrapper.querySelectorAll(
			"ul.dataTable-pagination-list li"
		);

		for (const paginationLi of paginationLis) {
			paginationLi.classList.add("page-item");
		}

		const paginationLinks = this.table.wrapper.querySelectorAll(
			"ul.dataTable-pagination-list li a"
		);

		for (const paginationLink of paginationLinks) {
			paginationLink.classList.add("page-link");
		}
	}

	bindEvents() {
		if (!this.table) return;

		const refreshPagination = () => {
			this.adaptPagination();
		};

		// Patch "per page dropdown" and pagination after table rendered
		this.table.on("datatable.init", () => {
			this.adaptPageDropdown();
			refreshPagination();
		});

		this.table.on("datatable.update", refreshPagination);
		this.table.on("datatable.sort", refreshPagination);

		// Re-patch pagination after the page was changed
		this.table.on("datatable.page", () => {
			this.adaptPagination();
		});
	}

	// Public methods for external access
	getTable() {
		return this.table;
	}

	refresh() {
		if (this.table) {
			this.table.refresh();
		}
	}

	destroy() {
		if (this.table) {
			this.table.destroy();
		}
	}

	// Static method to create DataTable with default options
	static create(tableId, options = {}) {
		return new DataTableHelper(tableId, options);
	}

	// Static method to create DataTable with common admin table options
	static createAdminTable(tableId, options = {}) {
		const defaultOptions = {
			searchable: true,
			fixedHeight: true,
			perPage: 10,
			columns: [
				{ select: [0], sortable: false }, // ID column
				{ select: [1], sortable: true }, // Name column
				{ select: [2], sortable: true }, // Description column
				{ select: [3], sortable: true }, // Status/Count column
				{ select: [4], sortable: true }, // Created column
				{ select: [5], sortable: false }, // Actions column
			],
		};

		return new DataTableHelper(tableId, { ...defaultOptions, ...options });
	}

	// Static method to create DataTable with custom column configuration
	static createCustomTable(tableId, columns = [], options = {}) {
		const defaultOptions = {
			searchable: true,
			fixedHeight: true,
			perPage: 10,
			columns: columns,
		};

		return new DataTableHelper(tableId, { ...defaultOptions, ...options });
	}
}

// Export for use in other modules
if (typeof module !== "undefined" && module.exports) {
	module.exports = DataTableHelper;
}

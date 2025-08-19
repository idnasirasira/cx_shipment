/**
 * DataTable Helper Usage Examples
 *
 * Demonstrates how to use the DataTableHelper for different table scenarios
 *
 * @author CX Shipment System
 * @version 1.0
 */

// Example 1: Basic admin table (like roles/permissions)
function initializeBasicAdminTable() {
	const tableId = "basicTable";
	const dataTable = DataTableHelper.createAdminTable(tableId, {
		columns: [
			{ select: [0], sortable: false }, // ID column
			{ select: [1], sortable: true }, // Name column
			{ select: [2], sortable: true }, // Description column
			{ select: [3], sortable: true }, // Status column
			{ select: [4], sortable: true }, // Created column
			{ select: [5], sortable: false }, // Actions column
		],
	});

	return dataTable;
}

// Example 2: Custom table with specific columns
function initializeCustomTable() {
	const tableId = "customTable";
	const columns = [
		{ select: [0], sortable: false }, // Checkbox column
		{ select: [1], sortable: true }, // Name column
		{ select: [2], sortable: true }, // Email column
		{ select: [3], sortable: true }, // Phone column
		{ select: [4], sortable: true }, // Status column
		{ select: [5], sortable: false }, // Actions column
	];

	const dataTable = DataTableHelper.createCustomTable(tableId, columns, {
		perPage: 25,
		searchable: true,
		fixedHeight: false,
	});

	return dataTable;
}

// Example 3: Simple table with minimal configuration
function initializeSimpleTable() {
	const tableId = "simpleTable";
	const dataTable = DataTableHelper.create(tableId, {
		searchable: true,
		perPage: 5,
		columns: [
			{ select: [0], sortable: true }, // All columns sortable
			{ select: [1], sortable: true },
			{ select: [2], sortable: true },
		],
	});

	return dataTable;
}

// Example 4: Table with custom styling options
function initializeStyledTable() {
	const tableId = "styledTable";
	const dataTable = DataTableHelper.create(tableId, {
		searchable: true,
		fixedHeight: true,
		perPage: 15,
		columns: [
			{ select: [0], sortable: false }, // ID
			{ select: [1], sortable: true }, // Name
			{ select: [2], sortable: true }, // Category
			{ select: [3], sortable: true }, // Price
			{ select: [4], sortable: true }, // Stock
			{ select: [5], sortable: false }, // Actions
		],
	});

	// Access the table instance for additional customization
	const tableInstance = dataTable.getTable();

	// Example: Add custom event listeners
	if (tableInstance) {
		tableInstance.on("datatable.selectrow", (row) => {
			console.log("Row selected:", row);
		});
	}

	return dataTable;
}

// Example 5: Table with dynamic data refresh
function initializeDynamicTable() {
	const tableId = "dynamicTable";
	const dataTable = DataTableHelper.createAdminTable(tableId);

	// Example function to refresh table data
	function refreshTableData() {
		// Fetch new data from server
		fetch("/api/data")
			.then((response) => response.json())
			.then((data) => {
				// Update table data
				const tableInstance = dataTable.getTable();
				if (tableInstance) {
					tableInstance.insert(data);
					dataTable.refresh();
				}
			})
			.catch((error) => {
				console.error("Error refreshing table:", error);
			});
	}

	// Example: Refresh data every 30 seconds
	setInterval(refreshTableData, 30000);

	return dataTable;
}

// Example 6: Table with export functionality
function initializeExportableTable() {
	const tableId = "exportableTable";
	const dataTable = DataTableHelper.createAdminTable(tableId);

	// Add export button functionality
	const exportBtn = document.getElementById("exportBtn");
	if (exportBtn) {
		exportBtn.addEventListener("click", () => {
			const tableInstance = dataTable.getTable();
			if (tableInstance) {
				// Export current table data
				const data = tableInstance.data;
				exportToCSV(data, "table_export.csv");
			}
		});
	}

	return dataTable;
}

// Helper function for CSV export
function exportToCSV(data, filename) {
	const csvContent = convertToCSV(data);
	const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
	const link = document.createElement("a");

	if (link.download !== undefined) {
		const url = URL.createObjectURL(blob);
		link.setAttribute("href", url);
		link.setAttribute("download", filename);
		link.style.visibility = "hidden";
		document.body.appendChild(link);
		link.click();
		document.body.removeChild(link);
	}
}

function convertToCSV(data) {
	// Implementation for converting data to CSV format
	// This is a simplified example
	return data.map((row) => row.join(",")).join("\n");
}

// Example 7: Table with row selection
function initializeSelectableTable() {
	const tableId = "selectableTable";
	const dataTable = DataTableHelper.create(tableId, {
		searchable: true,
		perPage: 10,
		columns: [
			{ select: [0], sortable: false }, // Checkbox
			{ select: [1], sortable: true }, // Name
			{ select: [2], sortable: true }, // Email
			{ select: [3], sortable: false }, // Actions
		],
	});

	// Add row selection functionality
	const tableInstance = dataTable.getTable();
	if (tableInstance) {
		tableInstance.on("datatable.selectrow", (row) => {
			// Handle row selection
			console.log("Selected row:", row);
		});
	}

	return dataTable;
}

// Example 8: Table with custom filters
function initializeFilterableTable() {
	const tableId = "filterableTable";
	const dataTable = DataTableHelper.createAdminTable(tableId);

	// Add custom filter functionality
	const filterInput = document.getElementById("customFilter");
	if (filterInput) {
		filterInput.addEventListener("input", (e) => {
			const filterValue = e.target.value.toLowerCase();
			const tableInstance = dataTable.getTable();

			if (tableInstance) {
				// Apply custom filter
				tableInstance.search(filterValue);
			}
		});
	}

	return dataTable;
}

// Example 9: Table with pagination controls
function initializePaginationTable() {
	const tableId = "paginationTable";
	const dataTable = DataTableHelper.create(tableId, {
		searchable: true,
		perPage: 5,
		columns: [
			{ select: [0], sortable: true }, // ID
			{ select: [1], sortable: true }, // Name
			{ select: [2], sortable: true }, // Description
		],
	});

	// Add custom pagination controls
	const tableInstance = dataTable.getTable();
	if (tableInstance) {
		// Example: Go to specific page
		function goToPage(pageNumber) {
			tableInstance.page(pageNumber);
		}

		// Example: Change items per page
		function changePerPage(itemsPerPage) {
			tableInstance.perPage = itemsPerPage;
			tableInstance.refresh();
		}

		// Make functions globally available
		window.goToPage = goToPage;
		window.changePerPage = changePerPage;
	}

	return dataTable;
}

// Example 10: Table with sorting indicators
function initializeSortableTable() {
	const tableId = "sortableTable";
	const dataTable = DataTableHelper.create(tableId, {
		searchable: true,
		perPage: 10,
		columns: [
			{ select: [0], sortable: true }, // All columns sortable
			{ select: [1], sortable: true },
			{ select: [2], sortable: true },
			{ select: [3], sortable: true },
		],
	});

	const tableInstance = dataTable.getTable();
	if (tableInstance) {
		// Add custom sorting indicators
		tableInstance.on("datatable.sort", (column, direction) => {
			console.log(`Sorted column ${column} in ${direction} direction`);

			// Example: Update UI to show sort direction
			const headers = document.querySelectorAll(`#${tableId} th`);
			headers.forEach((header, index) => {
				header.classList.remove("sort-asc", "sort-desc");
				if (index === column) {
					header.classList.add(direction === "asc" ? "sort-asc" : "sort-desc");
				}
			});
		});
	}

	return dataTable;
}

// Export all examples for use in other modules
if (typeof module !== "undefined" && module.exports) {
	module.exports = {
		initializeBasicAdminTable,
		initializeCustomTable,
		initializeSimpleTable,
		initializeStyledTable,
		initializeDynamicTable,
		initializeExportableTable,
		initializeSelectableTable,
		initializeFilterableTable,
		initializePaginationTable,
		initializeSortableTable,
	};
}

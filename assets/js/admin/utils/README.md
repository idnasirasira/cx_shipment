# DataTable Helper Utility

A reusable JavaScript utility for creating and managing simpleDataTables with consistent Bootstrap 5 styling across the CX Shipment Management System.

## Features

- ✅ **Consistent Styling**: Automatic Bootstrap 5 integration
- ✅ **Reusable**: Single implementation for all tables
- ✅ **Flexible**: Multiple configuration options
- ✅ **Event Handling**: Built-in event management
- ✅ **Pagination**: Bootstrap-styled pagination controls
- ✅ **Search**: Integrated search functionality
- ✅ **Sorting**: Configurable column sorting

## Quick Start

### 1. Include the Helper Script

Add the DataTable helper to your controller:

```php
// In your controller constructor
$this->pageScripts = [
    'assets/js/admin/utils/datatable-helper.js',
    'assets/js/admin/your-feature/index.js'
];
```

### 2. Basic Usage

```javascript
// Initialize a basic admin table
const dataTable = DataTableHelper.createAdminTable("myTableId");

// Or with custom options
const dataTable = DataTableHelper.createAdminTable("myTableId", {
	perPage: 25,
	searchable: true,
	columns: [
		{ select: [0], sortable: false }, // ID column
		{ select: [1], sortable: true }, // Name column
		{ select: [2], sortable: true }, // Description column
		{ select: [3], sortable: true }, // Status column
		{ select: [4], sortable: true }, // Created column
		{ select: [5], sortable: false }, // Actions column
	],
});
```

## API Reference

### DataTableHelper.create(tableId, options)

Creates a DataTable with custom options.

**Parameters:**

- `tableId` (string): The ID of the table element
- `options` (object): Configuration options

**Options:**

- `searchable` (boolean): Enable search functionality (default: true)
- `fixedHeight` (boolean): Use fixed height (default: true)
- `perPage` (number): Items per page (default: 10)
- `columns` (array): Column configuration array

### DataTableHelper.createAdminTable(tableId, options)

Creates a DataTable with standard admin table configuration.

**Parameters:**

- `tableId` (string): The ID of the table element
- `options` (object): Additional configuration options

**Default Admin Configuration:**

- 6 columns (ID, Name, Description, Status, Created, Actions)
- Searchable and sortable
- Fixed height
- 10 items per page

### DataTableHelper.createCustomTable(tableId, columns, options)

Creates a DataTable with custom column configuration.

**Parameters:**

- `tableId` (string): The ID of the table element
- `columns` (array): Column configuration array
- `options` (object): Additional configuration options

## Column Configuration

```javascript
const columns = [
	{ select: [0], sortable: false }, // ID column (not sortable)
	{ select: [1], sortable: true }, // Name column (sortable)
	{ select: [2], sortable: true }, // Description column (sortable)
	{ select: [3], sortable: false }, // Actions column (not sortable)
];
```

## Usage Examples

### Example 1: Basic Admin Table

```javascript
class MyManager {
	initializeComponents() {
		const dataTable = DataTableHelper.createAdminTable("myTableId");
	}
}
```

### Example 2: Custom Table Configuration

```javascript
class MyManager {
	initializeComponents() {
		const dataTable = DataTableHelper.create("myTableId", {
			searchable: true,
			perPage: 25,
			columns: [
				{ select: [0], sortable: false }, // Checkbox
				{ select: [1], sortable: true }, // Name
				{ select: [2], sortable: true }, // Email
				{ select: [3], sortable: false }, // Actions
			],
		});
	}
}
```

### Example 3: Accessing Table Instance

```javascript
class MyManager {
	initializeComponents() {
		const dataTable = DataTableHelper.createAdminTable("myTableId");

		// Get the underlying table instance
		const tableInstance = dataTable.getTable();

		// Add custom event listeners
		if (tableInstance) {
			tableInstance.on("datatable.selectrow", (row) => {
				console.log("Row selected:", row);
			});
		}
	}
}
```

### Example 4: Table with Export Functionality

```javascript
class MyManager {
	initializeComponents() {
		this.dataTable = DataTableHelper.createAdminTable("myTableId");

		// Add export button
		const exportBtn = document.getElementById("exportBtn");
		if (exportBtn) {
			exportBtn.addEventListener("click", () => {
				this.exportTableData();
			});
		}
	}

	exportTableData() {
		const tableInstance = this.dataTable.getTable();
		if (tableInstance) {
			// Export logic here
			console.log("Exporting table data...");
		}
	}
}
```

## HTML Structure

Your table HTML should follow this structure:

```html
<table id="myTableId" class="table table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Description</th>
			<th>Status</th>
			<th>Created</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>1</td>
			<td>Example Name</td>
			<td>Example Description</td>
			<td><span class="badge bg-success">Active</span></td>
			<td>2024-01-01</td>
			<td>
				<div class="btn-group" role="group">
					<button class="btn btn-sm btn-outline-primary">View</button>
					<button class="btn btn-sm btn-outline-warning">Edit</button>
				</div>
			</td>
		</tr>
	</tbody>
</table>
```

## Bootstrap 5 Integration

The helper automatically applies Bootstrap 5 classes to:

- **Pagination**: `.pagination`, `.pagination-primary`, `.page-item`, `.page-link`
- **Dropdown**: `.form-select` for the "per page" selector
- **Table**: Works with `.table`, `.table-striped`, `.table-hover` classes

## Event Handling

The helper automatically handles these events:

- `datatable.init`: When table is initialized
- `datatable.update`: When table data is updated
- `datatable.sort`: When columns are sorted
- `datatable.page`: When pagination changes

## Methods

### Instance Methods

- `getTable()`: Returns the underlying simpleDataTable instance
- `refresh()`: Refreshes the table display
- `destroy()`: Destroys the table instance

### Static Methods

- `create(tableId, options)`: Create with custom options
- `createAdminTable(tableId, options)`: Create with admin defaults
- `createCustomTable(tableId, columns, options)`: Create with custom columns

## Migration from Direct simpleDataTable Usage

### Before (Old Way)

```javascript
// Old way - direct simpleDataTable usage
const table = new simpleDatatables.DataTable("#myTable", {
	searchable: true,
	fixedHeight: true,
	perPage: 10,
});

// Manual Bootstrap styling
function adaptPagination() {
	// ... lots of manual styling code
}
```

### After (New Way)

```javascript
// New way - using DataTableHelper
const dataTable = DataTableHelper.createAdminTable("myTable");
// Bootstrap styling is automatically applied!
```

## Best Practices

1. **Always use the helper**: Don't create simpleDataTables directly
2. **Consistent naming**: Use descriptive table IDs
3. **Column configuration**: Define sortable/non-sortable columns explicitly
4. **Event handling**: Use the table instance for custom events
5. **Responsive design**: Ensure your table HTML is responsive

## Troubleshooting

### Table not initializing

- Check if the table element exists with the correct ID
- Ensure simpleDatatables library is loaded
- Verify the DataTableHelper script is included

### Styling issues

- Ensure Bootstrap 5 CSS is loaded
- Check that table has proper Bootstrap classes
- Verify the helper script is loaded before your custom scripts

### Performance issues

- Use appropriate `perPage` values
- Consider `fixedHeight: false` for large datasets
- Implement server-side pagination for very large datasets

## Examples

See `datatable-examples.js` for comprehensive usage examples including:

- Basic admin tables
- Custom configurations
- Dynamic data refresh
- Export functionality
- Row selection
- Custom filters
- Pagination controls
- Sorting indicators

## Support

For issues or questions about the DataTable helper, refer to:

1. The examples in `datatable-examples.js`
2. The simpleDataTables documentation
3. Bootstrap 5 documentation for styling
4. The existing implementation in roles and permissions modules

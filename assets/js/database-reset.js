// Get base URL from meta tag or default to current location
const baseUrl =
	document.querySelector('meta[name="base-url"]')?.getAttribute("content") ||
	window.location.origin + "/";

document.addEventListener("DOMContentLoaded", function () {
	const confirmationInput = document.getElementById("confirmation");
	const resetBtn = document.getElementById("resetBtn");
	const resetForm = document.getElementById("resetForm");
	const resultsModal = new bootstrap.Modal(
		document.getElementById("resultsModal")
	);
	const resultsContent = document.getElementById("resultsContent");
	const resultsModalLabel = document.getElementById("resultsModalLabel");

	// Enable/disable reset button based on confirmation input
	confirmationInput.addEventListener("input", function () {
		resetBtn.disabled = this.value !== "RESET_DATABASE";
	});

	// Handle form submission
	resetForm.addEventListener("submit", function (e) {
		e.preventDefault();

		if (confirmationInput.value !== "RESET_DATABASE") {
			alert('Please type "RESET_DATABASE" to confirm this action.');
			return;
		}

		// Show loading state
		resetBtn.disabled = true;
		resetBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Resetting...';

		// Prepare form data
		const formData = new FormData();
		formData.append("confirmation", confirmationInput.value);

		// Send AJAX request
		fetch(baseUrl + "admin/database/reset", {
			method: "POST",
			body: formData,
		})
			.then((response) => response.json())
			.then((data) => {
				showResults(data);
			})
			.catch((error) => {
				console.error("Error:", error);
				showResults({
					success: false,
					message: "An error occurred while processing the request.",
				});
			})
			.finally(() => {
				// Reset button state
				resetBtn.disabled = false;
				resetBtn.innerHTML = '<i class="bi bi-trash"></i> Reset Database';
			});
	});

	function showResults(data) {
		let content = "";

		if (data.success) {
			resultsModalLabel.textContent = "Reset Successful";
			content = `
                <div class="alert alert-success">
                    <h6 class="alert-heading">✅ ${data.message}</h6>
                </div>
            `;

			if (data.details && data.details.length > 0) {
				content += `
                    <h6>Execution Details:</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>File</th>
                                    <th>Status</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

				data.details.forEach((detail) => {
					const statusClass =
						detail.status === "success" ? "success" : "danger";
					const statusIcon = detail.status === "success" ? "✅" : "❌";
					const details = detail.statements
						? `${detail.statements} statements executed`
						: detail.error || "N/A";

					content += `
                        <tr>
                            <td><code>${detail.file}</code></td>
                            <td><span class="badge bg-${statusClass}">${statusIcon} ${detail.status}</span></td>
                            <td>${details}</td>
                        </tr>
                    `;
				});

				content += `
                            </tbody>
                        </table>
                    </div>
                `;
			}
		} else {
			resultsModalLabel.textContent = "Reset Failed";
			content = `
                <div class="alert alert-danger">
                    <h6 class="alert-heading">❌ ${data.message}</h6>
                </div>
            `;

			if (data.details && data.details.length > 0) {
				content += `
                    <h6>Error Details:</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>File</th>
                                    <th>Status</th>
                                    <th>Error</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

				data.details.forEach((detail) => {
					if (detail.status === "error") {
						content += `
                            <tr>
                                <td><code>${detail.file}</code></td>
                                <td><span class="badge bg-danger">❌ error</span></td>
                                <td><small class="text-danger">${detail.error}</small></td>
                            </tr>
                        `;
					}
				});

				content += `
                            </tbody>
                        </table>
                    </div>
                `;
			}
		}

		resultsContent.innerHTML = content;
		resultsModal.show();

		// If successful, refresh the page after a delay
		if (data.success) {
			setTimeout(() => {
				window.location.reload();
			}, 3000);
		}
	}
});

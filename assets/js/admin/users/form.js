/**
 * User Form JavaScript
 *
 * Handles form interactions and validation for create/edit user forms
 *
 * @author CX Shipment System
 * @version 1.0
 */

$(document).ready(function () {
	"use strict";

	// Password toggle functionality
	initializePasswordToggles();

	// Form validation
	initializeFormValidation();

	// Auto-hide alerts
	initializeAlerts();
});

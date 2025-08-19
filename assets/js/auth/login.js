$(document).ready(function () {
	const Login = {
		init: function () {
			this.handleSubmit();
			const toggle = document.querySelector(".toggle"),
				input = document.querySelector("input");

			toggle.addEventListener("click", () => {
				if (input.type === "password") {
					input.type = "text";
					toggle.classList.replace("bi-eye-slash, bi-eye");
				} else {
					input.type = "password";
					toggle.classList.replace("bi-eye, bi-eye-slash");
				}
			});
		},

		handleSubmit: function () {
			console.log("handleSubmit");
		},
	};

	Login.init();
});

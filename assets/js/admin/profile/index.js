$(document).ready(function () {
	$("#resetButton").on("click", function () {
		// Redirect ke halaman Account Security
		window.location.href = '<?= base_url("admin/account_security") ?>';
	});
	// Fungsi untuk menampilkan form upload ketika gambar di klik
	$(".profile-picture-container").on("click", function () {
		$("#profile-picture-form").toggle();
	});

	// Event listener untuk input file
	$("#profile_picture").on("change", function () {
		const file = this.files[0];
		if (file) {
			// Validasi file (ukuran dan tipe)
			const allowedTypes = [
				"image/jpeg",
				"image/png",
				"image/gif",
				"image/webp",
			];
			const maxSize = 2 * 1024 * 1024; // 2MB

			if (!allowedTypes.includes(file.type)) {
				alert(
					"Tipe file tidak diizinkan. Silakan unggah file JPG, PNG, GIF, atau WebP."
				);
				return;
			}

			if (file.size > maxSize) {
				alert("Ukuran file terlalu besar. Ukuran maksimum adalah 2MB.");
				return;
			}

			// Buat FormData untuk mengirim data dan file
			const formData = new FormData();
			formData.append("profile_picture", file);

			// Kirim permintaan AJAX untuk mengunggah gambar
			$.ajax({
				url: '<?= base_url("admin/profile/update") ?>', // Pastikan URL ini sesuai dengan controller Anda
				type: "POST",
				data: formData,
				processData: false, // Penting untuk FormData
				contentType: false, // Penting untuk FormData
				dataType: "json",
				beforeSend: function () {
					// Tampilkan loader atau pesan "sedang mengunggah"
					console.log("Mengunggah...");
					// Bisa tambahkan kode untuk menampilkan spinner
				},
				success: function (response) {
					if (response.status === "success") {
						// Perbarui gambar profil di halaman
						$(".profile-picture").attr("src", response.new_image_url);
						// Perbarui gambar profil di navbar
						$(".user-img-profile").attr("src", response.new_image_url);
						// Sembunyikan form
						$("#profile-picture-form").hide();
						alert(response.message);
						console.log("Berhasil diperbarui");
					} else {
						// Tampilkan pesan error dari server
						alert("Error: " + response.message);
					}
				},
				error: function (xhr, status, error) {
					// Tampilkan pesan error umum
					alert("Terjadi kesalahan saat mengunggah. Mohon coba lagi.");
					console.error("Error AJAX: ", error);
				},
			});
		}
	});

	// Menangani form update profil utama
	$(".form").on("submit", function (e) {
		// Form ini akan dikelola oleh Parsley.js, jadi tidak perlu mencegah default di sini kecuali ada kebutuhan khusus
	});

	// Tambahkan event listener untuk tombol "Reset"
	$("#resetButton").on("click", function () {
		// Redirect ke halaman Account Security
		window.location.href = '<?= base_url("admin/account_security") ?>';
	});
});

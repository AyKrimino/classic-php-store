window.addEventListener("DOMContentLoaded", () => {
	const sliders = document.querySelectorAll(".product-card .slider");

	sliders.forEach((slider) => {
		const images = [...slider.querySelectorAll(".product-img")].filter(
			(image) => image.currentSrc !== ""
		);

		if (images.length) {
			images[0].hidden = false;
		}

		setInterval(() => {
			for (let i = 0; i < images.length; i++) {
				if (!images[i].hidden) {
					images[i].hidden = true;
					images[(i + 1) % images.length].hidden = false;
					break; 
				}
			}
		}, 3000);
	});
});

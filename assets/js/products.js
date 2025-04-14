const images = document.querySelectorAll(".product-img");

function changeImage(images) {
	for (let i = 0; i < images.length; i++) {
		if (!images[i].hidden) {
			images[i].hidden = true;
			images[(i + 1) % images.length].hidden = false;
			return;
		}
	}
}

setInterval(() => changeImage(images), 3000);

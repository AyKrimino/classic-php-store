document.addEventListener("DOMContentLoaded", function() {
	document.querySelectorAll(".product-section").forEach(section => {
		const mainImg = section.querySelector(".main-image img");
		const thumbs  = section.querySelectorAll(".slider-section img");

		if (thumbs.length) {
			thumbs[0].classList.add("selected");
			mainImg.src = thumbs[0].src;
		}

		thumbs.forEach(thumb => {
			thumb.addEventListener("click", () => {
				mainImg.src = thumb.src;
				thumbs.forEach(t => t.classList.remove("selected"));
				thumb.classList.add("selected");
			});
		});
	});
});

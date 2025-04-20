document.addEventListener("DOMContentLoaded", function() {
	const mainImg = document.querySelector(".main-image img");
	const thumbs  = document.querySelectorAll(".slider-section img");

	if (thumbs.length) {
		thumbs[0].classList.add("selected");
	}

	thumbs.forEach(thumb => {
		thumb.addEventListener("click", () => {
			mainImg.src = thumb.src;
			thumbs.forEach(t => t.classList.remove("selected"));
			thumb.classList.add("selected");
		});
	});
});

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

document.addEventListener("DOMContentLoaded", () => {
  const wrapper = document.querySelector(".related-products-wrapper");
  const prevBtn = document.getElementById("related-prev");
  const nextBtn = document.getElementById("related-next");

  const scrollAmount = wrapper.clientWidth * 0.7;

  prevBtn.addEventListener("click", () => {
    wrapper.scrollBy({ left: -scrollAmount, behavior: "smooth" });
  });

  nextBtn.addEventListener("click", () => {
    wrapper.scrollBy({ left: scrollAmount, behavior: "smooth" });
  });
});

const images = [
	"./assets/images/book1.jpg",
	"./assets/images/kitchen1.jpg",
	"./assets/images/kitchen2.jpg",
	"./assets/images/still-life-skincare-products.jpg",
	"./assets/images/toys1.jpg"
];

let currentIndex = 0;

const sliderImg = document.getElementById("slider-img");
const dots = document.querySelectorAll(".slider-dots .dot");

function updateDots() {
	dots.forEach((dot, index) => {
		dot.classList.toggle("active", index === currentIndex);
	});
}

function changeImage() {
	currentIndex = (currentIndex + 1) % images.length;

	sliderImg.src = images[currentIndex];

	updateDots();
}

setInterval(changeImage, 3000); 

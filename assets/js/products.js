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

const editButtons = document.querySelectorAll(".edit");
const createButton = document.getElementById("create");
const updateButton = document.getElementById("update");
const nameInput = document.getElementById("name");
const descriptionInput = document.getElementById("description");
const companyInput = document.getElementById("company");
const priceInput = document.getElementById("price");
const subcategoryInput = document.getElementById("subcategory");
const stockInput = document.getElementById("stock");
const hiddenInput = document.getElementById("product_id");

editButtons.forEach(function(editButton) {
	editButton.addEventListener("click", function(e) {
		const productID = this.dataset.productId;
		const productName = this.dataset.name;
		const productDescription = this.dataset.description;
		const productCompany = this.dataset.company;
		const productPrice = this.dataset.price;
		const productSubCategoryID = this.dataset.subcategoryId;
		const productStock = this.dataset.stock;

		hiddenInput.value = productID;
		nameInput.value = productName;
		descriptionInput.value = productDescription;
		companyInput.value = productCompany;
		priceInput.value = productPrice;
		for (const option of subcategoryInput.options) {
			if (option.value == productSubCategoryID) {
				option.selected = "selected";
			}
		}
		stockInput.value = productStock;

		updateButton.hidden = false;
		createButton.hidden = true;
	});
});

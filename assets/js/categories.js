const editButtons = document.querySelectorAll(".edit");
const addButton = document.getElementById("add");
const updateButton = document.getElementById("update");
const nameInput = document.getElementById("name");
const descriptionInput = document.getElementById("description");
const hiddenInput = document.getElementById("category_id");

editButtons.forEach(function(editButton) {
	editButton.addEventListener("click", function(e) {
		const categoryID = this.dataset.categoryId;
		const categoryName = this.dataset.name;
		const categoryDescription = this.dataset.description;

		hiddenInput.value = categoryID;
		nameInput.value = categoryName;
		descriptionInput.value = (categoryDescription === "No description") ? "" : categoryDescription;
		updateButton.hidden = false;
		addButton.hidden = true;
	});
});

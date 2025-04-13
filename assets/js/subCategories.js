const editButtons = document.querySelectorAll(".edit");
const addButton = document.getElementById("add");
const updateButton = document.getElementById("update");
const nameInput = document.getElementById("name");
const descriptionInput = document.getElementById("description");
const categoryInput = document.getElementById("category");
const hiddenInput = document.getElementById("subCategory_id");

editButtons.forEach(function(editButton) {
	editButton.addEventListener("click", function(e) {
		const subCategoryID = this.dataset.subCategoryId;
		const categoryID = this.dataset.categoryId;
		const subCategoryName = this.dataset.name;
		const subCategoryDescription = this.dataset.description;

		hiddenInput.value = subCategoryID;
		nameInput.value = subCategoryName;
		descriptionInput.value = (subCategoryDescription === "No description") ? "" : subCategoryDescription;
		for (const option of categoryInput.options) {
			if (option.value == categoryID) {
				option.selected = "selected";
			}
		}
		updateButton.hidden = false;
		addButton.hidden = true;
	});
});

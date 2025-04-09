const items = document.querySelectorAll(".sidebar-item");

items.forEach(item => {
	item.addEventListener("click", function() {
		items.forEach(item => {
			item.classList.remove("active");
		});
		item.classList.add("active");
	});
});

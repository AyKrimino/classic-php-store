document.getElementById('select-all')
	.addEventListener('change', function() {
		document.querySelectorAll('.row-checkbox')
			.forEach(cb => cb.checked = this.checked);
	});

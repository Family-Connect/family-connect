let toggleButton = document.querySelector('.toggleButton');
let sidebar = document.querySelector('#sidebar');
let content = document.querySelector('.content');

function toggleSidebar() {
	sidebar.classList.add("active");
	toggleButton.classList.add("active");
}

function removeToggle() {
	sidebar.classList.remove("active");
	toggleButton.classList.remove("active");
}

toggleButton.addEventListener('click', toggleSidebar);
content.addEventListener('click', removeToggle);

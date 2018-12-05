let toggleButton = document.querySelector('.toggleButton');
let sidebar = document.querySelector('#sidebar');
let content = document.querySelector('.content');
let configButtons = document.querySelector('.configButtons');

function toggleSidebar() {
	sidebar.classList.add("active");
	toggleButton.classList.add("active");
	configButtons.classList.add("active");
}

function removeToggle() {
	sidebar.classList.remove("active");
	toggleButton.classList.remove("active");
	configButtons.classList.remove("active");
}

toggleButton.addEventListener('click', toggleSidebar);
content.addEventListener('click', removeToggle);

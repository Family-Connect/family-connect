let toggleButton = document.querySelector('.toggleButton');
let sidebar = document.querySelector('#sidebar');
let content = document.querySelector('#content');
let toggled = false;

function toggleSidebar() {
	sidebar.classList.toggle("active");
	toggleButton.classList.toggle("active");
	if(toggleButton.classList.contains('active') === true){
		toggled = true;
	} else {
		toggled = false;
	}
	console.log(toggled)
}

if(toggled === true){
	content.addEventListener('click', toggleSidebar)
}


toggleButton.addEventListener("click", toggleSidebar);

console.log(toggleButton.classList.contains('active'));
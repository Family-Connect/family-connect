let signUpButton = document.querySelector('#signUpButton');
let signInButton = document.querySelector('#signInButton');
let backButton = document.querySelector('#backButton');
let backButton1 = document.querySelector('#backButton1');
let buttons = document.querySelector('.splash-background');
let signUpForm = document.querySelector('.sign-up');
let signInForm = document.querySelector('.sign-in');

function signUpFunction() {
	buttons.classList.toggle('inactive');
	signUpForm.classList.toggle('inactive');
}

function signInFunction() {
	buttons.classList.toggle('inactive');
	signInForm.classList.toggle('inactive');
}

function goBack() {
	buttons.classList.remove('inactive');
	signUpForm.classList.add('inactive');
	signInForm.classList.add('inactive');
}

signUpButton.addEventListener('click', signUpFunction);
signInButton.addEventListener('click', signInFunction);
backButton.addEventListener('click', goBack);
backButton1.addEventListener('click', goBack);


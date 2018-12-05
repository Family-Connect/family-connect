<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">


	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

	<!-- Custom CSS -->
	<link rel="stylesheet" href="css/splash.css"/>

	<!-- Custom scripts -->
	<script src="scripts/splash.js" defer></script>

	<!-- Google fonts -->
	<link href="https://fonts.googleapis.com/css?family=Libre+Franklin:500" rel="stylesheet">

</head>

<body>
	<div class="container-fluid splash-background">
		<h1>Welcome to Family Connect</h1>
		<div class="buttons">
			<button id="signUpButton">Sign Up</button>
			<button id="signInButton">Sign In</button>
		</div>
	</div>

	<div class="container-fluid row main">
		<div class="column col-md-3 sign-in inactive">
			<h2>Sign In</h2>
			<form>
				<div>
					<input type="email" id="mail" name="user_mail" placeholder="Email"/>
				</div>
				<div>
					<input id="password" name="userPassword" placeholder="Password"/>
				</div>
				<div class="form-buttons">
					<div>
						<button type="submit">Sign In</button>
					</div>
					<div>
						<button type="button" id="backButton">Back</button>
					</div>
				</div>

			</form>
		</div>

		<div class="column col-md-3 sign-up inactive">
			<h2>Sign Up</h2>
			<form>
				<div>
					<input type="email" id="userEmail" name="userEmail" placeholder="Email"/>
				</div>
				<div>
					<input type="text" id="userDisplayName" name="userDisplayName" placeholder="User Name"/>
				</div>
				<div>
					<input type="text" id="userPhoneNumber" name="userPhoneNumber" placeholder="Phone Number"/>
				</div>
				<div>
					<input id="userPassword" name="userPassword" placeholder="Password"/>
				</div>
				<div>
					<input id="userPasswordConfirm" name="userPasswordConfirm" placeholder="Confirm Password"/>
				</div>
				<div>
					<input type="text" id="familyName" name="family-name" placeholder="Family Name"/>
				</div>
				<div class="form-buttons">
					<div>
						<button type="submit">Sign In</button>
					</div>
					<div>
						<button type="button" id="backButton1">Back</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</body>



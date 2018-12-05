<?php require_once ("head-utils.php");?>

<div class="wrapper">

	<!-- Sidebar -->
	<nav id="sidebar" class="sidebar col-md-2 bg-light">
		<div class="sidebar-header">
			<h2>Family Name</h2>
		</div>

		<ul class="users">
			<li>
				<a href="#">User1</a>
			</li>
		</ul>
	</nav>

	<!-- Page Content -->
	<div id="main container-fluid">
		<!-- Buttons -->
		<div class="buttons">

			<button type="button" id="sidebarCollapse" class="btn toggleButton">
				<i class="fas fa-ellipsis-h"></i>
			</button>

			<div class="configButtons">
				<button type="button" id="plusButton" class="btn plusButton">
					<i class="fas fa-plus"></i>
				</button>

				<button type="button" id="settingsButton" class="btn settingsButton">
					<i class="fas fa-cog"></i>
				</button>
			</div>
		</div>

		<div class="content container">
			<h4>Profile</h4>
		</div>
	</div>
	<!-- View/Edit Credentials -->
	<section class="page-edit-content">
	<form class="container-fluid">
		<div class="form-group">
			<label for="nameViewEdit">Name</label>
			<input type="text" class="form-control" id="nameViewEdit" placeholder="Name">
		</div>
		<div class="form-group">
			<label for="emailViewEdit">Email</label>
			<input type="text" class="form-control" id="emailViewEdit" placeholder="Email">
		</div>
		<div class="form-group">
			<label for="UsernameViewEdit">Username</label>
			<input type="text" class="form-control" id="UsernameViewEdit" placeholder="Username">
		</div>
		<div class="form-group">
			<label for="PhoneNumberViewEdit">Phone Number</label>
			<input type="text" class="form-control" id="PhoneNumberViewEdit" placeholder="Phone Number">
		</div>
		<h6>Privilege</h6>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" disabled>
			<label class="form-check-label" for="inlineRadio1">0</label>
		</div>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
			<label class="form-check-label" for="inlineRadio2">1</label>
		</div>
		<div class="userLists">
			<div>
				<h4>Events</h4>
					<ul>
						<li>Event 1</li>
						<li>Event 2</li>
						<li>Event 3</li>
					</ul>
				<h4>Tasks</h4>
				<ul>
					<li>Task 1</li>
					<li>Task 2</li>
					<li>Task 3</li>
				</ul>
			</div>
		</div>
	</form>
	</section>

</div>
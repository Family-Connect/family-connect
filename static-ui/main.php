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


		<!-- Actual content (not sidebar) - edit below -->
			<!--Radio buttons-->
		<div class="content container">
		<div class="custom-control custom-radio custom-control-inline">
			<input type="radio" class="custom-control-input" id="task" name="defaultRadios" checked>
			<label class="custom-control-label" for="task">Task</label>
		</div>

		<div class="custom-control custom-radio custom-control-inline">
			<input type="radio" class="custom-control-input" id="event" name="defaultRadios">
			<label class="custom-control-label" for="event">Event</label>
		</div>
			<!--Check box, just me-->
			<div class="custom-control custom-checkbox mt-3">
				<input type="checkbox" class="custom-control-input" id="justMe">
				<label class="custom-control-label" for="justMe">Just Me</label>
			</div>
		</div>
		</div>
	</div>
</div>

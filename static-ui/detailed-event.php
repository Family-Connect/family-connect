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

		<!-- Actual content (not sidebar) - edit below -->

		<div class="content container-fluid">
			<div class="event-head">
				<h4>Event Name</h4>
				<h6>Event Creator</h6>
				<ul>
					<li>User</li>
					<li>User</li>
					<li>User</li>
					<li>User</li>
					<li>User</li>
					<li>User</li>
				</ul>
			</div>

			<div class="event-body row">
				<div class="event-description-comments col-6">
					<div class="event-description">
						<h4>Description</h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>

					<div class="event-comments">
						<h4>Event Commments</h4>

					</div>

				</div>

				<div class="event-tasks col-6">
					<h4>Event Tasks</h4>
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Task 1</h5>
							<h6 class="card-subtitle mb-2 text-muted">Task assignee(s)</h6>
							<p class="card-text">Contents of task go here</p>
							<a href="#" class="card-link">Link to task</a>
						</div>
					</div>

					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Task 1</h5>
							<h6 class="card-subtitle mb-2 text-muted">Task assignee(s)</h6>
							<p class="card-text">Contents of task go here</p>
							<a href="#" class="card-link">Link to task</a>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

</div>
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

		<div class="content container">
			<h4>Privileges</h4>
		</div>
	</div>

	<section>
		<table class="table table-striped">
			<thead>
				<tr>
					<th scope="col">Name</th>
					<th scope="col">Email</th>
					<th scope="col">Username</th>
					<th scope="col">Phone Number</th>
					<th scope="col">Delete User</th>
					<th scope="col">Edit User</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th scope="row">Frank G</th>
					<td>anEmail@handle.com</td>
					<td>UserName1</td>
					<td>55555555</td>
					<td><button type="button" id="plusButton" class="btn plusButton">
						<span class="fa-stack fa-1x">
							<i class="fas fa-trash-alt"></i>
						</span>
						</button></td>
					<td><button type="button" id="plusButton" class="btn plusButton">
							<i class="fas fa-pencil-alt"></i>
						</button></td>
				</tr>

				<tr>
					<th scope="row">Jake G</th>
					<td>otherEmail@handle.com</td>
					<td>UserName2</td>
					<td>5555557</td>
					<td><button type="button" id="plusButton" class="btn plusButton">
						<span class="fa-stack fa-1x">
							<i class="fas fa-trash-alt"></i>
						</span>
						</button></td>
					<td><button type="button" id="plusButton" class="btn plusButton">
							<i class="fas fa-pencil-alt"></i>
						</button></td>
				</tr>

				<tr>
					<th scope="row">Bob G</th>
					<td>bob@handle.com</td>
					<td>UserName3</td>
					<td>5555556</td>
					<td><button type="button" id="plusButton" class="btn plusButton">
						<span class="fa-stack fa-1x">
							<i class="fas fa-trash-alt"></i>
						</span>
						</button></td>
					<td><button type="button" id="plusButton" class="btn plusButton">
							<i class="fas fa-pencil-alt"></i>
						</button></td>
				</tr>
			</tbody>
		</table>
	</section>

</div>
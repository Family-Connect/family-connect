<?php require_once ("head-utils.php");?>

<div class="wrapper">

	<!-- Sidebar -->
	<nav id="sidebar" class="sidebar col-md-2 bg-light">
		<div class="sidebar-header">
			<h2>Sanchez</h2>
		</div>

		<ul class="users">
			<li>
				<a href="#">Erika</a>
			</li>
			<li>
				<a href="#">Stephanie</a>
			</li>
			<li>
				<a href="#">Fran</a>
			</li>
			<li>
				<a href="#">Andy</a>
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
			<div class="task-head">
				<h4>Task Name</h4>
				<h6>Task Creator</h6>
			</div>

			<div class="task-body row">
				<div class="task-description-comments col-6">
					<div class="task-description">
						<h4>Description</h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>

					<div class="task-comment">
						<h4>Task Comments</h4>

						<div class="comment">
							<p>Comment Creator</p>
							<ul>
								<li>Aliquet nibh praesent tristique magna sit amet purus gravida quis. Porttitor massa id neque aliquam. Mauris augue neque gravida in fermentum et. In ornare quam viverra orci.</li>
							</ul>
						</div>

						<div class="task-comment">
							<p>Comment creator 2</p>
							<ul>
								<li>Volutpat maecenas volutpat blandit aliquam etiam erat velit. Vel pharetra vel turpis nunc eget lorem dolor. Et netus et malesuada fames ac turpis egestas integer.</li>
							</ul>
						</div>

						<form class="add-task-comment container-fluid">
							<div>
								<textarea id="taskComment" name="TaskComment" class="task-comment-textarea" placeholder="What's on your mind?" "></textarea>
							</div>
							<div class="button">
								<button type="submit">Add comment</button>
							</div>
						</form>
					</div>
				</div>

				<div class="task-due-date col-md-6"
					<h4>Due Date</h4>
					<div class="card">
						<div class="card-body">
							00/00/0000
						</div>
					</div>
				</div
		</div>
</div>
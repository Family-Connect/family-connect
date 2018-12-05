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
			</div>

			<div class="event-body row">
				<div class="event-description-comments col-md-6">
					<div class="event-description">
						<h4>Description</h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>

					<div class="event-comments">
						<h4>Comments</h4>

						<div class="comment">
							<p>Comment creator</p>
							<ul>
								<li>Aliquet nibh praesent tristique magna sit amet purus gravida quis. Porttitor massa id neque aliquam. Mauris augue neque gravida in fermentum et. In ornare quam viverra orci.</li>
							</ul>
						</div>

						<div class="comment">
							<p>Comment creator 2</p>
							<ul>
								<li>Volutpat maecenas volutpat blandit aliquam etiam erat velit. Vel pharetra vel turpis nunc eget lorem dolor. Et netus et malesuada fames ac turpis egestas integer.</li>
							</ul>
						</div>

						<form class="add-comment container-fluid">
							<div>
								<textarea id="comment" name="eventComment" placeholder="What's on your mind?" "></textarea>
							</div>
							<div class="button">
								<button type="submit">Add comment</button>
							</div>
						</form>
					</div>
				</div>

			<div class="event-tasks col-md-6">
				<h4>Event Tasks</h4>
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Task 1</h5>
						<h6 class="card-subtitle mb-2 text-muted">Task assignee</h6>
						<p class="card-text">Contents of task go here</p>
						<a class="btn" data-toggle="collapse" href="#collapseTask1" role="button" aria-expanded="false" aria-controls="collapseTask1"><i class="fas fa-comments"></i></a>
						<div class="collapse multi-collapse" id="collapseTask1">
							<div class="card card-body event-task-comment">
								<p>Comment creator</p>
								<ul>
									<li>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.</li>
								</ul>
							</div>
							<form class="add-task-comment container-fluid">
								<div>
									<textarea id="taskComment" name="eventTaskComment" class="event-task-comment-textarea" placeholder="What's on your mind?" "></textarea>
								</div>
								<div class="button">
									<button type="submit">Add comment</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Task 2</h5>
						<h6 class="card-subtitle mb-2 text-muted">Task assignee</h6>
						<p class="card-text">Contents of task go here</p>
						<a class="btn" data-toggle="collapse" href="#collapseTask2" role="button" aria-expanded="false" aria-controls="collapseTask2"><i class="fas fa-comments"></i></a>
						<div class="collapse multi-collapse" id="collapseTask2">

							<form class="add-task-comment container-fluid">
								<div>
									<textarea id="taskComment" name="eventTaskComment" class="event-task-comment-textarea" placeholder="What's on your mind?" "></textarea>
								</div>
								<div class="button">
									<button type="submit">Add comment</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				</div>
		</div>
	</div>

</div>
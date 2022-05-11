<div class="navbar">
			<div class="logo_div">
				<a href="blogIndex.php"><h1>PHP-Example Blog</h1></a>
			</div>
			<ul>
				<?php if($loggedIn): ?>
					<li><a class="active" href="Index.php">Home</a></li>
					<li><a href="dashboard.php?action=logout">Logout</a></li>
					<li><a href="dashboard.php">Dashboard</a></li>
				<?php else: ?>
					<li><a class="active" href="Index.php">Home</a></li>
			  	<?php endif ?>
			</ul>
		</div>
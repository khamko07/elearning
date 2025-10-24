<h1><?php echo $title;?></h1>
<div class="col-lg-12">
	<div class="table-responsive">
		<table id="example" class="table table-bordered">
			<thead>
				<th width="5%">#</th>
				<th>Question</th>
				<th width="15%">Action</th>
			</thead>
			<tbody>
				<?php 
				$sql = "SELECT * FROM tblexercise ORDER BY ExerciseID DESC";
				$mydb->setQuery($sql);
				$cur = $mydb->loadResultList();
				$cnt = 1;
				foreach ($cur as $result) {
					echo '<tr>';
					echo '<td>'.$cnt.'</td>';
					echo '<td>'.$result->Question.'</td>';
					echo '<td><a href="index.php?q=question&id=all" class="btn btn-xs btn-info">Take Quiz</a></td>';
					echo '</tr>';
					$cnt++;
				}
				?>
			</tbody>
		</table>
	</div>
</div>
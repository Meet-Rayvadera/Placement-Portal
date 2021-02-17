<?php
	session_start();
	if(sizeof($_SESSION)==0)
		header("Location: job_login.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Company Dashboard</title>

	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.3-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.3-dist/css/customstyle.css">

<style type="text/css">
	.dtable{
		margin: 10mm;
		border-style: solid;
		border-width: 2px; 
		padding: 3mm; 
	}
</style>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand mb-0 h1" href="#">
		 	<?php echo $_SESSION['company_name']." : ".$_SESSION['profile_name'] ?>
		</a>
		
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    	<span class="navbar-toggler-icon"></span>
    	</button>

    	<div class="collapse navbar-collapse" id="navbarSupportedContent">
    		<ul class="navbar-nav mr-auto">
		      <li class="nav-item">
		        <a class="nav-link" href="job_db_app.php">Students Applications <span class="sr-only">(current)</span></a>
		      </li>
		      <li class="nav-item">
		      	<a class="nav-link" href="job_db_eligibility.php">Eligibility</a>
		      </li>
		      <li class="nav-item active">
		      	<a class="nav-link" href="job_db_schedule.php">Schedule</a>
		      </li>
  			</ul>

  			<form class="form-inline" action="" method="post">
    			<input class="btn btn-sm btn-outline-primary" type="submit" name="logout" value="Log Out"/>
  			</form>
  		</div>

	</nav>

	<br>

	<div class="container">
  	<h1>Schedule an event</h1>
  	<br>
  	<form method="post" action="" >
		<div class="form-group">
		  	Enter event purpose : 
			<input type="text" name="purpose" class="form-control" required/>
		</div>
		<div class="form-group">
		Enter start time : 
		<input type="datetime-local" name="start_time" class="form-control" required/>
		</div>
		<div class="form-group">
		Enter end time : 
		<input type="datetime-local" name="end_time" class="form-control" required/>
		</div>
		<div class="form-group">
		Links : 
		<input type="text" name="links" class="form-control"/>
		</div>
		<div class="form-group">
  		<input type="submit" name="sub" >
		</div>
  	</form>
</div>

	<br>

	<div class="dtable">
		<h1> Events Scheduled</h1>
		<br>
		<table class="table">
	  		<thead>
	  			<th scope="col"> Purpose </th>
	  			<th scope="col"> Start time</th>
	  			<th scope="col"> End time</th>
	  			<th scope="col"> Links</th>
	  		</thead>
	  		<tbody>
	  		
	  		<?php
	  			require('db.php');
	  			$sql = "SELECT * FROM plcmtportal.time_slots T WHERE T.company_name='".$_SESSION['company_name']."' AND T.profile_name='".$_SESSION['profile_name']."' ORDER BY T.start_time";
	  			
	  			$stmt = $conn->query($sql);

	  			while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
					echo "<tr><td>";
					echo $row['purpose'];
					echo "</td><td>";
					echo $row['start_time'];
					echo "</td><td>";
					echo $row['end_time'];
					echo "</td><td>";
					echo $row['links'];
					echo "</td></tr>";
				}
	  		?>


	  		</tbody>
	  	</table>
  	</div><br>

	<!-- jQuery (Bootstrap JS plugins depend on it) -->
	<script type="bootstrap-4.5.3-dist/js/jquery-3.5.1.min.js"></script>
	<script type="bootstrap-4.5.3-dist/js/bootstrp.min.js"></script>
	<script type="bootstrap-4.5.3-dist/js/script.js"></script>
</body>
</html>

<?php

	if(isset($_POST['sub']))
	{
		require('db.php');

		$sql = "INSERT INTO plcmtportal.time_slots(company_name, profile_name, start_time, end_time, links, purpose) VALUES (:company_name, :profile_name, :start_time, :end_time, :links, :purpose)";
		$stmt = $conn->prepare($sql);
		$res = $stmt->execute(
			array(
				':company_name'=>$_SESSION['company_name'],
				':profile_name'=>$_SESSION['profile_name'],
				':start_time'=>$_POST['start_time'],
				':end_time'=>$_POST['end_time'],
				':links'=>$_POST['links'],
				':purpose'=>$_POST['purpose']
			)
		);
		header("Location:job_db_schedule.php");

	}

	if(isset($_POST['logout']))
	{	
		session_unset();
		session_destroy();
		header("Location:job_login.php");
	}

?>
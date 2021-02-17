<?php
	session_start();
	if(sizeof($_SESSION)==0)
		header("Location: std_login.php");
	$str="Hello";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Student Dashboard</title>

	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.3-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.3-dist/css/customstyle.css">

<style type="text/css">
	.dtable{
		margin: 10mm;
		border-style: solid;
		border-width: 2px; 
		padding: 3mm; 
	}
	.but:disabled{
	  border: 1px solid #999999;
	  background-color: #cccccc;
	  color: #666666;
	}
</style>

</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand mb-0 h1" href="#">
		 	<?php echo "Welcome ".$_SESSION['name'] ?>
		</a>
		
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    	<span class="navbar-toggler-icon"></span>
    	</button>

    	<div class="collapse navbar-collapse" id="navbarSupportedContent">
    		<ul class="navbar-nav mr-auto">
		      <li class="nav-item active">
		        <a class="nav-link" href="std_db_jobs.php">Eligible jobs <span class="sr-only">(current)</span></a>
		      </li>
		      <li class="nav-item">
		      	<a class="nav-link" href="std_db_timeslots.php">Time slots</a>
		      </li>
  			</ul>

  			<form class="form-inline" action="" method="post">
    			<input class="btn btn-sm btn-outline-primary" type="submit" name="logout" value="Log Out"/>
  			</form>
  		</div>

	</nav>
	<br>

	<div class="dtable">
		<h1>Eligibile jobs</h1>
		<br>
		<table class="table">
	  		<thead>
	  			<th scope="col"> Company_name </th>
	  			<th scope="col"> Profile_name</th>
	  			<th scope="col"> Application Deadline</th>
	  			<th scope="col"> CTC (in LPA)</th>
	  			<th scope="col"> Apply</th>
	  		</thead>
	  		<tbody>
	  		
	  		<?php
	  			require('db.php');

	  			$sql = "SELECT J.profile_name, J.company_name, J.application_deadline, J.ctc FROM plcmtportal.Jobs J, plcmtportal.Eligible E, plcmtportal.Program P, plcmtportal.Student S WHERE J.profile_name=E.profile_name AND J.company_name=E.company_name AND E.prog_name=P.prog_name AND S.prog_name=P.prog_name AND S.rollno=".$_SESSION['rollno']." AND S.tenth_per>=E.tenth_per_crt AND S.twelveth_per>=E.twelveth_per_crt AND S.ug_cpi>=E.ug_cpi_crt AND (S.pg_cpi=-1 OR S.pg_cpi>=E.pg_cpi_crt) AND (S.phd_cpi=-1 OR S.phd_cpi>=E.phd_cpi_crt) AND J.application_deadline>=now()";
	  			
	  			$stmt = $conn->query($sql);

	  			$i=1;
	  			$memo = array(array());

	  			while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
					echo "<tr><td>";
					echo $row['company_name'];
					echo "</td><td>";
					echo $row['profile_name'];
					echo "</td><td>";
					echo $row['application_deadline'];
					echo "</td><td>";
					echo $row['ctc'];
					echo "</td><td>";

					$sql2 = "SELECT * FROM plcmtportal.application A, plcmtportal.student S WHERE A.rollno=S.rollno AND A.company_name='".$row['company_name']."' AND A.profile_name='".$row['profile_name']."' AND A.rollno=".$_SESSION['rollno'];
					
					$stmt2 = $conn->query($sql2);
					$row2=$stmt2->fetch(PDO::FETCH_ASSOC);

					if($row2)
						echo "<form method='post'><input class='but' type='submit' value='Applied' name='sub".$i."' disabled></form>";
					else
						echo "<form method='post'><input class='but' type='submit' value='Apply' name='sub".$i."'></form>";
					echo "</td><td>";
					echo "</td></tr>";

					$arr = array($i, $row['company_name'], $row['profile_name']);
					
					array_push($memo, $arr);

					$i++;
				}
	  		?>
	  		</tbody>
	  	</table>
	</div>


	<!-- jQuery (Bootstrap JS plugins depend on it) -->
	<script type="bootstrap-4.5.3-dist/js/jquery-3.5.1.min.js"></script>
	<script type="bootstrap-4.5.3-dist/js/bootstrp.min.js"></script>
	<script type="bootstrap-4.5.3-dist/js/script.js"></script>
</body>
</html>

<?php
	
	for($i=1; $i<sizeof($memo); $i++)
	{
		$str = "sub".$i;
		if(isset($_POST[$str]))
		{
			$rollno = $_SESSION['rollno'];
			$prog_name = $_SESSION['prog_name'];
			$company_name = $memo[$i][1];
			$profile_name = $memo[$i][2];

			$sql = "INSERT INTO plcmtportal.application(rollno,prog_name,company_name,profile_name,statas) VALUES (:rollno, :prog_name, :company_name, :profile_name, :statas)";
			$stmt = $conn->prepare($sql);
			$stmt->execute(
				array(
					':rollno'=>$rollno,
					':prog_name'=>$prog_name,
					':company_name'=>$company_name,
					':profile_name'=>$profile_name,
					':statas'=>"Applied"
				)
			);
			header('Location:std_db_jobs.php');
		}
	}

	if(isset($_POST['logout']))
	{	
		session_unset();
		session_destroy();
		header("Location:std_login.php");
	}

?>
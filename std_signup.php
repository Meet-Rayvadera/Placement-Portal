<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Student Signup</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<form class="form" action="" method="post">
        <h1 class="login-title">Student registration</h1>
        <input type="text" class="login-input" name="rollno" placeholder="Roll Number" required />
        <input type="text" class="login-input" name="fname" placeholder="First Name" required />
        <input type="text" class="login-input" name="mname" placeholder="Middle Name" />
        <input type="text" class="login-input" name="lname" placeholder="Last Name" required />
        <input type="email" class="login-input" name="email" placeholder="Email Adress" required />
        <input type="text" class="login-input" name="ug_college" placeholder="UG college" />
        <input type="text" class="login-input" name="pg_college" placeholder="PG college" />
        <div style="font-size: 115%">
        <label for="programs">Choose program:</label>
        <select id="programs" name="prog_name">
		    <option value="MSc MnC">MSc MnC</option>
		    <option value="MTech CSE">MTech CSE</option>
		    <option value="BTech CSE">BTech CSE</option>
		    <option value="BTech MnC">BTech MnC</option>
		  </select>
		</div>
		 <br>
        <input type="number" step=0.01 class="login-input" name="tenth_per" placeholder="10th percentage" required />
        <input type="number" step=0.01 class="login-input" name="twelveth_per" placeholder="12th percentage" required />
        <input type="number" step=0.01 class="login-input" name="ugcpi" placeholder="UG cpi" required />
        <input type="number" step=0.01 class="login-input" name="pgcpi" placeholder="PG cpi" />
        <input type="number" step=0.01 class="login-input" name="phdcpi" placeholder="PhD cpi" />
        <input type="password" class="login-input" name="passwd" placeholder="Password" required/>
        <input type="submit" name="submit" value="Register" class="login-button" />
        <p class="link"><a href="std_login.php">Click to Login</a></p>
    </form>
</body>
</html>


<?php
	require('db.php');

	if(isset($_POST['submit']))
	{		
		$rollno = $_POST['rollno'];
		$fname = $_POST['fname'];
		$mname = $_POST['mname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$ug_college = $_POST['ug_college'];
		$pg_college = $_POST['pg_college'];
		$prog_name = $_POST['prog_name'];
		$tenth_per = $_POST['tenth_per'];
		$twelveth_per = $_POST['twelveth_per'];
		$ugcpi = $_POST['ugcpi'];
		if(strlen($_POST['pgcpi']))
			$pgcpi = $_POST['pgcpi'];
		else
			$pgcpi = -1;
		if(strlen($_POST['phdcpi']))
			$phdcpi = $_POST['phdcpi'];
		else
			$phdcpi = -1;
		$passwd = $_POST['passwd'];
		
		$sql = "INSERT INTO plcmtportal.student(rollno, fname, mname, lname, email, ug_college, pg_college, prog_name, tenth_per, twelveth_per, ug_cpi, pg_cpi, phd_cpi, passwd) VALUES(:rollno, :fname, :mname, :lname, :email, :ug_college, :pg_college, :prog_name, :tenth_per, :twelveth_per, :ugcpi, :pgcpi, :phdcpi, :passwd)";
		$stmt = $conn->prepare($sql);
		$res = $stmt->execute(
			array(
				':rollno' => $rollno,
				':fname' => $fname,
				':mname' => $mname,
				':lname' => $lname,
				':email' => $email,
				':ug_college' => $ug_college,
				':pg_college' => $pg_college,
				':prog_name' => $prog_name,
				':tenth_per' => $tenth_per,
				':twelveth_per' => $twelveth_per,
				':ugcpi' => $ugcpi,
				':pgcpi' => $pgcpi,
				':phdcpi' => $phdcpi,
				':passwd' => $passwd
			)
		);
		//var_dump($res);
	}

?>









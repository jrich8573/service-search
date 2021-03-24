<html>
	<head>
		<title> Service Search </title>
			<meta name="viewport" content="width=device-width, initial-scale=1">
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<style>
			body {
   			  font-family: Arial;
			}

			* {
	  		  box-sizing: border-box;
			}

			table {
	 		   border-collapse: collapse;
	  		   width: 100%;
			}

			th, td {
	  		  padding: 8px;
	  		  text-align: center;
	      		  border-bottom: 1px solid #ddd;
			}

			tr:hover {background-color:#f5f5f5;}

			form.flname input[type=text] {
				padding: 8px;
	  			font-size: 17px;
				border: 1px solid black;
				float: left;
				width: 80%;
				background: #0b7dda;
		   	}

		  	form.flname button {
		   		 float: left;
		   		 width: 15%;
		   		 padding: 10px;
		   		 background: #0b7dda;
		   		 color: white;
		   		 font-size: 17px;
		   		 border: none;
		   		 border-left: none;
				 cursor: pointer;

		  	}

		 	form.flname button:hover {
			 	background: #0b7dda;
			 }	

			form.street input[type=text] {
	  			padding: 8px;
	  			font-size: 17px;
				border: 1px solid black;
				float: left;
				width: 80%;
				background: #0b7dda;
		   	}

		  	form.street button {
				 float: left;
		   		 width: 15%;
		   		 padding: 10px;
		   		 background: #0b7dda;
		   		 color: white;
		   		 font-size: 17px;
		   		 border: none;
		   		 border-left: none;
		   		 cursor: pointer;
		  	}

		 	form.street button:hover {
			 	background: #0b7dda;
			 }	

			form.zip input[type=text] {
	  			padding: 8px;
	  			font-size: 17px;
				border: 1px solid black;
				float: left;
				width: 80%;
				background: #0b7dda;
		   	}

		  	form.zip button {
				 float: left;
		   		 width: 15%;
		   		 padding: 10px;
		   		 background: #0b7dda;
		   		 color: white;
		   		 font-size: 17px;
		   		 border: none;
		   		 border-left: none;
		   		 cursor: pointer;
		  	}

		 	form.zip button:hover {
			 	background: #0b7dda;
			 }	
			@media screen and (min-width: 7680px){
				form {
					display: flex;
					flex-wrap: wrap;
					justify-content:space-between;
				}
				form div{
`					width: 100%
				}
				.form>*:nth-child(flname),
				.form>*:nth-child(street),
				.form>*:nth-child(zip){
					width: 32%
				}
			}
			
		</style>
	</head>

	<h3>Service Search Console </h3>
		
	<form class="flname" action="" style="margin:auto;max-width:350px" method="post">
	  	<input type="text" placeholder="Search by owner's first or last name" name="name">
	  	<button type="submit"><i class="fa fa-search"></i></button>
	</form>
	<form class="street" action="" style="margin:auto;max-width:350px" method="post">
	  	<input type="text" placeholder="Search by street address" name="street">
	  	<button type="submit"><i class="fa fa-search"></i></button>
	</form>
	<form class="zip" action="" style="margin:auto;max-width:350px" method="post">
	  	<input type="text" placeholder="Search by zip code" name="zip">
	  	<button type="submit"><i class="fa fa-search"></i></button>
	</form>
		
	<form action="" method="post">
	<br>
	<?php
		$server = "mysql-class.infra.cs.odu.edu";
		$sqlUsername = "jrich202020";
		$sqlPassword = "";
		$databaseName = "jrich202020db";
		
		$conn = new mysqli($server, $sqlUsername, $sqlPassword,$databaseName);
		
		// check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		//echo "Connected successfully<br>";
	
	  if (!empty($_POST['name'])) {
			$name = $_POST['name'];
			$query = "SELECT  a.PropertyID, a.PropertyName, a.Street, a.City, a.State, a.ZIP, b.OwnerName, b.OwnerEmail, b.OwnerType, SUM(c.HoursWorked) as tot_hrs_wrkd, COUNT(c.EmployeeID) as service_cnt FROM PROPERTY a LEFT JOIN OWNER b ON a.OwnerID=b.OwnerID LEFT JOIN SERVICE c ON a.PropertyID=c.PropertyID WHERE b.OwnerName  LIKE '$name%' GROUP BY a.PropertyID ORDER BY service_cnt DESC";
		} elseif (!empty($_POST['street'])) {
			$street = $_POST['street'];
			$query = "SELECT  a.PropertyID, a.PropertyName, a.Street, a.City, a.State, a.ZIP, b.OwnerName, b.OwnerEmail, b.OwnerType, SUM(c.HoursWorked) as tot_hrs_wrkd, COUNT(c.EmployeeID) as service_cnt FROM PROPERTY a LEFT JOIN OWNER b ON a.OwnerID=b.OwnerID LEFT JOIN SERVICE c ON a.PropertyID=c.PropertyID WHERE a.Street LIKE '$street%' GROUP BY a.PropertyID ORDER BY service_cnt DESC";
		} elseif (!empty($_POST['zip'])) {
		 	$zip = $_POST['zip'];
			$query = "SELECT a.PropertyID,  a.PropertyName, a.Street, a.City, a.State, a.ZIP, b.OwnerName, b.OwnerEmail, b.OwnerType, SUM(c.HoursWorked) as tot_hrs_wrkd, COUNT(c.EmployeeID) as service_cnt FROM PROPERTY a LEFT JOIN OWNER b ON a.OwnerID=b.OwnerID LEFT JOIN SERVICE c ON a.PropertyID=c.PropertyID WHERE a.ZIP LIKE '$zip%' GROUP BY a.PropertyID ORDER BY service_cnt DESC";
		} else {
			$query = "SELECT a.PropertyID, a.PropertyName, a.Street, a.City, a.State, a.ZIP, b.OwnerName, b.OwnerEmail, b.OwnerType, SUM(c.HoursWorked) as tot_hrs_wrkd, COUNT(c.EmployeeID) as service_cnt FROM PROPERTY a LEFT JOIN OWNER b ON a.OwnerID=b.OwnerID LEFT JOIN SERVICE c ON a.PropertyID=c.PropertyID GROUP BY a.PropertyID ORDER BY tot_hrs_wrkd LIMIT 20";	
		}
	
		// Execute SQL query
		$result = $conn->query($query)
			or die( "ERROR: Query is wrong");
	
		//print table header
	  $headers = Array('ID','PropertyName','Street','City','State','Zip','OwnerName','OwnerEmail','OwnerType','Total Hours Worked','Service Count');
		echo "<table>";
		echo "<tr>";
				// fetch attribute names
				foreach($headers as $header) {
					echo "<th style=\"text-align:center\">".$header."</th>";
			}
		echo "</tr>";
		
		//print table data
		while( $row = $result->fetch_assoc() ) {
			echo "<tr>\n";
			foreach ($row as $cell) {
					echo "<td style=\"text-align:center\"> $cell </td>";
			}
			echo "</tr>\n";
		}
		
		while($row = $result->fetch_assoc()){
			$num_rows = mysql_num_rows($row);
			echo "$num_rows Rows\n";
		}
		// close table
		echo "</table>";
	
		// close the connection with database
		$conn->close();
	?>
	
	</form>
</html>

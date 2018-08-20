<?
function Login(){
	$dbuser="isiska";
	$dbpass="1s1skat1mur";
	$dbhost="(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=10.96.2.233)(PORT=1521))(CONNECT_DATA=(SERVER=DEDICATED)(SID=dcspool)))";
	$conn=OCILogon($dbuser,$dbpass,$dbhost);
	return $conn;
}

$conn=Login();
function OCIexec($sql){
	global $conn;
	$stmt=OCIparse($conn,$sql);
	OCIexecute($stmt);
	return $stmt;
}

function Login1(){
	$dbuser1="asro";
	$dbpass1="asro2016";
	$dbhost1="(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=10.96.2.234)(PORT=1521))(CONNECT_DATA=(SERVER=DEDICATED)(SID=isreg5)))";
	$conn1=OCILogon($dbuser1,$dbpass1,$dbhost1);
	return $conn1;
}

$conn1=Login1();
function OCIexec_isreg5($sql1){
	global $conn1;
	$stmt1=OCIparse($conn1,$sql1);
	OCIexecute($stmt1);
	return $stmt1;
}

function Login2(){
	$dbuser2="egbis";
	$dbpass2="egbis2015";
	$dbhost2="(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=10.96.2.234)(PORT=1521))(CONNECT_DATA=(SERVER=DEDICATED)(SID=isreg5)))";
	$conn2=OCILogon($dbuser2,$dbpass2,$dbhost2);
	return $conn2;
}

$conn2=Login2();
function OCIexec_egbis($sql2){
	global $conn2;
	$stmt2=OCIparse($conn2,$sql2);
	OCIexecute($stmt2);
	return $stmt2;
	echo $stmt2;
}
?>
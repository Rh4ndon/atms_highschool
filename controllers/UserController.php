<?php 
@include '../models/dbconn.php';

if (isset($_POST['register'])) {
                           
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $department = $_POST['department'];
    $birthday = $_POST['birthday'];
    
    
    $query = mysqli_query($conn,"select * from teachers where email = '$email' && firstname = '$firstname' && lastname = '$lastname' ")or die(mysqli_error());
    $count = mysqli_num_rows($query);
    
    if ($count > 0){ ?>
    <script>
    alert('User Already Exist');
    </script>
    <?php
    }else{

    mysqli_query($conn,"insert into teachers (email,firstname,lastname,password,gender,contact,department,birthday)
    values ('$email','$firstname','$lastname','$password','$gender','$contact','$department','$birthday')") or die(mysqli_error()); 

      /* teacher */
		$query_teacher = mysqli_query($conn,"SELECT * FROM teachers WHERE email='$email' AND password='$password'")or die(mysqli_error());
		$row_teahcer = mysqli_fetch_array($query_teacher);
		$num_row_teacher = mysqli_num_rows($query_teacher);   
    session_start();
    $_SESSION['id']=$row_teahcer['user_id'];
    echo "<script> location.href='../teacher/teacher_panel.php'; </script>";
    }}



if (isset($_POST['update'])) {

    $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $department = $_POST['department'];
    $birthday = $_POST['birthday'];

        /* admin */
			$query = "SELECT * FROM users WHERE user_id ='$user_id'";
			$result = mysqli_query($conn,$query)or die(mysqli_error());
			$row = mysqli_fetch_array($result);
			$num_row = mysqli_num_rows($result);
		/* teacher */
		$query_teacher = mysqli_query($conn,"SELECT * FROM teachers WHERE user_id ='$user_id'")or die(mysqli_error());
		$row_teahcer = mysqli_fetch_array($query_teacher);
		$num_row_teacher = mysqli_num_rows($query_teacher);
		
		if( $num_row > 0 ) {

        mysqli_query($conn,"update users set firstname = '$firstname' , lastname = '$lastname' , email = '$email', password = '$password', gender ='$gender', contact = '$contact', department = '$department', birthday = '$birthday' where user_id = '$user_id' ")or die(mysqli_error());

        session_start();
		$_SESSION['id']=$row['user_id'];
		echo "<script> location.href='../admin/profile.php'; </script>";
        exit();	
		}else if ($num_row_teacher > 0){
        mysqli_query($conn,"update teachers set firstname = '$firstname' , lastname = '$lastname' , email = '$email', password = '$password', gender ='$gender', contact = '$contact', department = '$department', birthday = '$birthday' where user_id = '$user_id' ")or die(mysqli_error());
        
        session_start();
		$_SESSION['id']=$row_teahcer['user_id'];
		echo "<script> location.href='../teacher/profile.php'; </script>";
        exit();	
		
		 }else{ 
            echo "<script> location.href='index.php?msg=failed'; </script>";
		}

}

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

        /* admin */
			$query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
			$result = mysqli_query($conn,$query)or die(mysqli_error());
			$row = mysqli_fetch_array($result);
			$num_row = mysqli_num_rows($result);
		/* teacher */
		$query_teacher = mysqli_query($conn,"SELECT * FROM teachers WHERE email='$email' AND password='$password'")or die(mysqli_error());
		$row_teahcer = mysqli_fetch_array($query_teacher);
		$num_row_teacher = mysqli_num_rows($query_teacher);
		
		if( $num_row > 0 ) { 
        session_start();
		$_SESSION['id']=$row['user_id'];
		echo "<script> location.href='../admin/admin_dashboard.php'; </script>";
        exit();	
		}else if ($num_row_teacher > 0){
        session_start();
		$_SESSION['id']=$row_teahcer['user_id'];
		echo "<script> location.href='../teacher/teacher_panel.php'; </script>";
        exit();	
		
		 }else{ 
            echo "<script> location.href='index.php?msg=failed'; </script>";
		}

}




















?>
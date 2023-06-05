<?php
session_start();

require_once("db.php");



if(isset($_POST['signin']))
{
    if( !empty($_POST['email']) && !empty($_POST['pass']))
    {
        $email=$_POST['email'];
        $pass=md5($_POST['pass']);
        $stmt = $conn->prepare("select * from users where email=? and password=?");
		$stmt->bind_param("ss", $email,$pass);
		$stmt->execute();
		$res=$stmt->get_result();
        if($res->num_rows ==1)
        {
            $user=$res->fetch_assoc();
            $_SESSION['name']=$user['name'];
            $_SESSION['email']=$user['email'];
            $_SESSION['notes_file']=$user['notes_file'];
            $_SESSION['uuid']=$user['uuid'];
            echo "<script>window.location.href='notes.php'</script>";
        }
        else
        {
            die("<script>alert('Wrong Data');history.back()</script>"); 
        }
    }
}


?>
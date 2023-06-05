<?php

require_once("db.php");

function guidv4($data = null) {
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
$uuid=guidv4();
$notes_file="notes/".md5($uuid).".txt";

if(isset($_POST['signup']))
{
    if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['re_pass'])  )
    {
        $name=$_POST['name'];
        $email=htmlspecialchars($_POST['email']);
        $pass=md5($_POST['pass']);
        $pass2=md5($_POST['re_pass']);
        $stmt = $conn->prepare("select * from users where email=?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$res=$stmt->get_result();
		if ($pass !== $pass2)
        {
            die("<script>alert('Passwords not matched');history.back()</script>"); 
        }
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            die("<script>alert('Wrong email');history.back()</script>"); 
        }
        elseif($res->num_rows > 0)
        {
            die("<script>alert('Email taken before');history.back()</script>"); 
        }
        if($reg=$conn->query("insert into users(uuid,name,email,password,notes_file)values('$uuid','$name','$email','$pass','$notes_file')") && file_put_contents($notes_file,base64_encode('first_note')))
        {                                                                                         
            die("<script>alert('Success');history.back()</script>"); 
        }

    }
    else
    {
        die("<script>alert('Please Fill All Fields');history.back()</script>");
    }
}
?>
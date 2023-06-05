<?php
session_start();
if(empty($_SESSION['email']) || empty($_SESSION['notes_file']))
{
    die(header("Location:index.php")); 
}

if(preg_match('/up/',realpath($_SESSION['notes_file'])) || preg_match('/php:\/\/|sess/',$_SESSION['notes_file']))
{
    die("Noooo");
}
if (isset($_POST['add_note']))
{
    $current=file_get_contents("notes/".md5($_SESSION['uuid']).".txt");
    $new=base64_decode($current)."<br>".htmlspecialchars($_POST['note']);
    $fp = fopen("notes/".md5($_SESSION['uuid']).".txt", 'w');
    fwrite($fp, base64_encode($new)); 
    fclose($fp);  
}

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes</title>
</head>
<body>

<form method="post">
    <textarea name="note">
    </textarea>
    <input name="add_note" type="submit" />
</form>

<p id="notes"><?php include_once($_SESSION['notes_file']);?></p>

<a href="profile.php">Go to your profile</a>
<a href="logout.php">Logout</a>
    <script>
        notes=document.getElementById('notes');
        notes.innerHTML=atob(notes.innerHTML);
    </script>
</body>
</html>
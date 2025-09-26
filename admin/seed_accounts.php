<?php
require_once("../include/initialize.php");

// Seed default admin and student user if they don't exist

function ensure_admin_exists($name, $email, $plainPassword) {
    global $mydb;
    $hash = sha1($plainPassword);
    $mydb->setQuery("SELECT USERID FROM tblusers WHERE UEMAIL='".$mydb->escape_value($email)."' LIMIT 1");
    $exists = $mydb->loadSingleResult();
    if (!$exists) {
        $mydb->setQuery("INSERT INTO tblusers(NAME,UEMAIL,PASS,TYPE) VALUES('".
            $mydb->escape_value($name)."','".
            $mydb->escape_value($email)."','".$hash."','Administrator')");
        $mydb->executeQuery();
        echo "Created admin: {$email}\n";
    } else {
        echo "Admin already exists: {$email}\n";
    }
}

function ensure_student_exists($username, $plainPassword) {
    global $mydb;
    $hash = sha1($plainPassword);
    $mydb->setQuery("SELECT StudentID FROM tblstudent WHERE STUDUSERNAME='".$mydb->escape_value($username)."' LIMIT 1");
    $exists = $mydb->loadSingleResult();
    if (!$exists) {
        $mydb->setQuery("INSERT INTO tblstudent(Fname,Lname,Address,MobileNo,STUDUSERNAME,STUDPASS) VALUES('User','Demo','', '', '".
            $mydb->escape_value($username)."','".$hash."')");
        $mydb->executeQuery();
        echo "Created student: {$username}\n";
    } else {
        echo "Student already exists: {$username}\n";
    }
}

// Defaults requested
ensure_admin_exists('Administrator', 'admin', 'admin');
ensure_student_exists('user', 'user');

echo "Seeding complete.\n";
?>



<?php
/**
 * Created by PhpStorm.
 * User: gontar700
 * Date: 19/07/2016
 * Time: 14:47
 */
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
try {
        $dbConnection = new DbConnect ('localhost', 'gontar_test', 'Dg270882', 'gontar_test');
        $result1 = $dbConnection->userVerification($username, $password); // result of designer query select by username
        // for verification check
        if ($result1->num_rows > 0) {
            $_SESSION['designerDetails'] = $result1->fetch_row();
            $encryptedPassword =  $_SESSION['designerDetails'][2];
            if (!password_verify($password, $encryptedPassword))
            {
                throw new UserVerificationException ("<div id='message1'>שם משתמש ו/או סיסמא לא מתאימים</div>");
            }
            $_SESSION['dayCounter'] = 0; // counter to days relatively to current date : ...,-1,0,1 ...
        }
        else
        {
            throw new UserVerificationException ("<div id='message1'>שם משתמש ו/או סיסמא לא מתאימים</div>");
        }
    }
catch (UserVerificationException $e)
{
    exit($e->getmessage()."<div><button class='btn-primary' onclick='home()' style='margin: 1em'>חזור</button></div>");

}
if ($username=='manager@atarix.co.il') // manager is loging in
{
    $_SESSION['login']=6; // set proper session
}
<?php

include_once("adb.php");
class user extends adb{
  function user(){

  }


  function Signup( $firstname, $lastname,$username,$tel, $password){
    $strQuery="Insert into signup set fname='$firstname', lname='$lastname',username= '$username', tel='$tel',password= MD5('$password')";

    return $this->query($strQuery);
  }

  function checkUsername($username)
  {
    $strQuery="Select * from signup where username like '$username'";
    return $this->query($strQuery);


  }

  function Login($username,$password){
   $strQuery="Select * from signup where username = '$username' and password='$password'";

      return $this->query($strQuery);

  }

  function createPool($username,$poolname,$max,$destination,$location){
    $strQuery="Insert into pool set owner='$username', name='$poolname',max= '$max', destination='$destination',location= '$location'";

    return $this->query($strQuery);
  }

  function viewPool(){
    $strQuery="Select * from pool ";

       return $this->query($strQuery);

  }

  function joinPool($pool_ID,$owner,$username,$destination,$payment){
      $strQuery="Insert into JoinPool set pool_ID='$pool_ID',PoolOwner='$owner',username='$username', Destination='$destination',Payment= '$payment'";
      return $this->query($strQuery);
  }

  function getpool($owner)
  {
    $strQuery="Select * from pool where Owner='$owner' ";
    return $this->query($strQuery);
  }

  function view_pool($username){
    $strQuery="Select * from JoinPool where username='$owner' ";
    return $this->query($strQuery);

  }

}

 ?>

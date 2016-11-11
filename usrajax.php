<?php
//check command
if(!isset($_REQUEST['cmd'])){
  echo "cmd is not provided";
  exit();
}
/*get command*/
$cmd=$_REQUEST['cmd'];
switch($cmd){
  case 1:
  signup();		//if cmd=1 the call delete
  break;
  case 2:
  login();
  break;
  case 3:
  createpool();
  break;
  case 4:
  viewPools();
  break;
  case 5:
  joinPool();
  break;
  case 6:
  view_pool();
  break;
  default:
  echo "wrong cmd";	//change to json message
  break;
}

function view_pool(){
  include_once("user.php");
    $username	=$_REQUEST["username"];
    $obj= new user();
    $results=obj->view_pool($username);
    $row=$obj->fetch();
    if(!$row){
      echo '{"result":0,"message":"No available Pools"}';
      return;
    }
    else{
      while ($re=$obj->fetch()){
        $array[]=$re;
      }

    echo json_encode($array);

    }

}


function joinPool(){
  include_once("user.php");
  $obj=new user();
//cmd=5&pool_ID=2&owner=jnsiah&username=knsiah&tel=0200000000&payment=credit&destination=Kumasi&Max=7
      $username	=$_REQUEST["username"];
      $pool_ID=$_REQUEST["pool_ID"];
      $owner=$_REQUEST["owner"];
      $tel=$_REQUEST["tel"];
      $max=$_REQUEST["Max"];
      $destination=$_REQUEST["destination"];
      //$location=$_REQUEST["location"];
      $payment=$_REQUEST["payment"];

      $row=$obj->getpool($owner);


      if (!$results=$obj->fetch()){
      $obj1=new user();
      $r=$obj1->joinPool($pool_ID,$owner,$username,$destination,$payment);
        if($r==0){
            echo '{"result":0,"message":"Cannot join pool"}';
        }
        else{
          echo '{"result":1,"message":" Pool joined successfully "}';
          $sender="EIBUR";
          $message="You succesfully joined pool";
          $smsmessage = str_replace(' ','%20', $message);
          $ch = curl_init("http://52.89.116.249:13013/cgi-bin/sendsms?username=mobileapp&password=foobar&to=$tel&from=$sender&smsc=smsc&text=$smsmessage");
          curl_exec($ch);


          }
        }

    else{
       $count=0;
      while ($re=$obj->fetch()){
        $count++;
      }
      if ($count==$max){
          echo '{"result":0,"message":" pool full"}';
      }
      else {
        $obj1=new user();

        $r=$obj1->joinPool($pool_ID,$owner,$username,$destination,$payment);
          if($r==0){
              echo '{"result":0,"message":"Cannot join pool"}';
          }
          else{
            echo '{"result":1,"message":" Pool joined successfully "}';
              $sender="EIBUR";

              $message="You succesfully joined pool";
              $smsmessage = str_replace(' ','%20', $message);
              $ch = curl_init("http://52.89.116.249:13013/cgi-bin/sendsms?username=mobileapp&password=foobar&to=$tel&from=$sender&smsc=smsc&text=$smsmessage");
              curl_exec($ch);

            }

      }

    }



}

function viewPools(){
include_once("user.php");
$obj=new user();
$row=$obj->viewPool();
$results=$obj->fetch();
if(!$results){
  echo '{"result":0,"message":"No available Pools"}';
  return;
}
else{
  while ($re=$obj->fetch()){
    $array[]=$re;
  }

echo json_encode($array);

}
}



function createpool(){
  include_once("user.php");
  $obj=new user();
  if (empty($_REQUEST['name'])||empty($_REQUEST['max']) || empty($_REQUEST['owner']) || empty($_REQUEST['destination']) ||empty($_REQUEST['location'])){
        echo'{"result":0,"message":"Please provide all details"}';
    return;
  }
  else{

    $username	=$_REQUEST["owner"];
    $poolname=$_REQUEST["name"];
    $max=$_REQUEST["max"];
    $destination=$_REQUEST['destination'];
    $location=$_REQUEST['location'];
    $row=$obj->createPool($username,$poolname,$max,$destination,$location);
      if($row==0){
        echo '{"result":0,"message":"Error! Pool cannot be created"}';
        return;
      }
      else{
        echo '{"result":1,"message":" Pool  successfully  created"}';

      }
    }
  }




function signup(){
  include_once("user.php");
  $obj=new user();
  //check if there is a user code
  if (empty($_REQUEST['fname'])||empty($_REQUEST['lname']) || empty($_REQUEST['username']) || empty($_REQUEST['tel']) ||empty($_REQUEST['password'])){
        echo'{"result":0,"message":"Please provide all sign up details"}';
    return;
  }
  else{

    $username	=$_REQUEST["username"];
    $row=$obj->checkUsername($username);
    $results=$obj->fetch();


    if ($results){
      echo '{"result":0,"message":"Error! Username already exist!"}';
    }

    else{

      $fname= $_REQUEST["fname"];
      $lname=$_REQUEST["lname"];
      $tel=$_REQUEST["tel"];
      $password=$_REQUEST["password"];

      $row=$obj->Signup($fname, $lname,$username,$tel, $password);
      if($row==0){
        echo '{"result":0,"message":"Error! User account cannot be created"}';
        return;
      }
      else{
        echo '{"result":1,"message":" User account successfully  created"}';

      }
    }
  }
}


function login(){
  include_once("user.php");
  $obj=new user();
  if(!isset($_REQUEST['username'])||!isset($_REQUEST['password'])){
    echo '{"result":0,"message":"Please provide username and password"}';
    return;
  }
  $username	=$_REQUEST["username"];
  $password=MD5($_REQUEST["password"]);
  $row=$obj->login($username,$password);
  $results=$obj->fetch();

  if(!$results){
    echo '{"result":0,"message":"Wrong username or password"}';
    return;
  }
  else{
    //session_start();
  //  $_SESSION=$results;
  //  header("location: dashboard.html");
  echo json_encode($results);

  }



}




?>

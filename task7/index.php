<?php
include ('config.php');
include ('libs/Controller.php');
include ('libs/View.php');
include ('libs/Model.php');
try
{
    $objContr = new Controller();
    if($_POST)
      {
          print_r($_POST);
      }

  
}
catch(Exception $e)
{
  echo $e->getMessage();	           
}



//include 'templates/indexT.php';




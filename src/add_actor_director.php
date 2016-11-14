<!DOCTYPE html>
<!-- saved from url=(0066)http://oak.cs.ucla.edu/classes/cs143/project/demo/p1c/homepage.php -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>CS143 Project 1c</title>

    <!-- Bootstrap -->
    <link href="./bootstrap.min.css" rel="stylesheet">
    <link href="./project1c.css" rel="stylesheet">

  </head><body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header navbar-defalt">
          <a class="navbar-brand" href="index.html">Movie Database System</a>
        </div>
      </div>
    </nav>

    <div class="container">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <p>&nbsp;&nbsp;Add New Content</p>
            <li><a href="add_actor_director.php">Add Actor/Director</a></li>
            <li><a href="add_movie.php">Add Movie Information</a></li>
            <li><a href="add_movie_actor.php">Add Movie/Actor Relation</a></li>
            <li><a href="add_movie_director.php">Add Movie/Director Relation</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <p>&nbsp;&nbsp;Search Interface</p>
            <li><a href="search.php">Search/Actor Movie</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3>Add New Actor/Director</h3>
            <form method="GET" action="add_actor_director.php">
               <label class="radio-inline">
                    <input type="radio" checked="checked" name="identity" value="Actor">
                    Actor
                </label>
                <label class="radio-inline">
                    <input type="radio" name="identity" value="Director">Director
                </label>
                <div class="form-group">
                  <label for="first_name">First Name</label>
                  <input type="text" class="form-control" placeholder="Text input" name="fname">
                </div>
                <div class="form-group">
                  <label for="last_name">Last Name</label>
                  <input type="text" class="form-control" placeholder="Text input" name="lname">
                </div>
                <label class="radio-inline">
                    <input type="radio" name="sex" checked="checked" value="Male">Male
                </label>
                <label class="radio-inline">
                    <input type="radio" name="sex" value="Female">Female
                </label>
                <div class="form-group">
                  <label for="DOB">Date of Birth</label>
                  <input type="text" class="form-control" placeholder="Text input" name="dateb">ie: 1997-05-05<br>
                </div>
                <div class="form-group">
                  <label for="DOD">Date of Die</label>
                  <input type="text" class="form-control" placeholder="Text input" name="dated">(leave blank if alive now)<br>
                </div>
                <button type="submit" class="btn btn-info">Add</button>
            </form>
<?php

$db = new mysqli('localhost', 'cs143', '', 'CS143');
if($db->connect_errno > 0)
{
    die('Unable to connect to database [' . $db->connect_error . ']');
}
if($_SERVER["REQUEST_METHOD"] == "GET") 
{
    $identity=$_GET['identity'];
    $first_name=$_GET['fname'];
    $last_name=$_GET['lname'];
    $sex=$_GET['sex'];
    $dateofbirth=$_GET['dateb'];
    $dateofdeath=$_GET['dated'];

    if($_GET['identity'])
    {
      echo "<br/>";
      echo "Add Success!<br/>";
   //  echo "$identity $first_name $last_name $sex $dateofbirth $dateofdeath";}

    if (!($id = $db->query("SELECT id From MaxPersonID"))){
        $errmsg = $db->error;
        print "Query failed: $errmsg <br />";
        exit(1);
      } else{
        $personID = mysqli_fetch_assoc($id);
        $newMaxPersonID =  $personID['id']+1;
        $id->free();
      }

    if($identity=='Actor'){
        $query = "INSERT INTO Actor (id,last,first,sex,dob,dod) VALUES($newMaxPersonID,'$last_name','$first_name','$sex', '$dateofbirth','$dateofdeath')";
      }
    else
    {
        $query = "INSERT INTO Director (id,last,first,dob,dod) VALUES($newMaxPersonID,'$last_name','$first_name','$dateofbirth','$dateofdeath')";
    }

    if (!($insert = $db->query($query))){
        $errmsg = $db->error;
        print "Query failed: $errmsg <br />";
        exit(1);
      }

   
    $query="UPDATE MaxPersonID SET id=id+1";
    if (!($increase = $db->query($query))){
        $errmsg = $db->error;
        print "Query failed: $errmsg <br />";
        exit(1);
      }
  }
     $increase->free();
      
     $insert->free();
}
  $db->close();

?>  
        </div>

      </div>
    </div>



</body></html>
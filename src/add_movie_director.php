<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>CS143 Project 1c</title>

    <!-- Bootstrap -->
    <link href="./bootstrap.min.css" rel="stylesheet">
    <link href="./project1c.css" rel="stylesheet">

  <body>

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
            <h3>Add New Movie/Director Relation</h3>
            <form method = 'GET' action='#'> 
                <div class="form-group"><label for="movieid">Movie Title:</label>
                <select class="form-control" name="movieid">
                <option value=NULL> </option>
                
<?php
$db = new mysqli('localhost', 'cs143', '', 'CS143');

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

if($_SERVER["REQUEST_METHOD"] == "GET") 
{
    if (!($title = $db->query("SELECT title From Movie"))){
        $errmsg = $db->error;
        print "Query failed: $errmsg <br />";
        exit(1);
    }
    $nameArray='title';
    if($title->num_rows>0)
    {
      while($row=$title->fetch_assoc()){
    //  $echo=$row[$nameArray];  
   //   $row[$nameArray]=str_replace(' ','&nbsp;',$row[$nameArray]);
?>  
      <option value="<?php echo $row[$nameArray] ?>">
<?php

      echo $row[$nameArray];
?>
      </option>
<?php
      }
    }
?>
                </select></div><br>
                <div class="form-group"><label for="directorid">Director:</label>
                <select class="form-control" name="directorid">
                <option value=NULL> </option>
<?php
    if (!($first = $db->query("SELECT first From Director"))){
        $errmsg = $db->error;
        print "Query failed: $errmsg <br />";
        exit(1);
    }
    if (!($last = $db->query("SELECT last From Director"))){
        $errmsg = $db->error;
        print "Query failed: $errmsg <br />";
        exit(1);
    }
    $nameArray1='first';
    $nameArray2='last';
    if($first->num_rows>0)
    {
      $value=$value+1;
      while($row1=$first->fetch_assoc() and $row2=$last->fetch_assoc()){
        //concatenation
        $directorname=$row1[$nameArray1].' '.$row2[$nameArray2];
   //     $actorname=str_replace(' ','&nbsp;',$actorname);
?>
      <option value="<?php echo "$directorname"?>">
<?php 
      echo $directorname;
?>
      </option>
<?php
      }
    }
?>            
                </select></div><br>

                <div class="form-group"><input type='submit' class="btn btn-info" value='Add'>

<?php

      $movietitle=$_GET['movieid'];
  //    echo "The movie1 u enter is $movietitle1<br/>";
   //   echo "The title1 is $movietitle1<br/>";
   //   $movietitle="Til&nbsp;There&nbsp;Was&nbsp;You";
   //   $movietitle=str_replace('&nbsp;',' ',$movietitle);
 //     echo "The movie u enter is $movietitle<br/>";

  /*    if($movietitle != $movietitle1)
      {
        echo "They are the same.<br/>";
      }   */

      $directorname=explode(" ",$_GET['directorid']);
      $first=$directorname[0];
      $last=$directorname[1];
   //   echo "The director name is $first $last<br/>";

    if(!empty($first))
    {
      echo "<br/><br/>";
      echo "Add Success!<br/>";
  
//we should know the id in Movie table and id in Actor table before we move on.
//echo $movietitle; 
      $query="SELECT id from Movie where title='$movietitle'";
    //  echo $query;
      if (!($select1 = $db->query($query))){
          $errmsg = $db->error;
          echo mysql_error();
          print "Query failed: $errmsg <br />";
          exit(1);
        } 
      $movieID=mysqli_fetch_array($select1); 
    //  echo $movieID[0];
   //   echo "The movie id is $movieID[0]<br/>";

      $query="SELECT id from Director where first='$first' and last='$last'";
   //   echo "$query <br/>";
      if (!($select2 = $db->query($query))){
          $errmsg = $db->error;
          echo mysql_error();
          print "Query failed: $errmsg <br />";
          exit(1);
      }
      $directorID=mysqli_fetch_array($select2);
   //   echo "The director id is $directorID[0]<br/>";   


      $query="INSERT INTO MovieDirector (mid,did) VALUES ($movieID[0],$directorID[0])";
      if (!($insert = $db->query($query))){
          $errmsg = $db->error;
          echo mysql_error();
          print "Query failed: $errmsg <br />";
          exit(1);
        } 
    }  
}

$select1->free();
$select2->free();
$first->free();
$insert->free();
$last->free();
$db->close();
?> 
            </form>   
          </div>
      
      </div>
    </div>

  

</body>
</html>
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
          <a class="navbar-brand" href="index.php">CS143 DataBase Query System (Demo)</a>
        </div>
      </div>
    </nav>

    <div class="container">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <p>&nbsp;&nbsp;Add new content</p>
            <li><a href="main.php">Add Actor/Director</a></li>
            <li><a href="add_movie.php">Add Movie Information</a></li>
            <li><a href="add_movie_actor.php">Add Movie/Actor Relation</a></li>
            <li><a href="add_movie_director.php">Add Movie/Director Relation</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <p>&nbsp;&nbsp;Browsering Content :</p>
            <li><a href="Show_A.php">Show Actor Information</a></li>
            <li><a href="Show_M.php">Show Movie Information</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <p>&nbsp;&nbsp;Search Interface:</p>
            <li><a href="search.php">Search/Actor Movie</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3>Add new Movie</h3>
            <form method="GET" action="add_movie.php">
                <div class="form-group">
                  <label for="title">Title:</label>
                  <input type="text" class="form-control" placeholder="Text input" name="title">
                </div>
                <div class="form-group">
                  <label for="company">Company</label>
                  <input type="text" class="form-control" placeholder="Text input" name="company">
                </div>
                <div class="form-group">
                  <label for="year">Year</label>
                  <input type="text" class="form-control" placeholder="Text input" name="year">
                </div>
                <div class="form-group">
                    <label for="rating">MPAA Rating</label>
                    <select   class="form-control" name="rate">
                        <option value="G">G</option>
                        <option value="NC-17">NC-17</option>
                        <option value="PG">PG</option>
                        <option value="PG-13">PG-13</option>
                        <option value="R">R</option>
                        <option value="surrendere">surrendere</option>
                    </select>
                </div>
                <div class="form-group">
                    <label >Genre:</label>
                    <input type="checkbox" name="genre[]" value="Action">Action</input>
                    <input type="checkbox" name="genre[]" value="Adult">Adult</input>
                    <input type="checkbox" name="genre[]" value="Adventure">Adventure</input>
                    <input type="checkbox" name="genre[]" value="Animation">Animation</input>
                    <input type="checkbox" name="genre[]" value="Comedy">Comedy</input>
                    <input type="checkbox" name="genre[]" value="Crime">Crime</input>
                    <input type="checkbox" name="genre[]" value="Documentary">Documentary</input>
                    <input type="checkbox" name="genre[]" value="Drama">Drama</input>
                    <input type="checkbox" name="genre[]" value="Family">Family</input>
                    <input type="checkbox" name="genre[]" value="Fantasy">Fantasy</input>
                    <input type="checkbox" name="genre[]" value="Horror">Horror</input>
                    <input type="checkbox" name="genre[]" value="Musical">Musical</input>
                    <input type="checkbox" name="genre[]" value="Mystery">Mystery</input>
                    <input type="checkbox" name="genre[]" value="Romance">Romance</input>
                    <input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi</input>
                    <input type="checkbox" name="genre[]" value="Short">Short</input>
                    <input type="checkbox" name="genre[]" value="Thriller">Thriller</input>
                    <input type="checkbox" name="genre[]" value="War">War</input>
                    <input type="checkbox" name="genre[]" value="Western">Western</input>
                </div>
                <button type="submit" class="btn btn-default">Add!</button>
            </form>
<?php

$db = new mysqli('localhost', 'cs143', '', 'CS143');
if($db->connect_errno > 0)
{
    die('Unable to connect to database [' . $db->connect_error . ']');
}
if($_SERVER["REQUEST_METHOD"] == "GET") 
{
    $title=$_GET['title'];
    $company=$_GET['company'];
    $company=htmlspecialchars($company,ENT_QUOTES);
    $year=$_GET['year'];
    $rating=$_GET['rate'];
    $genre=$_GET['genre'];

    if(!empty($title)){
      echo "Add Success!<br/>";
      echo $company;

    if (!($id = $db->query("SELECT id From MaxMovieID"))){
        $errmsg = $db->error;
        print "Query failed: $errmsg <br />";
        exit(1);
      } else{
        $movieID = mysqli_fetch_assoc($id);
        $newMaxMovieID =  $movieID['id']+1;
        $id->free();
      }

    $query = "INSERT INTO Movie (id,title,year,rating,company) VALUES ($newMaxMovieID,'$title',$year,'$rating','$company')";

    if (!($insert = $db->query($query))){
        $errmsg = $db->error;
        echo mysql_error();
        print "Query failed: $errmsg <br />";
        exit(1);
      }  

    if(empty($genre)){
        echo("You didn't select any movie genre.");
      }
    else{
    foreach ($genre as $selected) {
        $query = "INSERT INTO MovieGenre (mid,genre) VALUES ($newMaxMovieID,'$selected')";
        if (!($insertagain = $db->query($query))){
          $errmsg = $db->error;
          echo mysql_error();
          print "Query failed: $errmsg <br />";
          exit(1);
        } 
      }
    }  
    $query="UPDATE MaxMovieID SET id=id+1";
    if (!($increase = $db->query($query))){
       $errmsg = $db->error;
        print "Query failed: $errmsg <br />";
        exit(1);
      }
    }

 
     $increase->free();
      
     $insert->free();

     $insertagain->free();
}

  $db->close();

?>  

        </div>
      </div>
    </div>

</body>
</html>


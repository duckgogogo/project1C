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
            <form method="GET" id="userform">
 <h4><b>Add new comment here : </b></h4> <div class="form-group"><label for="ID">Movie Title:</label><select  name="MovieID" id="ID">

 <?php
$db = new mysqli('localhost', 'cs143', '', 'CS143');
if($db->connect_errno > 0)
{
    die('Unable to connect to database [' . $db->connect_error . ']');
}


if($_SERVER["REQUEST_METHOD"] == "GET") 
{
    
    $id=$_GET['id'];
    $comment=$_GET['comment'];
    $movieid=$_GET['MovieID'];
    if(empty($comment))
    {
    if (!($title = $db->query("SELECT title From Movie where id=$id"))){
        $errmsg = $db->error;
        print "Query failed: $errmsg <br />";
        exit(1);
    } 
    $movietitle = mysqli_fetch_array($title);
?>
    <option value="<?php echo $id ?>"><?php echo $movietitle[0]; ?></option></select></div> 
<?php
  }
  if(!empty($comment))
    {
       if (!($titletitle = $db->query("SELECT title From Movie where id=$movieid"))){
        $errmsg = $db->error;
        print "Query failed: $errmsg <br />";
        exit(1);
      } 
    $movietitlenow = mysqli_fetch_array($titletitle);
?>
       <option value="<?php echo $movieid ?>"><?php echo $movietitlenow[0]; ?></option></select></div> 
<?php
    
}
    
?>
                                
                   <div class="form-group">
                  <label for="title">Your name</label>
                  <input type="text" name="viewer"class="form-control" value="Mr. Anonymous" id="title">
                </div>
                <div class="form-group">
                    <label for="rating">Rating</label>
                    <select  class="form-control" name="score" id="rating">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="form-froup">
                  <textarea class="form-control" name="comment" rows="5"  placeholder="no more than 500 characters" > </textarea><br> 
                </div>
                <button type="submit" class="btn btn-info">Add</button>

        </form> 
<?php
  //  echo "The id is $id<br/>";
  //  echo "movietitlenow is $movietitlenow<br/>";
 //   echo "The movietitle is $movietitle<br/>";
    $name=$_GET['viewer'];
    $time=new Datetime();
    $time=$time->getTimestamp();
  //  echo "$time<br/>";
    $today=date('Y-m-d H:i:s',$time);
//    echo "$today<br/>";
    $rating=$_GET['score'];
    


    if(!empty($name))
    {
      echo "<br/>";
      echo "Add Success!<br/>";
   //  echo "$identity $first_name $last_name $sex $dateofbirth $dateofdeath";}

    $query="INSERT INTO Review (name,time,mid,rating,comment) VALUES ('$name','$today',$movieid,$rating,'$comment')";
    if (!($insert = $db->query($query))){
        $errmsg = $db->error;
        print "Query failed: $errmsg <br />";
        exit(1);
      }
}
     $title->free();
     $titletitle->free();
     $insert->free();
}
  $db->close();

?>   
          </div>
      
      </div>
    </div>

  

</body>
</html>
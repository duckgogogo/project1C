<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CS143 Project 1C</title>

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
            <li><a href="search.php">Search Actor/Movie</a></li>
          </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h3><b> Movie Information Page</b></h3>

            <hr>
            <form class="form-group" action="search.php" method ="GET" id="usrform">
              <input type="submit" value="Go to Search" class="btn btn-primary" style="margin-bottom:10px">
            </form>

            <!-- **********************strat here********************** -->
            
            <?php    
            // connect 
            $db = new mysqli('localhost', 'cs143', '', 'CS143');
            if($db->connect_errno > 0)
              die('Unable to connect to database [' . $db->connect_error . ']');
            // use GET
            if($_SERVER["REQUEST_METHOD"] == "GET") 
            {
              $id=$_GET['id'];
              ?>
              <h4><b>Movie Infomation</b></h4>
              <?php
              $query = "SELECT M.title, M.year, M.company, M.rating FROM (SELECT * FROM Movie WHERE id = ".$id.") M;";
              $query1 = "SELECT CONCAT(MD.first, ' ', MD.last) Dname FROM (SELECT * FROM MovieDirector, Director WHERE MovieDirector.mid = ".$id." AND MovieDirector.did = Director.id) MD;";
              $query2 = "SELECT MG.genre FROM (SELECT * FROM MovieGenre WHERE mid = ".$id.") MG;";
              //$sanitized_name = $db->real_escape_string($query);
              //$query_to_issue = sprintf($query, $sanitized_name);
              if (!($rs = $db->query($query))) 
              {
                $errmsg = $db->error;
                print "Query failed: $errmsg <br />";
                exit(1);
              }
              $row = $rs->fetch_assoc();
              ?>
                Title: <?php echo $row[title]; ?><br>
                Year: <?php echo $row[year]; ?><br>
                Company: <?php echo $row[company]; ?><br>
                Rating: <?php echo $row[rating]; ?><br>                  
              <?php
              if (!($rs = $db->query($query1))) 
              {
                $errmsg = $db->error;
                print "Query failed: $errmsg <br />";
                exit(1);
              }
              $row = $rs->fetch_assoc();
              ?>
                Director: <?php echo $row[Dname]; ?><br>                 
              <?php
              if (!($rs = $db->query($query2))) 
              {
                $errmsg = $db->error;
                print "Query failed: $errmsg <br />";
                exit(1);
              }
              $row = $rs->fetch_assoc();
              ?>
                Genre: <?php echo $row[genre]; ?><br>               
              <?php
              $rs->free();
              ?>
              <hr> 
              <h4><b>Actors in the Movie</b></h4>
              <div class='table-responsive'> 
                <table class='table table-bordered table-condensed table-hover'>
                  <thead> <tr><td><b>Actor</b></td><td><b>Role</b></td></tr></thead>
                  <tbody>
                  <?php
                  $query = "SELECT CONCAT(A.first, ' ', A.last) Aname, MA.role, A.id FROM MovieActor MA, Actor A WHERE MA.mid = ".$id." AND A.id = MA.aid;";
                  //$sanitized_name = $db->real_escape_string($query);
                  //$query_to_issue = sprintf($query, $sanitized_name);
                  if (!($rs = $db->query($query))) 
                  {
                    $errmsg = $db->error;
                    print "Query failed: $errmsg <br />";
                    exit(1);
                  }
                  while($row = $rs->fetch_assoc())
                  {
                    ?>
                    <tr>
                      <script type="text/javascript">
                      function addId(idname){
                      var linkid = "Show_Actor.php?id="+idname;
                      location.href=linkid;
                      }
                    </script>
                    <td><a href="javascript:void(0);"onclick="javascript:addId('<?php echo $row[id];?>');return false;"><?php echo $row[Aname];?></a></td>   <!--********************id********************-->
                    <td><?php echo $row[role];?></td>
                    </tr>
                    <?php
                  }
                  $rs->free();
                  ?>
                  </tbody>
                </table>
              </div>            
              <hr>
              <h4><b>Average Score</b></h4>
              <?php
              $query = "SELECT AVG(rating) score FROM Review WHERE mid = ".$id.";";
              //$sanitized_name = $db->real_escape_string($query);
              //$query_to_issue = sprintf($query, $sanitized_name);
              if (!($rs = $db->query($query))) 
              {
                $errmsg = $db->error;
                print "Query failed: $errmsg <br />";
                exit(1);
              }
              $row = $rs->fetch_assoc();
              if($row[score] == "")
                echo "No average score now!";
              else
                echo "The average score is ".$row[score].".";
              $rs->free();
              $idd = $id;
              ?>
              <br><br>
              <script type="text/javascript">
                  function addIdc(idname){
                      var linkid = "add_movie_review.php?id="+idname;
                      //alert(idname);
                      location.href=linkid;
                      }
              </script>
              <a href="javascript:void(0);"onclick="javascript:addIdc('<?php echo $idd;?>');return false;">Add a new review!</a>
              
              <hr>
              <h4><b>Comments</b></h4>
              <?php
                $query = "SELECT name, time, rating, comment FROM Review WHERE mid = ".$id.";";
                //$sanitized_name = $db->real_escape_string($query);
                //$query_to_issue = sprintf($query, $sanitized_name);
                if (!($rs = $db->query($query))) 
                {
                  $errmsg = $db->error;
                  print "Query failed: $errmsg <br />";
                  exit(1);
                }
                while($row = $rs->fetch_assoc())
                {
                  ?>
                  <b>User name:</b> <?php echo $row[name]; ?><br>
                  <b>Time:</b> <?php echo $row[time]; ?> <br>
                  <b>Score:</b> <?php echo $row[rating]; ?><br>
                  <b>Comment:</b> <?php echo $row[comment]; ?> <br>
                  <br>
                  <?php
                }
                $rs->free();
                $db->close();
              ?>
              <?php
            }

            $rs->free();
            $db->close();

            ?>



            <!-- **********************end here********************** -->
      </div>
    </div>
  </div>
  

</body>
</html>

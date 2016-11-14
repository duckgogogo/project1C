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
          <h3><b> Actor Information Page</b></h3>

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
              <h4><b>Actor Information</b></h4>
              <?php
              $query = "SELECT CONCAT(first, ' ', last) name, sex, dob, dod FROM Actor WHERE id = ".$id.";";
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
                Name: <?php echo $row[name]; ?><br>
                Sexual: <?php echo $row[sex]; ?><br>
                Date of Birth: <?php echo $row[dob]; ?><br>
                Date of Death: <?php if($row[dod] == NULL) echo "Still alive"; else echo $row[dod];?><br>
              <?php
              $rs->free();
              ?>
              <hr> 
              <h4><b>Actor's Movies and Roles:</b></h4>
              <div class='table-responsive'> 
                <table class='table table-bordered table-condensed table-hover'>
                  <thead> <tr><td><b>Role</b></td><td><b>Movie Title</b></td></tr></thead>
                  <tbody>
                  <?php
                  
                  $query = "SELECT MA.role, M.title, M.id FROM MovieActor MA, Movie M WHERE MA.aid = ".$id." AND M.id = MA.mid;";
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
                    <td><?php echo $row[role];?></td>
                    <script type="text/javascript">
                      function addId(idname){
                      var linkid = "Show_Movie_Info.php?id="+idname;
                      location.href=linkid;
                      }
                    </script>
                    <td><a href="javascript:void(0);"onclick="javascript:addId('<?php echo $row[id];?>');return false;"><?php echo $row[title];?></a></td></td>   
                    </tr>
                    <?php
                  }
                  $rs->free();
                  $db->close();
                  ?>
                  </tbody>
                </table>
              </div>            
              <hr>
              <?php
            }
            ?>

            <!-- **********************end here********************** -->
        </div>
      </div>
    </div>
  

</body>
</html>

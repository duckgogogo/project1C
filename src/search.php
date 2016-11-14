<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CS143 Project 1C</title>

    <!-- Bootstrap -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="project1c.css" rel="stylesheet">

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
          <h3><b>Search Information Page</b></h3>

            <hr>
            <label for="search_input">Type the name of actor or movie:</label>
            <form class="form-group" action="search.php" method ="GET" id="usrform">
              <input type="text" id="search_input"class="form-control" placeholder="Search..." name="keyword"><br>
              <input type="submit" value="Search Actor" class="btn btn-info" name="type" style="margin-bottom:10px">
              <input type="submit" value="Search Movie" class="btn btn-success" name="type" style="margin-bottom:10px">
              <input type="submit" value="Search All" class="btn btn-danger" name="type" style="margin-bottom:10px">
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
              $type = $_GET['type'];
              $keyword = $_GET['keyword'];
           //   echo $keyword."<br>";
              if($type == "Search Actor" || $type == "Search All")
              {
                ?>
                <h4><b>Matching Actors are:</b></h4>
                <div class='table-responsive'> 
                  <table class='table table-bordered table-condensed table-hover'>
                    <thead><tr><td><b>Name</b></td><td><b>Sexual</b></td><td><b>Date of Birth</b></td><td><b>Date of Deadth</b></td></tr></thead>
                    <tbody>
                    <?php
                    $array = explode(' ', $keyword);
                    if($keyword != "")
                    {
                      $query = "SELECT id, CONCAT(first, ' ', last) name, sex, dob, dod FROM Actor WHERE (first LIKE '%".$array[0]."%' OR last LIKE '%".$array[0]."%') ";
                      for ($i = 1; $i<count($array); $i++)
                        $query = $query."AND (first LIKE '%".$array[$i]."%' OR last LIKE '%".$array[$i]."%') ";
                    }
                    else
                      $query = "SELECT id, CONCAT(first, ' ', last) name, sex, dob, dod FROM Actor;";
                 //   echo $query;
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
                      function addIda(idname){
                      var linkid = "Show_Actor.php?id="+idname;
                      location.href=linkid;
                      }
                    </script>
                      <td><a href="javascript:void(0);"onclick="javascript:addIda('<?php echo $row[id];?>');return false;"><?php echo htmlspecialchars($row[name]);?></a></td>      
                      <td><?php echo $row[sex];?></td>
                      <td><?php echo $row[dob];?></td>
                      <td><?php if($row[dod] == NULL) echo "Still alive"; else echo $row[dod];?></td>
                      </tr>
                      <?php
                    }
                    $rs->free();
                    
                    ?>
                    </tbody>
                  </table>
                </div>
                <?php
              }
              if($type == "Search Movie" || $type == "Search All")
              {
                ?>
                <h4><b>Matching Movies are:</b></h4>
                <div class='table-responsive'> 
                  <table class='table table-bordered table-condensed table-hover'>
                    <thead><tr><td><b>Title</b></td><td><b>Year</b></td><td><b>Company</b></td><td><b>Rating</b></td></tr></thead>
                    <tbody>
                    <?php
                    $array = explode(' ', $keyword);
                    if($keyword != "")
                    {
                      $query = "SELECT id, title, year, rating, company FROM Movie WHERE title LIKE '%".$array[0]."%' ";
                      for ($i = 1; $i<count($array); $i++)
                        $query = $query."AND title LIKE '%".$array[$i]."%' ";
                    }
                    else
                      $query = "SELECT id, title, year, rating, company FROM Movie;";
                    //echo $query;
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
                      function addIdm(idname){
                      var linkid = "Show_Movie_Info.php?id="+idname;
                      location.href=linkid;
                      }
                    </script>
                      <td><a href="javascript:void(0);"onclick="javascript:addIdm('<?php echo $row[id];?>');return false;"><?php echo htmlspecialchars($row[title]);?></a></td>   
                      <td><?php echo $row[year];?></td>
                      <td><?php echo htmlspecialchars($row[company]);?></td>
                      <td><?php echo $row[rating];?></td>
                      </tr>
                      <?php
                    }
                    $rs->free();
                    
                    ?>
                    </tbody>
                  </table>
                </div>
                <?php
              }
              $db->close();
            }
            ?>

            <!-- **********************end here********************** -->
        </div>
      </div>
    </div>
  

</body>
</html>

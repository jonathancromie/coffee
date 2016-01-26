<!DOCTYPE html>
<html lang="en">

<?php include 'includes/header.inc';?>

<body>
  <?php include 'includes/menu.inc';?>

  <?php

    require 'includes/config.inc';

    $rec_limit = 10;
    $conn = mysql_connect($dbhost, $dbuser, $dbpass);

    if(! $conn ) {
      die('Could not connect: ' . mysql_error());
    }
    mysql_select_db('coffee');

    /* Get total number of records */
    $sql = "SELECT count(id) FROM coffee ";
    $retval = mysql_query( $sql, $conn );

    if(! $retval ) {
      die('Could not get data: ' . mysql_error());
    }
    $row = mysql_fetch_array($retval, MYSQL_NUM );
    $rec_count = $row[0];

    if( isset($_GET{'page'} ) ) {
      $page = $_GET{'page'} + 1;
      $offset = $rec_limit * $page ;
    }else {
      $page = 0;
      $offset = 0;
    }

    $left_rec = $rec_count - ($page * $rec_limit);
    $sql = "SELECT id, title, url, image, category ".
      "FROM coffee WHERE category = 'Dessert'".
      "LIMIT $offset, $rec_limit";

    $retval = mysql_query( $sql, $conn );

    if(! $retval ) {
      die('Could not get data: ' . mysql_error());
    }

  ?>

  <div class='container'>
    <div class='row'>
      <?php
        while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
          echo ("<div class='col-md-4'>
            <div class='card hoverable'>
              <div class='card-image'>
                <img src={$row['image']}>
                <span class='card-title'>{$row['title']}</span>
              </div>
              <!-- <div class='card-content'>
                <p>Some things just look better in motion and in the highly competitive world of fashion, finding an edge over the competition is crucial. When it comes to clothes ...</p>
              </div> -->
              <div class='card-action'>
                <a href={$row['url']}>
                  <button type='button' class='btn btn-info waves-effect waves-light'>Read more</button>
                </a>
              </div>
            </div>
          </div>");
        }

        echo "<div class='row text-center'>";
        echo "<div class='col-lg-12'>";
        echo "<ul class='pagination'>";

        if( $page > 0 ) {
          $last = $page - 2;
          echo "<a href='{$_SERVER['PHP_SELF']}?page = $last\">&laquo;/a> |";
          echo "<a href='{$_SERVER['PHP_SELF']}?page = $page\">&raquo;</a>";
        }else if( $page == 0 ) {
          //echo "<a href='{$_SERVER['PHP_SELF']}?page = $page\">&raquo;/a>";
        }else if( $left_rec < $rec_limit ) {
          $last = $page - 2;
          echo "<a href='{$_SERVER['PHP_SELF']}?page = $last\">&laquo;</a>";
        }

        echo "</ul>";
        echo "</div>";
        echo "</div>";

      ?>
  </div>

   <?php include 'includes/footer.inc';?>
   <?php include 'includes/scripts.inc';?>
</body>
</html>

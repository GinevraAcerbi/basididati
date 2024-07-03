<?php
include "utils/sql.php";
?>
<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> LPW GinevraAcerbi </title>
  <link rel="stylesheet" type="text/css" href="style/index.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/6911c927ab.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
  <header class="border-bottom 1h-1 py-3">
    <div class="row flex-nowrap justify-content-between align-items-center fst-italic">
      <div class="col-4 text-center">
        <a class="blog-header-logo text-decoration-none" style="color:pink" href="index.php">
          <h1>TalkaboutAnything</h1>
        </a>
      </div>
      <div class="col-7 d-flex justify-content-end align-items-center">
        <div id="searchbarWrapper" class="autocomplete" style="width:250px;">
          <input id="searchBar" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        </div>
        <button class="btn" type="submit"><i class="fa-solid fa-search"></i></button>
        &nbsp;&nbsp;&nbsp;
        <?php
        if (isset($_SESSION['sess_user'])){
          echo '<a class="btn btn-sm btn-outline-secondary" style="margin:2%;" href="profile.php"><i class="fa-solid fa-user"></i></a>';
          echo '<a class="btn btn-sm btn-outline-secondary" style="margin:2%;"  href="crea.php"><i class="fa-solid fa-circle-plus"></i></a>';
        }else
          echo '<a class="btn btn-sm btn-outline-secondary" style="margin:2%;"  href="login.php"><i class="fa-solid fa-user"></i></a>';
        ?>
        <?php
        if(isset($_SESSION['sess_user'])) {
          $userName= query_get_int("utente", ["nome"], ["id_utente" => intval($_SESSION["sess_user"])]);
          echo '<span>benvenuto, ';
          echo $userName[0]['nome'];
          echo '</span>';
        }
        ?>
      </div>
    </div>
  </header>
  <div id="divBlogBar" class="nav-scroller py-1 mb-3 border-bottom fst-italic">
    <nav class="nav nav-underline justify-content-between">
      <a name="navbar_-1" class="nav-item nav-link link-body-emphasis" href="index.php">Home</a>
      <?php
      $allBlogs=query_get("blog",["id_blog", "titolob"]);
      foreach ($allBlogs as $blog) {
        echo "<a class='nav-item nav-link link-body-emphasis' name='navbar_".$blog["id_blog"]."'  href='blog.php?id_blog=".$blog['id_blog']."'>".$blog['titolob']."</a>";
      }
      ?>
    </nav>
  </div>
  <script>
  $(document).ready(function() {
    var activeNavbar="a[name='navbar_"+localStorage.getItem("blogId")+"']";
    $(activeNavbar).addClass("active");
    localStorage.setItem("blogId", "");
    $("#searchBar").keyup(function() {
      if($('#searchBar').val()!="")
        $.ajax({
          type: "POST",
          url: "search.php",
          data: {"search": $('#searchBar').val()},
          success: function(data) {
            set_results(jQuery.parseJSON(data));
          }
        });
    });

    $('a[name^="navbar_"]').click(function(){
      var blog=$(this).attr("name").split('_')[1];
      localStorage.setItem("blogId", blog);
    });

    function set_results(data) {
      // Close any already open lists of autocompleted values
      closeAllLists();
      
      // Create a DIV element that will contain the items (values)
      var $autocompleteList = $("<div id='searchBar-autocomplete-list'>").addClass("autocomplete-items");
  
      // Append the DIV element as a child of the autocomplete container
      $("#searchbarWrapper").append($autocompleteList);
      
      var i=0;
      // For each item in the results
      for(i=0; i<data.length; i++){
        // Create a DIV element for each matching element
        var $item = $("<div id='item" + i + "'>");
      
        // Insert a input field that will hold the current array item's value
        if (data[i].name == "titolob") {
          $item.html("Titolo Blog: " + data[i].value + "<input type='hidden' value='titolo_"+ data[i].value +"'>");
        } else if (data[i].name == "descrizioneb") {
          $item.html("Descrizione Blog: " + data[i].value + "<input type='hidden' value='descrizione_"+ data[i].value +"'>");
        } else if (data[i].name == "descrcat") {
          $item.html("Categoria: " + data[i].value + "<input type='hidden' value='categoria_" + data[i].value + "'>");
        } else if (data[i].name == "email") {
          $item.html("Utente: " + data[i].value + "<input type='hidden' value='utente_" + data[i].value + "'>");
        }
        
        // Execute a function when someone clicks on the item value (DIV element)
        $item.on("click", function() {
          $("#searchBar").val($(this).find("input").val());
          closeAllLists();
          var key = $(this).find("input").val().split('_')[0];
          var value = $(this).find("input").val().split('_')[1];
          if(key == "titolo"){
            $.ajax({
              type: "POST",
              url: "completeSearch.php",
              data: {"titolob": value},
              success: function(data) {
                window.location.href = "blog.php?id_blog=" + data;
              }
            });
          } else if(key=="descrizione"){
            $.ajax({
              type: "POST",
              url: "completeSearch.php",
              data: {"descrizioneb": value},
              success: function(data) {
                window.location.href = "blog.php?id_blog=" + data;
              }
            });
          } else if(key=="categoria"){
            $.ajax({
              type: "POST",
              url: "completeSearch.php",
              data: {"descrcat": value},
              success: function(data) {
                window.location.href = "categorie.php?id_cat=" + data;
              }
            });
          } else if(key=="utente"){
            window.location.href = "blogsutente.php?user=" + value;
          }
        });
        
        $autocompleteList.append($item);
      }
      $autocompleteList.show();
    }

    function closeAllLists(elmnt) {
      // Close all autocomplete lists in the document, except the one passed as an argument
      $(".autocomplete-items").not(elmnt).remove();
    }
  });
</script>
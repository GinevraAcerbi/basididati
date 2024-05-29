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
      <div class="col-4 d-flex justify-content-end align-items-center">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn" type="submit"><i class="fa-solid fa-search"></i></button>
        &nbsp;&nbsp;&nbsp;
        <a class="btn btn-sm btn-outline-secondary" href="#"><i class="fa-solid fa-user"></i></a>
      </div>
    </div>
  </header>
  <div id="divBlogBar" class="nav-scroller py-1 mb-3 border-bottom fst-italic">
    <nav class="nav nav-underline justify-content-between">
      <a class="nav-item nav-link link-body-emphasis active" href="index.php">Home</a>
      <?php
      $allBlogs=query_get("blog",["id_blog", "titolob"]);
      foreach ($allBlogs as $blog) {
        echo "<a class='nav-item nav-link link-body-emphasis' href='blog.php?id_blog=".$blog['id_blog']."'>".$blog['titolob']."</a>";
      }
      ?>
    </nav>
  </div>
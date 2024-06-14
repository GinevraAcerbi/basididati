  <?php
  include "./common/header.php";
  ?>

  <div class="paginainiziale">
    <div id="sfondopezzo" class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
      <div class="col-lg-6 px-0">
        <h1 class="display-4 fst-italic">Benvenuto in TalkaboutAnything</h1>
        <p class="lead my-3">Benvenuto! se è la tua prima volta sul nostro blog ti consigliamo di aprire questa pagina e leggere le regole!</p>
        <p class="lead mb-0"><a href="regole.php" class="text-body-emphasis fw-bold">continua a leggere...</a></p>
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <?php
    //passo da post a blog  a categoria
    $ultimiPosts=query_get_join(
      ["post", "blog", "categoria"],
      ["post.id_post","post.titolop","post.testop","categoria.descrcat"],
      [],
      [
      "post.id_blog_p" => "blog.id_blog", 
      "blog.id_cat_b" => "categoria.id_cat"
      ],
      ["post.data", "post.ora"],
      "DESC",
      "4"
    );
    foreach($ultimiPosts as $post){
    ?>
    <div class="col-md-6">
      <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-primary-emphasis"><?php echo($post["descrcat"]) ?></strong>
          <h3 class="mb-0"><?php echo($post["titolop"]) ?></h3>
          <p class="card-text mb-auto"><?php echo($post["testop"]) ?></p>
          <a href="post.php?id_post=<?php echo($post['id_post']) ?>" class="icon-link gap-1 icon-link-hover stretched-link">
            Continua a leggere
          </a>
        </div>
        <div class="col-auto d-none d-lg-block">
          <?php 
          $img = query_get("immagine", ["percorso"], ["id_post_imm" => $post["id_post"]]);
          if(!$img)
            $img[0]["percorso"]="";
          ?>
          <img width="200px" height="250px" style="background-color:pink" src="<?php echo($img[0]["percorso"]) ?>"/>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
<?php
  include "./common/footer.php";
?>
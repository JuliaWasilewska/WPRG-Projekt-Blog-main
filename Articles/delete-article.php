
<?php
require 'includes/db_connection.php';
require 'includes/article-functions.php';
require 'includes/url.php';
require 'includes/auth.php';

session_start();
$conn = getDBconn();

if (isset($_GET['id'])) {

  $article = getArticle($conn, $_GET['id'], 'id');

  if ($article) {

    $id = $article['id'];

  }

  else {
    die("article not found!");
  }



  }
else {
  die("id not supplied, article not found!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $sql = "DELETE FROM article
          WHERE id = ?";

  $stmt = mysqli_prepare($conn, $sql);

  if ($stmt === false ){

    echo mysqli_error($conn);

    }
  else {
    mysqli_stmt_bind_param($stmt, "i", $id);

    if(mysqli_stmt_execute($stmt)) {

      redirect("/Articles/Index.php");

      }
    else {
      echo mysqli_stmt_error($stmt);
      }
    }
}
?>


<?php require 'includes/header.php'; ?>

<h3><a href="Index.php">Main page</a></h3>

<?php if (isLoggedIn()): ?>
<form method="post">
  <p>Are you sure you want to delete this article?</p>
  <button>Delete</button>
  <a href="article.php?id=<?= $article['id']; ?>">Cancel</a>
</form>
<?php else: ?>
  <a href="/Articles/login.php">Log in </a> to access author panel <br>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>

<?php
define('PAGE', 'cadastro');
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php' ?>

<body>

  <?php include 'navbar.php' ?>

  <main class="container my-3 heightfill">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header d-flex flex-row justify-content-between align-items-center">
            <h3 class="card-title align-middle h-100 pt-2">Cadastro</h3>
          </div>
          <div class="card-body">
            <form action="./cadastro.php?action=register" method="post">
              <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control">
              </div>
              <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control">
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Cadastrar">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include 'footer.php' ?>

</body>

</html>
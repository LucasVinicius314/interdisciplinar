<?php
define('PAGE', 'categorias');
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php' ?>

<body>

  <?php include 'navbar.php' ?>

  <main class="container my-3 heightfill">
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cadastrar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="categorias.php?action=create&class=categoria" method="post">
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="nome">Nome</label>
                    <input class="form-control" type="text" name="nome" id="nome" required>
                  </div>
                </div>
                <div class="col-12 flex-row-reverse">
                  <div class="form-group float-right">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Cadastrar" />
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex flex-row justify-content-between align-items-center">
            <h3 class="card-title align-middle h-100 pt-2">Categorias</h3>
            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i></button>
          </div>
          <div class="card-body">
            <table id="categorias" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nome</th>
                  <th>-</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach (Connection::QueryAll("select * from categoria") as $item) { ?>
                  <tr>
                    <td><?= $item->id ?></td>
                    <td><?= $item->nome ?></td>
                    <td><a class="btn btn-danger" href="./categorias.php?action=delete&class=categoria&id=<?= $item->id ?>"><i class="fa fa-trash"></i></a></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include 'footer.php' ?>

</body>

<script>
  $(document).ready(() => {
    $('#categorias').DataTable()
  })
</script>

</html>
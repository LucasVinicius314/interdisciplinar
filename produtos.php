<?php
define('PAGE', 'produtos');
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php' ?>

<body>

  <?php include 'navbar.php' ?>

  <main class="container my-3">

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
            <form action="produtos.php?action=create&class=produto" method="post">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="codigo">Código de Barras</label>
                    <input class="form-control" type="text" name="codigo" id="codigo" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nome">Nome do Produto</label>
                    <input class="form-control" type="text" name="nome" id="nome" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="volume">Volume</label>
                    <input class="form-control" type="number" name="volume" id="volume" value="1" min="0" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="medida">Unidade de Medida</label>
                    <input class="form-control" type="text" name="medida" id="medida" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <select class="form-control" name="categoria" id="categoria" required>
                      <?php foreach (Connection::QueryAll("select * from categoria") as $item) { ?>
                        <option value="<?= $item->id ?>"><?= $item->nome ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="fornecedor">Fornecedor</label>
                    <select class="form-control" name="fornecedor" id="fornecedor" required>
                      <?php foreach (Connection::QueryAll("select * from fornecedor") as $item) { ?>
                        <option value="<?= $item->id ?>"><?= $item->razao_social ?></option>
                      <?php } ?>
                    </select>
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
            <h3 class="card-title align-middle h-100 pt-2">Produtos</h3>
            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i></button>
          </div>
          <div class="card-body">
            <table id="produtos" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Código</th>
                  <th>Nome</th>
                  <th>Quantidade</th>
                  <th>Categoria</th>
                  <th>Fornecedor</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach (Connection::QueryAll("select * from ver_produto") as $item) { ?>
                  <tr>
                    <td><?= $item->codigo_barra ?></td>
                    <td><?= $item->nome ?></td>
                    <td><?= $item->quantidade ?></td>
                    <td><?= $item->categoria ?></td>
                    <td><?= $item->razao_social ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>

<script>
  $(document).ready(() => {
    $('#produtos').DataTable()
  })
</script>

</html>
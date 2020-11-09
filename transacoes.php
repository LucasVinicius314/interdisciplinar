<?php
define('PAGE', 'transacoes');
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php' ?>

<body>

  <?php include 'navbar.php' ?>

  <main class="container my-3">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title h-100 pt-2">Transações</h3>
          </div>
          <div class="card-body">
            <table id="transacoes" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Tipo</th>
                  <th>Data</th>
                  <th>Quantidade</th>
                  <th>Preço</th>
                  <th>Produto</th>
                  <th>Usuário</th>
                  <th>-</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach (Connection::QueryAll("select * from ver_transacao") as $item) { ?>
                  <tr>
                    <td><?= $item->tipo ?></td>
                    <td><?= $item->data ?></td>
                    <td><?= $item->quantidade ?></td>
                    <td><?= $item->preco ?></td>
                    <td><?= $item->pnome ?></td>
                    <td><?= $item->usuario ?></td>
                    <td><a class="btn btn-danger" href="./transacoes.php?action=delete&class=transacao&id=<?= $item->id ?>"><i class="fa fa-trash"></i></a></td>
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
    $('#transacoes').DataTable()
  })
</script>

</html>
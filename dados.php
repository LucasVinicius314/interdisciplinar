<?php
define('PAGE', 'dados');
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
            <h3 class="card-title">Produtos</h3>
          </div>
          <div class="card-body">
            <table id="example" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Código</th>
                  <th>Nome</th>
                  <th>Quantidade</th>
                  <th>Compra</th>
                  <th>Venda</th>
                  <th>Categoria</th>
                  <th>Fornecedor</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach (Connection::QueryAll("select * from ver_produto") as $item) { ?>
                  <tr>
                    <td><?= $item->codigo_barra ?></td>
                    <td><?= $item->nome ?></td>
                    <td><?= $item->quantidade_estoque ?></td>
                    <td>R$ <?= Util::Money($item->preco_compra) ?></td>
                    <td>R$ <?= Util::Money($item->preco_venda) ?></td>
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
    $('#example').DataTable()
  })
</script>

</html>
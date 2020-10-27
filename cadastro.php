<?php
define('PAGE', 'cadastro');
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
            <h3 class="card-title">Cadastro</h3>
          </div>
          <div class="card-body">
            <form action="cadastro.php?action=create" method="post">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="data">Data da Movimentação</label>
                    <input class="form-control" type="date" name="data" id="data" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="compra">Tipo de Transação</label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="tipo" id="compra" value="compra" checked>
                      <label class="form-check-label" for="compra">Compra</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="tipo" id="venda" value="venda">
                      <label class="form-check-label" for="venda">Venda</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="codigo">Código de Barras</label>
                    <input class="form-control" type="text" name="codigo" id="codigo" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="preco">Preço</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">R$</div>
                      </div>
                      <input class="form-control" type="number" name="preco" id="preco" min="0" step="0.01" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nome">Nome do Produto</label>
                    <input class="form-control" type="text" name="nome" id="nome" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="quantidade">Quantidade</label>
                    <input class="form-control" type="number" name="quantidade" id="quantidade" min="0" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="volume">Volume</label>
                    <input class="form-control" type="number" name="volume" id="volume" min="0" required>
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
                    <input class="btn btn-success" type="submit" value="Inserir">
                    <input class="btn btn-light" type="button" value="Cancelar" id="cancelar">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>

<script>
  $(document).ready(() => $('#cancelar').on('click', () => location = 'dados.php'))
</script>

</html>
<?php
define('PAGE', 'transacao');
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php' ?>

<body>

  <?php include 'navbar.php' ?>

  <main class="container my-3 heightfill">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title h-100 pt-2">Transação</h3>
          </div>
          <div class="card-body">
            <form action="transacoes.php?action=create&class=transacao" method="post">
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
                    <input class="form-control" type="text" name="nome" id="nome" required disabled>
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
                    <input class="form-control" type="number" name="volume" id="volume" min="0" required disabled>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="medida">Unidade de Medida</label>
                    <input class="form-control" type="text" name="medida" id="medida" required disabled>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 flex-row-reverse">
                  <div class="form-group float-right">
                    <input class="btn btn-success" type="submit" value="Inserir">
                    <input class="btn btn-light" type="button" value="Cancelar" id="cancelar">
                  </div>
                </div>
              </div>
              <input type="hidden" name="produto_id" id="produto_id">
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include 'footer.php' ?>

</body>

<script>
  const {
    log
  } = console
  $(document).ready(() => {
    $('#cancelar').on('click', () => location = 'produtos.php')
    $('#codigo').on('keyup', function() {
      const el = $(this)
      if (el.val().length === 0) return
      if (!el.val().match(/\d+/)) return
      fetch(`./busca.php?action=search&codigo=${el.val()}`)
        .then(d => d.json())
        .then(d => log(d) || d)
        .then(d => {
          $('#nome').val(d.nome)
          $('#volume').val(d.volume)
          $('#medida').val(d.unidade_medida)
          $('#produto_id').val(d.id)
        })
        .catch(log)
    })
  })
</script>

</html>
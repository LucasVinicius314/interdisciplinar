<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Interdisciplinar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <?php if ($_SESSION['usuario'] ?? null) { ?>
        <li class="nav-item <?= PAGE === 'categorias' ? 'active' : '' ?>">
          <a class="nav-link" href="categorias.php">Categorias</a>
        </li>
        <li class="nav-item <?= PAGE === 'fornecedores' ? 'active' : '' ?>">
          <a class="nav-link" href="fornecedores.php">Fornecedores</a>
        </li>
        <li class="nav-item <?= PAGE === 'produtos' ? 'active' : '' ?>">
          <a class="nav-link" href="produtos.php">Produtos</a>
        </li>
        <li class="nav-item <?= PAGE === 'transacoes' ? 'active' : '' ?>">
          <a class="nav-link" href="transacoes.php">Transações</a>
        </li>
        <li class="nav-item <?= PAGE === 'transacao' ? 'active' : '' ?>">
          <a class="nav-link" href="transacao.php">Transação</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php?action=logout">Sair</a>
        </li>
        <li class="nav-item active">
          <h5 class="nav-link">Olá, <?= $_SESSION['usuario']->nome ?></h4>
        </li>
      <?php } else { ?>
        <li class="nav-item <?= PAGE === 'login' ? 'active' : '' ?>">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item <?= PAGE === 'cadastro' ? 'active' : '' ?>">
          <a class="nav-link" href="cadastro.php">Cadastro</a>
        </li>
      <?php } ?>
    </ul>
  </div>
</nav>
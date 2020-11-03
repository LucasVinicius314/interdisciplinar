<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Interdisciplinar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item <?= PAGE === 'produtos' ? 'active' : '' ?>">
        <a class="nav-link" href="produtos.php">Produtos</a>
      </li>
      <li class="nav-item <?= PAGE === 'transacao' ? 'active' : '' ?>">
        <a class="nav-link" href="transacao.php">Transação</a>
      </li>
    </ul>
  </div>
</nav>
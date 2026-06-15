<?php

include("../conexao.php");

$pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
$status   = isset($_GET['status'])   ? $_GET['status']   : '';

if (isset($_GET['excluir'])) {
  $idExcluir = (int) $_GET['excluir'];
  $stmtExcluir = mysqli_prepare($conn, "DELETE FROM clientes WHERE id_cliente = ?");
  mysqli_stmt_bind_param($stmtExcluir, "i", $idExcluir);
  mysqli_stmt_execute($stmtExcluir);

  // Redireciona para a própria página sem o parâmetro 'excluir'
  header("Location: visualizacao-clientes.php");
  exit;
}

$sql = "SELECT c.id_cliente, c.nome_responsavel, c.nome_empresa, c.email, c.telefone,
               COALESCE(
                 (SELECT os.status FROM ordens_servico os
                  WHERE os.id_cliente = c.id_cliente
                  ORDER BY os.data_atualizacao DESC LIMIT 1),
                 'Sem OS'
               ) AS ultimo_status
        FROM clientes c
        WHERE 1=1";

$params = [];
$types  = "";

if ($pesquisa !== '') {
  $sql .= " AND (c.nome_responsavel LIKE ? OR c.nome_empresa LIKE ? OR c.email LIKE ?)";
  $termo = "%" . $pesquisa . "%";
  $params[] = $termo;
  $params[] = $termo;
  $params[] = $termo;
  $types .= "sss";
}

if ($status !== '' && $status !== 'Todos os Status') {
  $sql .= " AND (SELECT os.status FROM ordens_servico os
                   WHERE os.id_cliente = c.id_cliente
                   ORDER BY os.data_atualizacao DESC LIMIT 1) = ?";
  $params[] = $status;
  $types .= "s";
}

$sql .= " ORDER BY c.nome_empresa ASC";


$stmt = mysqli_prepare($conn, $sql);
if ($params) {
  mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$total = mysqli_num_rows($resultado);
?>
<!doctype html>
<html lang="pt-BR" data-bs-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TTC Automação — Clientes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../shared/global.css">
  <link rel="stylesheet" href="clientes.css">
  <style>
    /* === BODY === */
    [data-bs-theme="light"] body {
      background-color: #f5f5f5;
    }

    /* === BOTÃO PRIMARY === */
    [data-bs-theme="light"] .btn-primary {
      background-color: #378cb1;
      color: #f5f5f5;
      --bs-btn-border-color: #378cb1;
      --bs-btn-hover-bg: #173b4b;
      --bs-btn-hover-border-color: #173b4b;
      --bs-btn-active-bg: #173b4b;
    }

    /* === BARRA DE PESQUISA === */
    .clientes-search-bar {
      background-color: #ffffff;
      border: 1px solid #cccccc;
      border-radius: 8px;
    }

    [data-bs-theme="dark"] .clientes-search-bar {
      background-color: #2c2c2c;
      border-color: #555555;
    }

    /* === CARD DE CLIENTE === */
    .cliente-card {
      border-radius: 10px;
      border: 1px solid #cccccc;
      border-left: 4px solid #378cb1;
      background-color: #ffffff;
      transition: box-shadow 0.2s;
    }

    .cliente-card:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    [data-bs-theme="dark"] .cliente-card {
      background-color: #333333;
      border-color: #555555;
      border-left: 4px solid #378cb1;
    }

    .empresa-nome {
      font-size: 1.1rem;
      font-weight: 700;
    }

    .cliente-info {
      font-size: 0.9rem;
      color: #555555;
    }

    [data-bs-theme="dark"] .cliente-info {
      color: #aaaaaa;
    }

    /* === BOTÕES DE AÇÃO === */
    .btn-acao {
      width: 36px;
      height: 36px;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 6px;
    }

    /* === BADGES DE STATUS === */
    .badge-concluido {
      background-color: #28a745;
      color: #fff;
      font-size: 0.8rem;
      padding: 4px 10px;
      border-radius: 20px;
    }

    .badge-pendente {
      background-color: #ffc107;
      color: #2c2c2c;
      font-size: 0.8rem;
      padding: 4px 10px;
      border-radius: 20px;
    }

    .badge-em-andamento {
      background-color: #378cb1;
      color: #fff;
      font-size: 0.8rem;
      padding: 4px 10px;
      border-radius: 20px;
    }

    .badge-sem-os {
      background-color: #aaaaaa;
      color: #fff;
      font-size: 0.8rem;
      padding: 4px 10px;
      border-radius: 20px;
    }

    /* === CONTADOR E VAZIO === */
    .clientes-contador {
      font-size: 0.9rem;
      color: #888;
      text-align: center;
      margin-top: 1rem;
    }

    .clientes-vazio {
      text-align: center;
      color: #888;
      margin-top: 5rem;
      font-size: 0.95rem;
    }

    /* === DROPDOWN FILTRO === */
    .filtro-status {
      min-width: 160px;
    }
  </style>
</head>

<body class="d-flex flex-column min-vh-100 m-0 p-0">

  <header
    class="container-fluid text-center m-0 w-100 h-100 rounded-bottom-4">
    <div class="row p-2">
      <div class="col d-flex justify-content-start ps-5">
        <a class="rounded-4 p-1 a" href="../index.php">
          <img
            class="logoImg"
            src="../assets/img/logotipoPreta.png"
            alt="Logo Completa Versão Preta" />
        </a>
      </div>
      <div class="col-6 d-flex justify-content-between align-items-center">
        <a class="headerLink rounded-4 p-1 a" href="#sobreNos">Sobre nós</a>
        <a class="headerLink rounded-4 p-1 a" href="#servicos">Serviços</a>
        <a class="headerLink rounded-4 p-1 a" href="#orcamento">Orçamento </a>
      </div>
      <div class="col d-flex justify-content-end align-items-center pe-5">
        <button id="themeToggleBtn" class="theme-toggle-btn rounded-circle p-2 d-flex">
          <svg id="themeIconSun" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun-icon lucide-sun">
            <circle cx="12" cy="12" r="4" />
            <path d="M12 2v2" />
            <path d="M12 20v2" />
            <path d="m4.93 4.93 1.41 1.41" />
            <path d="m17.66 17.66 1.41 1.41" />
            <path d="M2 12h2" />
            <path d="M20 12h2" />
            <path d="m6.34 17.66-1.41 1.41" />
            <path d="m19.07 4.93-1.41 1.41" />
          </svg>
          <svg
            id="themeIconMoon"
            xmlns="http://www.w3.org/2000/svg"
            width="30"
            height="30"
            viewBox="0 0 24 24"
            fill="none"
            stroke="white"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="lucide lucide-moon-icon lucide-moon">
            <path
              d="M20.985 12.486a9 9 0 1 1-9.473-9.472c.405-.022.617.46.402.803a6 6 0 0 0 8.268 8.268c.344-.215.825-.004.803.401" />
          </svg>
        </button>
        <a class="rounded-4 p-2 d-flex a" href="../login/login.php">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="30"
            height="30"
            viewBox="0 0 24 24"
            fill="none"
            stroke="white"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="lucide lucide-user-round-cog-icon lucide-user-round-cog">
            <path d="m14.305 19.53.923-.382" />
            <path d="m15.228 16.852-.923-.383" />
            <path d="m16.852 15.228-.383-.923" />
            <path d="m16.852 20.772-.383.924" />
            <path d="m19.148 15.228.383-.923" />
            <path d="m19.53 21.696-.382-.924" />
            <path d="M2 21a8 8 0 0 1 10.434-7.62" />
            <path d="m20.772 16.852.924-.383" />
            <path d="m20.772 19.148.924.383" />
            <circle cx="10" cy="8" r="5" />
            <circle cx="18" cy="18" r="3" />
          </svg>
        </a>
      </div>
    </div>
  </header>

  <main class="flex-fill container my-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="m-0">Clientes e Ordens de Serviço</h2>
      <a href="../novo-cliente/novo-cliente.php" class="btn btn-primary">Novo Cliente +</a>
    </div>

    <form method="GET" action="visualizacao-clientes.php" class="clientes-search-bar p-3 mb-4 d-flex gap-2">
      <div class="input-group">
        <span class="input-group-text border-0 bg-transparent">
          <i class="bi bi-search"></i>
        </span>
        <input type="text" name="pesquisa" class="form-control border-0 bg-transparent"
          placeholder="Buscar por Nome, Empresa, Email ou Código de OS"
          value="<?php echo htmlspecialchars($pesquisa); ?>">
      </div>

      <input type="hidden" name="status" id="statusHidden" value="<?php echo htmlspecialchars($status); ?>">
      <div class="dropdown filtro-status">
        <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
          <span id="filtroLabel"><?php echo $status !== '' ? htmlspecialchars($status) : 'Todos os Status'; ?></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="#" onclick="filtrarStatus('Todos os Status')">Todos os Status</a></li>
          <li><a class="dropdown-item" href="#" onclick="filtrarStatus('Concluido')">Concluído</a></li>
          <li><a class="dropdown-item" href="#" onclick="filtrarStatus('Pendente')">Pendente</a></li>
          <li><a class="dropdown-item" href="#" onclick="filtrarStatus('Em Andamento')">Em Andamento</a></li>
        </ul>
      </div>
      <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <div id="listaClientes">
      <?php if ($total > 0): ?>
        <?php while ($cliente = mysqli_fetch_assoc($resultado)): ?>

          <?php
          $badgeClass = 'badge-sem-os';
          $badgeLabel = 'Sem OS';
          if ($cliente['ultimo_status'] === 'Concluido') {
            $badgeClass = 'badge-concluido';
            $badgeLabel = 'Concluído';
          } elseif ($cliente['ultimo_status'] === 'Pendente') {
            $badgeClass = 'badge-pendente';
            $badgeLabel = 'Pendente';
          } elseif ($cliente['ultimo_status'] === 'Em Andamento') {
            $badgeClass = 'badge-em-andamento';
            $badgeLabel = 'Em Andamento';
          }
          ?>

          <div class="cliente-card-wrapper mb-3" data-status="<?php echo htmlspecialchars($cliente['ultimo_status']); ?>">
            <div class="cliente-card p-3 d-flex justify-content-between align-items-start">
              <div>

                <div class="d-flex align-items-center gap-2 mb-1">
                  <span class="empresa-nome"><?php echo htmlspecialchars($cliente['nome_empresa']); ?></span>
                  <span class="<?php echo $badgeClass; ?>"><?php echo $badgeLabel; ?></span>
                </div>

                <div class="cliente-info d-flex align-items-center gap-1 mb-1">
                  <i class="bi bi-person"></i> <?php echo htmlspecialchars($cliente['nome_responsavel']); ?>
                </div>

                <div class="cliente-info d-flex align-items-center gap-1 mb-1">
                  <i class="bi bi-envelope"></i> <?php echo htmlspecialchars($cliente['email']); ?>
                </div>

                <div class="cliente-info d-flex align-items-center gap-1">
                  <i class="bi bi-telephone"></i> <?php echo htmlspecialchars($cliente['telefone']); ?>
                </div>
              </div>

              <div class="d-flex flex-column gap-2">
                <a href="../visualizacao-cliente/visualizacao-cliente.php?id=<?php echo $cliente['id_cliente']; ?>" class="btn btn-acao btn-outline-secondary" title="Visualizar"><i class="bi bi-eye"></i></a>
                <a href="../editar-cliente/editar-cliente.php?id=<?php echo $cliente['id_cliente']; ?>" class="btn btn-acao btn-outline-primary" title="Editar"><i class="bi bi-pencil-square"></i></a>
                <button onclick="confirmarExclusao(<?php echo $cliente['id_cliente']; ?>, '<?php echo htmlspecialchars($cliente['nome_empresa']); ?>')" class="btn btn-acao btn-outline-danger" title="Excluir"><i class="bi bi-trash"></i></button>
              </div>
            </div>
          </div>

        <?php endwhile; ?>
      <?php endif; ?>
    </div>

    <?php if ($total === 0): ?>
      <div class="clientes-vazio">0 clientes cadastrados</div>
    <?php endif; ?>

    <?php if ($total > 0): ?>
      <div class="clientes-contador"><?php echo $total; ?> cliente(s) encontrado(s)</div>
    <?php endif; ?>

  </main>

  <div class="modal fade" id="modalExclusao" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-0">
          <h5 class="modal-title fw-bold">Confirmar Exclusão</h5>
        </div>
        <div class="modal-body">
          Tem certeza que deseja excluir o cliente "<span id="nomeClienteModal"></span>"?
          Esta ação é <strong>permanente</strong>.
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" id="btnConfirmarExclusao" class="btn btn-danger">Excluir</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./js/"></script>
  <script>
    function filtrarStatus(status) {
      document.getElementById("filtroLabel").textContent = status;
      document.getElementById("statusHidden").value = status === "Todos os Status" ? "" : status;
      document.querySelector("form").submit();
    }

    // MODAL EXCLUSÃO
    function confirmarExclusao(id, nome) {
      document.getElementById("nomeClienteModal").textContent = nome;
      document.getElementById("btnConfirmarExclusao").setAttribute("data-id", id);
      new bootstrap.Modal(document.getElementById("modalExclusao")).show();
    }

    // BOTÃO CONFIRMAR EXCLUSÃO
    document.addEventListener("DOMContentLoaded", function() {
      document.getElementById("btnConfirmarExclusao").addEventListener("click", function() {
        const id = this.getAttribute("data-id");
        window.location.href = "visualizacao-clientes.php?excluir=" + id;
      });
    });
  </script>
  <script>
    function setTheme(theme) {
      const html = document.documentElement;
      html.setAttribute("data-bs-theme", theme);
      localStorage.setItem("ttc_theme", theme);
      const sunIcon = document.getElementById("themeIconSun");
      const moonIcon = document.getElementById("themeIconMoon");
      if (theme === "dark") {
        if (sunIcon) sunIcon.style.display = "none";
        if (moonIcon) moonIcon.style.display = "inline-block";
      } else {
        if (sunIcon) sunIcon.style.display = "inline-block";
        if (moonIcon) moonIcon.style.display = "none";
      }
    }

    function toggleTheme() {
      const current = document.documentElement.getAttribute("data-bs-theme");
      const newTheme = current === "light" ? "dark" : "light";
      setTheme(newTheme);
    }

    const savedTheme = localStorage.getItem("ttc_theme");
    if (savedTheme === "dark" || savedTheme === "light") setTheme(savedTheme);
    else setTheme("light");
    document.getElementById("themeToggleBtn")?.addEventListener("click", toggleTheme);

    window.togglePassword = function(inputId) {
      const input = document.getElementById(inputId);
      if (!input) return;
      const type = input.type === "password" ? "text" : "password";
      input.type = type;
    };
  </script>
</body>

</html>
<?php mysqli_close($conn); ?>
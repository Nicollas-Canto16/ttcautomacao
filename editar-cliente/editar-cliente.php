<?php

// session_start();
// if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
//     header("Location: ../login/login.php");
//     exit;
// }

// ===================================================
// CONEXÃO COM O BANCO
// ===================================================
$conn = mysqli_connect("localhost", "root", "", "ttc_automacao");
if (!$conn) {
  die("Erro na conexão: " . mysqli_connect_error());
}

// ===================================================
// PEGA O ID DO CLIENTE PELA URL
// Ex: editarCliente.php?id=3
// ===================================================
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id === 0) {
  die("Cliente não informado.");
}

// ===================================================
// PROCESSA O FORMULÁRIO QUANDO ENVIADO (UPDATE)
// ===================================================
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome_responsavel  = $_POST['nome_responsavel'];
  $nome_empresa      = $_POST['nome_empresa'];
  $email             = $_POST['email'];
  $telefone          = $_POST['telefone'];
  $endereco          = $_POST['endereco'];
  $tipo_documento    = $_POST['tipo_documento'];
  $numero_documento  = $_POST['numero_documento'];

  $stmt = mysqli_prepare($conn, "UPDATE clientes SET
        nome_responsavel = ?,
        nome_empresa = ?,
        email = ?,
        telefone = ?,
        endereco = ?,
        tipo_documento = ?,
        numero_documento = ?
        WHERE id_cliente = ?");

  mysqli_stmt_bind_param(
    $stmt,
    "sssssssi",
    $nome_responsavel,
    $nome_empresa,
    $email,
    $telefone,
    $endereco,
    $tipo_documento,
    $numero_documento,
    $id
  );

  if (mysqli_stmt_execute($stmt)) {
    $mensagem = "Cliente atualizado com sucesso!";
  } else {
    $mensagem = "Erro ao atualizar: " . mysqli_error($conn);
  }
}

// ===================================================
// BUSCA OS DADOS ATUAIS DO CLIENTE
// ===================================================
$stmt = mysqli_prepare($conn, "SELECT * FROM clientes WHERE id_cliente = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$cliente = mysqli_fetch_assoc($resultado);

if (!$cliente) {
  die("Cliente não encontrado.");
}
?>
<!doctype html>
<html lang="pt-BR" data-bs-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TTC Automação — Editar Cliente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../shared/global.css">
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

    /* === CARD DO FORMULÁRIO === */
    .form-card {
      background-color: #ffffff;
      border: 1px solid #cccccc;
      border-radius: 10px;
    }

    [data-bs-theme="dark"] .form-card {
      background-color: #333333;
      border-color: #555555;
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

  <!-- CONTEÚDO -->
  <main class="flex-fill container my-4">

    <!-- Título + voltar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="m-0">Editar Cliente</h2>
      <a href="../visualizacao-clientes/visualizacao-clientes.php" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Voltar
      </a>
    </div>

    <!-- Mensagem de sucesso/erro -->
    <?php if ($mensagem !== ''): ?>
      <div class="alert alert-info"><?php echo htmlspecialchars($mensagem); ?></div>
    <?php endif; ?>

    <!-- Formulário de edição -->
    <div class="form-card p-4">
      <form method="POST" action="editar-cliente.php?id=<?php echo $id; ?>">

        <!-- Nome / Empresa -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="nome_responsavel" class="form-label fw-semibold">Nome do Responsável</label>
            <input type="text" id="nome_responsavel" name="nome_responsavel" class="form-control"
              value="<?php echo htmlspecialchars($cliente['nome_responsavel']); ?>" required>
          </div>
          <div class="col-md-6">
            <label for="nome_empresa" class="form-label fw-semibold">Nome da Empresa</label>
            <input type="text" id="nome_empresa" name="nome_empresa" class="form-control"
              value="<?php echo htmlspecialchars($cliente['nome_empresa']); ?>" required>
          </div>
        </div>

        <!-- Email / Telefone -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input type="email" id="email" name="email" class="form-control"
              value="<?php echo htmlspecialchars($cliente['email']); ?>" required>
          </div>
          <div class="col-md-6">
            <label for="telefone" class="form-label fw-semibold">Telefone</label>
            <input type="text" id="telefone" name="telefone" class="form-control"
              value="<?php echo htmlspecialchars($cliente['telefone']); ?>">
          </div>
        </div>

        <!-- Tipo de documento / Número -->
        <div class="row mb-3">
          <div class="col-md-4">
            <label for="tipo_documento" class="form-label fw-semibold">Tipo de Documento</label>
            <select id="tipo_documento" name="tipo_documento" class="form-select">
              <option value="CPF" <?php echo $cliente['tipo_documento'] === 'CPF' ? 'selected' : ''; ?>>CPF</option>
              <option value="CNPJ" <?php echo $cliente['tipo_documento'] === 'CNPJ' ? 'selected' : ''; ?>>CNPJ</option>
            </select>
          </div>
          <div class="col-md-8">
            <label for="numero_documento" class="form-label fw-semibold">Número do Documento</label>
            <input type="text" id="numero_documento" name="numero_documento" class="form-control"
              value="<?php echo htmlspecialchars($cliente['numero_documento']); ?>" required>
          </div>
        </div>

        <!-- Endereço -->
        <div class="mb-4">
          <label for="endereco" class="form-label fw-semibold">Endereço</label>
          <textarea id="endereco" name="endereco" class="form-control" rows="2"><?php echo htmlspecialchars($cliente['endereco']); ?></textarea>
        </div>

        <!-- Botão salvar -->
        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-check-circle"></i> Salvar Alterações
          </button>
        </div>

      </form>
    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // TEMA
    function toggleTheme() {
      const html = document.documentElement;
      const atual = html.getAttribute("data-bs-theme");
      if (atual === "dark") {
        html.setAttribute("data-bs-theme", "light");
        localStorage.setItem("theme", "light");
      } else {
        html.setAttribute("data-bs-theme", "dark");
        localStorage.setItem("theme", "dark");
      }
    }
    window.onload = function() {
      const saved = localStorage.getItem("theme");
      if (saved) document.documentElement.setAttribute("data-bs-theme", saved);
    };
  </script>
</body>

</html>
<?php mysqli_close($conn); ?>
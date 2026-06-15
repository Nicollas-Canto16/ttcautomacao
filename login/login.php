<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>TTC Assessoria - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="m-0 p-0 d-flex flex-column">
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

    <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5">
        <div class="container" style="max-width: 500px;">
            <div class="card-auth p-4 p-md-5">
                <div class="text-center mb-4">
                    <h2 class="auth-title display-6 fw-bold">Acessar conta</h2>
                    <div class="underlineTitle"></div>
                    <p class="text-secondary mt-3">Informe suas credenciais para continuar</p>
                </div>
                <form id="loginForm">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">E-mail</label>
                        <input type="email" class="form-control form-control-auth" id="loginEmail" placeholder="seu@email.com" required>
                    </div>
                    <div class="mb-3 position-relative">
                        <label class="form-label fw-semibold">Senha</label>
                        <input type="password" class="form-control form-control-auth" id="loginPassword" placeholder="••••••" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('loginPassword')"><i class="far fa-eye"></i></button>
                    </div>
                    <div class="d-flex justify-content-end mb-4">
                        <a href="../recuperacao-senha/recuperacao-senha.php" class="auth-link" id="esqueceuSenhaBtn">Esqueceu a senha?</a>
                    </div>
                    <button type="submit" class="btn btn-custom-primary w-100 py-2 rounded-4 fw-semibold">Entrar</button>
                </form>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
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

        document.getElementById("loginForm")?.addEventListener("submit", (e) => {
            e.preventDefault();
            const email = document.getElementById("loginEmail").value;
            const senha = document.getElementById("loginPassword").value;

            if (!email || !senha) {
                Toastify({
                    text: "Preencha e-mail e senha",
                    duration: 2500,
                    backgroundColor: "#c0392b",
                    gravity: "top",
                    position: "right"
                }).showToast();
                return;
            }

            if (email === "admin@ttc.com" && senha === "123456") {
                Toastify({
                    text: "Login bem-sucedido! Redirecionando...",
                    duration: 2000,
                    backgroundColor: "#2e7d64",
                    gravity: "top",
                    position: "right"
                }).showToast();
                setTimeout(() => {
                    window.location.href = "./cliente.html";
                }, 1500);
            } else {
                Toastify({
                    text: "Credenciais inválidas. Tente admin@ttc.com / 123456",
                    duration: 3000,
                    backgroundColor: "#c0392b",
                    gravity: "top",
                    position: "right"
                }).showToast();
            }
        });
    </script>
</body>

</html>
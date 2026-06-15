<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>TTC Assessoria - Visualização do Cliente</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- EmailJS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
    <!-- html2pdf.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="../shared/global.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .logoImg {
            width: 9.75rem;
            transition: filter 0.2s ease;
        }
        
        /* Light Theme (default) */
        [data-bs-theme="light"] body {
            background-color: #f5f5f5 !important;
            font-family: system-ui, 'Segoe UI', Roboto, sans-serif;
        }
        [data-bs-theme="light"] a:hover {
            background-color: #173b4b;
            border-radius: 1rem;
        }
        [data-bs-theme="light"] .logoImg {
            filter: none;
        }
        [data-bs-theme="light"] .btn-outline-theme {
            border: 1px solid #378cb1;
            color: #378cb1;
            background: white;
        }
        [data-bs-theme="light"] .btn-outline-theme:hover {
            background-color: #378cb1;
            color: white;
        }
        [data-bs-theme="light"] .btn-custom-primary {
            background-color: #378cb1;
            color: white;
            border: none;
        }
        [data-bs-theme="light"] .btn-custom-primary:hover {
            background-color: #173b4b;
        }
        [data-bs-theme="light"] .card-cliente {
            background-color: #ffffff !important;
            border-radius: 20px;
            border: none;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }
        [data-bs-theme="light"] .card-title-custom {
            color: #378cb1;
            font-weight: 700;
            font-size: 1.6rem;
            border-left: 5px solid #378cb1;
            padding-left: 15px;
            margin-bottom: 1.5rem;
        }
        [data-bs-theme="light"] .info-row {
            margin-bottom: 1rem;
            border-bottom: 1px dashed #e9ecef;
            padding-bottom: 0.5rem;
        }
        [data-bs-theme="light"] .info-label {
            font-weight: 600;
            color: #2c3e50;
            width: 110px;
            display: inline-block;
        }
        [data-bs-theme="light"] .info-value {
            background: #f8f9fa;
            padding: 0.2rem 0.8rem;
            border-radius: 12px;
            display: inline-block;
        }
        [data-bs-theme="light"] .edit-mode-input {
            border: 1px solid #ced4da;
            border-radius: 12px;
            padding: 0.4rem 0.8rem;
            width: 100%;
        }
        [data-bs-theme="light"] .status-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.35rem 1rem;
            border-radius: 30px;
            cursor: pointer;
            transition: 0.2s;
        }
        [data-bs-theme="light"] .status-concluido { background-color: #d1e7dd; color: #0f5132; }
        [data-bs-theme="light"] .status-pendente { background-color: #f8d7da; color: #842029; }
        [data-bs-theme="light"] .status-andamento { background-color: #fff3cd; color: #856404; }
        [data-bs-theme="light"] .os-card {
            background: #fefefe;
            border-radius: 18px;
            border: 1px solid #eef2f6;
        }

        /* Dark Theme */
        [data-bs-theme="dark"] body {
            background-color: #0f0f12 !important;
            color: #eef2ff;
            font-family: system-ui, 'Segoe UI', Roboto, sans-serif;
        }
        [data-bs-theme="dark"] header {
            background-color: #0a2e3f !important;
            color: #f0f3f8;
            border-bottom: 1px solid #2c4b5e;
        }
        [data-bs-theme="dark"] .headerLink {
            color: #f0f3f8;
            text-decoration: none;
            font-size: 1.5rem;
            transition: 0.2s;
        }
        [data-bs-theme="dark"] a:hover {
            background-color: #1f5a72;
            border-radius: 1rem;
        }
        [data-bs-theme="dark"] .logoImg {
            filter: brightness(0) invert(1);
        }
        [data-bs-theme="dark"] .btn-outline-theme {
            border: 1px solid #4aa3c2;
            color: #bbdef5;
            background: transparent;
        }
        [data-bs-theme="dark"] .btn-outline-theme:hover {
            background-color: #2c6f8c;
            color: white;
        }
        [data-bs-theme="dark"] .btn-custom-primary {
            background-color: #2c7a9e;
            color: white;
            border: none;
        }
        [data-bs-theme="dark"] .btn-custom-primary:hover {
            background-color: #1f5a72;
        }
        [data-bs-theme="dark"] .card-cliente {
            background-color: #18181f !important;
            border-radius: 20px;
            border: 1px solid #2a2a35;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }
        [data-bs-theme="dark"] .card-title-custom {
            color: #5bb4d4 !important;
            font-weight: 700;
            font-size: 1.6rem;
            border-left: 5px solid #5bb4d4;
            padding-left: 15px;
            margin-bottom: 1.5rem;
        }
        [data-bs-theme="dark"] .info-row {
            margin-bottom: 1rem;
            border-bottom: 1px solid #2a2a35;
            padding-bottom: 0.5rem;
        }
        [data-bs-theme="dark"] .info-label {
            font-weight: 600;
            color: #b9d9f0;
            width: 110px;
            display: inline-block;
        }
        [data-bs-theme="dark"] .info-value {
            background-color: #25252e;
            padding: 0.2rem 0.8rem;
            border-radius: 12px;
            display: inline-block;
            color: #e2e8ff;
        }
        [data-bs-theme="dark"] .edit-mode-input {
            background-color: #2c2c36;
            border: 1px solid #4c5a6b;
            border-radius: 12px;
            padding: 0.4rem 0.8rem;
            width: 100%;
            color: #f0f3fa;
        }
        [data-bs-theme="dark"] .edit-mode-input:focus {
            border-color: #5bb4d4;
            outline: none;
            box-shadow: 0 0 0 2px rgba(91,180,212,0.3);
        }
        [data-bs-theme="dark"] .status-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.35rem 1rem;
            border-radius: 30px;
            cursor: pointer;
            transition: 0.2s;
        }
        [data-bs-theme="dark"] .status-concluido { background-color: #1f4d3a; color: #b0f0d0; }
        [data-bs-theme="dark"] .status-pendente { background-color: #712b36; color: #ffb7bc; }
        [data-bs-theme="dark"] .status-andamento { background-color: #7a630c; color: #ffe7a3; }
        [data-bs-theme="dark"] .os-card {
            background: #1f1f28;
            border-radius: 18px;
            border: 1px solid #2e3a46;
        }

        /* Shared styles */
        .btn-outline-theme {
            transition: 0.2s;
        }
        .btn-custom-primary {
            transition: 0.2s;
        }
        .theme-toggle-btn {
            cursor: pointer;
            background: transparent;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            border-radius: 50%;
            transition: 0.2s;
        }
        .theme-toggle-btn:hover {
            background-color: rgba(255,255,255,0.2);
        }
        @media (max-width: 768px) {
            .headerLink { font-size: 1rem; }
            .info-label { width: 100%; margin-bottom: 0.25rem; }
        }
        
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            z-index: 10;
            background: transparent;
            border: none;
        }
        [data-bs-theme="dark"] .toggle-password {
            color: #9aa7c2;
        }
        .position-relative {
            position: relative;
        }
    </style>
</head>
<body class="m-0 p-0">
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


    <main class="container my-4 py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h1 class="display-6 fw-semibold" id="clienteNomeDisplay" style="transition: color 0.2s;">Almeida Ferramentas</h1>
                <p id="clienteSubDisplay">Carlos Almeida dos Santos</p>
            </div>
            <div class="d-flex gap-3">
                <button id="btnEditar" class="btn btn-outline-theme px-4 py-2 rounded-4"><i class="fas fa-pen me-2"></i>Editar</button>
                <button id="btnSalvarPDF" class="btn btn-custom-primary px-4 py-2 rounded-4"><i class="fas fa-file-pdf me-2"></i>Salvar PDF</button>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <div class="card-cliente p-4 h-100">
                    <div class="card-title-custom">Informações de Contato</div>
                    <div id="infoContainer"></div>
                    <div class="mt-2 text-muted small" id="editHelperMsg" style="display: none;"><i class="fas fa-info-circle"></i> Modo edição ativo. Clique em "Salvar" para manter alterações.</div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card-cliente p-4 h-100">
                    <div class="card-title-custom d-flex justify-content-between align-items-center flex-wrap">
                        <span>Ordens de Serviço <span id="osCount" class="badge bg-secondary ms-2">0</span></span>
                        <button id="addOsBtn" class="btn btn-sm rounded-pill btn-outline-theme"><i class="fas fa-plus me-1"></i>Nova OS</button>
                    </div>
                    <div id="osListContainer"></div>
                    <div class="mt-3 text-center text-muted" id="noOsMsg" style="display: none;">Nenhuma ordem de serviço registrada.</div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // ===================== DADOS DO CLIENTE =====================
        let clientData = {
            nomeEmpresa: "Almeida Ferramentas",
            nomeResponsavel: "Carlos Almeida dos Santos",
            email: "carlos.almeida@almeidaferramentas.com.br",
            telefone: "(51) 97312-7234",
            endereco: "Rua José Fonseca, 635, Passo das Pedras - Porto Alegre, RS",
            cnpj: "23.634.242/0001-54",
            clienteDesde: "12/04/2015"
        };
        
        let ordensServico = [
            {
                id: "os_1",
                titulo: "Ordem de serviço #1",
                descricao: "Realizado instalação de cabeamento em 10 máquinas de torneamento",
                criadoEm: "12/04/2015",
                atualizadoEm: "22/10/2016",
                status: "Concluído"
            }
        ];
        
        let editMode = false;
        let tempData = { ...clientData };

        // ===================== FUNÇÕES AUXILIARES =====================
        function toast(msg, type = "success") {
            if(window.Toastify){
                Toastify({
                    text: msg,
                    duration: 2500,
                    gravity: "top",
                    position: "right",
                    backgroundColor: type === "success" ? "#2e7d64" : "#c0392b",
                    className: "rounded-3",
                }).showToast();
            } else {
                alert(msg);
            }
        }
        
        function escapeHtml(s) {
            if (!s) return "";
            return s.replace(/[&<>]/g, function(m){
                return m === "&" ? "&amp;" : (m === "<" ? "&lt;" : "&gt;");
            });
        }
        
        function updateHeader() {
            const nomeEl = document.getElementById("clienteNomeDisplay");
            const subEl = document.getElementById("clienteSubDisplay");
            if(nomeEl) nomeEl.innerText = clientData.nomeEmpresa;
            if(subEl) subEl.innerText = clientData.nomeResponsavel;
        }
        
        // ===================== RENDER INFORMAÇÕES =====================
        function renderInfo() {
            const container = document.getElementById("infoContainer");
            if(!container) return;
            
            if(!editMode) {
                container.innerHTML = `
                    <div class="info-row"><span class="info-label"><i class="fas fa-envelope me-2" style="color:#378cb1"></i>E-mail:</span> <span class="info-value">${escapeHtml(clientData.email)}</span></div>
                    <div class="info-row"><span class="info-label"><i class="fas fa-phone-alt me-2" style="color:#378cb1"></i>Telefone:</span> <span class="info-value">${escapeHtml(clientData.telefone)}</span></div>
                    <div class="info-row"><span class="info-label"><i class="fas fa-map-marker-alt me-2" style="color:#378cb1"></i>Endereço:</span> <span class="info-value">${escapeHtml(clientData.endereco)}</span></div>
                    <div class="info-row"><span class="info-label"><i class="fas fa-building me-2" style="color:#378cb1"></i>CNPJ:</span> <span class="info-value">${escapeHtml(clientData.cnpj)}</span></div>
                    <div class="info-row"><span class="info-label"><i class="fas fa-calendar-alt me-2" style="color:#378cb1"></i>Cliente desde:</span> <span class="info-value">${escapeHtml(clientData.clienteDesde)}</span></div>
                `;
            } else {
                container.innerHTML = `
                    <div class="mb-3"><label class="fw-semibold mb-1" style="color:#378cb1">E-mail</label><input type="email" id="editEmail" class="form-control edit-mode-input" value="${escapeHtml(tempData.email)}"></div>
                    <div class="mb-3"><label class="fw-semibold mb-1" style="color:#378cb1">Telefone</label><input type="text" id="editTelefone" class="form-control edit-mode-input" value="${escapeHtml(tempData.telefone)}"></div>
                    <div class="mb-3"><label class="fw-semibold mb-1" style="color:#378cb1">Endereço</label><input type="text" id="editEndereco" class="form-control edit-mode-input" value="${escapeHtml(tempData.endereco)}"></div>
                    <div class="mb-3"><label class="fw-semibold mb-1" style="color:#378cb1">CNPJ</label><input type="text" id="editCnpj" class="form-control edit-mode-input" value="${escapeHtml(tempData.cnpj)}"></div>
                    <div class="mb-3"><label class="fw-semibold mb-1" style="color:#378cb1">Cliente desde</label><input type="text" id="editClienteDesde" class="form-control edit-mode-input" value="${escapeHtml(tempData.clienteDesde)}"></div>
                    <div class="d-flex gap-2 mt-3"><button id="saveInfoBtn" class="btn btn-custom-primary btn-sm px-4"><i class="fas fa-save me-1"></i> Salvar</button><button id="cancelEditBtn" class="btn btn-secondary btn-sm px-4">Cancelar</button></div>
                `;
                document.getElementById("saveInfoBtn")?.addEventListener("click", saveChanges);
                document.getElementById("cancelEditBtn")?.addEventListener("click", cancelEdit);
            }
            const helperMsg = document.getElementById("editHelperMsg");
            if(helperMsg) helperMsg.style.display = editMode ? "block" : "none";
        }
        
        function saveChanges() {
            tempData.email = document.getElementById("editEmail")?.value || tempData.email;
            tempData.telefone = document.getElementById("editTelefone")?.value || tempData.telefone;
            tempData.endereco = document.getElementById("editEndereco")?.value || tempData.endereco;
            tempData.cnpj = document.getElementById("editCnpj")?.value || tempData.cnpj;
            tempData.clienteDesde = document.getElementById("editClienteDesde")?.value || tempData.clienteDesde;
            Object.assign(clientData, tempData);
            editMode = false;
            renderInfo();
            updateHeader();
            toast("Informações de contato salvas com sucesso!", "success");
        }
        
        function cancelEdit() {
            tempData = { ...clientData };
            editMode = false;
            renderInfo();
        }
        
        // ===================== RENDER ORDENS DE SERVIÇO =====================
        function renderOS() {
            const container = document.getElementById("osListContainer");
            const noMsg = document.getElementById("noOsMsg");
            const countSpan = document.getElementById("osCount");
            if(!container) return;
            
            if(ordensServico.length === 0) {
                container.innerHTML = "";
                if(noMsg) noMsg.style.display = "block";
                if(countSpan) countSpan.innerText = "0";
                return;
            }
            
            if(noMsg) noMsg.style.display = "none";
            if(countSpan) countSpan.innerText = ordensServico.length;
            container.innerHTML = "";
            
            ordensServico.forEach(os => {
                let statusClass = "";
                if(os.status === "Concluído") statusClass = "status-concluido";
                else if(os.status === "Pendente") statusClass = "status-pendente";
                else if(os.status === "Andamento") statusClass = "status-andamento";
                
                const div = document.createElement("div");
                div.className = "os-card p-3 mb-3";
                div.innerHTML = `
                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                        <div class="flex-grow-1 me-2">
                            <h5 class="fw-bold mb-1" style="color: inherit;">${escapeHtml(os.titulo)}</h5>
                            <p class="text-secondary mb-2 small">${escapeHtml(os.descricao)}</p>
                            <div class="d-flex gap-3 flex-wrap small text-muted">
                                <span><i class="far fa-calendar-alt"></i> Criado: ${escapeHtml(os.criadoEm)}</span>
                                <span><i class="fas fa-sync-alt"></i> Atualizado: ${escapeHtml(os.atualizadoEm)}</span>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-2">
                            <div class="status-badge ${statusClass}" data-os-id="${os.id}" data-status="${os.status}">
                                <i class="fas fa-tag"></i> ${os.status}
                            </div>
                            <button class="btn btn-sm btn-link text-danger remove-os p-0" data-os-id="${os.id}" style="font-size:0.75rem; text-decoration:none;">
                                <i class="fas fa-trash-alt"></i> Excluir
                            </button>
                        </div>
                    </div>
                `;
                container.appendChild(div);
            });
            
            document.querySelectorAll(".status-badge").forEach(badge => {
                badge.removeEventListener("click", statusHandler);
                badge.addEventListener("click", statusHandler);
            });
            
            document.querySelectorAll(".remove-os").forEach(btn => {
                btn.removeEventListener("click", removeHandler);
                btn.addEventListener("click", removeHandler);
            });
        }
        
        function statusHandler(e) {
            const badge = e.currentTarget;
            const osId = badge.getAttribute("data-os-id");
            const currentStatus = badge.getAttribute("data-status");
            let nextStatus = "Concluído";
            if(currentStatus === "Concluído") nextStatus = "Pendente";
            else if(currentStatus === "Pendente") nextStatus = "Andamento";
            else if(currentStatus === "Andamento") nextStatus = "Concluído";
            
            const ordem = ordensServico.find(o => o.id === osId);
            if(ordem) {
                ordem.status = nextStatus;
                renderOS();
                toast(`Status alterado para "${nextStatus}"`, "success");
            }
        }
        
        function removeHandler(e) {
            const btn = e.currentTarget;
            const osId = btn.getAttribute("data-os-id");
            ordensServico = ordensServico.filter(o => o.id !== osId);
            renderOS();
            toast("Ordem de serviço removida", "info");
        }
        
        function novaOS() {
            const newId = "os_" + Date.now() + "_" + Math.floor(Math.random() * 1000);
            const hoje = new Date().toLocaleDateString("pt-BR");
            const novaOrdem = {
                id: newId,
                titulo: `Ordem de serviço #${ordensServico.length + 1}`,
                descricao: "Descreva os serviços realizados...",
                criadoEm: hoje,
                atualizadoEm: hoje,
                status: "Pendente"
            };
            ordensServico.push(novaOrdem);
            renderOS();
            toast("Nova ordem de serviço criada com status Pendente", "success");
        }
        
        // ===================== GERAR PDF =====================
        async function gerarPDF() {
            if(editMode) {
                cancelEdit();
                await new Promise(r => setTimeout(r, 100));
            }
            
            const main = document.querySelector("main");
            if(!main) return;
            
            const clone = main.cloneNode(true);
            clone.querySelectorAll("#btnEditar, #btnSalvarPDF, #addOsBtn, .remove-os, .status-badge").forEach(el => el.remove());
            
            const badges = clone.querySelectorAll(".status-badge");
            badges.forEach(b => {
                const statusText = b.innerText.trim();
                const plainSpan = document.createElement("span");
                plainSpan.className = "badge bg-secondary me-1";
                plainSpan.innerText = statusText;
                b.parentNode?.replaceChild(plainSpan, b);
            });
            
            const style = document.createElement("style");
            const isDark = document.documentElement.getAttribute("data-bs-theme") === "dark";
            if(isDark) {
                style.textContent = `body { background: #0f0f12; } .card-cliente { background: #18181f !important; border: 1px solid #2a2a35; } .btn, .remove-os { display: none; }`;
            } else {
                style.textContent = `body { background: white; } .card-cliente { box-shadow: none; border: 1px solid #ddd; } .btn, .remove-os { display: none; }`;
            }
            clone.prepend(style);
            
            const opt = {
                margin: [0.5, 0.5, 0.5, 0.5],
                filename: `Cliente_${clientData.nomeEmpresa.replace(/\s/g, "_")}.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, backgroundColor: isDark ? "#0f0f12" : "#ffffff" },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            };
            
            try {
                await html2pdf().set(opt).from(clone).save();
                toast("PDF gerado com sucesso!", "success");
            } catch(err) {
                console.error(err);
                toast("Erro ao gerar PDF", "error");
            }
        }
        
        // ===================== TEMA (LIGHT/DARK) =====================
        function setTheme(theme) {
            const html = document.documentElement;
            html.setAttribute("data-bs-theme", theme);
            localStorage.setItem("ttc_theme", theme);
            const sunIcon = document.getElementById("themeIconSun");
            const moonIcon = document.getElementById("themeIconMoon");
            if(theme === "dark") {
                if(sunIcon) sunIcon.style.display = "none";
                if(moonIcon) moonIcon.style.display = "inline-block";
            } else {
                if(sunIcon) sunIcon.style.display = "inline-block";
                if(moonIcon) moonIcon.style.display = "none";
            }
        }
        
        function toggleTheme() {
            const current = document.documentElement.getAttribute("data-bs-theme");
            const newTheme = current === "light" ? "dark" : "light";
            setTheme(newTheme);
        }
        
        // ===================== INICIALIZAÇÃO =====================
        function init() {
            const savedTheme = localStorage.getItem("ttc_theme");
            if(savedTheme === "dark" || savedTheme === "light") {
                setTheme(savedTheme);
            } else {
                setTheme("light");
            }
            
            renderInfo();
            renderOS();
            updateHeader();
            
            document.getElementById("btnEditar")?.addEventListener("click", () => {
                if(!editMode) {
                    editMode = true;
                    tempData = { ...clientData };
                    renderInfo();
                }
            });
            document.getElementById("btnSalvarPDF")?.addEventListener("click", gerarPDF);
            document.getElementById("addOsBtn")?.addEventListener("click", novaOS);
            document.getElementById("themeToggleBtn")?.addEventListener("click", toggleTheme);
        }
        
        init();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>
</html>
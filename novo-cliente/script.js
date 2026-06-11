document
  .getElementById("client_os_form")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch("envio_dados.php", { method: "POST", body: formData })
      .then((response) => response.text())
      .then((data) => {
        console.log(data);

        if (data.trim() === "ok") {
          Toastify({
            text: "Dados enviados com sucesso!",
            duration: 3000,
            style: {
              background: "#378cb1",
              color: "#f4f4f4",
            },
          }).showToast();
          this.reset();
        } else {
          console.log(data);
          Toastify({
            text: "Erro ao enviar dados",
            duration: 3000,
            style: {
              background: "#dc3545",
              color: "#f4f4f4",
            },
          }).showToast();
        }
      })
      .catch((error) => {
        console.error(error);
        Toastify({
          text: "Erro ao enviar dados",
          duration: 3000,
          style: {
            background: "#dc3545",
            color: "#f4f4f4",
          },
        }).showToast();
      });
  });

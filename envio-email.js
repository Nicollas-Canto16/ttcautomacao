emailjs.init("ovUDTXCptoycywoYX");
document
  .getElementById("orcamentoForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    const formData = {
      name: document.getElementById("name").value,
      companyName: document.getElementById("companyName").value,
      email: document.getElementById("email").value,
      phone: document.getElementById("phone").value,
      subject: document.getElementById("subject").value,
      emailBody: document.getElementById("emailBody").value,
    };

    const serviceId = "service_bdvuekq";
    const teamplateId = "template_rpk9nhu";

    emailjs
      .send(serviceId, teamplateId, formData)
      .then(() => {
        Toastify({
          text: "E-mail enviado com sucesso!",
          duration: 3000,
          style: {
            background: "#378cb1",
            color: "#f4f4f4",
          },
        }).showToast();
        document.getElementById("orcamentoForm").reset();
      })
      .catch((error) => {
        Toastify({
          text: "Erro ao enviar e-mail!",
          duration: 3000,
          style: {
            backgRound: "#dc3545",
            color: "#f4f4f4",
          },
        }).showToast();
      });
  });

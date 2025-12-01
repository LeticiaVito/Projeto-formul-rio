function enviarFormulario(event) {
  event.preventDefault(); // Evita o comportamento padrão do formulário

  const formulario = document.querySelector("form");
  const formData = new FormData(formulario);

  fetch("enviarMensagem", {
      method: "POST",
      body: formData,
  })
  .then(response => {
      if (response.ok) {
          const notificacao = document.getElementById('notificacao');
          if (notificacao) { // Verifica se o elemento existe
              notificacao.style.display = 'block'; // Exibe a mensagem de sucesso
              notificacao.textContent = 'Sua mensagem foi enviada com sucesso!'; // Texto personalizado
          }
          formulario.reset(); // Limpa o formulário
      } else {
          alert("Erro ao enviar a mensagem. Tente novamente.");
      }
  })
  .catch(error => {
      console.error("Erro:", error);
      alert("Erro ao enviar a mensagem. Verifique sua conexão.");
  });
}
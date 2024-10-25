$(document).ready(function() {
    // Validação de e-mail
    $('#registration-form').on('submit', function(e) {
      var email = $('#email').val();
      var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  
      if (!emailPattern.test(email)) {
        alert('Por favor, insira um e-mail válido.');
        e.preventDefault();  // Impede o envio do formulário se o e-mail for inválido
      }
    });
  
    // Máscara para o campo de telefone
    $('#phone').mask('(00) 00000-0000');
  
    // Máscara para o campo de CPF
    $('#cpf').mask('000.000.000-00');
  });
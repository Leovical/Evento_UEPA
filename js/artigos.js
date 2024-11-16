$(document).ready(function() {


    // Validação do envio do arquivo (permitir apenas .pdf, .xml, .ePub)
    $('#artigo-form').on('submit', function(e) {
      var arquivo = $('#arquivo')[0].files[0];
      var allowedExtensions = /(\.pdf|\.xml|\.epub)$/i;
  
      if (!allowedExtensions.exec(arquivo.name)) {
        alert('Por favor, envie um arquivo no formato .pdf, .xml ou .ePub.');
        e.preventDefault();  // Impede o envio do formulário se o arquivo não for válido
      }
    });
  
   
  });
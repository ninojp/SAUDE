//meu codigo JavaScript, local para a loja
//============================================================================
function adicionar_carrinho(id_produto) {
   //adicionar produtos ao carrinho
   axios.defaults.withCredentials = true;
   axios.get('?a=adicionar_carrinho&id_produto=' + id_produto)
      .then( function(response){
         var total_produtos = response.data;
         document.getElementById('carrinho').innerText = total_produtos;
      });
}
//============================================================================
function limpar_carrinho(){
   var e = document.getElementById("confirmar_limpar_carrinho");
   e.style.display = "inline";
}
function limpar_carrinho_off(){
   var e = document.getElementById("confirmar_limpar_carrinho");
   e.style.display = "none";
}
//============================================================================
function usar_endereco_alternativo(){
   //mostar ou esconder o endereço alternativo
   var e = document.getElementById('check_endereco_alternativo');
   if(e.checked == true){
      //mostra o quadro para definir o endereço alternativo
      document.getElementById('endereco_alternativo').style.display='block';
   } else {
      //Esconde o quadro para definir o endereço alternativo
      document.getElementById('endereco_alternativo').style.display='none';
   }
}
//============================================================================
function endereco_alternativo(){
   
  axios({
   method: 'post',
   url: '?a=endereco_alternativo',
   data: {
      text_endereco: document.getElementById('text_endereco_alternativo').value,
      text_cidade: document.getElementById('text_cidade_alternativo').value,
      text_telefone: document.getElementById('text_telefone_alternativo').value,
      text_email: document.getElementById('text_email_alternativo').value,
   }
  });
  /*vai buscar os dados do input
   vai enviar por url via post por axios para um método da controlador
   método do controlador vai receber os dados e colocar na sessão
   */
}

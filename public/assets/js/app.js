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

//meu codigo JavaScript, local para a loja

function adicionar_carrinho(id_produto) {
    axios.defaults.withCredentials = true;
    axios.get('?a=adicionar_carrinho&id_produto=' + id_produto)
     .then( function(response) {
        console.log(response);
     });
}
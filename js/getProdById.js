function getProd() {
  const productId = document.getElementById("getProdId").value;

  fetch('/backend/ProdutoRouter.php?id=' + productId, {
      method: 'GET'
  })
  .then(response => {
      if (!response.ok) {
          if (response.status === 401) {
              throw new Error('Não autorizado');
          } else {
              throw new Error('Sem rede ou não conseguiu localizar o recurso');
          }
      }
      return response.json();
  })
  .then(data => {
      if (!data.status){
          alert('Produto não encontrado')
          document.getElementById("nome").value = ''; 
          document.getElementById('preco').value = '';
          document.getElementById('quantidade').value = '';
      } else {
          document.getElementById("nome").value = data.produto.nome;
          document.getElementById('preco').value = data.produto.preco;
          document.getElementById('quantidade').value = data.produto.quantidade; 
      } 
     
  })
  .catch(error => alert('Erro na requisição: ' + error));
}
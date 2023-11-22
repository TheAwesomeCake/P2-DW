function deleteProd() {
  const prodId = document.getElementById("getProdId").value;
  fetch('/backend/ProdutoRouter.php?id=' + prodId, {
      method: 'DELETE'
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
      if(!data.status){
          alert("Não pode Deletar!");
      }else{
          alert("Produto deletado com sucesso!");
          document.getElementById("nome").value = ''; 
          document.getElementById('preco').value = '';
          document.getElementById('quantidade').value = '';
      } 
      
  })
  .catch(error => alert('Erro na requisição: ' + error));
}
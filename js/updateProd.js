function updateProd() {
  const prodId = document.getElementById("getProdId").value;
  const nomeProduto = document.getElementById('nome').value;
  const precoProduto = document.getElementById('preco').value;
  const quantidadeProduto = document.getElementById('quantidade').value;
  
  if (!nomeProduto && !precoProduto && !quantidadeProduto) {
      alert("Por favor, insira um nome, um preço e uma quantidade!");
      return;
  } else if (!nomeProduto && !precoProduto) {
      alert("Por favor, insira um nome e um preço!");
      return;
  } else if (!nomeProduto && !quantidadeProduto) {
      alert("Por favor, insira um nome e uma quantidade!");
      return;
  } else if (!nomeProduto) {
      alert("Por favor, insira um nome!");
      return;
  } else if (!precoProduto && !quantidadeProduto) {
      alert("Por favor, insira um preço e uma quantidade!");
      return;
  } else if (!precoProduto) {
      alert("Por favor, insira um preço!");
      return;
  } else if (!quantidadeProduto) {
      alert("Por favor, insira uma quantidade!");
      return;
  }
  const produtoAtualizado = {
      nome: nomeProduto,
      preco: precoProduto,
      quantidade: quantidadeProduto
  };

  fetch('/backend/ProdutoRouter.php?id=' + prodId, { 
      method: 'PUT',
      headers: {
          'Content-Type': 'application/json'
      },
      body: JSON.stringify(produtoAtualizado)
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
          alert("Não pode atualizar!");
      }else{
          alert("Produto atualizado com sucesso!");
      } 
      
  })
  .catch(error => alert('Erro na requisição: ' + error));
}

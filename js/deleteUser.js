function deleteUser() {
  const userId = document.getElementById("getUserId").value;
  fetch('/backend/UsuarioRouter.php?id=' + userId, {
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
          alert("Usuário deletado com sucesso!");
          document.getElementById("inpuNome").value = '';
          document.getElementById("inputEmail").value = '';  
      } 
      
  })
  .catch(error => alert('Erro na requisição: ' + error));
}
function getUserById() {
  const userId = document.getElementById("getUserId").value;
  fetch('/backend/UsuarioRouter.php?id=' + userId, {
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
      if(!data.status){
          alert('Usuário não encontrado')
          document.getElementById("nome").value = ''; 
          document.getElementById("email").value = ''; 
      }else{
          document.getElementById("nome").value = data.usuario.nome; 
          document.getElementById("email").value = data.usuario.email; 
      } 
     
  })
  .catch(error => alert('Erro na requisição: ' + error));
}
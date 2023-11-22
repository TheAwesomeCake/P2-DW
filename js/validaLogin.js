const token = sessionStorage.getItem('token');
if (!token) {
    redirecioneLogin();
}

async function validaToken() {
try {
    const response = await fetch("/backend/login", {
        method: 'GET',
        headers: {
            'authorization':  token
        }
    });

    const jsonResponse = await response.json();
    if (!jsonResponse.status) {  
        window.location.href = 'todosprod.html';  
    }
    
    const telasPermitidas = jsonResponse.telas.map(tela => tela.nome);
    console.log(telasPermitidas);
    const nomePaginaAtual = window.location.pathname.split('/').pop().replace('.html', '');
    console.log(nomePaginaAtual);
    
    const itensMenu = Array.from(document.getElementsByTagName('a'));
    
    
    itensMenu.forEach(item => {
        const nomeTela = item.href.split('/').pop().replace('.html', '');
    
        if (telasPermitidas.includes(nomeTela)) {
            
            item.style.display = 'block'; 
        } else {
            item.style.display = 'none'; 
        }
    });

    if (!telasPermitidas.includes(nomePaginaAtual)) {
        
        
        window.location.href = 'index.html';  
        
    }

    document.body.style.display = 'block';
    if (!response.ok || !jsonResponse.status) {
        redirecioneLogin(jsonResponse.message);
    }
} catch (error) {
    console.error("Erro ao validar token:", error);
    
}
}

validaToken();

setInterval(validaToken, 60000);


function redirecioneLogin() {
    window.location.href = "todosprod.html";
}
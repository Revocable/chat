document.getElementById("formCriarUsuario").addEventListener("submit", function (event) {
    event.preventDefault(); // Evita o comportamento padrão de submissão do formulário

    const loginUsuario = document.getElementById("loginUsuario").value;
    const senhaUsuario = document.getElementById("senhaUsuario").value;
    const username = document.getElementById("username").value;

    // Enviar os dados do formulário via AJAX
    const formData = new FormData();
    formData.append("signup", true);
    formData.append("login", loginUsuario);
    formData.append("senha", senhaUsuario);
    formData.append("nome", username);
    
    // Convertendo FormData para x-www-form-urlencoded
    const urlencoded = new URLSearchParams(formData);
    
    fetch("http://localhost/chat/usuario.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded" // Definindo o cabeçalho Content-Type
        },
        body: urlencoded
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro na requisição: ${response.status} - ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            alert(data.msg);
        })
        .catch(error => {
            console.error("Erro:", error);
        });
        
});

document.getElementById("formLoginUsuario").addEventListener("submit", function (event) {
    event.preventDefault(); // Evita o comportamento padrão de submissão do formulário

    const loginUsuario = document.getElementById("loginUsuarioLogin").value;
    const senhaUsuario = document.getElementById("senhaUsuarioLogin").value;

    // Enviar os dados do formulário via AJAX
    const formData = new FormData();
    formData.append("login", loginUsuario);
    formData.append("senha", senhaUsuario);
    
    // Convertendo FormData para x-www-form-urlencoded
    const urlencoded = new URLSearchParams(formData);
    
    fetch("http://localhost/chat/usuario.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded" // Definindo o cabeçalho Content-Type
        },
        body: urlencoded
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro na requisição: ${response.status} - ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            alert(data.msg);
            // Se o login for bem sucedido, você pode redirecionar o usuário para outra página ou realizar outras ações necessárias
        })
        .catch(error => {
            console.error("Erro:", error);
        });
});

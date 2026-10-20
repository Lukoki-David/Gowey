document.addEventListener("DOMContentLoaded", () => {
    carregarEscolas();
});

function carregarEscolas() {
    fetch("escolas_processo.php")
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector("#schoolTable tbody");
            tbody.innerHTML = "";

            data.forEach(escola => {
                const row = `
                    <tr>
                        <td>${escola.nome}</td>
                        <td>${escola.endereco}</td>
                        <td>${escola.telefone}</td>
                        <td>${escola.numero_processo}</td>
                        <td>${escola.email}</td>
                        <td>${escola.responsavel}</td>
                        <td>${escola.numero_aluno}</td>
                        <td>
                            <button class="btn-delete" onclick="deletarEscola(${escola.id})">Excluir</button>
                        </td>
                    </tr>`;
                tbody.innerHTML += row;
            });
        })
        .catch(error => console.error("Erro ao carregar escolas:", error));
}

function deletarEscola(id) {
    if (confirm("Tem certeza que deseja excluir esta escola?")) {
        fetch(`escolas_cadastr_deletar.php?id=${id}`, { method: "GET" })
            .then(response => response.json())
            .then(data => {
                mostrarMensagem(data.message, data.status);
                if (data.status === "success") {
                    carregarEscolas(); // Atualiza tabela
                }
            })
            .catch(error => console.error("Erro ao excluir escola:", error));
    }
}

function mostrarMensagem(texto, tipo) {
    const msgBox = document.getElementById("mensagem");
    msgBox.innerText = texto;
    msgBox.className = tipo === "success" ? "alert success" : "alert error";
    msgBox.style.display = "block";

    // Ocultar automaticamente após 4 segundos
    setTimeout(() => {
        msgBox.style.display = "none";
    }, 4000);
}

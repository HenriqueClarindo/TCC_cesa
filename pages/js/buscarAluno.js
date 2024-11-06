function buscarAluno() {
    var nomeAluno = document.getElementById("nomeAluno").value;

    // Verifica se o campo está vazio para limpar os resultados
    if (nomeAluno.length === 0) {
        document.getElementById("resultadoBusca").innerHTML = "";
        return;
    }

    // Cria um objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Define o que acontece quando a resposta do servidor é recebida
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Converte a resposta JSON em um objeto
            var alunos = JSON.parse(xhr.responseText);

            // Limpa a lista de resultados
            var resultadoBusca = document.getElementById("resultadoBusca");
            resultadoBusca.innerHTML = "";

            // Exibe os resultados como uma lista
            alunos.forEach(function(aluno) {
                var li = document.createElement("li");
                li.textContent = aluno.nome;
                li.onclick = function() {
                    document.getElementById("nomeAluno").value = aluno.nome; // Preenche o campo de entrada
                    resultadoBusca.innerHTML = ""; // Limpa a lista de resultados
                };
                resultadoBusca.appendChild(li);
            });
        }
    };

    // Abre uma requisição para o servidor (ajuste o caminho se necessário)
    xhr.open("GET", "../backend/buscarAlunos.php?nome=" + encodeURIComponent(nomeAluno), true);

    // Envia a requisição
    xhr.send();
}

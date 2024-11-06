// Seleciona elementos dos modais e botões
const adicionarAlunoBtn = document.getElementById('adicionarAlunoBtn');
const adicionarAlunoMenu = document.getElementById('adicionarAlunoMenu');
const cancelarBtn = document.getElementById('cancelar');
const overlay = document.getElementById('overlay');
const bodyContent = document.getElementById('background-content');

const cadastrarAlunoBtn = document.getElementById('cadAluno');
const cadastrarAlunoMenu = document.getElementById('cadastrarAlunoMenu');
const cancelar_cBtn = document.getElementById('cancelar_c');
const fecha = document.getElementById('fecha');

// Seleciona os formulários dentro dos modais
const adicionarAlunoForm = document.getElementById('adicionarAlunoForm');
const cadastrarAlunoForm = document.getElementById('cadastrarAlunoForm');

// Função para limpar um formulário
function limparFormulario(form) {
    form.reset();
}

// Adicionar evento para abrir o modal e exibir o overlay
adicionarAlunoBtn.addEventListener('click', () => {
    adicionarAlunoMenu.style.display = 'block';
    overlay.style.display = 'block';
    adicionarAlunoBtn.classList.add('active');
});

// Evento para fechar o modal e esconder o overlay ao clicar no botão "Cancelar"
cancelarBtn.addEventListener('click', () => {
    adicionarAlunoMenu.style.display = 'none';
    overlay.style.display = 'none';
    adicionarAlunoBtn.classList.remove('active');
    limparFormulario(adicionarAlunoForm); // Limpa o formulário ao fechar
});

// Evento para fechar o modal e esconder o overlay ao clicar no próprio overlay
overlay.addEventListener('click', () => {
    adicionarAlunoMenu.style.display = 'none';
    overlay.style.display = 'none';
    adicionarAlunoBtn.classList.remove('active');
    limparFormulario(adicionarAlunoForm); // Limpa o formulário ao fechar
});

// Código para o modal de cadastro
// Adicionar evento para abrir o modal de cadastro e exibir o fundo
cadastrarAlunoBtn.addEventListener('click', () => {
    cadastrarAlunoMenu.style.display = 'block';
    fecha.style.display = 'block';
    cadastrarAlunoBtn.classList.add('active');
    overlay.style.display = 'none'; // Garante que apenas um overlay esteja visível
});

// Evento para fechar o modal de cadastro e esconder o fundo ao clicar no botão "Cancelar"
cancelar_cBtn.addEventListener('click', () => {
    cadastrarAlunoMenu.style.display = 'none';
    fecha.style.display = 'none';
    cadastrarAlunoBtn.classList.remove('active');
    limparFormulario(cadastrarAlunoForm); // Limpa o formulário ao fechar
});

// Evento para fechar o modal de cadastro e esconder o fundo ao clicar no próprio fundo
fecha.addEventListener('click', () => {
    cadastrarAlunoMenu.style.display = 'none';
    fecha.style.display = 'none';
    cadastrarAlunoBtn.classList.remove('active');
    limparFormulario(cadastrarAlunoForm); // Limpa o formulário ao fechar
});

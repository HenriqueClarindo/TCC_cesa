function addResponsavel() {
    var responsaveisDiv = document.getElementById('responsaveis');
    var newResponsavelDiv = document.createElement('div');
    newResponsavelDiv.className = 'responsavel';
    newResponsavelDiv.innerHTML = 
                        `<div class="form-group">
							<input type="text" placeholder="nome do responsavel">
							<input type="text" placeholder="CPF">
							<input type="text" placeholder="tel do responsavel">
						</div>`;
    
    responsaveisDiv.appendChild(newResponsavelDiv);
}
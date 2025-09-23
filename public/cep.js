document.addEventListener('DOMContentLoaded', function () {
    const cepInput = document.getElementById('cep');
    const ruaInput = document.getElementById('street');
    const bairroInput = document.getElementById('district');
    const cidadeInput = document.getElementById('city');
    const estadoInput = document.getElementById('state');

    cepInput.addEventListener('blur', async function() {
        const cepLimpo = cepInput.value.replace(/\D/g, '');

        if (cepLimpo.length !== 8) {
            return;
        }

        try {
            const response = await fetch(`/cep/${cepLimpo}`);
            const data = await response.json();

            if (!response.ok || data.erro) {
                console.error('CEP não encontrado ou erro na API.');
                return;
            }
            
            ruaInput.value = data.logradouro;
            bairroInput.value = data.bairro;
            cidadeInput.value = data.localidade;
            estadoInput.value = data.uf;

        } catch (error){
            console.error('Ocorreu um erro:', error);
        }
    });
});
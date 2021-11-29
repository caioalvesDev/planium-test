<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Planium</title>
        <link rel="stylesheet" href="form-beneficiarios.css">
        <script>
            var beneficiarioIndex = 0;
            function addBeneficiarioToForm() {
                var beneficiarios = document.getElementById("beneficiarios");
                let nameInputName = `beneficiario[${beneficiarioIndex}][idade]`;
                let idadeInputName = `beneficiario[${beneficiarioIndex}][nome]`;
                let registroDoPlanoInputName = `beneficiario[${beneficiarioIndex}][registro-do-plano]`;
                beneficiarios.innerHTML += `
                <div class="beneficiario-container">
                    <div class="beneficiario-container-row">
                        <label for="${nameInputName}">Idade</label>
                        <input type="text" name="${nameInputName}"/>
                    </div>
                    <div class="beneficiario-container-row">
                        <label for="${idadeInputName}">Nome</label>
                        <input type="text" name="${idadeInputName}"/>
                    </div>
                    <div class="beneficiario-container-row">
                        <label for="${registroDoPlanoInputName}">Registro do plano</label>
                        <input type="text" name="${registroDoPlanoInputName}"/>
                    </div>
                </div>
                `;
                beneficiarioIndex = beneficiarioIndex + 1;
            }
            document.addEventListener("DOMContentLoaded", function(event) {
                addBeneficiarioToForm();
            });
        </script>
    </head>
    <body>
        <div class="container">
            <h1>Cadastrar Beneficiários</h1>
            <form class="form" action="/form-proposta.php" method="POST">
                <div id="beneficiarios" class="beneficiarios"></div>
                <div class="add-button-container">
                    <button class="add-button" type="button" onclick="addBeneficiarioToForm()" action={}> + Adicionar Beneficiário </button>
                </div>
                <input class="submit-button" type="submit" value="Cadastrar"/>
            </form>
        </div>
    </body>
</html>

<?php
$prices = json_decode(file_get_contents("prices.json"));
$plans = json_decode(file_get_contents("plans.json"));
$beneficiarios = $_POST["beneficiario"];
$beneficiarios_result = array();
foreach ($beneficiarios as $beneficiario) {
	$plan = null;
	$price = null;
	foreach ($plans as $planIterator) {
		if ($planIterator->registro == $beneficiario["registro-do-plano"]) {
			$plan = $planIterator;
			break;
		}
	}
	if (!isset($plan)) {
		echo "O plano inserido é inválido.";
		exit;
	}
	foreach ($prices as $priceIterator) {
		if ($priceIterator->codigo == $plan->codigo) {
			if (isset($price)) {
				if (
					$priceIterator->minimo_vidas <= count($beneficiarios) &&
					$priceIterator->minimo_vidas > $price->minimo_vidas
				) {
					$price = $priceIterator;
				}
			} else {
				$price = $priceIterator;
			}
		}
	}
	$beneficiario_price = null;
	if ($beneficiario["idade"] < 17) {
		$beneficiario_price = $price->faixa1;
	} else if ($beneficiario["idade"] < 40) {
		$beneficiario_price = $price->faixa2;
	} else {
		$beneficiario_price = $price->faixa3;
	}
	array_push(
		$beneficiarios_result,
		array(
			"nome" => $beneficiario["nome"],
			"idade" => $beneficiario["idade"],
			"registro_plano" => $plan->registro,
			"preco" => $beneficiario_price,
		)
	);
}
$total_price = 0;
foreach ($beneficiarios_result as $beneficiario_result) {
	$total_price += $beneficiario_result["preco"];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Planium</title>
		<link rel="stylesheet" href="form-proposta.css">
	</head>
	<body>
		<div class="container">
			<h1>Proposta</h1>
			<form class="form" action="/save-proposta.php" method="POST">
				<div class="beneficiarios_result">
					<?php
						$index = 0;
						foreach($beneficiarios_result as $beneficiario_result_iterator):
						$nomeInputName = "beneficiarios_result[{$index}][nome]";
						$idadeInputName = "beneficiarios_result[{$index}][idade]";
						$registroDoPlanoInputName = "beneficiarios_result[{$index}][registro_plano]";
						$precoInputName = "beneficiarios_result[{$index}][preco]";
					?>
						<div class="beneficiario_result">
							<div class="beneficiario_result_row">
								<label for="<?= $nomeInputName ?>">Nome</label>
								<input
									class="disabled"
									type="text"
									name="<?= $nomeInputName ?>"
									value="<?= $beneficiario_result_iterator["nome"] ?>"
								/>
							</div>
							<div class="beneficiario_result_row">
								<label for="<?= $idadeInputName ?>">Idade</label>
								<input
									class="disabled"
									type="text"
									name="<?= $idadeInputName ?>"
									value="<?= $beneficiario_result_iterator["idade"] ?>"
								/>
							</div>
							<div class="beneficiario_result_row">
								<label for="<?= $registroDoPlanoInputName ?>">Registro do plano</label>
								<input
									class="disabled"
									type="text"
									name="<?= $registroDoPlanoInputName ?>"
									value="<?= $beneficiario_result_iterator["registro_plano"] ?>"
								/>
							</div>
							<div class="beneficiario_result_row">
								<label for="<?= $precoInputName ?>">Preço</label>
								<input
									class="disabled"
									type="text"
									name="<?= $precoInputName ?>"
									value="<?= $beneficiario_result_iterator["preco"] ?>"
								/>
							</div>
						</div>
					<?php
						$index++;
				 		endforeach;
					?>
				</div>
				<input class="submit-button" type="submit" value="Confirmar"/>
			</form>
		</div>
	</body>
</html>

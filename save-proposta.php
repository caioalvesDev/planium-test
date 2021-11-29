<?php
$file_path = "proposta.json";
$currentProposta = json_decode(file_get_contents($file_path));
$newBeneficiarios = $_POST["beneficiarios_result"];
$newPropostaContent = json_encode(array_merge($currentProposta, $newBeneficiarios));
$propostaFile = fopen($file_path, "w") or die("Unable to open file!");
fwrite($propostaFile, $newPropostaContent);
fclose($propostaFile);
header("Location: /");

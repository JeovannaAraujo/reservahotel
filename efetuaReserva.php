<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id_quarto"])) {
        $nome_hospede = $_POST["nome_hospede"];
        $checkin = $_POST["checkin"];
        $checkout = $_POST["checkout"];
        $id_quarto = $_POST["id_quarto"];

        // Verificar se o quarto já está reservado para as datas especificadas
        $checkAvailabilityQuery = "SELECT * FROM reserva WHERE id_quarto = $id_quarto AND 
            ((checkin <= '$checkin' AND checkout >= '$checkin') OR 
            (checkin <= '$checkout' AND checkout >= '$checkout'))";

        $result = $mysqli->query($checkAvailabilityQuery);

        if ($result && $result->num_rows > 0) {
            echo "Este quarto já está reservado para este período. Por favor, escolha outro período ou outro quarto.";
        } else {
            // Continuar com o processo de reserva
            $updateQuery = "UPDATE quarto SET status = 'Indisponível' WHERE ID = $id_quarto";
            $mysqli->query($updateQuery);

            $comandQuery = "INSERT INTO reserva (nome_hospede, id_quarto, checkin, checkout)
                VALUES ('$nome_hospede', $id_quarto, '$checkin', '$checkout')";

            if ($mysqli->query($comandQuery)) {
                echo "Reserva cadastrada com sucesso!";
            } else {
                echo "Ocorreu um erro ao cadastrar a reserva: " . $mysqli->error;
            }
        }
    } else {
        echo "ID do quarto não foi enviado.";
    }
    $mysqli->close();
}
?>

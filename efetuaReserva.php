<?php
include('conexao.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Efetuar Reserva</title>
</head>

<body>
    <h1>Efetuar Reserva</h1>
    <form action="" method="post">

        Nome do Hóspede: <input type="text" name="nome_hospede" required><br><br>

        <label for="id_quarto">Escolha o quarto:</label>
        <select name="id_quarto" id="id_quarto" required>
            <?php
            $result = $mysqli->query("SELECT ID, CONCAT(tipo, ' - Andar ', andar, ' - ', status) AS descricao FROM quarto WHERE status = 'Disponível'");
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['ID'] . '">' . $row['descricao'] . '</option>';
            }
            ?>
        </select><br><br>

        Data de Check-in: <input type="date" name="checkin" required><br><br>
        Data de Checkout: <input type="date" name="checkout" required><br><br>

        <input type="submit" value="Reservar">
        <br><br>
        <a href="index.php">Voltar</a>
    </form>
    <br>
</body>

</html>

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
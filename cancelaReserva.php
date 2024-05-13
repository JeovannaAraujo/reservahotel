<?php
include('conexao.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cancelar Reserva</title>
</head>
<body>
    <h1>Cancelar Reserva</h1>
    <form action="" method="post">
        <label for="id_reserva">ID da Reserva a Cancelar:</label>
        <select name="id_reserva" id="id_reserva" required>
            <?php
            $result = $mysqli->query("SELECT reserva.ID AS id_reserva, reserva.nome_hospede AS nome_hospede, quarto.tipo AS tipo_quarto, quarto.andar AS andar_quarto FROM reserva INNER JOIN quarto ON reserva.id_quarto = quarto.ID");
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['id_reserva'] . '">ID Reserva: ' . $row['id_reserva'] . ' - Nome: ' . $row['nome_hospede'] . ' - Quarto: ' . $row['tipo_quarto'] . ' - Andar: ' . $row['andar_quarto'] . '</option>';
            }
            ?>
        </select><br><br>
        <input type="submit" value="Cancelar Reserva"><br><br>
        <a href="index.php">Voltar</a>

    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["id_reserva"])) {
            $id_reserva = $_POST["id_reserva"];

            $deleteQuery = "DELETE FROM reserva WHERE ID = $id_reserva";

            if ($mysqli->query($deleteQuery)) {
                echo "<p>Reserva ID $id_reserva cancelada com sucesso!</p>";
            } else {
                echo "<p>Ocorreu um erro ao cancelar a reserva.</p>";
            }
        } else {
            echo "<p>ID da reserva não foi enviado.</p>";
        }
    }
    ?>

</body>
</html>

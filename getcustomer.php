<?php
include("conexao.php");

$sql = "SELECT clientes.id_cliente, clientes.nome_cliente FROM clientes WHERE clientes.id_cliente = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $_GET['cliente']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $name);
$stmt->fetch();
$stmt->close();

echo "<table>";
echo "<tr>";
echo "<th>CustomerID</th>";
echo "<th>CompanyName</th>";
echo "</tr>";
echo "<tr>";
echo "<td>" . $id . "</td>";
echo "<td>" . $name . "</td>";
echo "</tr>";
echo "</table>";
?> 

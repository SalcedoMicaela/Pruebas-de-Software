<?php
require_once('fpdf.php');
require_once('code128.php');

class PDF extends FPDF
{
    // Agregar la biblioteca Code128 para códigos de barras
    use Code128;
    
    public function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Factura', 0, 1, 'C');
        $this->Ln(10);
    }
    
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
    
    public function TablaHeader()
    {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(90, 10, 'Producto', 1);
        $this->Cell(30, 10, 'Cantidad', 1);
        $this->Cell(30, 10, 'Precio Unitario', 1);
        $this->Cell(30, 10, 'Subtotal', 1);
        $this->Ln();
    }
    
    public function TablaBody($productos)
    {
        $this->SetFont('Arial', '', 10);
        $total = 0;
        foreach ($productos as $producto) {
            $subtotal = $producto['cantidad'] * $producto['precio_unitario'];
            $total += $subtotal;
            $this->Cell(90, 10, $producto['nombre'], 1);
            $this->Cell(30, 10, $producto['cantidad'], 1, 0, 'R');
            $this->Cell(30, 10, number_format($producto['precio_unitario'], 2), 1, 0, 'R');
            $this->Cell(30, 10, number_format($subtotal, 2), 1, 0, 'R');
            $this->Ln();
        }
        $this->Cell(150, 10, 'Total', 1);
        $this->Cell(30, 10, number_format($total, 2), 1, 0, 'R');
    }
}

// Recoger datos de la venta
$id_cliente = $_POST['id_cliente'];
$cliente_nombre = $_POST['clienteNombre'];
$productos = $_POST['productos']; // Asumimos que `productos` es un array de arrays con datos de productos

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Datos del cliente
$pdf->Cell(0, 10, "Cliente: $cliente_nombre", 0, 1);
$pdf->Cell(0, 10, "ID Cliente: $id_cliente", 0, 1);
$pdf->Ln(10);

// Tabla de productos
$pdf->TablaHeader();
$pdf->TablaBody($productos);

// Generar código de barras (ejemplo con ID de la venta)
$pdf->Ln(10);
$pdf->Cell(0, 10, 'Código de Barras:', 0, 1);
$pdf->Code128(10, $pdf->GetY(), '123456789012', 120, 20); // Aquí podrías usar un ID de venta real

$pdf->Output();
?>

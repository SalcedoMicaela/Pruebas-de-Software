class Validaciones {
  static bool validarEdad(DateTime fechaNacimiento) {
    final hoy = DateTime.now();
    return fechaNacimiento.isBefore(hoy);
  }

  static bool validarLadosTriangulo(double l1, double l2, double l3) {
    // Ningún lado debe ser <= 0 y debe cumplir la desigualdad triangular
    if (l1 <= 0 || l2 <= 0 || l3 <= 0) return false;
    return (l1 + l2 > l3) && (l1 + l3 > l2) && (l2 + l3 > l1);
  }
}

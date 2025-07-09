import '../models/triangulo.dart';
import 'validaciones.dart';

class TrianguloViewModel {
  String tipoTriangulo(Triangulo t) {
    if (!Validaciones.validarLadosTriangulo(t.lado1, t.lado2, t.lado3)) {
      throw Exception("Lados inválidos para formar un triángulo.");
    }

    if (t.lado1 == t.lado2 && t.lado2 == t.lado3) {
      return 'Equilátero';
    } else if (t.lado1 == t.lado2 || t.lado2 == t.lado3 || t.lado1 == t.lado3) {
      return 'Isósceles';
    } else {
      return 'Escaleno';
    }
  }
}

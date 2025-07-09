import '../models/persona.dart';
import 'validaciones.dart';


class EdadViewModel {
  Map<String, int> calcularEdad(Persona persona) {
    if (!Validaciones.validarEdad(persona.fechaNacimiento)) {
      throw Exception("Fecha de nacimiento inválida.");
    }
    final hoy = DateTime.now();
    final nacimiento = persona.fechaNacimiento;

    int anios = hoy.year - nacimiento.year;
    int meses = hoy.month - nacimiento.month;
    int dias = hoy.day - nacimiento.day;

    if (dias < 0) {
      meses--;
      dias += DateTime(hoy.year, hoy.month, 0).day;
    }

    if (meses < 0) {
      anios--;
      meses += 12;
    }

    return {
      'anios': anios,
      'meses': meses,
      'dias': dias,
    };
  }
}

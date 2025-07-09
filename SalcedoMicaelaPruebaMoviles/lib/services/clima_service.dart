import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/clima.dart';

class ClimaService {
  Future<Clima> obtenerClima(String ciudad) async {
    final url = Uri.parse('https://wttr.in/$ciudad?format=j1');
    final respuesta = await http.get(url);

    if (respuesta.statusCode == 200) {
      return Clima.fromJson(json.decode(respuesta.body), ciudad);
    } else {
      throw Exception('Error al cargar el clima para $ciudad');
    }
  }
}

import 'package:flutter/material.dart';
import '../models/clima.dart';
import '../services/clima_service.dart';

class ClimaViewModel extends ChangeNotifier {
  final ClimaService _climaService = ClimaService();

  List<Clima> climas = [];
  bool isLoading = false;
  String? error;

  Future<void> cargarClimas() async {
    isLoading = true;
    error = null;
    notifyListeners();

    List<String> ciudades = ['Quito', 'Guayaquil', 'Cuenca'];
    List<Clima> nuevosClimas = [];

    try {
      for (String ciudad in ciudades) {
        final clima = await _climaService.obtenerClima(ciudad);
        nuevosClimas.add(clima);
      }
      climas = nuevosClimas;
    } catch (e) {
      error = 'Error al cargar el clima';
    } finally {
      isLoading = false;
      notifyListeners();
    }
  }
}

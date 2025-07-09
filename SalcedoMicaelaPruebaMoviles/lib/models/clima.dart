class Clima {
  final String ciudad;
  final double temperatura;
  final String descripcion;

  Clima({
    required this.ciudad,
    required this.temperatura,
    required this.descripcion,
  });

  factory Clima.fromJson(Map<String, dynamic> json, String ciudad) {
    final tempString = json['current_condition'][0]['temp_C'];
    final descripcion = json['current_condition'][0]['weatherDesc'][0]['value'];

    return Clima(
      ciudad: ciudad,
      temperatura: double.tryParse(tempString) ?? 0,
      descripcion: descripcion,
    );
  }
}

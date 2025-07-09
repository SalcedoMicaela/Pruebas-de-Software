import 'package:flutter/material.dart';
import '../models/triangulo.dart';
import '../viewmodels/triangulo_viewmodel.dart';
import '../viewmodels/validaciones.dart';

class TrianguloScreen extends StatefulWidget {
  @override
  _TrianguloScreenState createState() => _TrianguloScreenState();
}

class _TrianguloScreenState extends State<TrianguloScreen> {
  final TextEditingController _lado1Controller = TextEditingController();
  final TextEditingController _lado2Controller = TextEditingController();
  final TextEditingController _lado3Controller = TextEditingController();
  final _formKey = GlobalKey<FormState>();

  String _resultado = "";
  bool _isLoading = false;
  final TrianguloViewModel _trianguloVM = TrianguloViewModel();

  // Validation error messages
  String? _lado1Error;
  String? _lado2Error;
  String? _lado3Error;

  @override
  void initState() {
    super.initState();
    // Add listeners for real-time validation
    _lado1Controller.addListener(_validateInputs);
    _lado2Controller.addListener(_validateInputs);
    _lado3Controller.addListener(_validateInputs);
  }

  @override
  void dispose() {
    _lado1Controller.dispose();
    _lado2Controller.dispose();
    _lado3Controller.dispose();
    super.dispose();
  }

  void _validateInputs() {
    setState(() {
      _lado1Error = _validateSide(_lado1Controller.text, "Lado 1");
      _lado2Error = _validateSide(_lado2Controller.text, "Lado 2");
      _lado3Error = _validateSide(_lado3Controller.text, "Lado 3");
    });
  }

  String? _validateSide(String value, String fieldName) {
    if (value.isEmpty) return null; // Don't show error for empty fields initially

    final parsed = double.tryParse(value);
    if (parsed == null) {
      return "$fieldName debe ser un número válido";
    }
    if (parsed <= 0) {
      return "$fieldName debe ser mayor que 0";
    }
    return null;
  }

  bool _hasValidInputs() {
    return _lado1Error == null &&
        _lado2Error == null &&
        _lado3Error == null &&
        _lado1Controller.text.isNotEmpty &&
        _lado2Controller.text.isNotEmpty &&
        _lado3Controller.text.isNotEmpty;
  }

  void _determinarTipo() async {
    // Validate all inputs first
    _validateInputs();

    if (!_hasValidInputs()) {
      setState(() {
        _resultado = "Por favor, corrige los errores antes de continuar.";
      });
      return;
    }

    setState(() {
      _isLoading = true;
      _resultado = "";
    });

    try {
      // Add slight delay for better UX
      await Future.delayed(Duration(milliseconds: 300));

      final l1 = double.parse(_lado1Controller.text);
      final l2 = double.parse(_lado2Controller.text);
      final l3 = double.parse(_lado3Controller.text);

      Triangulo t = Triangulo(lado1: l1, lado2: l2, lado3: l3);
      String tipo = _trianguloVM.tipoTriangulo(t);

      setState(() {
        _resultado = "🔺 El triángulo es $tipo";
        _isLoading = false;
      });
    } catch (e) {
      setState(() {
        _resultado = "❌ ${e.toString().replaceAll("Exception: ", "")}";
        _isLoading = false;
      });
    }
  }

  void _limpiarCampos() {
    _lado1Controller.clear();
    _lado2Controller.clear();
    _lado3Controller.clear();
    setState(() {
      _resultado = "";
      _lado1Error = null;
      _lado2Error = null;
      _lado3Error = null;
    });
  }

  Widget _buildTextField({
    required TextEditingController controller,
    required String label,
    String? errorText,
  }) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        TextField(
          controller: controller,
          decoration: InputDecoration(
            labelText: label,
            errorText: errorText,
            border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(8),
            ),
            prefixIcon: Icon(Icons.straighten),
            suffixText: "cm",
          ),
          keyboardType: TextInputType.numberWithOptions(decimal: true),
        ),
        SizedBox(height: 16),
      ],
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Tipo de Triángulo"),
        backgroundColor: Theme.of(context).colorScheme.inversePrimary,
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16.0),
        child: Form(
          key: _formKey,
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
              Card(
                elevation: 2,
                child: Padding(
                  padding: const EdgeInsets.all(16.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        "Ingresa las longitudes de los tres lados:",
                        style: Theme.of(context).textTheme.titleMedium,
                      ),
                      SizedBox(height: 16),
                      _buildTextField(
                        controller: _lado1Controller,
                        label: "Lado 1",
                        errorText: _lado1Error,
                      ),
                      _buildTextField(
                        controller: _lado2Controller,
                        label: "Lado 2",
                        errorText: _lado2Error,
                      ),
                      _buildTextField(
                        controller: _lado3Controller,
                        label: "Lado 3",
                        errorText: _lado3Error,
                      ),
                    ],
                  ),
                ),
              ),

              SizedBox(height: 20),

              Row(
                children: [
                  Expanded(
                    child: ElevatedButton.icon(
                      onPressed: _isLoading ? null : _determinarTipo,
                      icon: _isLoading
                          ? SizedBox(
                        width: 20,
                        height: 20,
                        child: CircularProgressIndicator(strokeWidth: 2),
                      )
                          : Icon(Icons.calculate),
                      label: Text(_isLoading ? "Calculando..." : "Determinar tipo"),
                      style: ElevatedButton.styleFrom(
                        padding: EdgeInsets.symmetric(vertical: 12),
                      ),
                    ),
                  ),
                  SizedBox(width: 12),
                  OutlinedButton.icon(
                    onPressed: _isLoading ? null : _limpiarCampos,
                    icon: Icon(Icons.clear),
                    label: Text("Limpiar"),
                    style: OutlinedButton.styleFrom(
                      padding: EdgeInsets.symmetric(vertical: 12),
                    ),
                  ),
                ],
              ),

              SizedBox(height: 20),

              if (_resultado.isNotEmpty)
                Card(
                  elevation: 2,
                  color: _resultado.contains("❌")
                      ? Colors.red.shade50
                      : Colors.green.shade50,
                  child: Padding(
                    padding: const EdgeInsets.all(16.0),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          "Resultado:",
                          style: Theme.of(context).textTheme.titleSmall,
                        ),
                        SizedBox(height: 8),
                        Text(
                          _resultado,
                          style: TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.w500,
                            color: _resultado.contains("❌")
                                ? Colors.red.shade700
                                : Colors.green.shade700,
                          ),
                        ),
                      ],
                    ),
                  ),
                ),

              SizedBox(height: 20),

              // Help section
              Card(
                elevation: 1,
                child: Padding(
                  padding: const EdgeInsets.all(16.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Row(
                        children: [
                          Icon(Icons.info_outline, color: Colors.blue),
                          SizedBox(width: 8),
                          Text(
                            "Tipos de triángulos:",
                            style: Theme.of(context).textTheme.titleSmall,
                          ),
                        ],
                      ),
                      SizedBox(height: 8),
                      Text(
                        "• Equilátero: Los tres lados son iguales\n"
                            "• Isósceles: Dos lados son iguales\n"
                            "• Escaleno: Los tres lados son diferentes",
                        style: TextStyle(fontSize: 14),
                      ),
                    ],
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
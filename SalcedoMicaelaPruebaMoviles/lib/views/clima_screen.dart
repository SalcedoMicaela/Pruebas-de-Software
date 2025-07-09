import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../viewmodels/clima_viewmodel.dart';
import '../models/clima.dart';

class ClimaScreen extends StatefulWidget {
  @override
  _ClimaScreenState createState() => _ClimaScreenState();
}

class _ClimaScreenState extends State<ClimaScreen> {
  @override
  void initState() {
    super.initState();
    Provider.of<ClimaViewModel>(context, listen: false).cargarClimas();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Clima actual')),
      body: Consumer<ClimaViewModel>(
        builder: (context, climaVM, child) {
          if (climaVM.isLoading) {
            return Center(child: CircularProgressIndicator());
          } else if (climaVM.error != null) {
            return Center(child: Text(climaVM.error!));
          } else if (climaVM.climas.isEmpty) {
            return Center(child: Text('No hay datos disponibles'));
          } else {
            return ListView.builder(
              itemCount: climaVM.climas.length,
              itemBuilder: (context, index) {
                final clima = climaVM.climas[index];
                return Card(
                  margin: EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                  child: ListTile(
                    leading: Icon(Icons.cloud_queue, size: 40, color: Colors.blue),
                    title: Text(
                      clima.ciudad,
                      style: TextStyle(fontWeight: FontWeight.bold, fontSize: 18),
                    ),
                    subtitle: Text(
                      '${_capitalize(clima.descripcion)}, ${clima.temperatura.toStringAsFixed(1)} °C',
                      style: TextStyle(fontSize: 16),
                    ),
                  ),
                );
              },
            );
          }
        },
      ),
    );
  }

  String _capitalize(String s) {
    if (s.isEmpty) return s;
    return s[0].toUpperCase() + s.substring(1);
  }
}

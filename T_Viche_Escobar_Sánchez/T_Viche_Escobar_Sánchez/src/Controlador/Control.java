/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Controlador;

import Modelo.JuegoRN;
import Vista.Partida;
import Vista.Principal;
import Vista.Resultado;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import javax.swing.DefaultListModel;
import javax.swing.JList;

/**
 *
 * @author Usuario
 */
public class Control implements ActionListener {
    private JuegoRN JUEGO;
    private Partida partida;
    private Principal principal;
    private Resultado resultado;

    public Control(JuegoRN JUEGO, Partida partida, Principal principal, Resultado resultado) {
        this.JUEGO = JUEGO;
        this.partida = partida;
        this.principal = principal;
        this.resultado = resultado;
        this.principal.getjButton1().addActionListener(this);
        this.partida.getjButton1().addActionListener(this);
  
    }

    @Override
    public void actionPerformed(ActionEvent ae) {
         if (ae.getSource().equals(principal.getjButton1())) {
            principal.setVisible(false);
            partida.setVisible(true);
            
    }
      
         
         if (ae.getSource().equals(partida.getjButton1())){
            String numeroString=partida.getjTextField1().getText();
            int numero;
            try {
                numero=Integer.parseInt(numeroString);
                String mensaje = JUEGO.verificar(numero);
                
                if (JUEGO.getIntentos().size() == 10) {
                partida.getjLabel2().setText("");
                partida.setVisible(false);
                resultado.setVisible(true); 
                resultado.getjLabel1().setText("Has Perdido");
                
                DefaultListModel<String> modelo = new DefaultListModel();
                for (int intento : JUEGO.getIntentos()) {
                    String intentoString = String.valueOf(intento);
                    modelo.addElement(intentoString);
                }
                
                resultado.getjList1().setModel(modelo);
            }
            if (mensaje=="<"){
                partida.getjLabel2().setText("El numero ingresado es menor a la respuesta");
            } else if (mensaje==">"){
                partida.getjLabel2().setText("El numero ingresado es mayor a la respuesta");
            }else {
                partida.getjLabel2().setText("");
                partida.setVisible(false);
                resultado.setVisible(true); 
                resultado.getjLabel1().setText("Has Ganado");
                
                DefaultListModel<String> modelo = new DefaultListModel();
                for (int intento : JUEGO.getIntentos()) {
                    String intentoString = String.valueOf(intento);
                    modelo.addElement(intentoString);
                }
                
                resultado.getjList1().setModel(modelo);
         }
            } catch (NumberFormatException ex) { 
                partida.getjLabel2().setText("Ingrese solo numeros enteros(No se aceptan letras o caracteres)");
            }
 
    }    
 }
}

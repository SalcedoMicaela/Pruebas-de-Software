/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package t_viche_escobar_sánchez;

import Controlador.Control;
import Modelo.JuegoRN;
import Vista.Partida;
import Vista.Principal;
import Vista.Resultado;

/**
 *
 * @author Usuario
 */
public class T_Viche_Escobar_Sánchez {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        JuegoRN JUEGO = new JuegoRN();
        Partida partida = new Partida();
        Principal principal = new Principal();
        Resultado resultado = new Resultado();
        JUEGO.mostrar();
        Control control = new Control(JUEGO, partida, principal, resultado);
    }
    
}

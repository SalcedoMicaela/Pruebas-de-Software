/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Modelo;

import java.util.ArrayList;

/**
 *
 * @author Usuario
 */
public class JuegoRN {
   // private int numero;
    int numero = (int)(Math.random()*50+1);
    ArrayList<Integer> intentos = new ArrayList(10);
    
    public void mostrar ( ){
        System.out.println(numero);
    }
    public String verificar(int n){
        intentos.add(n);
        
        if(n<numero)
            return "<";
        else if (n>numero)
            return ">";
        else
            return "=";
        }

    public int getNumero() {
        return numero;
    }

    public void setNumero(int numero) {
        this.numero = numero;
    }

    public ArrayList<Integer> getIntentos() {
        return intentos;
    }

    public void setIntentos(ArrayList<Integer> intentos) {
        this.intentos = intentos;
    }
    
}

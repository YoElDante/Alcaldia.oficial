<?php
/**
 * Servicio de clave temporal diaria para el modulo de descargas.
 * Genera y valida la clave de acceso que rota automaticamente cada dia.
 * Variables clave: fecha del sistema (date() interno).
 * Dependencias: ninguna; logica pura de fecha.
 */

namespace App\Services;

/**
 * DECISION DE DISEÑO INTENCIONAL — leer antes de modificar:
 *
 * La clave diaria es simple y predecible A PROPOSITO. El modelo operativo
 * es que el contador entrega la clave al cliente de forma verbal o por
 * telefono el mismo dia. No se requiere entropia criptografica fuerte
 * porque: (a) la clave vence al dia siguiente, (b) el riesgo de filtracion
 * es bajo en el contexto municipal, (c) la simplicidad operativa es un
 * requisito de negocio explicito.
 * El uso de hash_equals() garantiza comparacion en tiempo constante para
 * evitar ataques de timing, que es la unica amenaza relevante aqui.
 * NO es un error ni una omision de seguridad.
 */
class ClaveTemporalService
{
    /**
     * Genera la clave temporal del dia actual.
     * Formula: DDMMYYYY + (dia + mes, con cero a la izq.) + '$$'
      * Ejemplo: 01/05/2026 -> "0105202606$$"
     * @return string Clave en texto plano del dia actual.
     */
    public function generate(): string
    {
        $d = (int) date('j');
        $m = (int) date('n');
        $y = date('Y');
        return sprintf('%02d%02d%s%02d$$', $d, $m, $y, $d + $m);
    }

    /**
     * Valida que la clave ingresada coincida con la del dia actual.
     * Usa hash_equals() para comparacion en tiempo constante (anti-timing).
     * @param string $password Clave ingresada por el usuario.
     * @return bool true si la clave es correcta para el dia de hoy.
     */
    public function validate(string $password): bool
    {
        return hash_equals($this->generate(), $password);
    }
}

<?php 
interface ITerminales {
    public function crearTerminal($terminales);
    public function actuaalizarTerminal($terminales);
    public function borrarTerminal($terminal_id);
    public function obtenerTerminal();
    public function obtenerTerminalPorID($terminal_id);
}
?>
<?php
/**
 * Clase para manejar la ativacion en la bd
 * Created by PhpStorm.
 * User: halain
 * Date: 26-Sep-16
 * Time: 10:40:05 PM
 */

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Connection;

class ActivationRepository
{

    protected $db;

    protected $table = 'user_activations';

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    //Metodos de Illuminate/Auth/Passwords/DatabaseTokenRepository y otros k se utilizaran en  ActivationService.

    //obtengo el token de la app, esto se genera segun su key
    protected function getToken(){
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    //busco  el usuario en la tabla user_activations
    public function getActivation($user){
        return $this->db->table($this->table)->where('user_id', $user->id)->first();
    }

    //inserto la fila en la tabla user_activations con los datos del usuario y el token generado 
    private function createToken($user){
        $token = $this->getToken();
        $this->db->table($this->table)->insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => new Carbon()
        ]);
        return $token;//retorno el token del usuario
    }

    //regenarar un nuevo token para el usuario y actualizarlo en la tabla user_activations
    private function regenerateToken($user){
        $token = $this->getToken();
        $this->db->table($this->table)->where('user_id', $user->id)->update([
            'token' => $token,
            'created_at' => new Carbon()
        ]);
        return $token;//terorno el token del usuario
    }

    //este metodo es el k lalama a crear los datos en la tabla de activacion
    public function createActivation($user) {
        //compruebo k exista el usuario en la tabla de activacion
        $activation = $this->getActivation($user);
        if (!$activation) {
            //sino existe lo creo
            return $this->createToken($user);
        }
        //si existe lo actualizo con un token nuevo
        return $this->regenerateToken($user);
    }

    //busco en la tabla la coincidencia para el token pasado por parametro y lo devuelvo
    public function getActivationByToken($token){
        return $this->db->table($this->table)->where('token', $token)->first();
    }
    
    //elimino el registro en la tabla k coincida con el token dado
    public function deleteActivation($token){
        $this->db->table($this->table)->where('token', $token)->delete();
    }

}
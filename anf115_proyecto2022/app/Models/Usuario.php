<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario
 * 
 * @property int $IDUSUARIO
 * @property string|null $NOMUSUARIO
 * @property string|null $CLAVE
 *
 * @package App\Models
 */
class Usuario extends Model
{
	protected $table = 'usuario';
	protected $primaryKey = 'IDUSUARIO';
	public $timestamps = false;

	protected $fillable = [
		'NOMUSUARIO',
		'CLAVE'
	];
}

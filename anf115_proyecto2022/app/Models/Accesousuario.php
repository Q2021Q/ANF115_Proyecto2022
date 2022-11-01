<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Accesousuario
 * 
 * @property int|null $IDOPCION
 * @property int|null $IDUSUARIO
 *
 * @package App\Models
 */
class Accesousuario extends Model
{
	protected $table = 'accesousuario';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'IDOPCION' => 'int',
		'IDUSUARIO' => 'int'
	];

	protected $fillable = [
		'IDOPCION',
		'IDUSUARIO'
	];
}

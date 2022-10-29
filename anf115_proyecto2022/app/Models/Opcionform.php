<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Opcionform
 * 
 * @property int $IDOPCION
 * @property string $DESOPCION
 * @property int $NUMFORM
 *
 * @package App\Models
 */
class Opcionform extends Model
{
	protected $table = 'opcionform';
	protected $primaryKey = 'IDOPCION';
	public $timestamps = false;

	protected $casts = [
		'NUMFORM' => 'int'
	];

	protected $fillable = [
		'DESOPCION',
		'NUMFORM'
	];
}

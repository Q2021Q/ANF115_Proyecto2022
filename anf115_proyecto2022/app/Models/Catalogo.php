<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Catalogo
 * 
 * @property string $IDEMPRESA
 * @property string $CODIGOCUENTA
 * @property string $NOMBRECUENTA
 *
 * @package App\Models
 */
class Catalogo extends Model
{
	protected $table = 'catalogo';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'NOMBRECUENTA'
	];
}

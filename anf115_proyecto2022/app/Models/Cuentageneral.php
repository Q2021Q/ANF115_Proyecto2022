<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cuentageneral
 * 
 * @property string $YEAR
 * @property string $IDEMPRESA
 * @property string $CODIGOCUENTA
 * @property int $IDTIPOCUENTA
 * @property float $SALDO
 *
 * @package App\Models
 */
class Cuentageneral extends Model
{
	protected $table = 'cuentageneral';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'IDTIPOCUENTA' => 'int',
		'SALDO' => 'float'
	];

	protected $fillable = [
		'IDTIPOCUENTA',
		'SALDO'
	];
}

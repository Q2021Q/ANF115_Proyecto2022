<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cuentapuente
 * 
 * @property string $CODCUENTARATIO
 * @property string $YEAR
 * @property string $IDEMPRESA
 * @property string $CODIGOCUENTA
 *
 * @package App\Models
 */
class Cuentapuente extends Model
{
	protected $table = 'cuentapuente';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'CODCUENTARATIO',
		'YEAR',
		'IDEMPRESA',
		'CODIGOCUENTA'
	];
}

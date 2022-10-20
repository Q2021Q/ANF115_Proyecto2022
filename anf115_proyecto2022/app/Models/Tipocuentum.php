<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tipocuentum
 * 
 * @property int $IDTIPOCUENTA
 * @property string $NOMTIPOCUENTA
 *
 * @package App\Models
 */
class Tipocuentum extends Model
{
	protected $table = 'tipocuenta';
	protected $primaryKey = 'IDTIPOCUENTA';
	public $timestamps = false;

	protected $fillable = [
		'NOMTIPOCUENTA'
	];
}

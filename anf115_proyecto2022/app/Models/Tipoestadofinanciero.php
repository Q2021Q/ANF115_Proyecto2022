<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tipoestadofinanciero
 * 
 * @property int $IDTIPOESTADOFINANCIERO
 * @property string|null $NOMBREESTADOFINANCIERO
 *
 * @package App\Models
 */
class Tipoestadofinanciero extends Model
{
	protected $table = 'tipoestadofinanciero';
	protected $primaryKey = 'IDTIPOESTADOFINANCIERO';
	public $timestamps = false;

	protected $fillable = [
		'NOMBREESTADOFINANCIERO'
	];
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Periodocontable
 * 
 * @property string $YEAR
 * @property string $IDEMPRESA
 * @property Carbon $DESDE
 * @property Carbon $HASTA
 *
 * @package App\Models
 */
class Periodocontable extends Model
{
	protected $table = 'periodocontable';
	public $incrementing = false;
	public $timestamps = false;

	protected $dates = [
		'DESDE',
		'HASTA'
	];

	protected $fillable = [
		'DESDE',
		'HASTA'
	];
}

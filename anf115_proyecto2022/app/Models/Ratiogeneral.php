<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ratiogeneral
 * 
 * @property int $IDGENERALRATIO
 * @property int $IDRATIO
 * @property float $VALORRATIOGENERAL
 *
 * @package App\Models
 */
class Ratiogeneral extends Model
{
	protected $table = 'ratiogeneral';
	protected $primaryKey = 'IDGENERALRATIO';
	public $timestamps = false;

	protected $casts = [
		'IDRATIO' => 'int',
		'VALORRATIOGENERAL' => 'float'
	];

	protected $fillable = [
		'IDRATIO',
		'VALORRATIOGENERAL'
	];
}

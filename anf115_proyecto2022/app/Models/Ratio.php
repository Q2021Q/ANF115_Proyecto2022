<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ratio
 * 
 * @property int $IDRATIO
 * @property int $IDTIPORATIO
 * @property string $NOMBRERATIO
 *
 * @package App\Models
 */
class Ratio extends Model
{
	protected $table = 'ratio';
	protected $primaryKey = 'IDRATIO';
	public $timestamps = false;

	protected $casts = [
		'IDTIPORATIO' => 'int'
	];

	protected $fillable = [
		'IDTIPORATIO',
		'NOMBRERATIO'
	];
}

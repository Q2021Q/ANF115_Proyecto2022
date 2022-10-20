<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tiporatio
 * 
 * @property int $IDTIPORATIO
 * @property string $NOMBRETIPORATIO
 *
 * @package App\Models
 */
class Tiporatio extends Model
{
	protected $table = 'tiporatio';
	protected $primaryKey = 'IDTIPORATIO';
	public $timestamps = false;

	protected $fillable = [
		'NOMBRETIPORATIO'
	];
}

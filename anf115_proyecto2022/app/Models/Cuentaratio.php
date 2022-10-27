<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cuentaratio
 * 
 * @property string $CODCUENTARATIO
 * @property string $NOMBRECUENTARATIO
 *
 * @package App\Models
 */
class Cuentaratio extends Model
{
	protected $table = 'cuentaratio';
	
	
	protected $primaryKey = 'CODCUENTARATIO';
	
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'NOMBRECUENTARATIO'
	];
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rubroempresa
 * 
 * @property int $IDRUBROEMPRESA
 * @property string $NOMBRERUBROEMPRESA
 *
 * @package App\Models
 */
class Rubroempresa extends Model
{
	protected $table = 'rubroempresa';
	protected $primaryKey = 'IDRUBROEMPRESA';
	public $timestamps = false;

	protected $fillable = [
		'NOMBRERUBROEMPRESA'
	];
}

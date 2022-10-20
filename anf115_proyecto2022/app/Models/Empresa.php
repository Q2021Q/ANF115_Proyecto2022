<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Empresa
 * 
 * @property string $IDEMPRESA
 * @property int $IDRUBROEMPRESA
 * @property string $NOMBREEMPRESA
 * @property string|null $NOMBREFOTOEMPRESA
 *
 * @package App\Models
 */
class Empresa extends Model
{
	protected $table = 'empresa';
	protected $primaryKey = 'IDEMPRESA';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'IDRUBROEMPRESA' => 'int'
	];

	protected $fillable = [
		'IDRUBROEMPRESA',
		'NOMBREEMPRESA',
		'NOMBREFOTOEMPRESA'
	];
}

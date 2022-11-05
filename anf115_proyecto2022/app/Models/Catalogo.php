<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Catalogo
 *
 * @property $IDEMPRESA
 * @property $CODIGOCUENTA
 * @property $NOMBRECUENTA
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Catalogo extends Model
{
    protected $table = 'catalogo';
  	public $timestamps = false;
    static $rules = [
		'IDEMPRESA' => 'required',
		'CODIGOCUENTA' => 'required',
		'NOMBRECUENTA' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['IDEMPRESA','CODIGOCUENTA','NOMBRECUENTA'];



}

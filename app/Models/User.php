<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'apellido',
        'email',
        'password',
        'password_cifrada',
        'telefono',
        'direccion',
        'tipo_documento',
        'nro_documento',
        'ciudad_id',
        'estado_id',
        'estado',
        'sucursal_id',
        'limitacion',
        'apertura',
        'ultima_fecha_apertura',
        'ultima_fecha_cierre',
        'ultima_caja_id_apertura',
        'ultima_sucursal_id_apertura'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Relaion uno a muhos inversa
    public function ciudad(){
        return $this->belongsTo(Ciudad::class);
    }

    public function estado(){
        return $this->belongsTo(Estado::class);
    }
    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
    public function sucursalApertura(){
        return $this->belongsTo(Sucursal::class);
    }
    public function cajaApertura(){
        return $this->belongsTo(Caja::class);
    }

    //Relacion uno a muchos
    public function ventas(){
        return $this->hasMany(Venta::class);
    }
    public function proformas(){
        return $this->hasMany(Proforma::class);
    }
    public function movimientoCajas(){
        return $this->hasMany(MovimientoCaja::class);
    }
    public function compras(){
        return $this->hasMany(Compra::class);
    }
    public function devolucions(){
        return $this->hasMany(Devolucion::class);
    }
    public function movimientos(){
        return $this->hasMany(Movimiento::class);
    }
    public function movimientos_producto_serial(){
        return $this->hasMany(Movimiento_product_serial::class);
    }

    public function clientes(){
        return $this->hasMany(Cliente::class);
    }

    public function tasa(){
        return $this->hasMany(tasa_dia::class);
    }
}

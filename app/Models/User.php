<?php

namespace App\Models;

use App\Models\DatosEmpleados;
use App\Models\catDepartamento;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    // The User model requires this trait
    use HasRoles;
    use HasPermissions;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no_empleado',
        'name',
        'email',
        'password',
        'department_id',
        'department_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // Funcionalidades
    public function allRoles()
    {
        $currentRole = Role::get();
        return $currentRole;
    }

    public function datosEmpleados() {
        return $this->hasOne(DatosEmpleados::class, "user_id", "id");
    }

    public static function jefesPorDepartamentoDeUsuario() {
        $idDepartamento = Auth::user()->department_id;
        // Traer ids de jefes
        $idJefes = ModelHasRoles::where("role_id", 2)->pluck("model_id")->toArray();

        return Self::whereIn("id", $idJefes)->where("department_id", $idDepartamento);
    }

    public function departamento()
    {
        return $this->HasOne(CatalogoDepartamentos::class,'id','department_id');
    }
}

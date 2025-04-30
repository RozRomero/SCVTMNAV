<?php

namespace App\Models;

use App\Models\DatosEmpleados;
use App\Models\CatalogoDepartamentos;
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
        'department_id', // DEPRECATED: This is kept for backward compatibility but should be removed in future versions
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

    /**
     * One-to-one relationship with employee data
     * Each user has one set of employee data
     */
    public function datosEmpleados()
    {
        return $this->hasOne(DatosEmpleados::class, "user_id", "id");
    }

    /**
     * Many-to-many relationship with departments as regular employee
     * Uses pivot table 'departamento_empleado'
     */
    public function departamentos()
    {
        return $this->belongsToMany(CatalogoDepartamentos::class, 'departamento_empleado', 'user_id', 'departamento_id');
    }

    /**
     * Many-to-many relationship with departments as manager
     * Uses pivot table 'departamento_jefe'
     */
    public function departamentosComoJefe()
    {
        return $this->belongsToMany(CatalogoDepartamentos::class, 'departamento_jefe', 'user_id', 'departamento_id');
    }

    /**
     * Alias for departamentosComoJefe (maintained for backward compatibility)
     */
    public function jefesDepartamentos()
    {
        return $this->departamentosComoJefe();
    }

    /**
     * Check if user is manager of any department
     * @return bool
     */
    public function esJefe()
    {
        return $this->departamentosComoJefe()->exists();
    }

    /**
     * Check if user belongs to specific department
     * @param int $departamentoId
     * @return bool
     */
    public function perteneceAlDepartamento($departamentoId)
    {
        return $this->departamentos()->where('departamento_id', $departamentoId)->exists();
    }

    /**
     * Get all available roles
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allRoles()
    {
        return Role::get();
    }

    /**
     * Get managers from the same department as current user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function jefesPorDepartamentoDeUsuario()
    {
        $usuario = Auth::user();

        // Ensure user has at least one department
        $departamento = $usuario->departamentos()->first(); 

        if (!$departamento) {
            return collect(); // Return empty collection if user has no department
        }

        // Get IDs of managers (users with role_id = 2)
        $idJefes = ModelHasRoles::where("role_id", 2)->pluck("model_id")->toArray();

        // Filter managers that belong to the same department
        return User::whereIn("id", $idJefes)
                   ->whereHas('departamentos', function ($query) use ($departamento) {
                       $query->where('catalogo_departamentos.id', $departamento->id);
                   })
                   ->get();
    }

    /**
     * Scope to filter users available for department assignment
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $departamentoId When editing, include current department members
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDisponiblesParaDepartamento($query, $departamentoId = null)
    {
        // Exclude users who are managers in any department
        $query->whereDoesntHave('departamentosComoJefe');
        
        if ($departamentoId) {
            // When editing, include:
            // 1. Users with no department assignment
            // 2. Users already in this department
            $query->where(function($q) use ($departamentoId) {
                $q->whereDoesntHave('departamentos')
                  ->orWhereHas('departamentos', function($sub) use ($departamentoId) {
                      $sub->where('departamento_empleado.departamento_id', $departamentoId);
                  });
            });
        } else {
            // When creating, only include users with no department assignment
            $query->whereDoesntHave('departamentos');
        }
        
        return $query;
    }

    /**
     * Check if user is available for department assignment
     * @param int|null $departamentoId Current department ID when editing
     * @return bool
     */
    public function estaDisponibleParaDepartamento($departamentoId = null)
{
    // No puede ser jefe en ningún departamento
    if ($this->departamentosComoJefe()->exists()) {
        return false;
    }

    if ($departamentoId) {
        // Puede ser asignado si:
        // 1. No tiene departamento O
        // 2. Ya está en este departamento
        return !$this->departamentos()->exists() || 
               $this->departamentos()->where('departamento_empleado.departamento_id', $departamentoId)->exists();
    } else {
        // Para creación, no debe tener departamento asignado
        return !$this->departamentos()->exists();
    }
}
}
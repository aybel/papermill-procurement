<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
//use Tymon\JWTAuth\Contracts\JWTSubject;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
    /** @use HasFactory<\Database\Factories\UserFactory> */

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'department_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Departamento al que pertenece el usuario (departamento home/principal).
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Departamentos a los que el usuario tiene acceso funcional
     * (para gestionar compras, presupuestos, requisiciones, etc.).
     */
    public function accessibleDepartments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'user_departments')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Verifica si el usuario tiene acceso funcional a un departamento específico.
     */
    public function hasAccessToDepartment(int $departmentId, ?string $role = null): bool
    {
        $query = $this->accessibleDepartments()->where('departments.id', $departmentId);

        if ($role) {
            $query->wherePivot('role', $role);
        }

        return $query->exists();
    }

    /**
     * Obtiene todos los IDs de departamentos a los que el usuario tiene acceso
     * (incluyendo su departamento home si existe).
     */
    public function getAllAccessibleDepartmentIds(): array
    {
        $ids = $this->accessibleDepartments()->pluck('departments.id')->toArray();

        if ($this->department_id && !in_array($this->department_id, $ids)) {
            $ids[] = $this->department_id;
        }

        return $ids;
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Ramsey\Uuid\Uuid;

class Task extends Model implements Auditable
{
    use AuditableTrait, HasFactory, SoftDeletes, AuditableTrait;

    protected $fillable = [
        'judul',
        'deskripsi',
        'prioritas',
        'status',
        'deadline',
        'selesai',
        'metadata',
        'lampiran',
        'project_id',
        'user_id',
    ];

    protected $casts = [
        'deadline' => 'date',
        'selesai' => 'boolean',
        'metadata' => 'json',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
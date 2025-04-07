<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Ramsey\Uuid\Uuid;

class Comment extends Model implements Auditable
{
    use AuditableTrait, HasFactory, SoftDeletes, AuditableTrait;

    protected $fillable = [
        'isi',
        'internal',
        'metadata',
        'task_id',
        'user_id',
    ];

    protected $casts = [
        'internal' => 'boolean',
        'metadata' => 'json',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
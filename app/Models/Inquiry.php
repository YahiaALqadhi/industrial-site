<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    use HasFactory;

    public const TYPE_GENERAL = 'general';
    public const TYPE_PRODUCT = 'product';
    public const TYPE_SERVICE = 'service';

    public const STATUS_NEW = 'new';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_REPLIED = 'replied';
    public const STATUS_ARCHIVED = 'archived';

    protected $fillable = [
        'type',
        'product_id',
        'service_id',
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'message',
        'reply_subject',
        'reply_message',
        'reply_channel',
        'reply_sent',
        'reply_error',
        'notify_sent',
        'notify_error',
        'replied_at',
        'replied_by',
        'status',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'service_id' => 'integer',
        'replied_by' => 'integer',
        'replied_at' => 'datetime',
        'reply_sent' => 'boolean',
        'notify_sent' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function repliedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'replied_by');
    }
}

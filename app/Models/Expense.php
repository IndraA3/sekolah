<?php

namespace App\Models;

use App\Models\User;
use App\Models\ExpenseDetail;
use App\Models\Scopes\ExpenseScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    
    const STATUS_APPROVED   = "approved";

    const STATUS_PENDING    = "pending";

    const STATUS_REJECTED   = "rejected";

    protected static function booted()
    {
        static::addGlobalScope(new ExpenseScope);
    }

    public function expense_details(): HasMany
    {
        return $this->hasMany(ExpenseDetail::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
    
    public function requested_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'request_by');
    }

    public function approved_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approval_by');
    }
}

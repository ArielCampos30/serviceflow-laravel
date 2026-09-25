<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'company', 'email', 'phone', 'status', 'notes'];

    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class);
    }
}

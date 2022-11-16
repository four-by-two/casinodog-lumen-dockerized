<?php

namespace App\Models;
use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ParentSessions extends Eloquent  {
    protected $table = 'wainwright_parent_sessions';
    protected $timestamp = true;
    protected $primaryKey = 'id';
    use HasUuids;

    protected $fillable = [
        'player_id',
        'player_operator_id',
        'game_id',
        'game_provider',
        'currency',
        'state',
        'operator_id',
        'token_original',
        'token_original_bridge',
        'active',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'extra_meta' => 'json',
        'user_agent' => 'json'
    ];
}
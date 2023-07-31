<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class History extends Model {
    protected $table = 'histories';
    protected $fillable = [
        'historyable_id',
        'historyable_type',
        'changed_column',
        'change_value_from',
        'change_value_to',
        'admin_id','user_id','driver_id'
    ];

    public function admin() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function driver() {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
}

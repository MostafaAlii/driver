<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyProfile extends BaseModel
{
    protected $table = 'company_profiles';
    protected $fillable = ['name','bio','company_id', 'uuid'];

    public function owner(): BelongsTo {
        return $this->belongsTo(related:Company::class, foreignKey:'company_id');
    }
}

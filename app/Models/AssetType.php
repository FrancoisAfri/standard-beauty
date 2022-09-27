<?php

namespace App\Models;

use \App\Models\LicensesType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetType extends Model
{
    public $table = 'asset_type';

    protected $fillable = [
        'name',
        'description',
        'status','licenceType_id'
    ];


    public function licences(): BelongsTo
    {
        return $this->belongsTo(LicensesType::class, 'licence_type')->orderBy('id');
    }



}

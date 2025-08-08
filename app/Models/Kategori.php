<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'kode',
        'nama'
    ];

    /**
     * Many-to-many relationship with MasterItem
     */
    public function masterItems()
    {
        return $this->belongsToMany(MasterItem::class, 'kategori_master_item');
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterPiece extends Model
{
    use SoftDeletes, HasUserStamps;
    
    protected $fillable = ['category_pieces', 'pieces_code', 'pieces_name', 'remark'];

    protected $casts = [
        'category_pieces' => 'integer','created_by', 'updated_by'];
}

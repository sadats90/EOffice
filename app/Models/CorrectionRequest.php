<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CorrectionRequest extends Model
{
   public function application(): BelongsTo
   {
       return $this->belongsTo(Application::class);
   }
}

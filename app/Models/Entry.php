<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed entry_id
 * @property mixed code
 * @property mixed description
 * @method whereNull(string $string)
 */
class Entry extends Model {
    /**
     * @return HasMany
     */
    public function children() {
        return $this->hasMany(Entry::class)->with('children');
    }
}

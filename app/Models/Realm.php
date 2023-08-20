<?php

namespace App\Models;

use App\Enums\RealmDatabaseTypes;
use Filament\Models\Contracts\HasCurrentTenantLabel;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Realm extends Model implements HasName, HasCurrentTenantLabel
{
    use HasFactory;
    use HasSlug;

    //###################################################################################################################
    // ATTRIBUTES
    //###################################################################################################################

    /**
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    //###################################################################################################################
    // RELATIONS
    //###################################################################################################################

    public function databases(): HasMany
    {
        return $this->hasMany(RealmDatabase::class);
    }

    public function authDatabase(): HasOne
    {
        return $this->getDatabaseOfType(RealmDatabaseTypes::AUTH);
    }

    public function characterDatabase(): HasOne
    {
        return $this->getDatabaseOfType(RealmDatabaseTypes::CHARACTER);
    }

    public function worldDatabase(): HasOne
    {
        return $this->getDatabaseOfType(RealmDatabaseTypes::WORLD);
    }

    private function getDatabaseOfType(RealmDatabaseTypes $type): HasOne
    {
        return $this->databases()
            ->one()
            ->ofMany([], fn (Builder $query) => $query->where('type', $type));
    }

    //###################################################################################################################
    // FILAMENT
    //###################################################################################################################

    public function getFilamentName(): string
    {
        return $this->name;
    }

    public function getCurrentTenantLabel(): string
    {
        return 'Current Realm';
    }

    //###################################################################################################################
    // SLUG
    //###################################################################################################################

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}

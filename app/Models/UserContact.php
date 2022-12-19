<?php

namespace App\Models;

use App\Scopes\ByUserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class UserContact extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id","name", "document_number",
        "phone_number","street",
        "street_number","neighborhood",
        "city","state","complement",
        "latitude","longitude",
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ByUserScope);
    }

    protected function documentNumber():Attribute
    {
        return Attribute::make(
            set: fn($value) => onlyNumbers($value),
            get: fn($value) => maskInput("cpf", $value),
        );
    }

    protected function phoneNumber(): Attribute
    {
        return Attribute::make(
            set: fn($value) => onlyNumbers($value),
            get: fn($value) => maskInput("phone_number", $value)
        );
    }

}

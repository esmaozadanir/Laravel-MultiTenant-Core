<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToCompany; // Trait'i çağır

class Product extends Model
{
    use HasFactory, BelongsToCompany; // Trait'i kullan
    protected $fillable = ['name', 'price', 'company_id'];
}
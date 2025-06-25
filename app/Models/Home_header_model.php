<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Home_header_model extends Model
{
	use HasFactory;
	protected $table = "home_header";
	protected $fillable = [
	"heading",
	"description",
	"contact_us_button",
	"image"
	];
}

?>
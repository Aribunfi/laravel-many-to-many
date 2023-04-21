<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ["title", "category_id", "year", "kind", "time", "description", "image"];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    
    public function user(){
    return $this->belongsTo(User::class);
}

protected function getUpdatedAttribute($value) {
    return date('d/m/Y H:i', strtotime($value));
}

protected function getCreatedAtAttribute($value) {
    return date('d/m/Y H:i', strtotime($value));
}

public function getImageUri() {
    return $this->image ? asset('storage/' . $this->image) : 'https://www.lupoburtscher.it/wp-content/uploads/2018/04/lupo-burtscher-progetto-grafico-30-03.jpg';
}

public static function generateUniqueSlug($title) {
    $slug = Str::of($title)->slug('-');

    $projects = Project::where('slug', $slug)->get();

    $i = 1;
    $original_slug = $slug;
    while(count($projects)) {
        $slug = $original_slug . "-" . ++$i;
        $projects = Project::where('slug', $slug)->get();
    }
    return $slug;
}

}


class User extends Model {
public function projects() {
    return $this->hasMany(Post::class);
}


}
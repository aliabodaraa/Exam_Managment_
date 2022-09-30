<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    public function courses(){//one to many between faculty & course
        return $this->hasMany(Course::class);
    }
    public function rotations(){//one to many between faculty & rotation
        return $this->hasMany(Rotation::class);
    }
    public function departments(){//one to many between faculty & department
        return $this->hasMany(Department::class);
    }
    public function users(){//one to many between faculty & user
        return $this->hasMany(User::class);
    }
    public function rooms(){//one to many between faculty & room
        return $this->hasMany(Room::class);
    }
}

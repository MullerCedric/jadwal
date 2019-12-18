<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

class LocationTeacherController extends Controller
{
    public function destroy(Location $location)
    {
        $location->teachers()->detach();
        return redirect()->route('locations.show', ['location' => $location->id]);
    }
}

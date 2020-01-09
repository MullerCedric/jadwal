<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class LocationTeacherController extends Controller
{
    public function destroy(Location $location, $id = null)
    {
        $location->teachers()->detach($id);
        if (isset($_GET['redirect_to']) && $_GET['redirect_to'] === 'teachers.show') {
            return redirect()->route('teachers.show', ['teacher' => $id]);
        }
        return redirect()->route('locations.show', ['location' => $location->id]);
    }
}

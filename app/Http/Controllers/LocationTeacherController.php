<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class LocationTeacherController extends Controller
{
    public function destroy(Location $location, $id = null)
    {
        // En fonction de si id vaut null ou pas
        if ($location->examSessions->isNotEmpty()) {
            Session::flash('notifications', ['Action impossible tant que l\'implantation est liée à une session ouverte']);
            return back();
        }

        $location->teachers()->detach($id);
        if (isset($_GET['redirect_to']) && $_GET['redirect_to'] === 'teachers.show') {
            return redirect()->route('teachers.show', ['teacher' => $id]);
        }
        return redirect()->route('locations.show', ['location' => $location->id]);
    }
}

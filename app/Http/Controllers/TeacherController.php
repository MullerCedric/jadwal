<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherStoreRequest;
use App\Http\Requests\TeacherUpdateRequest;
use App\Location;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with([
            'locations' => function ($query) {
                $query->orderBy('name', 'asc');
            },
        ])
            ->orderBy('name', 'asc')
            ->get();
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        $allLocations = Location::orderBy('name', 'asc')->get();
        return view('teachers.create', compact('allLocations'));
    }

    public function store(TeacherStoreRequest $request)
    {
        $hasAddedLocations = false;
        $now = new \DateTime();
        $token = Str::random(5) . '' . substr($now->getTimestamp(), -7) . '' . Str::random(4);

        $teacher = new Teacher();
        $teacher->name = request('name');
        $teacher->email = request('email');
        $teacher->token = $token;
        $teacher->save();

        Location::all()->each(function ($location) use ($request, $teacher, &$hasAddedLocations) {
            if ($request->has('location' . $location->id)) {
                $location->teachers()->attach($teacher->id);
                $hasAddedLocations = true;
            }
        });

        $notifications = ['Le professeur a été ajouté'];
        if($hasAddedLocations) {
            $notifications[] = $teacher->name . ' a été ajouté dans les implantations sélectionnées';
            $notifications[] = 'Vous pouvez maintenant planifier une session d\'examens';
        } else {
            $notifications[] = 'Pensez à l\'ajouter à des implantations !';
        }

        Session::flash('notifications', $notifications);
        return redirect()->route('exam_sessions.create');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load([
            'locations' => function ($query) {
                $query->orderBy('name', 'asc');
            },
        ]);
        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $teacher->load('locations');
        $allLocations = Location::orderBy('name', 'asc')->get();
        return view('teachers.edit', compact('teacher', 'allLocations'));
    }

    public function update(TeacherUpdateRequest $request, Teacher $teacher)
    {
        $teacher->name = request('name');
        if($teacher->email !== request('email')) {
            $request->validate(['email' => 'unique:teachers']);
            $teacher->email = request('email');
        }
        $teacher->locations()->detach();
        $teacher->save();

        Location::all()->each(function ($location) use ($request, $teacher) {
            if ($request->has('location' . $location->id)) {
                $location->teachers()->attach($teacher->id);
            }
        });

        Session::flash('notifications', ['Les informations du professeur ont bien été modifiées']);
        return redirect()->route('teachers.show', ['teacher' => $teacher->id]);
    }

    public function destroy(Teacher $teacher)
    {
        $title = $teacher->name;
        $teacher->delete();
        Session::flash('notifications', ['Les données sur "' . $title . '"" ont été définitivement supprimées']);
        return redirect()->route('teachers.index');
    }
}

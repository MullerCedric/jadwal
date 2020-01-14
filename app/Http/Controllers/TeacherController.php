<?php

namespace App\Http\Controllers;

use App\ExamSession;
use App\Http\Requests\TeacherStoreRequest;
use App\Http\Requests\TeacherUpdateRequest;
use App\Location;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    protected $letters = [['a', 'b', 'c'], ['d', 'e', 'f'], ['g', 'h', 'i'], ['j', 'k', 'l'], ['m', 'n', 'o'], ['p', 'q', 'r'], ['s', 't', 'u', 'v'], ['w', 'x', 'y', 'z']];

    public function index()
    {
        $currLetter = $_GET['currLetter'] ?? (is_array($this->letters[0]) ? implode('', $this->letters[0]) : $this->letters[0]);
        $teachers = Teacher::with([
            'locations' => function ($query) {
                $query->orderBy('name', 'asc');
            },
        ])
            ->where(function ($query) use ($currLetter) {
                foreach (str_split($currLetter) as $index => $letter) {
                    if ($index === 0) {
                        $query->where('name', 'like', $letter . '%');
                    } else {
                        $query->orWhere('name', 'like', $letter . '%');
                    }
                }

            })
            ->orderBy('name', 'asc')
            ->paginate(20);

        $letterPagination = $this->countAlphaTeachers();
        return view('teachers.index', compact('currLetter', 'teachers', 'letterPagination'));
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
        if ($hasAddedLocations) {
            $notifications[] = $teacher->name . ' a été ajouté dans les implantations sélectionnées';
            $notifications[] = 'Vous pouvez maintenant planifier une session d\'examens';
        } else {
            $notifications[] = 'Pensez à l\'ajouter à des implantations !';
        }

        Session::flash('lastAction', ['type' => 'store', 'isDraft' => false, 'resource' => ['type' => 'teacher', 'value' => $teacher]]);
        Session::flash('notifications', $notifications);
        return redirect()->route('teachers.show', ['teacher' => $teacher->id]);
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
        if ($teacher->email !== request('email')) {
            $request->validate(['email' => 'unique:teachers']);
            $teacher->email = request('email');
        }
        $teacher->save();

        $detachFailed = '';
        Location::all()->each(function ($location) use ($request, $teacher, &$detachFailed) {
            if ($request->has('location' . $location->id)) {
                $location->teachers()->syncWithoutDetaching($teacher->id);
            } else {
                if ($location->teachers()->find($teacher->id)) {
                    if ($location->examSessions->isNotEmpty()) {
                        $detachFailed .= $detachFailed ? ', ' . $location->name : $location->name;
                    } else {
                        $teacher->locations()->detach($location->id);
                    }
                }
            }
        });

        if ($detachFailed) {
            return redirect()->back()
                ->withErrors(['locations' => 'Le professeur n\'a pas pu être retiré des implantations suivantes : ' . $detachFailed . ' car elles sont liées à une session ouverte. Le reste des informations ont cependant été mises à jour']);
        }

        Session::flash('notifications', ['Les informations du professeur ont bien été modifiées']);
        return redirect()->route('teachers.show', ['teacher' => $teacher->id]);
    }

    public function destroy(Teacher $teacher)
    {
        $title = $teacher->name;

        if ($teacher->examSessions()->get()->isNotEmpty()) {
            Session::flash('notifications', ['Vous ne pouvez pas supprimer ce professeur car il est lié à une session ouverte']);
            return redirect()->back();
        }

        $teacher->locations()->detach();
        $teacher->delete();
        Session::flash('notifications', ['Les données sur "' . $title . '"" ont été définitivement supprimées']);
        return redirect()->route((isset($_GET['redirect_to']) && Route::has($_GET['redirect_to'])) ? $_GET['redirect_to'] : 'teachers.index');
    }

    protected function countAlphaTeachers()
    {
        $results = [];

        foreach ($this->letters as $letter) {
            if (is_array($letter)) {
                $key = '';
                $results['temp'] = 0;
                foreach ($letter as $subLetter) {
                    $key .= $subLetter;
                    $results['temp'] += Teacher::where('name', 'like', $subLetter . '%')->count();
                }
                $results[$key] = $results['temp'];
                unset($results['temp']);
            } else {
                $results[$letter] = Teacher::where('name', 'like', $letter . '%')->count();
            }
        }

        return $results;
    }
}

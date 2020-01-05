<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationStoreRequest;
use App\Location;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::with(['teachers'])
            ->withCount('teachers')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);
        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        $allTeachers = Teacher::orderBy('name', 'asc')->get();
        return view('locations.create', compact('allTeachers'));
    }

    public function store(LocationStoreRequest $request)
    {
        $notifications = [];
        $hasAddedTeachers = false;
        $redirectTo = 'teachers.create';
        $location = new Location();
        $location->name = request('name');

        if ($request->file('from_file') && $request->file('from_file')->isValid()) {
            $teachersFile = fopen($request->file('from_file'), 'r');
            while (!feof($teachersFile)) {
                $teacherData = fgetcsv($teachersFile, 255, ';');
                $teacherData = array_combine(['name', 'email'], $teacherData);

                if (preg_match("#^nom|name$#i", trim($teacherData['name'])) ||
                    preg_match("#^e?-?mail$#i", trim($teacherData['email']))) {
                    // Pass if it is the indication row
                    continue;
                }

                $validator = Validator::make($teacherData, [
                    'name' => 'required|string|min:2',
                    'email' => 'required|email:rfc',
                    'token' => 'nullable|alpha-num|size:16',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors(['from_file' => 'Le contenu du fichier fourni n\'est pas valide'])
                        ->withInput();
                }

                $location->save();
                $now = new \DateTime();
                $token = Str::random(5) . '' . substr($now->getTimestamp(), -7) . '' . Str::random(4);

                if (request('when_conflict') === 'keep_file_data') {
                    if (is_null($teacher = Teacher::where(['email' => trim($teacherData['email'])])
                        ->first())) {
                        $location->teachers()->create([
                            'email' => trim($teacherData['email']),
                            'name' => trim($teacherData['name']),
                            'token' => $token
                        ]);
                    } else {
                        $teacher->name = trim($teacherData['name']);
                        $teacher->save();
                        $teacher->locations()->syncWithoutDetaching($location->id);
                    }
                } else {
                    if (is_null($teacher = Teacher::where(['email' => trim($teacherData['email'])])
                        ->first())) {
                        $location->teachers()->create([
                            'email' => trim($teacherData['email']),
                            'name' => trim($teacherData['name']),
                            'token' => $token
                        ]);
                    } else {
                        $teacher->locations()->syncWithoutDetaching($location->id);
                    }
                }
            }
            fclose($teachersFile);
            $hasAddedTeachers = true;
            $notifications[] = 'Le fichier CSV a bien été importé';
        } else {
            $location->save();
        }

        Teacher::all()->each(function ($teacher) use ($request, $location, &$hasAddedTeachers) {
            if ($request->has('teacher' . $teacher->id)) {
                $teacher->locations()->syncWithoutDetaching($location->id);
                $hasAddedTeachers = true;
            }
        });

        if ($hasAddedTeachers) {
            array_unshift($notifications,
                'Les professeurs sélectionnés ont été ajoutés à l\'implantation ' . $location->name,
                'Vous pouvez maintenant lui planifier une session d\'examens'
            );
            $redirectTo = 'exam_sessions.create';
        } else {
            $notifications[] = 'Vous pouvez maintenant créer un professeur';
        }

        array_unshift($notifications, 'L\'implantation a été enregistrée');

        Session::flash('notifications', $notifications);
        return redirect()->route($redirectTo);
    }

    public function show(Location $location)
    {
        $location->load([
            'teachers' => function ($query) {
                $query->orderBy('name', 'asc');
            },
        ]);
        return view('locations.show', compact('location'));
    }

    public function edit(Location $location)
    {
        $location->load('teachers');
        $allTeachers = Teacher::orderBy('name', 'asc')->get();
        return view('locations.edit', compact('location', 'allTeachers'));
    }

    public function update(LocationStoreRequest $request, Location $location)
    {
        $notifications = [];
        $location->name = request('name');
        $location->teachers()->detach();
        if ($request->file('from_file') && $request->file('from_file')->isValid()) {
            $teachersFile = fopen($request->file('from_file'), 'r');
            while (!feof($teachersFile)) {
                $teacherData = fgetcsv($teachersFile, 255, ';');
                $teacherData = array_combine(['name', 'email'], $teacherData);

                if (preg_match("#^nom|name$#i", trim($teacherData['name'])) ||
                    preg_match("#^e?-?mail$#i", trim($teacherData['email']))) {
                    // Pass if it is the indication row
                    continue;
                }

                $validator = Validator::make($teacherData, [
                    'name' => 'required|string|min:2',
                    'email' => 'required|email:rfc',
                    'token' => 'nullable|alpha-num|size:16',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors(['from_file' => 'Le contenu du fichier fourni n\'est pas valide'])
                        ->withInput();
                }

                $location->save();
                $now = new \DateTime();
                $token = Str::random(5) . '' . substr($now->getTimestamp(), -7) . '' . Str::random(4);

                if (request('when_conflict') === 'keep_file_data') {
                    if (is_null($teacher = Teacher::where(['email' => trim($teacherData['email'])])
                        ->first())) {
                        $location->teachers()->create([
                            'email' => trim($teacherData['email']),
                            'name' => trim($teacherData['name']),
                            'token' => $token
                        ]);
                    } else {
                        $teacher->name = trim($teacherData['name']);
                        $teacher->save();
                        $teacher->locations()->syncWithoutDetaching($location->id);
                    }
                } else {
                    if (is_null($teacher = Teacher::where(['email' => trim($teacherData['email'])])
                        ->first())) {
                        $location->teachers()->create([
                            'email' => trim($teacherData['email']),
                            'name' => trim($teacherData['name']),
                            'token' => $token
                        ]);
                    } else {
                        $teacher->locations()->syncWithoutDetaching($location->id);
                    }
                }
            }
            fclose($teachersFile);
            $notifications[] = 'Le fichier CSV a bien été importé';
        } else {
            $location->save();
        }

        Teacher::all()->each(function ($teacher) use ($request, $location) {
            if ($request->has('teacher' . $teacher->id)) {
                $teacher->locations()->syncWithoutDetaching($location->id);
            }
        });

        array_unshift($notifications, 'L\'implantation a bien été modifiée');

        Session::flash('notifications', $notifications);
        return redirect()->route('locations.show', ['location' => $location->id]);
    }

    public function destroy(Location $location)
    {
        $title = $location->name;
        $location->delete();
        Session::flash('notifications', ['L\'implantation "' . $title . '" a été définitivement supprimée']);
        return redirect()->route('locations.index');
    }
}

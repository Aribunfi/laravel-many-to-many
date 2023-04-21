<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(8);
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $project = new Project;
        $categories = Category::all();
        return view('admin.projects.form', compact('project', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validation($request->all());
    $project = new Project;
    $project->fill($data);
    $project->save();
    return redirect()->route('projects.show', $project);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $categories = Category::all();

        return view('admin.projects.form', compact('project', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $data = $this->validation($request->all(), $project->id);
    $project->update($data);
    return redirect()->route('projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $id_project = $project->id;
        $project->delete();
        return redirect()->route('projects.index');
    } 

    private function validation($data) {
        $validator = Validator::make(
          $data
          [
            'title' => 'required|string|max:20',
            'year' => 'required|integer|between:2009,2023',
            'kind' => 'required|string|in:graphic,web,writing',
            'time' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',

          ],
          [
            'title.required' => 'Il titolo è obbligatorio',
            'title.string' => 'Il titolo deve essere una stringa',
            'title.max' => 'Il titolo deve massimo di 20 caratteri',
      
            'year.required' => 'Anno è obbligatorio',
            'year.integer' => 'Anno deve essere un numero',
            'year.unique' => 'Anno deve essere unico',
            'year.between' => 'Il numero deve essere compreso tra 2009:min e 2023:max',
      
            'kind.required' => 'Kind è obbligatorio',
            'kind.string' => 'Kind deve essere una stringa',
            'kind.in' => 'Kind deve essere un valore compreso tra "graphic", "web", "writing"',
            
            'time.required' => 'Time è obbligatorio',
            'time.integer' => 'Time deve essere un numero',
            
            // 'img.string' => 'L\'immagine deve essere una stringa',
            
            'description.string' => 'La descrizione deve essere una stringa',

            'image.image' => 'Il file caricato deve essere un\'immagine',
            'image.mimes' => 'Le estensioni accettate per l\'immagine sono jpg, png, jpeg',
          ]);

          $data = $request->all();

            if(Arr::exists($data, 'image')) {
                $path = Storage::put('uploads/projects', $data['image']);
                $data['image'] = $path;
            }  

            $project = new Project;
            $project->fill($data);
            $project->slug = Project::generateUniqueSlug($project->title);

            $project->save();

            return to_route('admin.projects.show', $project)

        
      }
}


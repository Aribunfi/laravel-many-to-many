<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controlelrs\Controller;
use App\Mail\PublishedProjectMail;

use App\Models\Project;
use App\Models\Category;
use App\Models\Tag;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
    $project->slug = Project::generateUniqueSlug($project->title);
    $project->save();

        if(Arr::exists($data, "tags")) $project->tags()->attach($data["tags"]);

        $mail = new PublishedProjectMail();

        $user_email = Auth::user()->email;
        Mail::to($user_email)->send();

    return to_route()('admin.projects.show', $project)
    ->with('message_content', "Project $project->id creato con successo");
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
        $request->validate([
            'title' => 'required|string|max:20',
            'year' => 'required|integer|between:2009,2023',
            'kind' => 'required|string|in:graphic,web,writing',
            'time' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
            'is_published' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id',

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


        'category_id.exists' => 'L\'id della categoria non è valido',
        'tags_exists' => 'I tags selezionati non sono validi',
        ]);

        $data = $request->all();
        $data["slug"] = Project::generateUniqueSlug($data["title"]);
        $data["is_published"] = $request->has("is_published") ? 1: 0;

        if(Arr::exists($data, 'image')) {
            if($project->image) Storage::delete($project->image);
            $path = Storage::put('uploads/projects', $data['image']);
            $data['image'] = $path;
        }
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

        return to route('admin.projects.index')
        ->with('message_type', "danger")
        ->with('message_content', "Progetto $id_project spostato nel cestino");
    } 

  public function trash(Request $request) {
    $sort = (!empty($sort_request = $request->get('sort'))) ? $sort_request : "updated_at";
    $order = (!empty($order_request = $request->get('order'))) ? $order_request : "DESC";

    $projects = Project::onlyTrashed()->orderBy($sort, $order)->paginate(10)->withQueryString();
    return view('admin.projects.trash', compact('projects', 'sort', 'order'));
  }

//   public function forceDelete(Int $id){
//     $project = Project::where('id')
//   }

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


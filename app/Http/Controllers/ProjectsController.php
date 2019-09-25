<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{

    /**
     * ProjectsController constructor.
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        $projects=auth()->user()->projects;
        return view('projects.index',compact('projects'));
    }

    public function show(Project $project)
    {

        if(auth()->user()->isNot($project->owner)) {
            abort(403);
        }
        return view('projects.show',compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }
    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function Store()
    {

           $project=auth()->user()->projects()->create($this->rules());

        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit' ,compact('project'));
    }
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //policie
//        $this->authorize('update',$project);

//        $project->update($request->validated());
        $request->save();
        return redirect($project->path());
    }

    //method 1
    protected function rules()
    {
        return request()->validate([
            'title'=>'sometimes|required',
            'description'=>'sometimes|required',
            'notes'=>'nullable'
        ]);

    }
}

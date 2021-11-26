<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vulnerability\CreateRequest;
use App\Http\Requests\Vulnerability\DestroyRequest;
use App\Http\Requests\Vulnerability\EditRequest;
use App\Http\Requests\Vulnerability\IndexRequest;
use App\Http\Requests\Vulnerability\ShowRequest;
use App\Http\Requests\Vulnerability\StoreRequest;
use App\Http\Requests\Vulnerability\UpdateRequest;
use App\Models\Vulnerability;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VulnerabilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(IndexRequest $request) : View
    {
        $vulnerabilities = Vulnerability
            ::query()
            ->paginate(5);


        return view('vulnerabilities.index')
            ->with([
                'vulnerabilities' => $vulnerabilities,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(CreateRequest $request) : View
    {
        return view('vulnerabilities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request) : RedirectResponse
    {
        $vulnerability = Vulnerability
            ::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
            ]);

        return redirect('/vulnerabilities/' . $vulnerability->id)
            ->with('status', __('Vulnerability created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param ShowRequest $request
     * @param Vulnerability $vulnerability
     * @return Application|Factory|View
     */
    public function show(ShowRequest $request, Vulnerability $vulnerability) : View
    {
        return view('vulnerabilities.show')->with([
            'vulnerability' => $vulnerability,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EditRequest $request
     * @param Vulnerability $vulnerability
     * @return Application|Factory|View
     */
    public function edit(EditRequest $request, Vulnerability $vulnerability) : View
    {
        return view('vulnerabilities.edit')->with([
            'vulnerability' => $vulnerability,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Vulnerability $vulnerability
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Vulnerability $vulnerability) : RedirectResponse
    {
        $vulnerability->update([
            'title' => $request->has('title') ? $request->input('title') : $vulnerability->title,
            'description' => $request->has('description') ? $request->input('description') : $vulnerability->description,
        ]);

        return redirect('/vulnerabilities/' . $vulnerability->id)
            ->with('status', __('Vulnerability updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRequest $request
     * @param Vulnerability $vulnerability
     * @return RedirectResponse
     */
    public function destroy(DestroyRequest $request, Vulnerability $vulnerability) : RedirectResponse
    {
        $vulnerability->delete();

        return redirect('/vulnerabilities')
            ->with('status', __('Vulnerability deleted successfully.'));

    }
}

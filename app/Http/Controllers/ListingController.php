<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //get
    public function index() {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(4),
        ]);
    }

    //get by id
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    //show create form
    public function create(){
        return view('listings.create');
    }

    //store create form
    public function store(Request $request){
        $formFields = $request->validate([
            'title'=> 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
            ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);
        return redirect('/')->with('message', 'Listing created Successfully!');
    }

    public function edit(Listing $listing){
        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Request $request, Listing $listing){

        if($listing->user_id != auth()->id())
        {
            abprt(403, 'Unaothorized');
        }

        $formFields = $request->validate([
            'title'=> 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
            ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        };

        $listing->update($formFields);

        return back()->with('message', 'Listing updated Successfully!');
    }

    public function destroy(Listing $listing) {
        $listing-> delete();
        return redirect('/')->with('message', 'Listing Deleted Successfully');
    }

    public function manage(Listing $listing){
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}

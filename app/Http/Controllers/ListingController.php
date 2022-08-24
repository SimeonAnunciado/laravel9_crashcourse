<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    //

    public function __construct()
    {
      
    }

    public function index(){
        $data = [
            'heading' => 'Latest Listings',
            'listings' => Listing::latest()->filter(request(['tag','search']))->paginate(5)
        ];
        return view('listings.index' , $data);
    }

    public function show(Listing $listing){

        return view('listings.show', [
            'listing' =>  $listing 
        ]);

    }

    public function create(){
        return view('listings.create');
    }

    public function store(Request $request){

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required',Rule::unique('listings','company')],
            'location' => 'required',
            'email' => ['required','email'],
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required',
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

        $formFields['user_id'] = auth()->id();
        Listing::create($formFields);
        return redirect('/')->with('message','Listing created successfully');
    }

    public function edit(Listing $listing){
        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Request $request,Listing $listing){

        if($listing->user_id != auth()->id()){
            abort(403,'UnAuthorized Action');
        }
        

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'email' => ['required','email'],
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required',
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

        $listing->update($formFields);
        return back()->with('message','Listing update successfully');
    }

    public function delete(Listing $listing){

        if($listing->user_id != auth()->id()){
            abort(403,'UnAuthorized Action');
        }

        $listing->delete();
        return redirect('/')->with('message','Listing Delete successfully');


    }

    public function manage(){
        return view('listings.manage',['listings' => auth()->user()->listings()->get() ]);
    }
}

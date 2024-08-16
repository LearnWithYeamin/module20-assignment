<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Exception;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::query();

        // Search functionality
        if ($request->has('search')) {
            $contacts->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        // Sorting functionality
        if ($request->has('sort')) {
            $contacts->orderBy($request->sort, $request->get('direction', 'asc'));
        } else {
            $contacts->orderBy('created_at', 'desc');
        }

        $contacts = $contacts->paginate(10);

        return view('contacts.index', compact('contacts'));
    }


    public function create()
    {
        return view('contacts.create');
    }


    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contacts,email',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        try {
            Contact::create($validated);
            return redirect()->route('contacts.index')->with('success', 'Contact created successfully!');
        } catch (Exception $e) {
        
            return redirect()->back()->withErrors('An error occurred while creating the contact.')->withInput();
        }
    }
    

    public function show(Contact $contact)
    {
        return view('contacts.show', compact('contact'));
    }


    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }


    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:contacts,email,' . $contact->id,
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);

        $contact->update($request->all());

        return redirect()->route('contacts.index')
            ->with('success', 'Contact updated successfully.');
    }


    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }
}

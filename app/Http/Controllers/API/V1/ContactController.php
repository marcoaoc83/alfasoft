<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Contact\ContactRequest;
use App\Models\Contact;


class ContactController extends BaseController
{

    protected $contact = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->middleware('auth:api');
        $this->contact = $contact;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = $this->contact->latest()->paginate(10);

        return $this->sendResponse($contacts, 'Contact list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Contact\ContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        $contact = $this->contact->create($request->all());

        return $this->sendResponse($contact, 'Contact Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = $this->contact->findOrFail($id);

        return $this->sendResponse($contact, 'Contact Details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, $id)
    {
        $contact = $this->contact->findOrFail($id);

        $contact->update($request->all());

        return $this->sendResponse($contact, 'Contact Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $contact = $this->contact->findOrFail($id)->delete();

        return $this->sendResponse($contact, 'Contact has been Deleted');
    }


}

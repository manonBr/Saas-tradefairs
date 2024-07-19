<?php

namespace App\Http\Controllers;

use App\Exceptions\WithArgumentException;

use App\Services\ContactService;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;


class ContactController extends Controller
{

    public function __construct(
        private ContactService $contacts
    ) {
        $this->contacts = $contacts;
    }

    public function render() {
        return view('contact');
    }

    public function add(ContactRequest $request) {
        $contact = prevent_injection($_POST);

        try {
            $filename = $this->contacts->store($contact);

            return redirect()->route('form-validation')->with(['filename' => $filename, 'route' => 'contacts', 'file' => 'csv']);
        } catch (\WithArgumentException $e) {
            $error = $e->getMessage();
            $filename = $e->getAdditionnalInfo();


            return redirect()->route('form-error')->with(['error' => $error, 'filename' => $filename, 'route' => 'contacts', 'file' => 'csv']);
        }

    }

    public function delete(int $id) {
        try{
            $this->contacts->delete($id);
            return redirect()->route('contacts')->with(['success' => 'Contact supprimé']);
        } catch(\Exception $e) {
            return redirect()->route('contacts')->with(['error' => $e->getMessage()]);
        }
    }

}

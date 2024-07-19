<?php

namespace App\Http\Controllers;

use App\Services\CreateCsvFileService;
use App\Services\ContactService;

use App\Models\Contact;

class ContactsController extends Controller
{

    public function __construct(
        private ContactService $contactService,
        private CreateCsvFileService $createCsvFile
    ) {
        $this->contactService = $contactService;
        $this->createCsvFile = $createCsvFile;
    }

    public function render() {

        $contacts = $this->contactService->findAll();

        return view('contacts', ['contacts' => $contacts]);
    }

    public function download() {
        $delimiter = ';';
        $filename = 'Export-contacts';
        $path = 'php://output';
        $headerTags = ['ID','Code du collaborateur','Nouveau client ?','Code de la famille de comptes', 'Nom', 'SIRET', 'Numéro de TVA intracommunautaire', 'Civilité (contact) (facturation)', 'Nom (contact) (facturation)', 'Prénom (facturation)', 'Fonction (facturation)', 'Téléphone portable (facturation)', 'Téléphone fixe (facturation)', 'E-mail (facturation)', 'Adresse 1 (facturation)', 'Adresse 2 (facturation)','Code postal (facturation)', 'Ville (facturation)', 'Code Pays (facturation)', 'Notes en texte brut'];
        
        $arrayKeys = ['collaborator','newContact','famille','company', 'siret', 'tva', 'gender','lastname','firstname','function','mobile','phone','email','adress','adressBis','zipcode','city','country','notes'];
        $contacts = databaseToArray(
            $this->contactService->findAll(), 
            $arrayKeys
        );

        $this->createCsvFile->execute($contacts, $filename, $path, $headerTags);
        
        exit;
    }

    public function delete() {

        $response = $this->contactService->deleteAll();
        
        return redirect()->route('contacts')->with(['response' => $response]);
        
    }

}

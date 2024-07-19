<?php

namespace App\Services;

use App\Exceptions\WithArgumentException;

use App\Services\CreateCsvFileService;
use App\Services\DeleteDataService;
use App\Services\FileService;

use App\Models\Contact;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
 
class ContactService {

    public function __construct(
        private CreateCsvFileService $createCsvFile,
        private DeleteDataService $deleteData,
        private FileService $files
    ) {
        $this->createCsvFile = $createCsvFile;
        $this->deleteData = $deleteData;
        $this->files = $files;
    }

    public function find(int $id): Contact {

        return Contact::where('id', $id)->first();

    }

    public function findAll(bool $returnArray = false, array $arrayArguments = []): Collection|array {

        $data = Contact::all();

        if($returnArray){
            $contacts = databaseToArray($data,$arrayArguments);

            return $contacts;
        }

        return $data;

    }

    public function store(array $datas):string {

        $csvDatas['filename'] = str_replace(' ', '_', $datas['company']).'-'.$datas['lastname'].'-'.time().$datas['_token'];
        $csvDatas['path'] = '../storage/app/public/csv/contacts/'.$csvDatas['filename'].'.csv';
        $csvDatas['headerTags'] = ['Code du collaborateur','Code de la famille de comptes', 'Civilité (contact) (facturation)', 'Nom (contact) (facturation)', 'Prénom (facturation)', 'Nom', 'Fonction (facturation)', 'SIRET', 'Numéro de TVA intracommunautaire', 'Téléphone portable (facturation)', 'E-mail (facturation)', 'Téléphone fixe (facturation)', 'Adresse 1 (facturation)', 'Adresse 2 (facturation)','Code postal (facturation)', 'Ville (facturation)', 'Code Pays (facturation)', 'Notes en texte brut', 'Nouveau client ?'];
        
        $datas['csvToken'] = $csvDatas['filename'];
        unset($datas['_token']);
        $this->createCsvFile->execute((array_fill(0, 1, $datas)), $csvDatas['filename'], $csvDatas['path'], $csvDatas['headerTags']);
        
        try {
            $contact = new Contact($datas);
            $contact->save();
            
            return $csvDatas['filename'];
        } catch (\WithArgumentException $e) {
            throw new \WithArgumentException($e->getMessage, $filename);
        }
        
    }

    public function delete(int $id) {

        $contact = $this->find($id);  

        try {
            $this->deleteData->execute($this, $id);
            $this->files->delete('csv', 'contacts', $contact->csvToken);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        } 

    }

    public function deleteAll() {

        $response = false;

        if(DB::table('contacts')->delete()) {
            $response = 'true';
        }
        $this->files->deleteAll('csv/contacts');

        return $response;

    }

}
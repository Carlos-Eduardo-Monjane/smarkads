<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Contacts;

class ContatoController extends Controller
{

    private $contact;

    public function __construct(Contacts $contact){
        $this->contact = $contact;
    }

    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:70|min:3',
            'lastname' => 'required|max:70|min:2',
            'email' => 'required|email',
            'subject' => 'required|max:300|min:10',
            'message' => 'required|max:5000|min:5',
        ]);

        if (!$validator->fails()) {

            $collection = $this->contact->create([
                'name' => $request->name,
                'lastname' =>  $request->lastname,
                'email' =>  $request->email,
                'telefone' => $request->telefone,
                'subject' => $request->subject,
                'message' => $request->message
            ]);

            if($collection){
                return response()->json(['success' => 200, 'errors' => []]);
            }

        }else{
            return response()->json(['success' => 500, 'errors' => $validator->errors()]);
        }
    }
}

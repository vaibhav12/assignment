<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\ContactRelation;
use Illuminate\Support\Facades\Validator; //for valication
use DB;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cruds = Contact::paginate(10);
        
        return view('contact.index', compact('cruds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contact.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|max:255|regex:/^[a-zA-Z]{2,40}(?: +[a-zA-Z]{2,40})+$/',
            'email' => 'required | email',
			'contact_number' => 'required|unique:contacts|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $contact = new Contact([
          'full_name' => $request->get('full_name'),
          'email' => $request->get('email'),
		  'contact_number' => $request->get('contact_number'),
        ]);

        $contact->save();
        return redirect('/contact');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $crud = Contact::find($id);
        $arr[] = $id;
        //$searchRelation = ContactRelation::select('group_concat(relation_contact_id)')->where('contact_id', $id)->get();
        $searchRelation = DB::table('contact_relations')
        ->select(DB::raw("GROUP_CONCAT(relation_contact_id) as `ids`"))
        ->where('contact_id', $id)
        ->first();
        $relationIds = explode(",",$searchRelation->ids);
        $arr = array_merge($relationIds,$arr);
		
        $searchRelationReverse = DB::table('contact_relations')
        ->select(DB::raw("GROUP_CONCAT(contact_id) as `ids`"))
        ->where('relation_contact_id', $id)
        ->first();		
        $relationIdsReverse = explode(",",$searchRelationReverse->ids);

        $arr = array_merge($relationIdsReverse,$arr);

        $results = Contact::select('id','full_name')->whereNotIn('id', $arr)->get();

        return view('contact.edit', compact('crud','id','results'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|max:255|regex:/^[a-zA-Z]{2,40}(?: +[a-zA-Z]{2,40})+$/',
            'email' => 'required | email',
			'contact_number' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $crud = Contact::find($id);
        $crud->full_name = $request->get('full_name');
        $crud->email = $request->get('email');
        $crud->contact_number = $request->get('contact_number');
        $crud->save();
		
        if(count($request->get('relation_id')) > 0){
            foreach($request->get('relation_id') as $value){
                $saveRelation = new ContactRelation([
                  'contact_id' => $id,
                  'relation_contact_id' => $value,
                ]);

                $saveRelation->save();
            }
        }
        return redirect('/contact');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $crud = Contact::find($id);
      $crud->delete();

      return redirect('/contact');
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        $data= file_get_contents('https://uinames.com/api/?ext&amount=10&region=india');
        $data = json_decode($data);

        foreach($data as $listing){
            $phone = '+'.str_replace(['+','(',')',' ','-'],['','','','',''],$listing->phone);					
            $contact = new Contact([
                      'full_name' => $listing->name." ".$listing->surname,
                      'email' => $listing->email,
                      'contact_number' => $phone,
                    ]);

            $contact->save();					 
        }
        return redirect('/contact');
    }
    /**
     * Burn down chart
     */
    public function burndown(){
        $results = Contact::select('id','contact_number')->distinct()
                ->orderBy('id','asc')->get();
        $result = $results->toArray();
        $aResult = array_column($result, 'contact_number');
        $aResult = json_encode($aResult);
        
        DB::select(DB::raw("set SESSION sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE"
                . ",NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'"));
        $crud = Contact::select(DB::raw("COUNT(contact_relations.id) as count_click"))
        ->leftJoin('contact_relations', 'contact_relations.contact_id', '=', 'contacts.id');
        $crud->groupBy('contacts.contact_number');
        $aCount = $crud->orderBy('contacts.id','asc')->get()->toArray();
        $aCount1 = array_column($aCount, 'count_click');
        $aCount = json_encode($aCount1);
        return view('contact.burndown', compact('aResult','aCount'));
    }
}

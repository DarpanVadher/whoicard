<?php

namespace Modules\Customer\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Modules\Customer\Entities\customer;
use Modules\Customer\Entities\customer_documents;
use Modules\Customer\Entities\Inquery;
use Modules\SiteSetting\Entities\ProfileTemplate;
use Illuminate\Support\Facades\Mail;
use App\Mail\inqueryMail;
use App\Mail\exchangeContactMail;
use JeroenDesloovere\VCard\VCard;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {


        $qrIdentifier = request()->query('id');
        $getQrCodeData = customer::where('identifier', $qrIdentifier)->first();

        // print_r($getQrCodeData);

        if (!empty($getQrCodeData)) {

            return redirect()->route('customer.view', ['username' => $getQrCodeData->customUrl]);
        }


        $getProfileTemplate = ProfileTemplate::all();

        // print_r($getProfileTemplate);

        return view('customer::index', ['qrIdentifier' => $qrIdentifier, 'profileTemplate' => $getProfileTemplate]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('customer::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        $customer = new customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->contactNumber = $request->number;
        $customer->profile = $request->number;
        $customer->image = $request->profileImage;
        $customer->customUrl     = $request->username;
        $customer->editCode = $request->password;
        $customer->personalData = $request->info;
        // $customer->documents = $request->documents;

        // Image Upload
        if ($request->hasFile('profileImage')) {
            $image = $request->file('profileImage');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = '/customer/' . $customer->customUrl;

            if (!Storage::exists($imagePath)) {
                Storage::makeDirectory($imagePath, 0775, true); //creates directory
            }

            Storage::disk('public')->put($imagePath . '/' . $imageName, file_get_contents($image));
            $customer->image = $imageName;
            $customer->profile = $imageName;
        }



        $customer->identifier = $request->indentifier;
        $customer->viewCount = 1;

        $customer->save();

        $cutomerDocuments = [];

        //Document multiple Upload
        if ($request->hasFile('documents')) {

            $documents = $request->documents;



            foreach ($documents  as $document) {

                print_r($document);

                $image = $document;
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = '/customer/' . $customer->customUrl . '/documents';

                if (!Storage::exists($imagePath)) {
                    Storage::makeDirectory($imagePath, 0775, true); //creates directory
                }

                Storage::disk('public')->put($imagePath . '/' . $imageName, file_get_contents($image));
                $cutomerDocuments[] = ['fileName' => $imageName, 'fileUrl' => $imagePath . '/' . $imageName, 'fileType' => $image->getClientOriginalExtension(), 'fileSize' => $image->getSize(), 'customerId' => $customer->id];
            }
        }

        print_r($cutomerDocuments);



        // Create books associated with the author
        $customer->customer_documents()->createMany($cutomerDocuments);





        return redirect()->route('customer.view', ['username' => $customer->customUrl]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $customerData = customer::where('customUrl', $id)->first();
        $customerDocumentData = customer_documents::where('customer_id', $customerData->id)->get();
        $customerData->viewCount = $customerData->viewCount + 1;
        $customerData->save();


        return view('customer::view', ['customerData' => $customerData, 'customerDocumentData' => $customerDocumentData]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $customerData = customer::where('customUrl', $id)->first();

        $getProfileTemplate = ProfileTemplate::all();

        return view('customer::edit', ['customerData' => $customerData, 'profileTemplate' => $getProfileTemplate]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        //
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'number' => 'required|numeric|min:10',
            // 'username' => 'required|string|unique:customers,customUrl,id',
            'username' => 'required', 'email', Rule::unique('customers')->ignore($request->id),
            'password' => 'required|string',
            'info' => 'required|string',

        ]);


        $customerId = $request->id;

        $customer = customer::where('id', $customerId)->first();



        if ($customer->editCode != $request->password) {


            return Redirect::back()->withErrors(['password' => 'Incorrect Password']);
        }





        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->contactNumber = $request->number;
        // $customer->profile = $request->number;
        // $customer->image = $request->profileImage === null ? $customer->image : $request->profileImage;
        $customer->customUrl     = $request->username;
        $customer->editCode = $request->password;
        $customer->personalData = $request->info;
        // $customer->documents = $request->documents;


        print_r($request->file('profileImage'));
        print_r($request->hasFile('profileImage'));

        // Image Upload
        if ($request->hasFile('profileImage')) {




            $image = $request->file('profileImage');

            print_r($image);
            print_r($image->getClientOriginalExtension());
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'customer/' . $customer->customUrl;



            if (!Storage::exists($imagePath)) {
                Storage::makeDirectory($imagePath, 0775, true); //creates directory
            }
            print_r($imagePath);

            $filename = $imagePath . '/' . $imageName;
            Storage::disk('public')->put($filename, file_get_contents($image));
            $customer->image = $imageName;
            $customer->profile = $imageName;
        }

        $customer->save();


        $cutomerDocuments = [];

        //Document multiple Upload
        if ($request->hasFile('documents')) {

            $documents = $request->documents;



            foreach ($documents  as $document) {

                print_r($document);

                $image = $document;
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = '/customer/' . $customer->customUrl . '/documents';

                if (!Storage::exists($imagePath)) {
                    Storage::makeDirectory($imagePath, 0775, true); //creates directory
                }

                Storage::disk('public')->put($imagePath . '/' . $imageName, file_get_contents($image));
                $cutomerDocuments[] = ['fileName' => $imageName, 'fileUrl' => $imagePath . '/' . $imageName, 'fileType' => $image->getClientOriginalExtension(), 'fileSize' => $image->getSize(), 'customerId' => $customerId];
            }
        }



        // Create books associated with the author
        $customer->customer_documents()->createMany($cutomerDocuments);



        return redirect()->route('customer.view', ['username' => $customer->customUrl]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }


    /* Send Inquery Mail */

    public function sendInqueryMail(Request $request)
    {


        $inquery = new Inquery();
        $inquery->name = $request->inqueryName;
        $inquery->email = $request->inqueryEmail;
        $inquery->number = $request->inqueryContactNumber;
        $inquery->subject = $request->inquerySubject;
        $inquery->message = $request->inqueryMessage;
        $inquery->type = 'Inquery';

        $inquery->save();

        if ($inquery) {
            $mailData = [
                'name' => $request->inqueryName,
                'email' => $request->inqueryEmail,
                'number' => $request->inqueryContactNumber,
                'subject' => $request->inquerySubject,
                'message' => $request->inqueryMessage,
            ];

            Mail::to($request->customerEmail)->send(new inqueryMail($mailData));

            return redirect()->route('customer.view', ['username' => $request->customUrl]);
        }
    }

    /* Send Exchange Contact Mail */

    public function sendexchangeContactMail(Request $request)
    {

        $inquery = new Inquery();
        $inquery->name = $request->inqueryName;
        $inquery->email = $request->inqueryEmail;
        $inquery->number = $request->inqueryContactNumber;
        $inquery->subject = $request->inquerySubject;
        $inquery->message = $request->inqueryMessage;
        $inquery->type = 'ExchangeContact';

        $inquery->save();

        if ($inquery) {
            $mailData = [
                'name' => $request->inqueryName,
                'email' => $request->inqueryEmail,
                'number' => $request->inqueryContactNumber,
                'subject' => $request->inquerySubject,
                'message' => $request->inqueryMessage,
            ];

            Mail::to($request->customerEmail)->send(new exchangeContactMail($mailData));

            return redirect()->route('customer.view', ['username' => $request->customUrl]);
        }
        $mailData = [
            'name' => $request->inqueryName,
            'email' => $request->inqueryEmail,
            'number' => $request->inqueryContactNumber,
            'subject' => $request->inquerySubject,
            'message' => $request->inqueryMessage,
        ];
    }


    public function downloadVcard($id)
    {

        $customerData = customer::where('customUrl', $id)->first();

        // dd($customerData);

        // define vcard
        $vcard = new VCard();

        // define variables
        $firstname = $customerData->name;
        $lastname = '';
        $additional = '';
        $prefix = '';
        $suffix = '';

        // add personal data
        $vcard->addName($lastname, $firstname, $additional, $prefix, $suffix);

        // add work data
        // $vcard->addCompany('Siesqo');
        // $vcard->addJobtitle('Web Developer');
        $vcard->addEmail($customerData->email);
        $vcard->addPhoneNumber($customerData->contactNumber, 'WORK');
        // $vcard->addURL('http://www.jeroendesloovere.be');
        // $vcard->addLabel('street, worktown, workpostcode Belgium', 'work');

        $vcard->addPhoto(asset('storage/customer/' . $customerData->customUrl . '/' . $customerData->image));
        //$vcard->addPhoto('https://raw.githubusercontent.com/jeroendesloovere/vcard/master/tests/image.jpg');

        // return vcard as a string
        //return $vcard->getOutput();

        // return vcard as a download
        // return $vcard->download();
        $content = $vcard->getOutput();

        $response = new Response();
        $response->setContent($content);
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/x-vcard');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $firstname . '.vcf"');
        $response->headers->set('Content-Length', mb_strlen($content, 'utf-8'));

        return $response;
    }


    public function adminCutomerList()
    {
        return view('customer::list');
    }

    public function getCustomersList(Request $request)
    {
        // Page Length
        $pageNumber = ($request->start / $request->length) + 1;
        $pageLength = $request->length;
        $skip       = ($pageNumber - 1) * $pageLength;

        // Page Order
        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'desc';

        // get data from products table
        $query = DB::table('customers')->select('*');

        // $query =   $query->leftJoin('customer_documents','customer_documents.customer_id', '=','customers.id');
        $query =   $query->leftJoin('qrs', 'qrs.identifier', '=', 'customers.identifier');


        // Search
        $search = $request->search;
        $query = $query->where(function ($query) use ($search) {
            $query->orWhere('name', 'like', "%" . $search . "%");
            $query->orWhere('email', 'like', "%" . $search . "%");
            $query->orWhere('contactNumber', 'like', "%" . $search . "%");
        });

        $orderByName = 'id';
        switch ($orderColumnIndex) {
            case '0':
                $orderByName = 'name';
                break;
            case '1':
                $orderByName = 'email';
                break;
            case '2':
                $orderByName = 'contactNumber';
                break;
        }
        // $query = $query->groupBy('id');


        // $query = $query->with('customer_documents');
        // $query = $query->with('qrs');

        $query = $query->orderBy($orderByName, $orderBy);
        $recordsFiltered = $recordsTotal = $query->count();
        $users = $query->skip($skip)->take($pageLength)->get();


        // $users = $users->map(function ($customer) {
        //     $documentsSubquery = DB::table('customer_documents')->select('*')->where('customer_id', $customer->id);



        //     print_r($documentsSubquery);
        //     // $customer->order_count = $ordersData ? $ordersData->order_count : 0;
        //     return $customer;
        // });

        return response()->json(["draw" => $request->draw, "recordsTotal" => $recordsTotal, "recordsFiltered" => $recordsFiltered, 'data' => $users], 200);
    }
}

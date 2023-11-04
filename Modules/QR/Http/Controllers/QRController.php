<?php

namespace Modules\QR\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\QR\Entities\Qr;


function randomString($n)
{

    $generated_string = "";

    $domain = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

    $len = strlen($domain);

    // Loop to create random string
    for ($i = 0; $i < $n; $i++) {
        // Generate a random index to pick characters
        $index = rand(0, $len - 1);

        // Concatenating the character
        // in resultant string
        $generated_string = $generated_string . $domain[$index];
    }

    return $generated_string;
}




class QRController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $allQrData = qr::all()->toArray();

        // // If you need objects, you can create instances of your model from the array data
        // $allQrData = array_map(function ($allQrData) {
        //     return new qr($allQrData);
        // }, $allQrData);

        return view('qr::index', ['qrData' => $allQrData]);
    }



    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('qr::create');
    }


    public function getQrCodes(Request $request)
    {
        // Page Length
        $pageNumber = ($request->start / $request->length) + 1;
        $pageLength = $request->length;
        $skip       = ($pageNumber - 1) * $pageLength;

        // Page Order
        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'desc';

        // get data from products table
        $query = DB::table('qrs')->select('*');

        // Search
        $search = $request->search;
        $query = $query->where(function ($query) use ($search) {
            $query->orWhere('filename', 'like', "%" . $search . "%");
            $query->orWhere('identifier', 'like', "%" . $search . "%");
            $query->orWhere('qrcode', 'like', "%" . $search . "%");
        });

        $orderByName = 'id';
        switch ($orderColumnIndex) {
            case '0':
                $orderByName = 'id';
                break;
            case '1':
                $orderByName = 'filename';
                break;
            case '2':
                $orderByName = 'format';
                break;
        }
        $query = $query->orderBy($orderByName, $orderBy);
        $recordsFiltered = $recordsTotal = $query->count();
        $users = $query->skip($skip)->take($pageLength)->get();

        return response()->json(["draw" => $request->draw, "recordsTotal" => $recordsTotal, "recordsFiltered" => $recordsFiltered, 'data' => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {


        $validatedData = $request->validate([
            'foreground' => 'required|string',
            'background' => 'required|string',
            'level' => 'required|string',
            'size' => 'required|string',
            'format' => 'required|string',
            'noofqrcode' => 'required|integer',
        ]);

        for ($i = 0; $i < $request->noofqrcode; $i++) {
            # code...

            $identifier = randomString(rand(5, 8));
            $format = $request->format;
            $qrcode = $identifier . '.' . $format;
            $size = 100;
            $foreground = $request->foreground;
            $background = $request->background;
            $level = $request->level;

            $errorCorrectionLevel = 'L';
            if (isset($level) && in_array($level, array('L', 'M', 'Q', 'H')))
                $errorCorrectionLevel = $level;

            if (isset($request->size))
                $size = min(max((int)$request->size, 100), 1000);

            $foreground = substr($foreground, 1);                      // We eliminate the character "#" for the hexadecimal color
            $background = substr($background, 1);

            $READ_PATH = $_SERVER['HTTP_HOST'] . '/info?id=';
            $created_by = Auth::user()->id;
            $updated_by = Auth::user()->id;



            if (!Storage::exists('/savedQr')) {
                Storage::makeDirectory('/savedQr', 0775, true); //creates directory
            }


            $READ_PATH = 'https://api.qrserver.com/v1/create-qr-code/?data=';
            $url = $READ_PATH . $identifier . '&size=' . $size . 'x' . $size . '&ecc=' . $errorCorrectionLevel . '&margin=0&color=' . $foreground . '&bgcolor=' . $background . '&qzone=2' . '&format=' . $format;


            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);

            if ($response === false) {
                echo "cURL Error: " . curl_error($ch);
                return false;
            }

            //  $content = file_get_contents('https://api.qrserver.com/v1/create-qr-code/?data=' . $READ_PATH . $identifier . '&amp;&size=' . $size . 'x' . $size . '&ecc=' . $errorCorrectionLevel . '&margin=0&color=' . $foreground . '&bgcolor=' . $background . '&qzone=2' . '&format=' . $format);

            $filename = 'storage/savedQr/' . $qrcode;

            Storage::disk('public')->put($filename, $response);


            qr::create([
                'filename' => $identifier,
                'format' => $format,
                'identifier' => $identifier,
                'link' => $READ_PATH . $identifier,
                'qrcode' => $qrcode,
                'scan' => 0,
                'state' => 1,
                'created_by' => $created_by,
                'updated_by' => $updated_by
            ]);
        }


        // $allQrData = qr::all()->toArray();


        // print_r($allQrData);

        // If you need objects, you can create instances of your model from the array data
        // $allQrData = array_map(function ($allQrData) {
        //     return new qr($allQrData);
        // }, $allQrData);

        return redirect('admin/qr');
        // return view('qr::index',['qrData' => $allQrData]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('qr::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('qr::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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
}

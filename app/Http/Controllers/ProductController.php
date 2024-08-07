<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $product = Product::query();
            return DataTables::of($product)
            ->editColumn('image',function($each){
                
                    return '<img src="'.asset("storage/images/" . $each->image).'" class="img-thumbnail" width="100" height="100"/>';
                
            })
            ->addColumn('qrcode', function($each) {
                return '<img src="data:image/png;base64,' . $each->qrcode . '" class="img-thumbnail" width="100" height="100"/>';
            })
            
            ->addColumn('action',function($each){
                $edit_icon = '<a href="'.route('products.edit',$each->id).'" class="btn btn-outline-warning" style="margin-right:10px;"><i class="fas fa-user-edit"></i>&nbsp;Edit</a>';
                $detail_icon = '<a href="'.route('products.show',$each->id).'" class="btn btn-outline-info" style="margin-right:10px;"><i class="fas fa-info-circle"></i>&nbsp;Detail</a>';
                $export_qr = '<a href="'.route('image',$each->id).'" class="btn btn-outline-success" style="margin-right:10px;"><i class="fas fa-info-circle"></i>&nbsp;ExportQr</a>';
                $delete_icon = '<a href="" class="btn btn-outline-danger delete" data-id = "'.$each->id.'"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>';

                return '<div class="action-icon">' . $edit_icon . $export_qr . $detail_icon . $delete_icon . '</div>';
            })
            ->rawColumns(['image','action','qrcode'])
            ->make(true);
        }
        return view('backend.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'buy_date' => 'required',
            'sell_date' => 'required',
            'length' => 'required',
            'width' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'origin' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'imagess.*' => 'required|image', // Validation for each image in the array
        ]);

        $imagePath = $request->file('image')->store('public/images');
        $imageName = basename($imagePath);

        $product = Product::create([
            'name' => $request['name'],
            'type' => $request['type'],
            'buy_date' => $request['buy_date'],
            'sell_date' => $request['sell_date'],
            'length' => $request['length'],
            'height' => $request['height'],
            'width' => $request['width'],
            'weight' => $request['weight'],
            'origin' => $request['origin'],
            'description' => $request['description'],
            'image' => $imageName,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                
                $imagePath = $image->store('public/images');
                $imageName = basename($imagePath);
                Image::create([
                    'product_id' => $product->id,
                    'photo' => $imageName, // Corrected column name
                ]);
            }
        }
        $product->qrcode = base64_encode(QrCode::format('png')->size(250)->generate(route('products.show', $product->id)));
        $product->save();
        return redirect('/products')->with('create', 'Products Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('backend.products.detail',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('backend.products.edit',compact('product'));
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
        $product = Product::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'buy_date' => 'required',
            'sell_date' => 'required',
            'length' => 'required',
            'width' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'origin' => 'required',
            'description' => 'required',
        ]);
        $product->name = $request->name;
        $product->type = $request->type;
        $product->buy_date = $request->buy_date;
        $product->sell_date = $request->sell_date;
        $product->length = $request->length;
        $product->width = $request->width;
        $product->height = $request->height; 
        $product->weight = $request->weight;
        $product->origin = $request->origin;
        $product->description = $request->description;
        if($request->file('image')){
            if($product->image){
                Storage::delete('public/images/'.$product->image);
            }
            $imagePath = $request->file('image')->store('public/images/');
            $imageName = basename($imagePath);

            $product->image = $imageName;
        }
        if($request->file('images')){
            foreach($request->file('images') as $image){
                $imagePath = $image->store('public/images');
                $imageName = basename($imagePath);
                Image::create([
                    'product_id' => $product->id,
                    'photo' => $imageName, // Corrected column name
                ]);
            }
        }
        $imagesArray = $request->except('name', 'type','buy_date','sell_date','length','height','width','weight','origin','description','image', '_token', '_method','images','deleted_images');
        if (count($imagesArray)>0) {
            
            foreach ($imagesArray as $id => $image) {
                $i = Image::findOrFail($id);  
                $imagePath = Storage::delete('public/images/'.$i->photo);
                $i->update([
                    'photo' => basename($image->store('public/images'))
                ]);
            }
        }
        
        if($request['deleted_images']){
            
            foreach($request['deleted_images'] as $delete){
                $deleted_image = Image::findOrFail($delete);

                
                $d = Storage::delete('public/images/'.$deleted_image['photo']);
                $deleted_image->delete();
                
            }
        }
        $product->save();
        return redirect('/products')->with('update','Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            Storage::delete('public/images/' . $product->image);
        }
        $product->delete();
        return 'success';
    }
    public function exportImage($id)
    {
        $product = Product::findOrFail($id);

        $info = [
            'qr'=> $product->qrcode,
            'name' => $product->name,
            'type' => $product->type,
            'buy_date'=> $product->buy_date,
            'sell_date' => $product->sell_date,
            'origin' => $product->origin,
        ];

        $image = View::make('backend.products.qr',$info)->render();

        $imageDirectory = public_path('qrimages');
        $imagePath = $imageDirectory . '/product_QR.jpg';

        if(!file_exists($imageDirectory)){
            mkdir($imageDirectory, 0755 ,true);
        }


        Browsershot::html($image)->setIncludePath('$PATH:/usr/local/bin/')->save($imagePath);
        return response()->download($imagePath,'product_QR.jpg');
    }
}

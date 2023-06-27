<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\StoreImportRequest;
use App\Http\Resources\API\Product\CollectionResource;
use App\Imports\ImportProduct;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $product = ProductDetail::with(['product.typeBrand', 'product.type', 'product.brandModel', 'product.modelCapacity'])->get();

        return new CollectionResource($product);
    }

    /**
     * Import resources.
     *
     * @param  StoreImportRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function storeImport(StoreImportRequest $request)
    {
        Excel::queueImport(new ImportProduct(), $request->file);

        $product = ProductDetail::with(['product.typeBrand', 'product.type', 'product.brandModel', 'product.modelCapacity'])->get();

        return new CollectionResource($product);
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Import success!'
        // ]);
    }

    public function store(Request $request)
    {
    }

    public function downloadTemplate()
    {
        $filename = 'product.xlsx';
        // Get path from storage directory
        $path = public_path('sample/' . $filename);

        // Download file with custom headers
        return response()->download($path, $filename, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}

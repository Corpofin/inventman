<?php

namespace App\Http\Controllers;

use App\DataTables\ProductTypeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateProductTypeRequest;
use App\Http\Requests\UpdateProductTypeRequest;
use App\Repositories\ProductTypeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ProductTypeController extends AppBaseController
{
    /** @var  ProductTypeRepository */
    private $productTypeRepository;

    public function __construct(ProductTypeRepository $productTypeRepo)
    {
        $this->productTypeRepository = $productTypeRepo;
    }

    /**
     * Display a listing of the ProductType.
     *
     * @param ProductTypeDataTable $productTypeDataTable
     * @return Response
     */
    public function index(ProductTypeDataTable $productTypeDataTable)
    {
        return $productTypeDataTable->render('product_types.index');
    }

    /**
     * Show the form for creating a new ProductType.
     *
     * @return Response
     */
    public function create()
    {
        return view('product_types.create');
    }

    /**
     * Store a newly created ProductType in storage.
     *
     * @param CreateProductTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateProductTypeRequest $request)
    {
        $input = $request->all();

        $productType = $this->productTypeRepository->create($input);

        Flash::success('Product Type saved successfully.');

        return redirect(route('productTypes.index'));
    }

    /**
     * Display the specified ProductType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $productType = $this->productTypeRepository->findWithoutFail($id);

        if (empty($productType)) {
            Flash::error('Product Type not found');

            return redirect(route('productTypes.index'));
        }

        return view('product_types.show')->with('productType', $productType);
    }

    /**
     * Show the form for editing the specified ProductType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $productType = $this->productTypeRepository->findWithoutFail($id);

        if (empty($productType)) {
            Flash::error('Product Type not found');

            return redirect(route('productTypes.index'));
        }

        return view('product_types.edit')->with('productType', $productType);
    }

    /**
     * Update the specified ProductType in storage.
     *
     * @param  int              $id
     * @param UpdateProductTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductTypeRequest $request)
    {
        $productType = $this->productTypeRepository->findWithoutFail($id);

        if (empty($productType)) {
            Flash::error('Product Type not found');

            return redirect(route('productTypes.index'));
        }

        $productType = $this->productTypeRepository->update($request->all(), $id);

        Flash::success('Product Type updated successfully.');

        return redirect(route('productTypes.index'));
    }

    /**
     * Remove the specified ProductType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $productType = $this->productTypeRepository->findWithoutFail($id);

        if (empty($productType)) {
            Flash::error('Product Type not found');

            return redirect(route('productTypes.index'));
        }

        $this->productTypeRepository->delete($id);

        Flash::success('Product Type deleted successfully.');

        return redirect(route('productTypes.index'));
    }
}

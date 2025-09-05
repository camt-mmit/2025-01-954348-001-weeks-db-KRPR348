<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Models\shop;
use Illuminate\Database\Eloquent\Builder;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\RedirectResponse;

class ShopController extends SearchableController
{
    const int MAX_ITEMS = 5;

    #[\Override]
    function getQuery(): Builder
    {
        return Shop::orderBy('code');
    }



    public function list(ServerRequestInterface $request): View
    {
        $criteria = $this->prepareCriteria($request->getQueryParams());
        $query = $this->search($criteria);
        // $products = shops::orderBy('code')->get();
        return view(
            'shops.list',
            [
                'criteria' => $criteria,
                'products' => $query->paginate(self::MAX_ITEMS),
            ]
        );
    }

    public function view(string $productCode): View
    {
        $product = shop::where('code', $productCode)->firstOrFail();
        return view('shops.view', [
            'product' => $product,
        ]);
    }

     public function showCreateForm(): View
    {
        return view('shops.create-form');
    }

        public function create(ServerRequestInterface $request): RedirectResponse
    {
        $product = shop::create($request->getParsedBody());
        return redirect()->route('shops.list');
    }




        function showUpdateForm(string $productCode): View
    {
        $product = $this->find($productCode);

        return view('shops.update-form', [
            'product' => $product,
        ]);
    }

    function update(ServerRequestInterface $request, string $productCode,): RedirectResponse
    {
        $product = $this->find($productCode);
        $product->fill($request->getParsedBody());
        $product->save();

        return redirect()->route('shops.view', [
            'product' => $product->code,
        ]);
    }

        function delete(string $productCode): RedirectResponse
    {
        $product = $this->find($productCode);
        $product->delete();

        return redirect()->route('shops.list');
    }
}

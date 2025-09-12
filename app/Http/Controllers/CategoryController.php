<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\RedirectResponse;

class CategoryController extends SearchableController
{
    const int MAX_ITEMS = 5;

    #[\Override]
    function getQuery(): Builder
    {
        return Category::orderBy('code');
    }
    #[\Override]
    function prepareCriteria(array $criteria): array
    {
        return [
            ...parent::prepareCriteria($criteria),
            'minPrice' => (($criteria['minPrice'] ?? null) === null)
                ? null
                : (float) $criteria['minPrice'],
            'maxPrice' => (($criteria['maxPrice'] ?? null) === null)
                ? null
                : (float) $criteria['maxPrice'],
        ];
    }

    function filterByPrice(
        Builder|Relation $query,
        ?float $minPrice,
        ?float $maxPrice
    ): Builder|Relation {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query;
    }
    #[\Override]
    function filter(Builder|Relation $query, array $criteria): Builder|Relation
    {
        $query = parent::filter($query, $criteria);
        $query = $this->filterByPrice(
            $query,
            $criteria['minPrice'],
            $criteria['maxPrice'],
        );

        return $query;
    }
    
    public function list(ServerRequestInterface $request): View
    {
        $criteria = $this->prepareCriteria($request->getQueryParams());
        $query = $this->search($criteria)->withCount('products');
        // ->withCount('products')
        return view(
            'categories.list',
            [
                'criteria' => $criteria,
                'category' => $query->paginate(self::MAX_ITEMS),
            ]
        );

    }

     public function showCreateForm(): View
    {
        return view('categories.create-form');
    }

     public function create(ServerRequestInterface $request): RedirectResponse
    {
        $category = Category::create($request->getParsedBody());
        return redirect()->route('categories.list');
    }

       public function view(string $productCode): View
    {
        $product = Category::where('code', $productCode)->firstOrFail();
        return view('categories.view', [
            'product' => $product,
        ]);
    }

        function showUpdateForm(string $productCode): View
    {
        $product = $this->find($productCode);

        return view('categories.update-form', [
            'product' => $product,
        ]);
    }

        function update(ServerRequestInterface $request, string $productCode,): RedirectResponse
    {
        $product = $this->find($productCode);
        $product->fill($request->getParsedBody());
        $product->save();

        return redirect()->route('categories.view', [
            'product' => $product->code,
        ]);
    }

        function delete(string $productCode): RedirectResponse
    {
        $product = $this->find($productCode);
        $product->delete();

        return redirect()->route('categories.list');
    }

        function viewProducts(
        ServerRequestInterface $request,
        ShopController $shopController,
        String $productCode,
    ): view {
        $category = $this->find($productCode);
        $criteria = $shopController->prepareCriteria($request->getQueryParams());
        $query = $shopController->filter(
            $category->products(),
            $criteria,
        )
            ->withCount('shops');

        return view('categories.view-product', [
            'category' => $category,
            'criteria' => $criteria,
            'shops' => $query->paginate($shopController::MAX_ITEMS),
        ]);
    }
}

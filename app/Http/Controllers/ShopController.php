<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
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

    // #[\Override]
    // function applywhereToFilterByterm(Builder $query, string $word): void
    // {
    //     parent::applyWhereToFilterByTerm($query, $word);
    //     $query->orWhere('owner', 'LIKE', "%{$word}%");
    // }

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
        $product = Shop::where('code', $productCode)->firstOrFail();
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
        $product = Shop::create($request->getParsedBody());
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

    function viewProducts(
        ServerRequestInterface $request,
        ShopController $shopController,
        String $productCode,
    ): view {
        $product = $this->find($productCode);
        $criteria = $shopController->prepareCriteria($request->getQueryParams());
        $query = $shopController->filter(
            $product->products(),
            $criteria,
        )
            ->withCount('shops');

        return view('shops.view-products', [
            'product' => $product,
            'criteria' => $criteria,
            'shops' => $query->paginate($shopController::MAX_ITEMS),
        ]);
    }
}

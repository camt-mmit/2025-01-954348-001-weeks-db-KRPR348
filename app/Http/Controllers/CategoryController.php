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
        return redirect()->route('categories.list')
        ->with('status', "Category {$category->name} was created.");
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
        ])
        ->with('status', "Category {$product->name} was updated.");
    }

        function delete(string $productCode): RedirectResponse
    {
        $product = $this->find($productCode);
        $product->delete();

        return redirect()->route('categories.list')
        ->with('status', "Product {$product->code} was deleted.");
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

    function showAddProductsForm(ServerRequestInterface $request, ProductController $productController, string $productCode): View
    {
        $category = $this->find($productCode);
        $criteria = $productController->prepareCriteria($request->getQueryParams());
        $query = $productController
            ->getQuery()
            ->whereDoesntHave(
                 'category',
                function (Builder $innerQuery) use ($category) {
                    return $innerQuery->where('code', $category->code);
                },
            );
        $query = $productController
            ->filter($query, $criteria)
            ->withCount('shops');
        return view('categories.add-products-form', [
            'criteria' => $criteria,
            'category' => $category,
            'categories' => $query->paginate($productController::MAX_ITEMS),
        ]);
    }
        function addProduct(
    ServerRequestInterface $request,
    ProductController $productController,
    string $productCode
): RedirectResponse {
    $category = $this->find($productCode);
    $data = $request->getParsedBody();

    // Retrieve the product, ensuring it does not already belong to the category
    $product = $productController
        ->getQuery()
        ->whereDoesntHave('category', function (Builder $innerQuery) use ($category): void {
            $innerQuery->where('code', $category->code);
        })
        ->where('code', $data['shop'])
        ->firstOrFail();

    // Associate the product with the category using 'associate'
    $product->category()->associate($category);

    // Save the product to persist the association
    $product->save();

    return redirect()->back()
    ->with('status', "Product {$product->name} was added to Category {$category->name}.");
}
}

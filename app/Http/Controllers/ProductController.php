<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProductController extends Controller
{
    private Product $product;

    private Categorie $categorie;

    /**
     * ProductController constructor.
     * Injects the Product, Categorie model wrapper.
     */
    public function __construct(
        Product $product,
        Categorie $categorie
    ) {
        $this->product = $product;
        $this->categorie = $categorie;
    }

    /**
     * Display a listing of all products, optionally filtered by category.
     */
    public function index(Request $request): View
    {
        $categories = $this->categorie->getAllCategories() ?? [];
        $selectedCategory = $request->input('category_id') ? (int) $request->input('category_id') : null;
        $products = $this->product->getAllProducts($selectedCategory) ?? [];

        $paginatedProducts = $this->product->paginate($products, 4);

        return view('admin.producten', [
            'products' => $paginatedProducts,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    /**
     * Display details of a single product.
     */
    public function show(int $id): View|RedirectResponse
    {
        $productDetail = $this->product->getProductById($id);

        if (! isset($productDetail->Id)) {
            session()->flash('error', 'Product niet gevonden.');

            return redirect()->route('admin.producten');
        }

        return view('admin.producten.show', [
            'product' => $productDetail,
        ]);
    }

    /**
     * Show the form to edit the product's expiration date.
     */
    public function edit(int $id): View|RedirectResponse
    {
        $productDetail = $this->product->getProductById($id);

        if (! isset($productDetail->Id)) {
            session()->flash('error', 'Product niet gevonden.');

            return redirect()->route('admin.producten');
        }

        return view('admin.producten.edit', [
            'product' => $productDetail,
        ]);
    }

    /**
     * Update the product's expiration date in the database.
     *
     * @throws ValidationException
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $productDetail = $this->product->getProductById($id);

        if (! isset($productDetail->Id)) {
            session()->flash('error', 'Product niet gevonden.');

            return redirect()->route('admin.producten');
        }

        $validator = Validator::make($request->all(), [
            'Nieuwe_houdbaarheidsdatum' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($productDetail) {
                    $current = Carbon::parse($productDetail->Houdbaarheidsdatum)->startOfDay();
                    $new = Carbon::parse($value)->startOfDay();

                    // The new expiration date cannot be before the current expiration date
                    if ($new->lessThan($current)) {
                        $fail('De nieuwe houdbaarheidsdatum kan niet in het verleden liggen ten opzichte van de huidige datum.');

                        return;
                    }

                    // The new expiration date cannot be extended by more than 7 days
                    if ($new->greaterThan($current->copy()->addDays(7))) {
                        $fail('De houdbaarheidsdatum is met meer dan 7 dagen verlengd.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'Gegevens niet bijgewerkt');

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $newDate = $request->input('Nieuwe_houdbaarheidsdatum');
        $success = $this->product->updateProductExpiration($id, $newDate);

        if ($success) {
            session()->flash('success', 'Houdbaarheidsdatum bijgewerkt');

            return redirect()->route('admin.producten.show', $id);
        }

        session()->flash('error', 'Gegevens niet bijgewerkt');

        return redirect()->back();
    }
}

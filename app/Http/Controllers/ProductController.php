<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    private Product $product;
    private Categorie $categorie;

    /**
     * ProductController constructor.
     * Injects the Product, Categorie model wrapper.
     *
     * @param Product $product
     * @param Categorie $categorie
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
     *
     * @param Request $request
     * @return View
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
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function show(int $id): View|RedirectResponse
    {
        $productDetail = $this->product->getProductById($id);

        if (!isset($productDetail->Id)) {
            session()->flash('error', 'Product niet gevonden.');
            return redirect()->route('admin.producten');
        }

        return view('admin.producten.show', [
            'product' => $productDetail,
        ]);
    }

    /**
     * Show the form to edit the product's expiration date.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        $productDetail = $this->product->getProductById($id);
    
        if (!isset($productDetail->Id)) {
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
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $productDetail = $this->product->getProductById($id);

        if (!isset($productDetail->Id)) {
            session()->flash('error', 'Product niet gevonden.');
            return redirect()->route('admin.producten');
        }

        $request->validate([
            'Nieuwe_houdbaarheidsdatum' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($productDetail) {
                    $currentDate = new \DateTime($productDetail->Houdbaarheidsdatum);
                    $newDate = new \DateTime($value);
                    
                    if ($newDate < $currentDate) {
                        $fail('De nieuwe houdbaarheidsdatum kan niet in het verleden liggen ten opzichte van de huidige datum.');
                        return;
                    }
                    
                    $diff = $currentDate->diff($newDate);
                    if ($diff->days > 7) {
                        $fail('De houdbaarheidsdatum is met meer dan 7 dagen verlengd.');
                    }
                }
            ],
        ]);

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

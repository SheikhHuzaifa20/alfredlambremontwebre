<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Attribute;
use App\Models\ProductAttribute;
use App\Models\ProductVariant;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Traits\FileUploadTrait;

class ProductController extends Controller
{
    use FileUploadTrait;
    /**
     * PRODUCT LIST PAGE
     */
    public function index()
    {
        return view('admin.product.index');
    }

    /**
     * DATATABLE LISTING
     */
    public function getData(Request $request)
    {
        $products = Product::with('category', 'subCategory', 'primaryImage')
            ->orderByDesc('id');

        if ($request->filled('status')) {
            $products->where('status', $request->status);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $products->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        if ($request->filled('featured')) {
            $products->where('is_featured', $request->featured);
        }

        if ($request->filled('category_id')) {
            $products->where('category_id', $request->category_id);
        }

        if ($request->filled('sub_category_id')) {
            $products->where('sub_category_id', $request->sub_category_id);
        }

        return datatables()->of($products)
            ->addColumn('category', function ($row) {
                if (!$row->category_id) return '-';
                $ids = array_filter(explode(',', $row->category_id));
                if (empty($ids)) return '-';
                return Category::whereIn('id', $ids)->pluck('name')->implode(', ');
            })
            ->addColumn('sub_category', fn($row) => $row->subCategory->name ?? '-')
            ->addColumn('paperback_price', fn($row) => $row->paperback_price ?? '-')
            ->addColumn('ebook_price', fn($row) => $row->ebook_price ?? '-')
            ->addColumn('rustica_price', fn($row) => $row->rustica_price ?? '-')
            ->addColumn('taschenbuch_price', fn($row) => $row->taschenbuch_price ?? '-')
            ->addColumn('image', function ($row) {
                $image = $row->primaryImage && $row->primaryImage->image_path
                    ? asset($row->primaryImage->image_path)
                    : asset('images/noimage.png'); // fallback image

                return '<img src="' . $image . '" width="120">';
            })
            ->addColumn('status', function ($row) {
                $checked = $row->status ? 'checked' : '';
                return '
                    <label class="switch">
                        <input type="checkbox" class="toggleProductStatus" data-id="' . $row->id . '" ' . $checked . '>
                        <span class="slider round" title="Click to toggle status"></span>
                    </label>
                ';
            })
            ->addColumn('is_featured', function ($row) {
                $checked = $row->is_featured ? 'checked' : '';
                return '
                    <label class="switch">
                        <input type="checkbox" class="toggleProductIsFeatured" data-id="' . $row->id . '" ' . $checked . '>
                        <span class="slider round" title="Click to toggle featured status"></span>
                    </label>
                ';
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d M, Y h:i A') : '-';
            })
            ->addColumn('action', function ($row) {
                $actions = '';
                if (auth()->user()->hasPermission('edit_product')) {
                    $actions .= '<a href="' . route('admin.product.edit', $row->id) . '"
                                    class="btn btn-sm btn-info" title="Edit User">
                                    <i class="la la-pencil"></i>
                                </a> ';
                }
                if (auth()->user()->hasPermission('delete_product')) {
                    $actions .= '<button class="btn btn-sm btn-danger deleteProduct"
                                    data-id="' . $row->id . '" title="Delete User">
                                    <i class="la la-trash"></i>
                                </button>';
                }
                return $actions ?: '<span class="text-muted">No actions</span>';
            })
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }

    /**
     * CREATE PAGE
     */
    public function create()
    {
        return view('admin.product.create', [
            'categories' => Category::where('status', 1)->get(),
            'attributes' => Attribute::with('values')->where('status', 1)->get(),
        ]);
    }

    /**
     * STORE PRODUCT
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::beginTransaction();

        try {

            $product = Product::create([
                'name'         => $request->name,
                'description'  => $request->description,
                'category_ids' => $request->category_ids ?? [],
                'slug'         => Str::slug($request->name),
                'created_by'   => auth()->id(),
            ]);

            if ($request->hasFile('image')) {

                $imagePath = $this->uploadFile(
                    $request->file('image'),
                    'uploads/products/',
                    'product'
                );

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'is_primary' => 1,
                ]);
            }

            DB::commit();

            return redirect()->back()
                ->with('message', 'Product added successfully!');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * EDIT PAGE
     */
    public function edit(Product $product)
    {
        return view('admin.product.edit', [
            'product'     => $product->load('primaryImage', 'attributes'),
            'primary_image'      => $product->primaryImage->image_path ?? '',
            'gallery_images'      => $product->galleryImages,
            'categories'  => Category::where('status', 1)->get(),
            'subCats'     => SubCategory::where('category_id', $product->category_id)->get(),
            'attributes'  => Attribute::with('values')->where('status', 1)->get(),
            'variants'    => $product->variants ?? [],
        ]);
    }

    /**
     * UPDATE PRODUCT
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'category_ids'   => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::beginTransaction();

        try {

            $product->update([
                'name'         => $request->name,
                'description'  => $request->description,
                'category_ids' => $request->category_ids ?? [],
                'slug'         => Str::slug($request->name),
                'updated_by'   => auth()->id(),
            ]);

            if ($request->hasFile('image')) {

                $oldImage = ProductImage::where('product_id', $product->id)
                    ->where('is_primary', 1)
                    ->first();

                if ($oldImage) {

                    if (
                        $oldImage->image_path &&
                        file_exists(public_path($oldImage->image_path))
                    ) {
                        unlink(public_path($oldImage->image_path));
                    }

                    $oldImage->delete();
                }

                $imagePath = $this->uploadFile(
                    $request->file('image'),
                    'uploads/products/',
                    'product'
                );

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'is_primary' => 1,
                ]);
            }

            DB::commit();

            return redirect()->back()
                ->with('message', 'Product updated successfully!');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * DELETE PRODUCT (Soft Delete)
     */
    public function destroy(Product $product)
    {
        $product->delete();

        log_activity('delete', Product::class, $product->id, "Deleted product {$product->name}");

        return response()->json(['success' => 'Product deleted successfully.']);
    }

    /**
     * TOGGLE STATUS
     */
    public function toggleStatus(Product $product)
    {
        $old = $product->status;
        $product->status = !$old;
        $product->save();

        log_activity(
            'status_toggle',
            Product::class,
            $product->id,
            'Toggled product status for ' . $product->name . ' from ' . ($old ? 'Active' : 'Inactive') . ' to ' . ($product->status ? 'Active' : 'Inactive')
        );

        return response()->json([
            'success' => true,
            'status' => $product->status ? 'Active' : 'Inactive',
        ]);
    }

    /**
     * TOGGLE IS FEATURED
     */
    public function toggleIsFeatured(Product $product)
    {
        $old = $product->is_featured;
        $product->is_featured = !$old;
        $product->save();

        log_activity(
            'is_featured_toggle',
            Product::class,
            $product->id,
            'Toggled product ' . $product->name . ' from ' . ($old ? 'Featured' : 'Not Featured') . ' to ' . ($product->is_featured ? 'Featured' : 'Not Featured'),
        );

        return response()->json([
            'success' => true,
            'is_featured' => $product->is_featured ? 'Featured' : 'Not Featured',
        ]);
    }

    /**
     * TRASH PAGE
     */
    public function trash()
    {
        return view('admin.product.trash');
    }

    /**
     * TRASH AJAX DATA
     */
    public function getTrashedData()
    {
        $products = Product::with('category', 'subCategory', 'primaryImage')->onlyTrashed()->get();

        return datatables()->of($products)
            ->addColumn('category', fn($row) => $row->category->name ?? '-')
            ->addColumn('sub_category', fn($row) => $row->subCategory->name ?? '-')
            ->addColumn('image', function ($row) {
                $image = $row->primaryImage && $row->primaryImage->image_path
                    ? asset($row->primaryImage->image_path)
                    : asset('images/noimage.png'); // fallback image

                return '<img src="' . $image . '" width="120">';
            })
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-sm btn-success restoreProduct" data-id="' . $row->id . '">Restore</button>
                    <button class="btn btn-sm btn-danger forceDeleteProduct" data-id="' . $row->id . '">Delete Permanently</button>
                ';
            })
            ->rawColumns(['action', 'image'])
            ->make(true);
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        log_activity('restore', Product::class, $product->id, "Restore product {$product->name}");

        return response()->json(['success' => 'Product restored successfully.']);
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        // $product->images()->delete();
        $product->forceDelete();

        log_activity('force_delete', Product::class, $id, "Permanently deleted product {$product->name}");

        return response()->json(['success' => 'Product permanently deleted.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || !is_array($ids)) {
            return response()->json(['error' => 'No items selected.'], 400);
        }

        Product::whereIn('id', $ids)->delete();

        log_activity('bulk_delete', Product::class, null, 'Bulk deleted products: ' . implode(',', $ids), ['ids' => $ids]);

        return response()->json(['success' => 'Selected products deleted successfully.']);
    }

    // Bulk restore from trash
    public function bulkRestore(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || !is_array($ids)) {
            return response()->json(['error' => 'No items selected.'], 400);
        }

        Product::withTrashed()->whereIn('id', $ids)->restore();

        log_activity('bulk_restore', Product::class, null, 'Bulk restore products: ' . implode(',', $ids), ['ids' => $ids]);

        return response()->json(['success' => 'Selected products restored successfully.']);
    }

    // Bulk permanent delete (from trash)
    public function bulkForceDelete(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || !is_array($ids)) {
            return response()->json(['error' => 'No items selected.'], 400);
        }

        $products = Product::withTrashed()->whereIn('id', $ids)->get();

        log_activity('bulk_force_delete', Product::class, null, 'Bulk permanently deleted products: ' . implode(',', $ids), ['ids' => $ids]);

        foreach ($products as $product) {
            $this->deleteFile($product->primary_image_path);
            $product->forceDelete();
        }

        return response()->json(['success' => 'Selected products permanently deleted.']);
    }

    public function getSubcategories($id)
    {
        $subcategories = SubCategory::where('category_id', $id)->get();

        return response()->json($subcategories);
    }

    public function getValues(Request $request)
    {
        $values = AttributeValue::where('attribute_id', $request->attribute_id)->get();

        return response()->json([
            'status' => true,
            'data' => $values
        ]);
    }

    public function destroyGalleryImage(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:product_images,id'
        ]);

        $image = ProductImage::findOrFail($request->id);

        // Delete file from storage
        if (file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }

        $image->delete();

        return response()->json(['success' => true]);
    }

    public function catSelect2(Request $request)
    {
        if ($request->filled('id')) {
            $cat = Category::find($request->id);
            return response()->json(['id' => $cat->id, 'text' => $cat->name]);
        }

        $query = Category::query();

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $data = $query->paginate(10);

        return response()->json([
            'results' => $data->map(fn($c) => ['id' => $c->id, 'text' => $c->name]),
            'pagination' => ['more' => $data->hasMorePages()]
        ]);
    }

    public function subCatselect2(Request $request)
    {
        if ($request->filled('id')) {
            $sub = SubCategory::find($request->id);
            return response()->json(['id' => $sub->id, 'text' => $sub->name]);
        }

        $query = SubCategory::where('category_id', $request->category_id);

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $data = $query->paginate(10);

        return response()->json([
            'results' => $data->map(fn($s) => ['id' => $s->id, 'text' => $s->name]),
            'pagination' => ['more' => $data->hasMorePages()]
        ]);
    }
}

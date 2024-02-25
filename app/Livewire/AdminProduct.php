<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use \App\Models\Inventory\Product;
use App\Models\Inventory\ProductDetail;
use Illuminate\Support\Facades\DB;

class AdminProduct extends Component
{
    public $productModal = [
        'id' => null,
        'name' => '',
        'sku' => '',
        'stock' => '',
        'sale_price' => 0,
        'price' => 0,
        'short_description' => '',
        'description' => '',
    ];
    public ?array $modal = [];
    public $alert = [
        'type'      => '',
        'message'   => ''
    ];

    public function mount()
    {
    }

    public function openEditModel(string $product_id)
    {
        $this->modal = [
            'type' => 'edit', 
        ];

        $product = Product::find($product_id);
        $this->productModal['id'] = $product->id;
        $this->productModal['name'] = $product->name;
        $this->productModal['stock'] = $product->stock;
        $this->productModal['sale_price'] = $product->sale_price;
        $this->productModal['price'] = $product->price;

        $this->productModal['sku'] = $product->details->sku;
        $this->productModal['short_description'] = $product->details->short_description;
        $this->productModal['description'] = $product->details->description;
    }

    public function openAddModal()
    {
        $this->modal = [
            'type' => 'add-product', 
        ];
    }

    public function closeModal()
    {
        $this->modal = [];
        $this->productModal = [];
    }

    public function updateProduct()
    {
        if(!isset($this->productModal['id'])) {
            $this->createProduct();
            return;
        }

        DB::beginTransaction();
        try {
            Log::info('productModal: ' . json_encode($this->productModal, JSON_PRETTY_PRINT));
            $product = Product::find($this->productModal['id']);
            $product->name = $this->productModal['name'];
            $product->stock = $this->productModal['stock'];
            $product->sale_price = $this->productModal['sale_price'];
            $product->price = $this->productModal['price'];
            $product->author_id = auth()->user()->id;

            $product->save();
            
            /**
             * TODO : 
             * - fix issue description can't update
             * */ 
            $product->details->sku = $this->productModal['sku'];
            $product->details->short_description = $this->productModal['short_description'];
            $product->details->description = $this->productModal['description'];
            $product->details->save();
            DB::commit();
            Log::info('product: ' . json_encode($product, JSON_PRETTY_PRINT));

            $this->alert['type'] = "success";
            $this->alert['message'] = "Successfully update product";
            $this->closeModal();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->alert['type'] = "error";
            $this->alert['message'] = $exception->getMessage();
            $this->closeModal();
        }
    }

    public function createProduct()
    {
        DB::beginTransaction();
        try {
            $product = new Product;
            $product->name = $this->productModal['name'];
            $product->stock = $this->productModal['stock'];
            $product->status_stock = $this->productModal['stock'] > 0 ? 'instock' : 'outstock';
            $product->sale_price = $this->productModal['sale_price'];
            $product->price = $this->productModal['price'];
            $product->author_id = auth()->user()->id;

            $product->save();

            $details = new ProductDetail([
                'sku' => $this->productModal['sku'],
                'short_description' => $this->productModal['short_description'],
                'description' => $this->productModal['short_description'],
            ]);

            $product->details()->save($details);
            DB::commit();
            
            $this->alert['type'] = "success";
            $this->alert['message'] = "Successfully adding product";
            $this->closeModal();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->alert['type'] = "error";
            $this->alert['message'] = $exception->getMessage();
            $this->closeModal();
        }
    }

    public function render()
    {
        $products = Product::with(['details'])->orderBy('created_at', 'DESC')->get()->all();
        return view('livewire.admin-product', compact('products'));
    }
}

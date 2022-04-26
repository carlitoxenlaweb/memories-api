<?php

namespace App\Http\Controllers;

use App\Models\Finish;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductFinish;
use App\Models\ProductImage;
use App\Models\Client;
use App\Models\ClientAddress;
use App\Models\ClientCards;
use App\Models\Orders;
use App\Models\OrdersImages;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getCategories ()
    {
        $categories = Category::whereNull('parent_id')->get();

        foreach ($categories as $category) {
            $this->unset($category);
            
            $subcategories = [];
            $subs = Category::where('parent_id', $category->id)->get();
            
            if (count($subs) > 0) {
                foreach ($subs as $cat) {
                    $this->unset($cat);
                    unset($cat->parent_id);
                    $subcategories[] = $cat;
                }
            }

            $category->sub_categories = $subcategories;
        }
        
        return response()->json($categories);
    }

    public function getCategory ($id)
    {
        $category = Category::find($id);

        if ($category) {
            $this->unset($category);
            
            $subcategories = [];
            $subs = Category::where('parent_id', $category->id)->get();
            
            if (count($subs) > 0) {
                foreach ($subs as $cat) {
                    $this->unset($cat);
                    unset($cat->parent_id);
                    $subcategories[] = $cat;
                }
            }

            $category->sub_categories = $subcategories;
        }

        return response()->json($category);
    }

    public function getCategoryProducts ($id)
    {
        $products = Product::with(['category', 'prices', 'finishes'])->where('category_id', $id)->get();

        foreach ($products as $product) {
            $this->unset($product);
            $this->unset($product->category);
            
            $product->specs = explode(";", $product->specs);
            foreach ($product->prices as $price) {
                $this->unset($price);
            }

            for ($i=0; $i < count($product->finishes); $i++) {
                $product->finishes[$i] = Finish::find($product->finishes[$i]->finish_id);
                $this->unset($product->finishes[$i]);
            }
        }

        return response()->json($products);
    }

    public function getFinishes ()
    {
        $finishes = Finish::all();
        foreach ($finishes as $finish) {
            $this->unset($finish);
        }
        return response()->json($finishes);
    }

    public function getFinish ($id)
    {
        $finish = Finish::find($id);
        $this->unset($finish);
        return response()->json($finish);
    }

    public function getProducts ()
    {
        $products = Product::with(['category', 'prices', 'finishes'])->get();

        foreach ($products as $product) {
            $this->unset($product);
            $this->unset($product->category);
            
            $product->specs = explode(";", $product->specs);
            foreach ($product->prices as $price) {
                $this->unset($price);
            }

            for ($i=0; $i < count($product->finishes); $i++) {
                $product->finishes[$i] = Finish::find($product->finishes[$i]->finish_id);
                $this->unset($product->finishes[$i]);
            }
            
            $images = ProductImage::where('product_id', $product->id)->get();
            foreach ($images as $image) {
                $this->unset($image);
                unset($image->id);
                unset($image->product_id);
            }

            $product->images = $images;
        }

        return response()->json($products);
    }

    public function getProduct ($id)
    {
        $product = Product::with(['category', 'prices', 'finishes'])->find($id);

        $this->unset($product);
        $this->unset($product->category);
            
        $product->specs = explode(";", $product->specs);        
        foreach ($product->prices as $price) {
            $this->unset($price);
        }

        for ($i=0; $i < count($product->finishes); $i++) {
            $product->finishes[$i] = Finish::find($product->finishes[$i]->finish_id);
            $this->unset($product->finishes[$i]);
        }
            
        $images = ProductImage::where('product_id', $product->id)->get();
        foreach ($images as $image) {
            $this->unset($image);
            unset($image->id);
            unset($image->product_id);
        }
        
        $product->images = $images;
        return response()->json($product);
    }

    public function getAddresses (Request $request)
    {
        $client = Client::where('email', $request->input('UserEmail'))->first();
        if ($client === null) {
            return response()->json([]);
        }

        $addresses = ClientAddress::where('client_id', $client->id)->get();
        foreach ($addresses as $address) {
            $this->unset($address);
        }

        return response()->json($addresses);
    }

    public function getAddress ($id, Request $request)
    {
        $client = Client::where('email', $request->input('UserEmail'))->first();
        if ($client === null) {
            return response()->json([]);
        }

        $address = ClientAddress::where('id', $id)->where('client_id', $client->id)->get();
        $this->unset($address);

        return response()->json($address);
    }

    public function newAddress (Request $request)
    {
        $client = Client::where('email', $request->input('UserEmail'))->first();
        if ($client === null) {
            $client = new Client();
            $client->name = $request->input('UserEmail');
            $client->email = $request->input('UserName');
            $client->save();
        }

        $address = new ClientAddress();
        
        $address->client_id = $client->id;
        $address->address = $request->input('Address');
        $address->country = $request->input('Country');
        $address->city = $request->input('City');
        $address->zip = $request->input('PostCode');
        $address->mobile = $request->input('Mobile');
        
        $address->save();
        return response()->json($address);
    }

    public function getCards (Request $request)
    {
        $client = Client::where('email', $request->input('UserEmail'))->first();
        if ($client === null) {
            return response()->json([]);
        }

        $cards = ClientCards::where('client_id', $client->id)->get();
        foreach ($cards as $card) {
            $this->unset($card);
        }

        return response()->json($cards);
    }

    public function getCard ($id, Request $request)
    {
        $client = Client::where('email', $request->input('UserEmail'))->first();
        if ($client === null) {
            return response()->json([]);
        }

        $card = ClientCards::where('id', $id)->where('client_id', $client->id)->get();
        $this->unset($card);

        return response()->json($card);
    }

    public function newCard (Request $request)
    {
        $client = Client::where('email', $request->input('UserEmail'))->first();
        if ($client === null) {
            $client = new Client();
            $client->name = $request->input('UserEmail');
            $client->email = $request->input('UserName');
            $client->save();
        }

        $card = new ClientCards();
        
        $card->client_id = $client->id;
        $card->card_number = $request->input('CardNumber');
        $card->card_expiry = $request->input('CardExpiry');
        $card->cvv = $request->input('CVV');
        
        $card->save();
        return response()->json($card);
    }

    public function getOrders (Request $request)
    {
        $client = Client::where('email', $request->input('UserEmail'))->first();
        if ($client === null) {
            return response()->json([]);
        }

        $orders = Order::with(['product', 'finish', 'images'])->where('client_id', $client->id)->get();
        foreach ($orders as $order) {
            $this->unset($order);
            $images = OrdersImages::where('order_id', $order->id)->get();
            foreach ($images as $image) {
                $this->unset($image);
            }
            $order->images = $images;
        }

        return response()->json($orders);
    }

    public function getOrder ($id, Request $request)
    {
        $client = Client::where('email', $request->input('UserEmail'))->first();
        if ($client === null) {
            return response()->json([]);
        }

        $order = Order::with(['product', 'finish', 'images'])->where('client_id', $client->id)->where('id', $id)->get();
        $this->unset($order);
        
        $images = OrdersImages::where('order_id', $order->id)->get();
        foreach ($images as $image) {
            $this->unset($image);
        }

        $order->images = $images;
        return response()->json($order);
    }

    public function newOrder (Request $request)
    {
        $client = Client::where('email', $request->input('UserEmail'))->first();
        //if (!Client::where('email', $request->input('UserEmail'))->exists()) {
        if ($client === null) {
            return response()->json(['err' => 'client not found, create a card first']);
        }

        $client_card = ClientCards::find('email', $request->input('CardID'));
        if ($client === null) {
            return response()->json(['err' => 'card not found, create a card first']);
        }

        $order = new Order();

        $order->product_id = $request->input('ProductID');
        $order->paper = $request->input('Paper');
        $order->finish_id = $request->input('Finish');
        $order->border = $request->input('Border');
        $order->format = $request->input('Format');
        $order->total_price = $request->input('TotalPrice');
        $order->total_photos = $request->input('TotalPhotos');
        $order->status = $request->input('Status');
        $order->paid = $request->input('Paid');
        $order->client_id = $client->id;
        $order->stripe_reference = $request->input('StripeReference');
        $order->client_card_id = $client_card->id;

        $order->save();

        if($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $file) {
                $image = new OrdersImages();

                $imageName = $this->hashFile($file->getClientOriginalName());
                $path = $file->storeAs('uploads/orders/' . $order->id, $imageName, 'public');
                
                $image->order_id = $order->id;
                $image->image_name = $imageName;
                $image->image_path = '/storage/'.$path;
                $image->save();
            }
        }
        
        return response()->json($order);
    }
}

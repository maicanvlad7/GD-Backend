<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class GiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gift  $gift
     * @return \Illuminate\Http\Response
     */
    public function show(Gift $gift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gift  $gift
     * @return \Illuminate\Http\Response
     */
    public function edit(Gift $gift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gift  $gift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gift $gift)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gift  $gift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gift $gift)
    {
        //
    }

    public function populateTable()
    {
        for($i = 0; $i < 100; $i++) {
            $gift = new Gift();

            $gift->code = Str::random('20');
            $gift->pid  = "price_1L7t3FCLTsRzEEEVLUDAG6WH";
            $gift->qr   = "https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=https://gandestediferit.ro/login-register/?pid=price_1L7t3FCLTsRzEEEVLUDAG6WH&kloiju=2&dc=GC100&gcc=" . $gift->code;
            $gift->type = "pro";

            $gift->save();
        }
    }

    public function checkoutProduct(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_API_KEY'));
        header('Content-Type: application/json');

        $type = $request->type;

        $gift = Gift::inRandomOrder()->whereNull('buyer_email')->where('type', $type)->first();

        $gift->buyer_email = $request->user['email'];
        $gift->city = $request->user['city'];
        $gift->name = $request->user['name'];
        $gift->address = $request->user['address'];
        $gift->phone = $request->user['phone'];

        $gift->save();

        $YOUR_DOMAIN = 'https://gandestediferit.ro/gift-buy';

        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                'price' => $request->product_id,
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'tax_id_collection' => ['enabled' => true],
            'locale' => 'ro',
            'success_url' => $YOUR_DOMAIN . '?success=true&session_id={CHECKOUT_SESSION_ID}&gcc=' . $gift->code,
            'cancel_url' => $YOUR_DOMAIN . '?canceled=true&gcc=' . $gift->code,
        ]);

        header("HTTP/1.1 303 See Other");

        return response()->json([
            "url" => $checkout_session->url,
        ]);


    }

    public function getPaymentDetails(Request $request)
    {

        $stripe = new \Stripe\StripeClient(
            env('STRIPE_API_KEY')
        );

        $resp = $stripe->checkout->sessions->retrieve(
            $request->session_id,
            []
        );

        return response()->json([
            "payment" => $resp,
        ]);
    }

    public function cancelCode(Request $request)
    {
        $gift = Gift::where('code', $request->gcc)->first();

        $gift->buyer_email = null;
        $gift->name = null;
        $gift->city = null;
        $gift->address = null;
        $gift->phone = null;

        $gift->save();
    }

    public function checkGiftCard(Request $request)
    {
        $gift = Gift::where('code', $request->gcc)->first();

        return response()->json([
            'success' => true,
            'message' => 'GIFT found',
            'used' => $gift->used,
        ], Response::HTTP_OK);
    }

    public function markAsUsed(Request $request)
    {
        $gift = Gift::where('code', $request->gcc)->first();

        $gift->used = 1;

        if($gift->save()) {
            return response()->json([
                'success' => true,
                'message' => 'GIFT found',
                'used' => $gift->used,
            ], Response::HTTP_OK);
        }
    }
}

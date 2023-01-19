<?php

namespace App\Http\Controllers;

use App\Models\Activation;
use App\Models\Host;
use App\Models\Reset;
use Illuminate\Support\Str;
use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;


class ApiController extends Controller
{
    public function __construct()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_API_KEY'));
    }

    public function stripe(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_API_KEY'));
        header('Content-Type: application/json');



        $YOUR_DOMAIN = 'https://gandestediferit.ro/payment';

        $discount_codes = ["GD50","GD20","UNI20","AC100", "GC100","MAN100", "JULLY"];

        $uid = isset($request->uid) ? $request->uid : 0;

        if(in_array(strtoupper($request->dc), $discount_codes)) {
            if(isset($request->te) && $request->te == 1) {

                $checkout_session = \Stripe\Checkout\Session::create([
                    'line_items' => [[
                        # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                        'price' => $request->product_id,
                        'quantity' => 1,
                    ]],
                    'mode' => 'subscription',
                    'subscription_data' => [
                        "trial_period_days" => 30
                    ],
                    'discounts' => [[
                        'coupon' => strtoupper($request->dc),
                    ]],
                    'tax_id_collection' => ['enabled' => true],
                    'locale' => 'ro',
                    'success_url' => $YOUR_DOMAIN . '?success=true&session_id={CHECKOUT_SESSION_ID}&kloiju=' . $request->level . '&uid=' . $uid,
                    'cancel_url' => $YOUR_DOMAIN . '?canceled=true',
                ]);
            }else {
                $checkout_session = \Stripe\Checkout\Session::create([
                    'line_items' => [[
                        # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                        'price' => $request->product_id,
                        'quantity' => 1,
                    ]],
                    'mode' => 'subscription',
                    'subscription_data' => [
                        "trial_period_days" => 30
                    ],
                    'discounts' => [[
                        'coupon' => strtoupper($request->dc),
                    ]],
                    'tax_id_collection' => ['enabled' => true],
                    'locale' => 'ro',
                    'success_url' => $YOUR_DOMAIN . '?success=true&session_id={CHECKOUT_SESSION_ID}&kloiju=' . $request->level . '&uid=' . $uid,
                    'cancel_url' => $YOUR_DOMAIN . '?canceled=true',
                ]);
            }

        }else {
            if(isset($request->te) && $request->te == 1) {
                $checkout_session = \Stripe\Checkout\Session::create([
                    'line_items' => [[
                        # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                        'price' => $request->product_id,
                        'quantity' => 1,
                    ]],
                    'mode' => 'subscription',
                    'subscription_data' => [
                        "trial_period_days" => 30
                    ],
                    'tax_id_collection' => ['enabled' => true],
                    'locale' => 'ro',
                    'success_url' => $YOUR_DOMAIN . '?success=true&session_id={CHECKOUT_SESSION_ID}&kloiju=' . $request->level . '&uid=' . $uid,
                    'cancel_url' => $YOUR_DOMAIN . '?canceled=true',
                ]);
            }else {
                $checkout_session = \Stripe\Checkout\Session::create([
                    'line_items' => [[
                        # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                        'price' => $request->product_id,
                        'quantity' => 1,
                    ]],
                    'mode' => 'subscription',
                    'subscription_data' => [
                        "trial_period_days" => 30
                    ],
                    'tax_id_collection' => ['enabled' => true],
                    'locale' => 'ro',
                    'success_url' => $YOUR_DOMAIN . '?success=true&session_id={CHECKOUT_SESSION_ID}&kloiju=' . $request->level . '&uid=' . $uid,
                    'cancel_url' => $YOUR_DOMAIN . '?canceled=true',
                ]);
            }

        }


        header("HTTP/1.1 303 See Other");

        return response()->json([
            "url" => $checkout_session->url,
        ]);
    }

    public function updateCustomerId(Request $request)
    {
        $user = User::find($request->input('gd_id'));

        $user->stripe_id    = $request->input('stripe_id');
        $user->subscription = $request->input('sub_id');
        $user->level        = $request->input('level');

        if($user->save()) {
            //User created, return success response
            return response()->json([
                'success' => true,
                'message' => 'Customer ID updated',
                'data' => $user
            ], Response::HTTP_OK);
        };
    }


    public function get_stripe_customer_data(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_API_KEY'));

        $session = \Stripe\Checkout\Session::retrieve($request->input('session_id'));
        $customer = \Stripe\Customer::retrieve($session->customer);

        return response()->json([
            "customer" => $customer,
            "session" => $session,
        ], Response::HTTP_OK);
    }

    public function get_stripe_profile_data(Request $request)
    {

        $user = User::find($request->input('user_id'));

        if($user->subscription == "0" ) {
            return response()->json([
                "customer" => null,
                "product"  => null,
            ], Response::HTTP_OK);
        }

        $customer = \Stripe\Subscription::retrieve($user->subscription);

        $prodInt = $customer->plan->product;

        $prod = \Stripe\Product::retrieve($prodInt);


        return response()->json([
            "customer" => $customer,
            "product"  => $prod,
        ], Response::HTTP_OK);
    }

    public function cancel_active_sub(Request $request)
    {
        $user = User::find($request->input('user_id'));

        $customer = \Stripe\Subscription::update($user->subscription,
            [
                'cancel_at_period_end' => true,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Customer Subscription canceled',
        ], Response::HTTP_OK);

    }


    public function saveUserResetPassword(Request $request)
    {
        $reset = Reset::where('token', $request->input('token'))->first();

        $user = User::where('email', $reset->email)->first();

        $user->password = bcrypt($request->password);

        if($user->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Parola schimbata cu succes',
            ], Response::HTTP_OK);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'A aparut o problema',
            ], Response::HTTP_OK);
        }
    }

    public function checkResetCode(Request $request)
    {
        $reset = Reset::where('token', $request->input('token'))->first();

        if(isset($reset->id)) {
            return response()->json([
                'success' => true,
                'message' => 'Acest token exista',
            ], Response::HTTP_OK);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Acest token nu exista',
            ], Response::HTTP_OK);
        }
    }

    public function generateResetCode(Request $request)
    {

        //verificam daca exista utilizatorul
        $user = User::where('email',$request->input('email'))->first();

        if(isset($user->id)) {

            //generam string random pentru token reset
            $pwResToken = Str::random(30);

            //inseram codul in tabela de reset, folosim update or create in caz ca nu e prima oara cand da reset
            $reset = Reset::updateOrCreate(
                ['email' => $user->email],
                ['token' => $pwResToken]
            );

            //message building
            $mailMessage = 'Pentru a reseta parola asociata cu contul dvs. va rugam sa accesati linkul : https://gandestediferit.ro/final-forgot?tk=' . $pwResToken;

            //trimitem mail SMTP
            Mail::raw($mailMessage, function($message) use($user) {
                $message->from('website@gandestediferit.ro', 'Gandeste Diferit App');
                $message->subject('Resetare parola');
                $message->to($user->email);
            });

            //daca nu se trimite mailul anuntam userul
            if(Mail::failures()) {
                return response()->json([
                    'success' => false,
                    'message' => 'A aparut o eroare. Te rog sa soliciti un cod mai tarziu!',
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Linkul de resetare a fost trimis pe email. Te rugam sa verifici si folderul de spam / promotii!',
                ], Response::HTTP_OK);
            }

            //daca mailul nu exista in baza de date we let the user know
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Emailul nu este asociat cu un cont. Incearca din nou!',
            ], Response::HTTP_OK);
        }
    }

    public function getReferred(Request $request)
    {
        $refer = new \stdClass();

        $refer->referredCount = User::where('referred_by', $request->user_id)->count();
        $refer->subbedCount   = User::where('referred_by', $request->user_id)
                            ->where('subscription','!=','0')
                            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Referral data fount',
            'data' => $refer
        ], Response::HTTP_OK);

    }


    public function register(Request $request)
    {
        //Validate data
        $data = $request->only('name', 'email', 'password', 'refCode', 'phone');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $active = 0;
        $refBy = 0;

        if(isset($request->refCode) && !empty($request->refCode)) {

            $reffer = $request->refCode;

            if($reffer[0] == 't') {

                $reffer = substr($reffer, 1);

                $host   = User::where('custom_ref', $reffer)->first();

                $refBy = $host->id;

            } else {

                $refBy = substr($request->refCode, 3);

            }

        }

        if(isset($request->pid) && !empty($request->pid)) {
            $active = 1;
        }

        //Request is valid, create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'referred_by' => intval($refBy),
            'active'    => 1,
        ]);

        $new_time = date("Y-m-d H:i:s", strtotime('+5 hours'));

       if(!$active) {
           //user created, create activation code
           $activation = Activation::create([
               'user_id' => $user->id,
               'code'    => Str::random(30),
               'expires' => $new_time
           ]);


       }

        //User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
            return $credentials;
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
            ], 500);
        }

        //Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated, do logout
        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_user(Request $request)
    {
//        $this->validate($request, [
//            'token' => 'required'
//        ]);

        $user = JWTAuth::authenticate($request->bearerToken());

        return response()->json(['user' => $user]);
    }

    public function activateAccount(Request $request, $code)
    {
        $user = JWTAuth::authenticate($request->bearerToken());
        //get user with activation data
        $user = User::where('id', $user->id)->with('activation')->first();

        $now = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', \Carbon\Carbon::now());
        $expires = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user->activation->expires);

        if($user->active) {
            return response()->json([
                'success' => false,
                'message' => 'Acest cont este deja activ.'
            ], 200);
        }else if($now->gt($expires)){
            echo($now);
            echo($expires);
            return response()->json([
                'success' => false,
                'message' => 'Codul de activare a expirat, va rugam sa solicitati unul nou.'
            ], 200);
        }else{
            if($code == $user->activation->code) {
                $user = User::where('id', $user->id)->update([
                    'active' => 1,
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Contul a fost activat cu succes! Veti fi redirectionat.'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Codul folosit este gresit sau nu exista. Va rugam sa solicitati unul nou.'
                ], 200);
            }


        }


    }

    public function changePassByUser(Request $request)
    {
        $user = JWTAuth::authenticate($request->bearerToken());

        $user = User::where('id', $user->id)->first();

        $user->password =  bcrypt($request->password);

        if($user->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Parola a fost schimbată cu succes'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'A apărut o eroare. Vă rugăm să încercați din nou!'
            ], 200);
        }
    }

    public function addTagToSub(Request $request)
    {
        $user = JWTAuth::authenticate($request->bearerToken());

        $user = User::where('id', $user->id)->first();
        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
        $ch = curl_init();

        $tag_url = 'https://api.convertkit.com/v3/tags/'.$request->cktag.'/subscribe';

        curl_setopt($ch, CURLOPT_URL, $tag_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \n            \"api_secret\": \"".env('CK_KEY')."\",\n            \"email\": \"".$user->email."\"\n         }");

        $headers = array();
        $headers[] = 'Content-Type: application/json; charset=utf-8';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return response()->json([
            'success' => true,
            'message' => 'Te-ai abonat cu succes'
        ], 200);
    }

    public function checkkAllUserSubs()
    {
        $stripe = new \Stripe\StripeClient(
            env('STRIPE_API_KEY')
        );

        $users = User::where('isHost', '0')->where('is_bot', '0')->where('subscription','!=','0')->get();

        foreach($users as $u) {

            try {
                $data =  $data = $stripe->subscriptions->retrieve(
                    $u->subscription,
                    []
                );

                //daca este canceled sau neplatita facem update si la noi in DB
                if($data->status == 'canceled' || $data->status == 'unpaid') {
                    $u->level = 0;
                    $u->subscription = 0;

                    $u->save();
                }
            } catch(\Stripe\Exception\InvalidRequestException $e) {
                error_log('Invalid sub from test mode used in live - bots');
            }

        }
    }

    public function stripeWebhookUpdateCall()
    {
        $endpoint_secret = env('SWHS');

        $payload = @file_get_contents('php://input');
        $event = null;

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            echo '⚠️  Webhook error while parsing basic request.';
            http_response_code(400);
            exit();
        }
        if ($endpoint_secret) {
            // Only verify the event if there is an endpoint secret defined
            // Otherwise use the basic decoded event
            $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
            try {
                $event = \Stripe\Webhook::constructEvent(
                    $payload, $sig_header, $endpoint_secret
                );
            } catch(\Stripe\Exception\SignatureVerificationException $e) {
                // Invalid signature
                echo '⚠️  Webhook error while validating signature.';
                http_response_code(400);
                exit();
            }
        }

// Handle the event
        switch ($event->type) {
            case 'customer.subscription.deleted':
                $subscription = $event->data->object;

                $user = User::where('subscription',$subscription->id)->first();

                $user->level = 0;
                $user->subscription = 0;
                $user->save();

                break;
            default:
                // Unexpected event type
                error_log('Received unknown event type');
        }

        http_response_code(200);
    }
}

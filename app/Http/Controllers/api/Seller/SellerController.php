<?php

namespace App\Http\Controllers\api\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Traits\apiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
use function GuzzleHttp\Promise\all;

class SellerController extends Controller
{
    use apiResponse ;


    public function index()
    {
//        $lat =auth()->user()->latitude;
//        $lng =auth()->user()->longitude;
//        $model = Seller::Selection();
//        $model->addSelect(DB::raw("acos(cos(" . $lat . "*pi()/180)*cos(latitude*pi()/180)*
//        cos(" . $lng . "*pi()/180-longitude*pi()/180)+
//        sin(" . $lat . "*pi()/180)*sin(latitude * pi()/180))
//        * 6367000 AS distance"))->orderBy('distance','ASC');
//        $sellers  = $model->get();
        $sellers =Seller::all();
        return $this->showAll($sellers , 200);
    }

    public function show($id)
    {
        $seller = Seller::findOrfail($id);
        return $this->showOne($seller , 200);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name'  => 'string',
            'phone' =>'unique:sellers',
            'online' => 'in:0,1'
        ];

        if ($this->assurence()->first()->tokenable_id != $id)
            return $this->errorResponse('unauthenticated you try to modify another user you do not have permission ' , 404);
        $seller = Seller::findOrFail($id);
        $this->validate($request , $rules);
        $data = $request->all();
        $seller->update($data);

        return $this->showOne($seller ,202);


    }
    public function me()
    {
        $user = auth()->user();
        return $this->showOne($user , 200);
    }

    private function assurence()
    {
        return PersonalAccessToken::where( 'name' ,'LIKE', auth()->user()->name )->
        Where('tokenable_id','LIKE',auth()->user()->id )->
        where('tokenable_type' , 'App\Models\Seller')->
        get();

    }

    public function changeStatus(Request  $request)
    {
        $rules = [
            'online' => 'required|in:0,1'
        ];
        $this->validate($request ,$rules);
       // $seller = Seller::findOrFail($id);

        $seller = auth()->user();
        $seller->update([
            'online' => $request->online
        ]);
        return $this->showOne($seller);

    }
}

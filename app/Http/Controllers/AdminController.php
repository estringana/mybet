<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Jobs\DeleteCoupon;

class AdminController extends Controller
{
    public function listsUsers()
    {
         $coupons = $this->championship->coupons;

         return view('admin.users')
                ->with(['coupons'=>$coupons]);
    }

    protected function getCouponFromUserId($user_id)
    {
           return $this->championship->coupons()->where('user_id',$user_id)->firstOrFail();
    }

    protected function getUserFromId($user_id)
    {
           return $this->getCouponFromUserId($user_id)->user;
    }    

    public function editUser($user_id)
    {
            $user = $this->getUserFromId($user_id);

             return view('admin.users.edit')
                ->with(['user' => $user]);
    }

    protected function logAction($user)
    {
           \Log::info(
                sprintf(
                    'User %s(%s) has been saved by %s with paid-%s admin-%s friend_of-%s ',
                    $user->name,
                    $user->id,
                    \Auth::user()->name,
                    $user->has_paid,
                    $user->is_admin,
                    $user->is_friend_of                    
            ));
    }

    public function saveUser(Request $request, $user_id)
    {
         $this->validate($request, [
                'paid'=> 'required|boolean',
                'admin' => 'required|boolean',
                'friend' => 'string'
            ]);

            $user = $this->getUserFromId($user_id);            

            $user->has_paid = $request->input('paid');
            $user->is_admin = $request->input('admin');
            $user->is_friend_of = $request->input('friend');

            $user->save();

            $this->logAction($user);

            alert()->success('User have been saved', 'Saved');
            
            return redirect('/users/list');
    }

    public function deleteCoupon($coupon_id)
    {
           $couponsToDelete = [3, 4, 5, 6, 7, 8, 10, 26, 47, 56, 89];
           if ( in_array($coupon_id, $couponsToDelete))
           {
                   $deleteCouponAction = new DeleteCoupon();
                   $deleteCouponAction->handle($this->championship, $coupon_id);

                   alert()->success('Coupon have been deleted', 'Deleted');
            }
            else
            {
                alert()->Error('Coupon has not been marked to be deleted', 'Deleted');
            }
            
            return redirect('/users/list');
    }
}

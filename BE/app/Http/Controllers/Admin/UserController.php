<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Province;
use App\Models\District;
use App\Models\Commune;
use App\Jobs\SendEmailUser;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Services\ImageService;
use config\constants;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * @var ImageService
     */
    protected $upload;

    /**
     * Instantiate a new controller instance.
     * @param \App\Services\ImageService $upload
     * @return void
     */
    public function __construct(ImageService $upload)
    {
        $this->getAlert();
        $this->upload = $upload;
    }
    /**
     * Show the form for creating a new resource.
     * Get page create user from admin.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $provinces = $this->getProvinces();
        return view('admin.category.create', compact('provinces'));
    }
    //For fetching all countries
    public function getProvinces()
    {
        $provinces = Province::select('id', 'name')
            ->get();
        return $provinces;
    }

    //For fetching states
    public function getDistricts($id)
    {
        $districts = District::select('id', 'name', 'province_id')
            ->where("province_id", $id)
            ->get();
        return response()->json($districts);
    }

    //For fetching cities
    public function getCommunes($id)
    {
        $communes = Commune::select('id', 'name', 'district_id')
            ->where("district_id", $id)
            ->get();
        return response()->json($communes);
    }
    /**
     * Store a new user.
     *
     * @param  \App\Http\Requests\Admin\CreateUserRequest  $CreateUserRequest
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $CreateUserRequest)
    {
        DB::beginTransaction();
        try {
            $path = $this->upload->uploadImage($CreateUserRequest->avatar, 'user');
            $user = new User;
            $user->email = $CreateUserRequest->email;
            $user->user_name = $CreateUserRequest->user_name;
            $user->birthday = $CreateUserRequest->birthday;
            $user->first_name = $CreateUserRequest->first_name;
            $user->last_name = $CreateUserRequest->last_name;
            $user->password = Hash::make($CreateUserRequest->password);
            $user->reset_password = Hash::make($CreateUserRequest->password);
            $user->status = $CreateUserRequest->status;
            $user->address = $CreateUserRequest->address;
            $user->province_id = $CreateUserRequest->province;
            $user->district_id = $CreateUserRequest->district;
            $user->commune_id = $CreateUserRequest->commune;
            $user->avatar = $path->getPathName();
            $message = [
                'type' => 'Create user',
                'user' => $CreateUserRequest->user_name,
                'email' => $CreateUserRequest->email,
                'content' => 'has been Created!',
            ];
            SendEmailUser::dispatch($message);
            $user->save();
            DB::commit();
            return redirect()->route('home')->withSuccessMessage('Thêm user thành công');
        } catch (Exception $e) {
            DB::rollback();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $provinces = $this->getProvinces();
        // $user = User::where('flag_delete', config('constants.FLAG_DELETE'))
        //     ->findOrFail($id);
        $user = User::select('users.id', 'users.email', 'users.user_name', 'users.avatar', 'users.first_name', 'users.last_name', 'users.status', 'users.password', 'users.birthday', 'users.address', 'users.province_id', 'users.district_id', 'users.commune_id', 'commune.name as commune_name', 'district.name as district_name', 'province.name as province_name')
            ->where('users.id', $id)
            ->leftJoin('communes as commune', 'users.commune_id', '=', 'commune.id')
            ->leftJoin('districts as district', 'users.district_id', '=', 'district.id')
            ->leftJoin('provinces as province', 'users.province_id', '=', 'province.id')
            ->where('flag_delete', config('constants.FLAG_DELETE'))
            ->first();

        if ($user) {
            return view('admin.category.edit', compact('user', 'provinces'));
        } else {
            return view('admin.category.edit', ['error' => 'Không tìm thấy user']);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateUserRequest  $UpdateUserRequest
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $UpdateUserRequest, $id)
    {
        DB::beginTransaction();
        $path = $this->upload->uploadImage($UpdateUserRequest->avatar, 'user');
        try {
            $user = User::where('id', $id)
                ->where('flag_delete', config('constants.FLAG_DELETE'))
                ->first();
            if (File::exists($user->avatar) && isset($path)) {
                unlink($user->avatar);
            }
            $user->email = $UpdateUserRequest->email;
            $user->user_name = $UpdateUserRequest->user_name;
            $user->birthday = $UpdateUserRequest->birthday;
            $user->first_name = $UpdateUserRequest->first_name;
            $user->last_name = $UpdateUserRequest->last_name;
            $user->status = $UpdateUserRequest->status;
            $user->address = $UpdateUserRequest->address;
            $user->province_id = $UpdateUserRequest->province;
            $user->district_id = $UpdateUserRequest->district;
            $user->commune_id = $UpdateUserRequest->commune;
            $user->avatar =  isset($path) ? $path->getPathName() : $user->avatar;
            $message = [
                'type' => 'Update user',
                'user' => $UpdateUserRequest->user_name,
                'email' => $UpdateUserRequest->email,
                'content' => 'has been Updated!',
            ];
            SendEmailUser::dispatch($message);
            $user->save();
            DB::commit();
            return redirect('admin/')->withSuccessMessage('Sửa thông tin user thành công');
        } catch (Exception $e) {
            DB::rollback();
            return view('admin.category.edit', ['error' => 'Không tìm thấy user']);
        }
    }
    /**
     * Delete user.
     *
     * @param   int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $user->update([
                'flag_delete' => config('constants.FLAG_DELETED'),
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'text' => 'Đã xóa!',
                'message' => 'Xóa thành công!',
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Xóa thất bại! ' . $e->getMessage(),
            ]);
        }
    }
}

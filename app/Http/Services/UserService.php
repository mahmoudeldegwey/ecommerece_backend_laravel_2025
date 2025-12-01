<?php 
namespace App\Http\Services;

use App\Repositories\Interfaces\UserInterFace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Filters\Users\{SuperUserFilter,UserEmailFilter,UserNameFilter};
use Illuminate\Pipeline\Pipeline;
use App\Traits\ResponsesTrait;

class UserService {

    use ResponsesTrait;
    
    public function __construct(private UserInterFace $userInterFace)
    {

    }

    public function index(Request $request){
        
        try {
            
            $paginate = $request->paginate ?? 10;

            $query = $this->userInterFace->getModel()->where('super_user',0);

            $data = app(Pipeline::class)
            ->send($query)
            ->through([
                SuperUserFilter::class,
                UserEmailFilter::class,
                UserNameFilter::class
            ])->thenReturn()->paginate($paginate);

        } catch (\Exception $e) {
           return $this->makeResponseErrors($e->getMessage());
        }

        return UserResource::collection($data);
    }

    public function store(Request $request){
        try{
            
            $data = $request->except('password_confirmation');

            $data['password'] = Hash::make($request->password);

            $user = $this->userInterFace->create($data);

        }catch(\Exception $e){
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    public function show(User $user){
        try {
        
            $user = $this->userInterFace->findById($user->id);   
        
        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return new UserResource($user);
    }

    public function update(User $user,Request $request)
    {
        try{

            $user = $this->userInterFace->update(['id' => $user->id],$request->all());

        }catch(\Exception $e){
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    public function updatePassword(User $user,Request $request)
    {
        try{
            
            $request['password'] = Hash::make($request->password);
            
            $user = $this->userInterFace->update(['id' => $user->id],[
                'password' => $request->password,
            ]);

        }catch(\Exception $e){
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();        
    }

    public function destroy(User $user)
    {
        try {
            
            $user->delete();

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage()); 
        }
        
        return $this->makeResponseSuccessful();
    }

}

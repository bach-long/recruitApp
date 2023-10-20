<?php

namespace App\Repositories\Company;

use App\Models\Activation;
use App\Models\User;
use App\Repositories\EloquentRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CompanyEloquentRepository extends EloquentRepository implements CompanyRepositoryInterface
{
    /**
     * get model
     *
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Company::class;
    }

    public function getDetail(Request $request)
    {
        $task = $this->_model
            ->withCount('managedHrs')
            ->with('managedHrs', function ($query) {
                $query->withCount('managedTasks')->orderBy('created_at', 'DESC')->limit(3);
            })
            ->with('address')
            ->with('tasks', function ($q) {
                $q->with('category', 'hr')->limit(5);
            })
            ->withCount('tasks')
            ->find($request->id);

        //$task->tasks()->limit(2);
        return $task;

    }

    public function search(Request $request)
    {
        $data = $this->_model->where('name', 'like', '%'.$request->searchInput.'%');

        return $data
            ->with('address')
            ->with('tasks')->withCount('tasks')->orderBy('tasks_count', 'DESC')->paginate(10);
    }

    public function index()
    {
        return $this->_model
            ->with('address')
            ->with('tasks')->withCount('tasks')->orderBy('tasks_count', 'DESC')->paginate(10);
    }

    public function createCompany(Request $request)
    {
        if ($request->password != $request->repassword) {
            throw new Exception('password not match');
        }
        $check = $this->_model->where(DB::raw('BINARY `email`'), $request->email)->orWhere(DB::raw('BINARY `tax_code`'), $request->tax_code)->exists();
        if (! $check) {
            if (Http::get('https://api.vietqr.io/v2/business/'.$request->tax_code)['data']) {
                $temp = Arr::except($request->all(), ['image']);
                $data = $this->_model->create($temp);
                $token = hash_hmac('sha256', Str::random(40), config('app.key'));
                $data['token'] = $token;
                $data['fullname'] = $data['name'];
                Activation::create([
                    'user_id' => $data->id,
                    'token' => $token,
                ]);

                return $data;
            } else {
                throw new Exception('taxcode invalid');
            }
        } else {
            throw new Exception('your email or taxcode already taken');
        }
    }

    public function hrOfCompany(Request $request)
    {
        $company = $request->user();
        if ($company) {
            $data = $company->managedHrs()->with('birthYear')->withCount('managedTasks')->orderBy('created_at', 'DESC')->paginate(10);
            if ($data) {
                return $data;
            } else {
                throw new Exception('can not find hrs of this company');
            }
        } else {
            return null;
        }
    }

    public function editCompany(Request $request)
    {
        $company = $this->_model->find($request->id);
        if ($company) {
            $temp = Arr::except($request->all(), ['image']);
            $data = $company->update($temp);

            return $data;
        } else {
            return null;
        }

    }

    public function acceptHr(Request $request)
    {
        $hr = User::find($request->hr_id);
        $company = $this->find($request->user()->id);
        if (! $company || ! $hr || ! $hr->company_id === $company->id) {
            return null;
        }
        if ($request->action == 'accept') {
            $data = $hr->update(['hraccepted' => 2]);
            if ($data) {
                return ['message' => 'hr accepted'];
            } else {
                return null;
            }
        } elseif ($request->action == 'reject') {
            $hr->delete();

            return ['message' => 'hr rejected'];
        }
    }
}

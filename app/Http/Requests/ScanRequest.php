<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ScanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(!Auth::check()){
            return false;
        }

        // $limitterKey = 'scan_freshness: ' . Auth::user()->id;
        // $tooManyAttemptKey = 'scan_freshness_too_many_attempts_count: ' . Auth::user()->id;
        // $tooManyAttemptCount = Cache::get($tooManyAttemptKey) ?: 0;
        // $minutes = ($tooManyAttemptCount == 0)? 1 : 10 * $tooManyAttemptCount ;
        // $seconds = 60 * (1);
        
        // if(RateLimiter::tooManyAttempts($limitterKey, 10)){
        //     Cache::put($tooManyAttemptKey, ++$tooManyAttemptCount, $seconds); 
        //     abort(response()->json([
        //         'status' => 'fail',
        //         'message' => 'Terlalu banyak percobaan, coba lagi dalam' . RateLimiter::availableIn($limitterKey)
        //     ], 400));
        // };
        // RateLimiter::increment($limitterKey, $seconds);

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:10240'],
            'smell' => ['required', Rule::in(['fresh', 'neutral', 'rotten'])],
            'texture' => ['required', Rule::in(['hard', 'normal', 'soft'])],
            'verified_store' => ['required', 'boolean'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'fail',
            'message' => $validator->errors()->first(),
            'errors' => $validator->errors()
        ], 400));
    }
}

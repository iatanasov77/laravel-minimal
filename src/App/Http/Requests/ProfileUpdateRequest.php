<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * @brief   Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'item.image'        => 'mimes:jpeg,jpg,png|max:1000000',
            'item.name'         => 'required|alpha',
            'item.last_name'    => 'required|alpha',
            
            'item.email'        => 'required|email',
            'item.password'     => 'between:3,50',
            'password_confirm'  => 'same:item.password'
        ];
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Http\FormRequest::messages()
     */
    public function messages()
    {
        return [
            'item.image.required'       => 'The image should be jpeg,jpg,png with max size 1000 Kb',
            'item.image.mimes'          => 'The image should be jpeg,jpg,png with max size 1000 Kb',
            'item.image.max'            => 'The image should be jpeg,jpg,png with max size 1000 Kb',
            
            'item.name.required'        => 'The first name must be entirely alphabetic characters.',
            'item.name.alpha'           => 'The first name must be entirely alphabetic characters.',
            
            'item.last_name.required'   => 'The last name must be entirely alphabetic characters.',
            'item.last_name.alpha'      => 'The last name must be entirely alphabetic characters.',
            
            'item.email.required'       => 'The email is not valid',
            'item.email.email'          => 'The email is not valid',
            
            
            'item.password.required'    => 'The password is required to be between the 3 and 50 signs',
            'item.password.between'     => 'The password is required to be between the 3 and 50 signs',
            
            'password_confirm.required' => 'Password confirmation failed',
            'password_confirm.same'     => 'Password confirmation failed'
        ];
    }
    
    /**
     * @brief   Determine if the user is authorized to make this request.
     *
     * @return  bool
     */
    public function authorize()
    {
        return true;
    }
}

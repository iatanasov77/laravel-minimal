<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @brief Registration form validation rules and error messages
 */
class RegistrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'item.image'        => 'required|mimes:jpeg,jpg,png|max:1024',	// Max 1 Mb
            'item.name'         => 'required|alpha',
            'item.last_name'    => 'required|alpha',
            
            'item.email'        => 'required|email',
            'item.password'     => 'required|between:3,50',
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
            'item.image.required'       => 'The image should be jpeg,jpg,png with max size 1 MB',
            'item.image.mimes'          => 'The image should be jpeg,jpg,png with max size 1 MB',
            'item.image.max'            => 'The image should be jpeg,jpg,png with max size 1 MB',
            
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
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}

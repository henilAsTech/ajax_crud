<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $unique = $user = null;
        if ($this->user_id) {
            $user = User::find($this->user_id);
            $unique = $user ? Rule::unique(User::class)->ignore($user->id) : Rule::unique(User::class);    
        }       

        return [
            'user_id' => ['nullable'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:200', $unique],
            'phone' => ['required', 'min:10'],
            'gender' => ['required', 'string'],
            'image' => $user ? ['nullable'] : ['required', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'file' => $user ? ['nullable'] : ['required', 'mimes:pdf,docx,xls,csv', 'max:5120']
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $data = parent::validated($key = null, $default = null);
        if ($this->hasFile('image')) {
            $data['image'] = fileUploader($this->image, 'images');
        } else {
            unset($data['image']);
        }
        if ($this->hasFile('file')) {
            $data['file'] = fileUploader($this->file, 'files');
        } else {
            unset($data['file']);
        }
        return $data;
    }
}

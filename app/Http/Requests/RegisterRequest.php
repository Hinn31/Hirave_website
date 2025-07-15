<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Xác nhận rằng request này được phép sử dụng.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Các luật kiểm tra dữ liệu đầu vào.
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string|max:50',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    /**
     * Thông báo lỗi tùy chỉnh.
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Vui lòng nhập tên người dùng.',
            'email.required'    => 'Vui lòng nhập email.',
            'email.email'       => 'Email không hợp lệ.',
            'email.unique'      => 'Email đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min'      => 'Mật khẩu tối thiểu 6 ký tự.',
            'password.confirmed'=> 'Mật khẩu xác nhận không khớp.',
        ];
    }
}

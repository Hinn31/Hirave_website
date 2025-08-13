<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Hiển thị danh sách tất cả liên hệ
     */
    public function index()
    {
        $contacts = Contact::all();

        return response()->json([
            'success' => true,
            'data' => $contacts
        ]);
    }

    /**
     * Lưu liên hệ mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'message'      => 'required|string',
        ]);

        $contact = Contact::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
            'data' => $contact
        ]);
    }

    /**
     * Hiển thị chi tiết liên hệ theo ID
     */
    public function show(string $id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Contact not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $contact
        ]);
    }

    /**
     * Cập nhật thông tin liên hệ theo ID
     */
    public function update(Request $request, string $id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Contact not found'
            ], 404);
        }

        $request->validate([
            'first_name'   => 'sometimes|required|string|max:255',
            'last_name'    => 'sometimes|required|string|max:255',
            'email'        => 'sometimes|required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'message'      => 'sometimes|required|string',
        ]);

        $contact->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Contact updated successfully',
            'data' => $contact
        ]);
    }

    /**
     * Xóa liên hệ theo ID
     */
    public function destroy(string $id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Contact not found'
            ], 404);
        }

        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contact deleted successfully'
        ]);
    }
}

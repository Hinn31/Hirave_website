<div class="w-60 h-screen bg-gray-900 text-white flex flex-col">
    <a href="{{ route('dashboard') }}" 
       class="p-4 hover:bg-gray-700 border-b border-gray-600 {{ request()->routeIs('dashboard') ? 'bg-gray-800' : '' }}">
        DashBoard
    </a>

    <a href="{{ route('products.index') }}" 
       class="p-4 hover:bg-gray-700 border-b border-gray-600 {{ request()->routeIs('products.*') ? 'bg-gray-800' : '' }}">
        Product Management
    </a>

    <a href="{{ route('users.index') }}" 
       class="p-4 hover:bg-gray-700 border-b border-gray-600 {{ request()->routeIs('users.*') ? 'bg-gray-800' : '' }}">
        User management
    </a>

    <a href="{{ route('orders.index') }}" 
       class="p-4 hover:bg-gray-700 border-b border-gray-600 {{ request()->routeIs('orders.*') ? 'bg-gray-800' : '' }}">
        Order management
    </a>

    <a href="{{ route('messages.index') }}" 
       class="p-4 hover:bg-gray-700 border-b border-gray-600 {{ request()->routeIs('messages.*') ? 'bg-blue-600' : '' }}">
        Message management
    </a>
</div>

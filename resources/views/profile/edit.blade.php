@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.user')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Pengaturan Akun</h1>
    <p class="text-gray-600 text-sm">Ubah informasi profil pribadi dan kata sandi Anda.</p>
</div>

<div class="space-y-6 pb-6">
    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-sm border border-gray-100">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-sm border border-gray-100">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-sm border border-gray-100">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection

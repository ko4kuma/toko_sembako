<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StokOpname;

class StokOpnamePolicy
{
    // BOLEH LIHAT (dipakai buat filter index & buka halaman isi)
    public function view(User $user, StokOpname $stokOpname): bool
    {
        return $user->role === 'admin' || $stokOpname->user_id === $user->id;
    }

    // BOLEH EDIT/ISI DATA (cuma pemilik sendiri, saat masih draft)
    public function edit(User $user, StokOpname $stokOpname): bool
    {
        return $stokOpname->user_id === $user->id
            && $stokOpname->status === 'draft';
    }

    // BOLEH AJUKAN (cuma pemilik sendiri, saat masih draft)
    public function ajukan(User $user, StokOpname $stokOpname): bool
    {
        return $stokOpname->user_id === $user->id
            && $stokOpname->status === 'draft';
    }

    // BOLEH HAPUS (cuma pemilik sendiri, saat masih draft)
    public function delete(User $user, StokOpname $stokOpname): bool
    {
        return $stokOpname->user_id === $user->id
            && $stokOpname->status === 'draft';
    }

    // BOLEH APPROVE/REJECT (cuma admin, BUKAN punya sendiri, saat menunggu_approval)
    public function approve(User $user, StokOpname $stokOpname): bool
    {
        return $user->role === 'admin'
            && $stokOpname->user_id !== $user->id
            && $stokOpname->status === 'menunggu_approval';
    }
}
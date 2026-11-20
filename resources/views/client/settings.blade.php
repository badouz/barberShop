@extends('layouts.client')

@section('title', 'Settings — CHAIR')

@push('styles')
<style>
    .settings-page-wrap {
        padding: 24px 0 60px;
        display: flex;
        justify-content: center;
    }
    .settings-container {
        width: 100%;
        max-width: 580px;
    }

    .settings-title {
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        margin-bottom: 24px;
    }

    /* Profile Card */
    .profile-card {
        background: #ffffff;
        border-radius: var(--radius-card);
        padding: 22px;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 28px;
    }
    .profile-avatar-large {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    .profile-info {
        flex: 1;
        min-width: 0;
    }
    .profile-name {
        font-size: 1.25rem;
        font-weight: 800;
        margin-bottom: 2px;
    }
    .profile-email {
        font-size: 0.88rem;
        color: var(--text-slate);
        margin-bottom: 4px;
    }
    .profile-member-since {
        font-size: 0.78rem;
        color: var(--primary-blue);
        font-weight: 600;
    }

    /* Settings Group */
    .settings-group {
        margin-bottom: 24px;
    }
    .group-label {
        font-size: 0.75rem;
        font-weight: 800;
        color: var(--text-muted);
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 10px;
        padding-left: 6px;
    }
    .settings-list {
        background: #ffffff;
        border-radius: var(--radius-card);
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }
    .settings-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px;
        border-bottom: 1px solid var(--border-light);
        text-decoration: none;
        color: inherit;
        transition: background 0.15s ease;
    }
    .settings-item:last-child {
        border-bottom: none;
    }
    .settings-item:hover {
        background: #f8fafc;
    }
    .item-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .item-icon {
        width: 22px;
        height: 22px;
        color: var(--text-slate);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .item-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-navy);
    }
    .item-right {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-slate);
        font-size: 0.88rem;
    }

    /* Toggle switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: .3s;
        border-radius: 24px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: var(--primary-blue);
    }
    input:checked + .slider:before {
        transform: translateX(20px);
    }

    /* Edit profile modal / accordion */
    .edit-profile-card {
        display: none;
        background: #ffffff;
        border-radius: var(--radius-card);
        padding: 20px;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
        margin-bottom: 24px;
    }
    .edit-profile-card.active {
        display: block;
    }

    /* Logout button */
    .btn-logout {
        width: 100%;
        padding: 14px;
        border-radius: var(--radius-pill);
        border: 1px solid #fecaca;
        background: #fff;
        color: var(--danger-red);
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .btn-logout:hover {
        background: var(--danger-light);
    }
</style>
@endpush

@section('content')
<div class="chair-container settings-page-wrap">
    <div class="settings-container">
        <h1 class="settings-title">Settings</h1>

        <!-- Profile Card -->
        <div class="profile-card">
            <img class="profile-avatar-large"
                 src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=160&h=160&fit=crop&crop=faces"
                 alt="{{ $user->name }}">
            <div class="profile-info">
                <div class="profile-name">{{ $user->name }}</div>
                <div class="profile-email">{{ $user->email }}</div>
                <div class="profile-member-since">Member since {{ $user->created_at ? $user->created_at->format('F Y') : 'October 2026' }}</div>
            </div>
        </div>

        <!-- Edit Profile Section (Collapsible) -->
        <div id="edit-profile-box" class="edit-profile-card">
            <h3 style="font-size:1.05rem; font-weight:800; margin-bottom:14px;">Edit Profile Information</h3>
            <form action="{{ route('client.settings.update') }}" method="POST">
                @csrf
                @method('PATCH')
                <div style="margin-bottom:12px;">
                    <label style="display:block; font-size:0.82rem; font-weight:700; color:var(--text-slate); margin-bottom:4px;">Full Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" required
                           style="width:100%; padding:10px 14px; border-radius:12px; border:1px solid var(--border-subtle); font-size:0.95rem;">
                </div>
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:0.82rem; font-weight:700; color:var(--text-slate); margin-bottom:4px;">Email Address</label>
                    <input type="email" name="email" value="{{ $user->email }}" required
                           style="width:100%; padding:10px 14px; border-radius:12px; border:1px solid var(--border-subtle); font-size:0.95rem;">
                </div>
                <div style="display:flex; gap:10px;">
                    <button type="submit" class="chair-btn-primary" style="flex:1; padding:10px;">Save Changes</button>
                    <button type="button" class="chair-btn-secondary" style="padding:10px 20px;" onclick="toggleEditProfile(false)">Cancel</button>
                </div>
            </form>
        </div>

        <!-- ACCOUNT -->
        <div class="settings-group">
            <div class="group-label">ACCOUNT</div>
            <div class="settings-list">
                <div class="settings-item" style="cursor:pointer;" onclick="toggleEditProfile(true)">
                    <div class="item-left">
                        <div class="item-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </div>
                        <span class="item-name">Edit information</span>
                    </div>
                    <div class="item-right">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </div>

                <div class="settings-item">
                    <div class="item-left">
                        <div class="item-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                        </div>
                        <span class="item-name">Language</span>
                    </div>
                    <div class="item-right">
                        <span>English (US)</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- PREFERENCES -->
        <div class="settings-group">
            <div class="group-label">PREFERENCES</div>
            <div class="settings-list">
                <div class="settings-item">
                    <div class="item-left">
                        <div class="item-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        </div>
                        <span class="item-name">Notifications</span>
                    </div>
                    <div class="item-right">
                        <label class="switch" aria-label="Toggle notifications">
                            <input type="checkbox" id="pref_notifications" checked onchange="savePref('pref_notifications', this.checked)">
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>

                <div class="settings-item">
                    <div class="item-left">
                        <div class="item-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                        </div>
                        <span class="item-name">Dark mode</span>
                    </div>
                    <div class="item-right">
                        <label class="switch" aria-label="Toggle dark mode">
                            <input type="checkbox" id="pref_dark_mode" onchange="savePref('pref_dark_mode', this.checked)">
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- MORE -->
        <div class="settings-group">
            <div class="group-label">MORE</div>
            <div class="settings-list">
                <a href="#" class="settings-item" onclick="alert('Privacy & security details'); return false;">
                    <div class="item-left">
                        <div class="item-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </div>
                        <span class="item-name">Privacy & security</span>
                    </div>
                    <div class="item-right">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>

                <a href="#" class="settings-item" onclick="alert('Customer support: support@chairapp.com'); return false;">
                    <div class="item-left">
                        <div class="item-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        </div>
                        <span class="item-name">Help & support</span>
                    </div>
                    <div class="item-right">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
            </div>
        </div>

        <!-- Logout Form -->
        <form action="{{ route('logout') }}" method="POST" style="margin-top:32px;">
            @csrf
            <button type="submit" class="btn-logout">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                <span>Log out</span>
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleEditProfile(show) {
        const box = document.getElementById('edit-profile-box');
        if (box) {
            box.classList.toggle('active', show);
            if (show) box.scrollIntoView({ behavior: 'smooth' });
        }
    }

    function savePref(key, val) {
        localStorage.setItem(key, val);
    }

    document.addEventListener('DOMContentLoaded', () => {
        ['pref_notifications', 'pref_dark_mode'].forEach(key => {
            const el = document.getElementById(key);
            const saved = localStorage.getItem(key);
            if (el && saved !== null) {
                el.checked = (saved === 'true');
            }
        });
    });
</script>
@endpush

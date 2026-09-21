@extends('admin.layouts.app')

@section('title', 'Users Management')
@section('page_title', 'Users Management')
@section('page_subtitle', 'Manage pet owners, veterinary doctors, shelter managers, and system administrators.')

@section('content')
<div class="crud-toolbar">
    <div class="filter-pills">
        <a href="{{ route('admin.users.index') }}" class="filter-pill-link {{ !request('role') ? 'active' : '' }}">
            All ({{ $rolesCount['all'] }})
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'owner']) }}" class="filter-pill-link {{ request('role') === 'owner' ? 'active' : '' }}">
            Pet Owners ({{ $rolesCount['owner'] }})
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'vet']) }}" class="filter-pill-link {{ request('role') === 'vet' ? 'active' : '' }}">
            Veterinarians ({{ $rolesCount['vet'] }})
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'shelter']) }}" class="filter-pill-link {{ request('role') === 'shelter' ? 'active' : '' }}">
            Shelters ({{ $rolesCount['shelter'] }})
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="filter-pill-link {{ request('role') === 'admin' ? 'active' : '' }}">
            Admins ({{ $rolesCount['admin'] }})
        </a>
    </div>

    <div class="toolbar-actions">
        <form method="GET" action="{{ route('admin.users.index') }}" class="toolbar-search">
            @if(request('role'))
                <input type="hidden" name="role" value="{{ request('role') }}">
            @endif
            <input type="text" name="search" class="form-control" placeholder="Search by name, email or phone..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary btn-sm">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.users.index', request()->only('role')) }}" class="btn btn-outline btn-sm">Clear</a>
            @endif
        </form>

        <button type="button" class="btn btn-primary" onclick="openModal('createUserModal')">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add New User
        </button>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="user-info-cell">
                                <div class="user-avatar-sm">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div class="user-info-meta">
                                    <strong>{{ $user->name }}</strong>
                                    <small>{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge badge-purple"><span class="badge-dot"></span> Admin</span>
                            @elseif($user->role === 'vet')
                                <span class="badge badge-info"><span class="badge-dot"></span> Veterinarian</span>
                            @elseif($user->role === 'shelter')
                                <span class="badge badge-warning"><span class="badge-dot"></span> Shelter Staff</span>
                            @else
                                <span class="badge badge-teal"><span class="badge-dot"></span> Pet Owner</span>
                            @endif
                        </td>
                        <td>
                            <div style="font-size: 12px; color: #475569;">
                                <div>{{ $user->phone ?? '—' }}</div>
                                <small style="color: #94a3b8;">{{ $user->address ? \Illuminate\Support\Str::limit($user->address, 25) : 'No address' }}</small>
                            </div>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.users.toggle', $user) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }}" style="border: none; cursor: pointer;" title="Click to toggle status">
                                    <span class="badge-dot"></span> {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td style="color: #64748b; font-size: 11.5px;">
                            {{ $user->created_at ? $user->created_at->format('M d, Y') : '—' }}
                        </td>
                        <td style="text-align: right;">
                            <div class="action-buttons">
                                <button type="button" class="btn btn-secondary btn-sm" onclick='editUser(@json($user))' title="Edit User">
                                    Edit
                                </button>
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to delete {{ $user->name }}?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete User">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <span class="empty-state-icon">👥</span>
                                <h4>No users found</h4>
                                <p>Try adjusting your search criteria or register a new user.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid var(--border);">
            {{ $users->links() }}
        </div>
    @endif
</div>

<!-- Create User Modal -->
<div class="modal-overlay" id="createUserModal">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <span class="modal-tag">Identity & Access</span>
                <h3>Add New User</h3>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeModal('createUserModal')" aria-label="Close modal">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="name" class="form-control" required placeholder="e.g. John Doe">
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email" class="form-control" required placeholder="john@example.com">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Role *</label>
                        <select name="role" class="form-select" required>
                            <option value="owner">Pet Owner</option>
                            <option value="vet">Veterinarian</option>
                            <option value="shelter">Shelter Staff</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Temporary Password *</label>
                        <input type="password" name="password" class="form-control" required placeholder="Min 6 characters">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" placeholder="+1 (555) 000-0000">
                </div>
                <div class="form-group">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" placeholder="123 Street, City, State">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('createUserModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Create User</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal-overlay" id="editUserModal">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <span class="modal-tag">Account Management</span>
                <h3>Edit User Profile</h3>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeModal('editUserModal')" aria-label="Close modal">&times;</button>
        </div>
        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="name" id="edit_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email" id="edit_email" class="form-control" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Role *</label>
                        <select name="role" id="edit_role" class="form-select" required>
                            <option value="owner">Pet Owner</option>
                            <option value="vet">Veterinarian</option>
                            <option value="shelter">Shelter Staff</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">New Password (leave blank to keep)</label>
                        <input type="password" name="password" class="form-control" placeholder="Optional">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" id="edit_phone" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" id="edit_address" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-checkbox-label">
                        <input type="checkbox" name="is_active" id="edit_is_active" value="1">
                        <span>Account is active</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editUserModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).classList.add('active');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('active');
}
function editUser(user) {
    document.getElementById('editUserForm').action = '/admin/users/' + user.id;
    document.getElementById('edit_name').value = user.name || '';
    document.getElementById('edit_email').value = user.email || '';
    document.getElementById('edit_role').value = user.role || 'owner';
    document.getElementById('edit_phone').value = user.phone || '';
    document.getElementById('edit_address').value = user.address || '';
    document.getElementById('edit_is_active').checked = !!user.is_active;
    openModal('editUserModal');
}
// Close modals on overlay click
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            overlay.classList.remove('active');
        }
    });
});
</script>
@endsection

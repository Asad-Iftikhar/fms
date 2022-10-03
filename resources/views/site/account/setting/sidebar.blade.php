<ul class="nav nav-pills">
    <li class="nav-item active">
        <a @class(["nav-link", "active" => \Request::is('account/setting/profile')]) href="{{ url('account/setting/profile') }}">My Profile</a>
    </li>
    <li class="nav-item">
        <a @class(["nav-link", "active" => \Request::is('account/setting/avatar')]) href="{{ url('account/setting/avatar') }}">Change Avatar</a>
    </li>
    <li class="nav-item">
        <a @class(["nav-link", "active" => \Request::is('account/setting/change-password')]) href="{{ url('account/setting/change-password') }}">Change Password</a>
    </li>
</ul>
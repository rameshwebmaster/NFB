<!-- Left navbar-header -->
<div class="sidebar" role="navigation">
    <div class="wp-sidebar-nav">
        <div class="user-profile">
            <div class="dropdown user-pro-body">
                <div><img src="/uploads/avatars/{{ $currentUser->avatar ?? 'default.jpg'}}" alt="user-img"
                          class="img-circle"></div>
                <a href="javascript:void(0)" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button"
                   aria-haspopup="true"
                   aria-expanded="false">{{ $currentUser->first_name }} {{ $currentUser->last_name }}<span
                            class="caret"></span></a>
                <ul class="dropdown-menu animated flipInY">
                    <li><a href="{{ route('profile', ['user' => $currentUser->id]) }}"><i class="ti-user"></i> My
                            Profile</a></li>
                    @if($currentUser->isSeller)
                        <li><a href="{{ route('referredByUser', ['user' => $currentUser->id]) }}"><i class="ti-user"></i> Referred Users</a></li>
                    @endif
                    <li role="separator" class="divider"></li>
                    <li>
                        <a href="/logout"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-power-off"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>

                </ul>
            </div>
        </div>
        <ul class="wp-side-menu">
            <li><a href="{{ route('dashboard') }}" class=""><i class="ti-dashboard"></i> <span
                            class="hide-menu"> Dashboard </span></a>
            </li>


            @if($currentUser->can('viewMenu', \App\User::class))
                <li><a href="javascript:void(0)"><i class=ti-user></i> <span
                                class="hide-menu">Users<span class="ti-angle-right arrow"></span></span>

                    </a>
                    <ul class="nav-second-level">
                        @if($currentUser->can('viewPanelUsersMenu', \App\User::class))
                            <li><a href="{{ route('panelUsers') }}">Panel Users</a></li>
                            <li><a href="{{ route('createPanelUser') }}">Create Panel User</a></li>
                            <li role="separator" class="divider"></li>
                        @endif
                        <li><a href="{{ route('appUsers') }}">App Users</a></li>
                        @if($currentUser->can('createAppUser', \App\User::class))
                            <li><a href="{{ route('createAppUser') }}">Create App User</a></li>
                            <li>
                                <a href="{{ route('appUsers') }}?new">New Users
                                    <span class="label label-rouded label-info pull-right">{{ \App\User::last24Hours()->where('role', 'consumer')->count() }}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif


            @foreach($postTypes as $pt => $ptInfo)

                @if($currentUser->can('viewMenu', \App\Post::class))
                    <li>
                        <a href="javascript:void(0)">
                            <i class="{{ $ptInfo['icon'] }}"></i>
                            <span class="hide-menu">
                        {{ $ptInfo['title'] }}
                                <span class="ti-angle-right arrow"></span>
                    </span>
                        </a>
                        <ul class="nav-second-level">
                            <li><a href="{{ route('posts', ['postType' => $pt]) }}">All {{ $ptInfo['title'] }}</a></li>
                            <li><a href="{{ route('createPost', ['postType' => $pt]) }}">Create New</a></li>
                            <li>
                                <a href="{{ route('categories', ['categoryType' => $ptInfo['category']]) }}">Categories</a>
                            </li>
                        </ul>
                    </li>
                @endif

            @endforeach


            @if($currentUser->can('viewMenu', \App\Program::class))
                <li>
                    <a href="javascript:void(0)">
                        <i class=ti-pulse></i>
                        <span class="hide-menu">
                        Programs
                        <span class="ti-angle-right arrow"></span>
                    </span>
                    </a>
                    <ul class="nav-second-level">
                        <li><a href="{{ route('programs') }}">All Programs</a></li>
                        <li><a href="{{ route('createProgram') }}">Create New Program</a></li>
                    </ul>
                </li>
            @endif


            @if($currentUser->can('viewMenu', \App\Attachment::class))
                <li>
                    <a href="javascript:void(0)">
                        <i class=ti-pulse></i>
                        <span class="hide-menu">
                        Upload Media
                        <span class="ti-angle-right arrow"></span>
                    </span>
                    </a>
                    <ul class="nav-second-level">
                        <li><a href="{{ route('media.all') }}">All Media</a></li>
                        <li><a href="{{ route('media.create') }}">Upload Media</a></li>
                    </ul>
                </li>
            @endif

            @if($currentUser->can('viewMenu', \App\Message::class))
                <li>
                    <a href="javascript:void(0)">
                        <i class=ti-pulse></i>
                        <span class="hide-menu">
                        Messages
                        <span class="ti-angle-right arrow"></span>
                    </span>
                    </a>
                    <ul class="nav-second-level">
                        <li><a href="{{ route('message', ['messageType' => 'email']) }}">Send Email</a></li>
                        <li><a href="{{ route('message', ['messageType' => 'notification']) }}">Send Notification</a>
                        </li>
                    </ul>
                </li>
            @endif


            @if($currentUser->can('viewMenu', \App\Activity::class))
                <li>
                    <a href="{{ route('activities') }}">
                        <i class=ti-video-camera></i>
                        <span class="hide-menu">Activity Logs</span>
                    </a>
                </li>
            @endif


            @if($currentUser->can('viewMenu', \App\Stream::class))
                <li>
                    <a href="{{ route('liveStream') }}">
                        <i class=ti-video-camera></i>
                        <span class="hide-menu">Live Stream</span>
                    </a>
                </li>
            @endif

            @if($currentUser->can('viewMenu', \App\Transaction::class))
                <li>
                    <a href="javascript:void(0)">
                        <i class=ti-pulse></i>
                        <span class="hide-menu">
                            Transactions
                            <span class="ti-angle-right arrow"></span>
                        </span>
                    </a>
                    <ul class="nav-second-level">
                        <li><a href="{{ route('transactions') }}">All Transaction</a></li>
                        <li><a href="{{ route('createTransaction') }}">Add Transaction</a></li>
                        <li><a href="{{ route('reportTransaction') }}">Reports</a></li>
                    </ul>
                </li>
            @endif

            @if($currentUser->can('viewMenu', \App\Feedback::class))
                <li>
                    <a href="{{ route('feedback') }}">
                        <i class=ti-video-camera></i>
                        <span class="hide-menu">Feedback</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
<!-- Left navbar-header end -->
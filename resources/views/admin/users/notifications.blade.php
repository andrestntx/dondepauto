<li class="dropdown" style="vertical-align: middle;">
    <a class="dropdown-toggle count-info" id="action-notifications" data-toggle="dropdown" href="#" aria-expanded="false" style="padding: 20px 10px 5px 10px;">
        <i class="fa fa-2x fa-bell"></i>  <span class="label label-primary">{{ $actionsToday }}</span>
    </a>
    {{-- 
    <ul class="dropdown-menu dropdown-alerts" style="max-height: 400px; overflow: auto;">
        @foreach($actionsToday as $contact)
            <li>
                <a href="javascript: void(0)" data-url="{{ route('users.search', $contact->user) }}" class="notification-user">
                    <div>
                        <i class="{{ $contact->action->logo }} fa-fw"></i> 
                        <span data-toggle="tooltip" data-placemente="top" title="{{ $contact->created_at_humans }} - {{ $contact->comments }}">
                            {{ $contact->action->name }}
                        </span>
                        <span class="pull-right text-muted small">{{ $contact->action->action_at_time }}</span>
                    </div>
                </a>
            </li>
            <li class="divider"></li>
        @endforeach
    </ul>
    --}}
</li> 
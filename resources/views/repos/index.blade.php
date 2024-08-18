<ul>
    @foreach ($repos as $repo)
        <li>
            <a href="{{ route('github.show', ['owner' => $repo->owner, 'name' => $repo->name])  }}">
                {{ $repo->fullName }}
            </a>
        </li>
    @endforeach
</ul>

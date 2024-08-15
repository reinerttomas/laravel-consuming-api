<h2>{{ $repo->fullName }}</h2>

<ul>
    <li>{{ $repo->id }}</li>
    <li>{{ $repo->owner }}</li>
    <li>{{ $repo->name }}</li>
    <li>{{ $repo->fullName }}</li>
    <li>{{ $repo->private ? 'private' : 'public' }}</li>
    <li>{{ $repo->description }}</li>
    <li>{{ $repo->createdAt }}</li>
</ul>

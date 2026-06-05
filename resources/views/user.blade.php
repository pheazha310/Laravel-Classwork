<h1>List user info</h1>

@isset($id)
    <p><strong>id:</strong> {{ $id }}</p>
@endisset

@isset($username, $email)
    <p><strong>username:</strong> {{ $username }}</p>
    <p><strong>email:</strong> {{ $email }}</p>
@endisset

<table>
    <thead>
        <tr>
            <th>Test ID</th>
            <th>Test Name</th>
            <th>Standard Price</th>
            <th>Corporate Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tests as $test)
            <tr>
                <td>{{ $test->package_id }}</td>
                <td>{{ $test->name }}</td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>

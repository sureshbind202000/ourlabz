<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Role and Modules</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS (optional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5 p-4 bg-white rounded shadow-sm">
        <h4 class="mb-4">Add Role and Modules</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('backend.roles.modules.store') }}" method="POST">
            @csrf
            <pre>
            0=Super Admin
            1=User
            2=Lab User
            3=Doctor
            4=Corporate User
            5=Vendor
            </pre>
            <div class="mb-3">
                <label for="role_id" class="form-label">Role Id</label>
                <input type="number" name="role_id" class="form-control" required>
            </div>

            <div id="modules-wrapper">
                <div class="mb-3 module-group">
                    <label class="form-label">Module Name</label>
                    <input type="text" name="modules[]" class="form-control" required>
                </div>
            </div>

            <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addModuleInput()">+ Add Another
                Module</button>

            <br>
            <button type="submit" class="btn btn-primary">Save Role & Modules</button>
        </form>
    </div>

    <script>
        function addModuleInput() {
            const wrapper = document.getElementById('modules-wrapper');
            const input = document.createElement('div');
            input.classList.add('mb-3', 'module-group');
            input.innerHTML = `<input type="text" name="modules[]" class="form-control" required>`;
            wrapper.appendChild(input);
        }
    </script>
</body>

</html>

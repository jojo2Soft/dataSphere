@extends('layouts.base')

@section('content')
   <!-- ======= Breadcrumbs ======= -->
   <section id="breadcrumbs" class="breadcrumbs">
    <div class="container">

      <div class="d-flex justify-content-between align-items-center">
        <h2>API Documentation</h2>
        
      </div>

    </div>
  </section><!-- End Breadcrumbs -->
<div class="container my-5">
    
    <div class="my-4">
        <h2>Authentication</h2>
        <h3>Register</h3>
        <p><strong>Endpoint:</strong> <code>POST /api/register</code></p>
        <p><strong>Parameters:</strong></p>
        <ul>
            <li><code>name</code> (string, required)</li>
            <li><code>email</code> (string, required, unique)</li>
            <li><code>password</code> (string, required, minimum 8 characters, confirmed)</li>
        </ul>
        <p><strong>Example Request:</strong></p>
        <pre>
            <code>
POST /api/register
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password"
}
            </code>
        </pre>
        <p><strong>Example Response:</strong></p>
        <pre>
            <code>
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "token_type": "Bearer"
}
            </code>
        </pre>
        
        <h3>Login</h3>
        <p><strong>Endpoint:</strong> <code>POST /api/login</code></p>
        <p><strong>Parameters:</strong></p>
        <ul>
            <li><code>email</code> (string, required)</li>
            <li><code>password</code> (string, required)</li>
        </ul>
        <p><strong>Example Request:</strong></p>
        <pre>
            <code>
POST /api/login
{
    "email": "john@example.com",
    "password": "password"
}
            </code>
        </pre>
        <p><strong>Example Response:</strong></p>
        <pre>
            <code>
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "token_type": "Bearer"
}
            </code>
        </pre>
        
        <h3>Logout</h3>
        <p><strong>Endpoint:</strong> <code>POST /api/logout</code></p>
        <p><strong>Example Request:</strong></p>
        <pre>
            <code>
POST /api/logout
Authorization: Bearer {access_token}
            </code>
        </pre>
        <p><strong>Example Response:</strong></p>
        <pre>
            <code>
{
    "message": "Logged out successfully"
}
            </code>
        </pre>
    </div>

    <div class="my-4">
        <h2>Analyses</h2>
        <h3>Get All Analyses</h3>
        <p><strong>Endpoint:</strong> <code>GET /api/analyses</code></p>
        <p><strong>Example Request:</strong></p>
        <pre>
            <code>
GET /api/analyses
Authorization: Bearer {access_token}
            </code>
        </pre>
        <p><strong>Example Response:</strong></p>
        <pre>
            <code>
[
    {
        "id": 1,
        "name": "Analysis 1",
        "description": "Description for Analysis 1",
        "user_id": 1,
        "dataset_id": 1
    },
    {
        "id": 2,
        "name": "Analysis 2",
        "description": "Description for Analysis 2",
        "user_id": 2,
        "dataset_id": 1
    }
]
            </code>
        </pre>

        <h3>Create Analysis</h3>
        <p><strong>Endpoint:</strong> <code>POST /api/analyses</code></p>
        <p><strong>Parameters:</strong></p>
        <ul>
            <li><code>name</code> (string, required)</li>
            <li><code>description</code> (string, required)</li>
            <li><code>user_id</code> (integer, required)</li>
            <li><code>dataset_id</code> (integer, required)</li>
        </ul>
        <p><strong>Example Request:</strong></p>
        <pre>
            <code>
POST /api/analyses
Authorization: Bearer {access_token}
{
    "name": "New Analysis",
    "description": "Description for new analysis",
    "user_id": 1,
    "dataset_id": 1
}
            </code>
        </pre>
        <p><strong>Example Response:</strong></p>
        <pre>
            <code>
{
    "id": 3,
    "name": "New Analysis",
    "description": "Description for new analysis",
    "user_id": 1,
    "dataset_id": 1
}
            </code>
        </pre>
    </div>

    <div class="my-4">
        <h2>Comments</h2>
        <h3>Get All Comments for an Analysis</h3>
        <p><strong>Endpoint:</strong> <code>GET /api/analyses/{analysis_id}/comments</code></p>
        <p><strong>Example Request:</strong></p>
        <pre>
            <code>
GET /api/analyses/1/comments
Authorization: Bearer {access_token}
            </code>
        </pre>
        <p><strong>Example Response:</strong></p>
        <pre>
            <code>
[
    {
        "id": 1,
        "content": "This is a comment",
        "user_id": 1,
        "analysis_id": 1,
        "dataset_id": 1
    },
    {
        "id": 2,
        "content": "This is another comment",
        "user_id": 2,
        "analysis_id": 1,
        "dataset_id": 1
    }
]
            </code>
        </pre>

        <h3>Create Comment</h3>
        <p><strong>Endpoint:</strong> <code>POST /api/analyses/{analysis_id}/comments</code></p>
        <p><strong>Parameters:</strong></p>
        <ul>
            <li><code>content</code> (string, required)</li>
            <li><code>user_id</code> (integer, required)</li>
            <li><code>dataset_id</code> (integer, required)</li>
        </ul>
        <p><strong>Example Request:</strong></p>
        <pre>
            <code>
POST /api/analyses/1/comments
Authorization: Bearer {access_token}
{
    "content": "This is a new comment",
    "user_id": 1,
    "dataset_id": 1
}
            </code>
        </pre>
        <p><strong>Example Response:</strong></p>
        <pre>
            <code>
{
    "id": 3,
    "content": "This is a new comment",
    "user_id": 1,
    "analysis_id": 1,
    "dataset_id": 1
}
            </code>
        </pre>
    </div>

    <div class="my-4">
        <h2>Datasets</h2>
        
        <h3>Download Dataset</h3>
        <p><strong>Endpoint:</strong> <code>GET /api/datasets/{dataset_id}/download</code></p>
        <p><strong>Example Request:</strong></p>
        <pre>
            <code>
GET /api/datasets/1/download
            </code>
        </pre>
        <p><strong>Example Response:</strong></p>
        <pre>
            <code>
{
    "file_url": "https://example.com/datasets/1/download"
}
            </code>
        </pre>

        <h3>Upload Dataset</h3>
        <p><strong>Endpoint:</strong> <code>POST /api/datasets/upload</code></p>
        <p><strong>Parameters:</strong></p>
        <ul>
            <li><code>file</code> (file, required)</li>
            <li><code>name</code> (string, required)</li>
            <li><code>description</code> (string, optional)</li>
            <li><code>user_id</code> (integer, required)</li>
        </ul>
        <p><strong>Example Request:</strong></p>
        <pre>
            <code>
POST /api/datasets/upload
Authorization: Bearer {access_token}
{
    "file": "path/to/dataset.csv",
    "name": "New Dataset",
    "description": "Description for new dataset",
    "user_id": 1
}
            </code>
        </pre>
        <p><strong>Example Response:</strong></p>
        <pre>
            <code>
{
    "id": 4,
    "name": "New Dataset",
    "description": "Description for new dataset",
    "file_url": "https://example.com/datasets/4/download",
    "user_id": 1
}
            </code>
        </pre>
    </div>
</div>
@endsection

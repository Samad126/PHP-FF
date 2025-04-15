<div class="container py-5">
    <div class="row" style="display: flex; justify-content: center;">
        <div class="col-md-6 col-lg-5" style="margin: 40px auto">
            <div class="bg-white p-4 p-md-5 shadow-sm rounded">
                <h3 class="text-center mb-4 fw-bold">Login to <span class="text-danger">Electro</span></h3>
                <form method="POST">
                    <div class="mb-3" style="margin-bottom: 15px;">
                        <label for="email" class="form-label">Email address</label>
                        <input name="email" type="email" class="form-control" id="email" placeholder="name@example.com" required>
                    </div>
                    <div class="mb-3" style="margin-bottom: 15px;">
                        <label for="password" class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" id="password" placeholder="********" required>
                    </div>
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-danger">Login</button>
                    </div>
                    <p class="text-center mb-0">Don't have an account? <a href="/register" class="text-danger">Register</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container py-5">
    <div class="row" style="display: flex; justify-content: center;">
        <div class="col-md-6 col-lg-5" style="margin: 40px auto">
            <div class="bg-white p-4 p-md-5 shadow-sm rounded">
                <h3 class="text-center mb-4 fw-bold">Register for <span class="text-danger">Electro</span></h3>
                <form method="POST">
                    <div class="mb-3" style="margin-bottom: 15px;">
                        <label for="name" class="form-label">Full Name</label>
                        <input name="name" type="text" class="form-control" id="name" placeholder="John Doe" required>
                    </div>
                    <div class="mb-3" style="margin-bottom: 15px;">
                        <label for="email" class="form-label">Email address</label>
                        <input name="email" type="email" class="form-control" id="email" placeholder="name@example.com" required>
                    </div>
                    <div class="mb-3" style="margin-bottom: 15px;">
                        <label for="password" class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" id="password" placeholder="********" required>
                    </div>
                    <div class="mb-3" style="margin-bottom: 15px;">
                        <label for="password_confirm" class="form-label">Confirm Password</label>
                        <input name="password_confirm" type="password" class="form-control" id="password_confirm" placeholder="********" required>
                    </div>
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-danger">Register</button>
                    </div>
                    <p class="text-center mb-0">Already have an account? <a href="/login" class="text-danger">Login</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

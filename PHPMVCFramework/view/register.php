

<h1>create an accountus</h1>
<form action="/register" method="post">
    <div class="form-group">
        <label>FisrtName</label>
        <input type="text" name="fisrtName" class="form-control">
    </div>
    <div class="form-group">
        <label>LastName</label>
        <input type="text" name="lastName" class="form-control"> <!-- sửa name ở đây -->
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control"> <!-- sửa name ở đây -->
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control"> <!-- sửa name ở đây -->
    </div>
    <div class="form-group">
        <label>Password Repeat</label>
        <input type="password" name="confirmPassword" class="form-control"> <!-- sửa name ở đây -->
    </div>
    <div class="form-group form-check">
        <input type="checkbox" name="agree" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

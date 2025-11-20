<form action="register_action.php" method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="email" name="email" placeholder="Email" required><br>

    <label><input type="radio" name="role" value="admin" required> Admin</label>
    <label><input type="radio" name="role" value="user"> User</label>
    <label><input type="radio" name="role" value="moderator"> Moderator</label><br>

    <button type="submit">Đăng ký</button>
</form>

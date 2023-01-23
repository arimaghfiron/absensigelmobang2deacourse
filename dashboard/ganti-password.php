<div class="bform">
    <form action="action.php" method="POST" class="form">
        <p>GANTI PASSWORD</p>
        <div class="inputform"><span>Password Lama</span>
            <input name="password0" placeholder="Old Password" type="password" class="login-input" />
        </div>
        <div class="inputform"><span>Password Baru</span> <input name="password1" placeholder="New Password" type="password" class="login-input" />
        </div>
        <div class="inputform"><span>Konfirmasi Password Baru</span>
            <input name="password2" placeholder="Confirm New Password" type="password" class="login-input" />
        </div>
        <div class="btform">
            <button type="submit" name="ganti-pw" value='<?php 
                echo $_SESSION['user_id'];
            ?>' class="button">SIMPAN</button>
            <button type="submit" name="cancel" class="button">BATAL</button>
        </div>
    </form>
</div>
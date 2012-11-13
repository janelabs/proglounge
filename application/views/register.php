<?php echo $header; ?>

<div class="hero-unit">
    <div class="container">
        <h1>Register</h1>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="span9">
            <form name="registration" id="registration" method="post" action="">
                <span>Last Name</span>
                <input type="text" id="last_name" name="last_name" />
                <br>
                <span>First Name</span>
                <input type="text" id="first_name" name="first_name" />
                <br>
                <span>Middle Name</span>
                <input type="text" id="middle_name" name="middle_name" />
                <br>
                <span>Nickname</span>
                <input type="text" id="nickname" name="nickname" />
                <br>
                <span>Birth Date</span>
                <input type="text" id="birth_date" name="birth_date" />
                <br>
                <span>Address</span>
                <input type="text" id="address" name="address" />
                <br>
                <br>
                <span>Email Address</span>
                <input type="email" id="email_address" name="email_address" />
                <br>
                <span>Username</span>
                <input type="text" id="username" name="username" />
                <br>
                <span>Password</span>
                <input type="password" id="password" name="password" />
                <br><br>
                <input type="submit" id="submit" value="Register" />
            </form>
        </div>
    </div>
</div>
<?php echo $footer; ?>
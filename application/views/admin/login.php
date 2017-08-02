
<style type="text/css">
	.error{
		color: red;
		margin-bottom: 10px;
	}
    .loging{
        font-weight: 600;
    }
</style>

<?php //echo base_url(); ?>
<?php //echo site_url(); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">请登录</h3>
                    </div>
                    <div class="panel-body">
                        <?php //echo validation_errors(); ?>
                        <?php echo form_open('admin/login/validate'); ?>
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" value="admin" autofocus>
                                </div>
                                <?php echo form_error('username', '<div class="error">', '</div>'); ?>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="123456">
                                </div>
                                <?php echo form_error('password', '<div class="error">', '</div>'); ?>
                                <p class="error"><?php if( isset($msg) ) echo $msg; ?></p>
                                <!-- <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div> -->
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" onclick="login_change();" class="btn btn-lg btn-success btn-block loging">登录</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function login_change(){
            $('.loging').html('登录中...');
        }
    </script>

